<?php

namespace App\Http\Controllers;

use App\Models\ArsipFisik;
use App\Models\ArsipLabel;
use App\Models\ArsipRuang;
use App\Models\SiswaAktif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CetakLabelController extends Controller
{
    /** Template label yang tersedia (harus sama dengan yang ada di JavaScript). */
    public const TEMPLATE = ['standar', 'vertikal', 'map', 'kop'];

    /** Status label pada tabel pemilihan arsip. */
    public const STATUS = [
        'belum'   => 'Belum Dibuat',
        'dibuat'  => 'Sudah Dibuat',
        'siap'    => 'Siap Cetak',
        'selesai' => 'Sudah Dicetak',
    ];

    private const TAB_RIWAYAT = ['dibuat', 'siap', 'selesai'];

    /* ======================================================================
       HALAMAN UTAMA
       ====================================================================== */
    public function index(Request $request)
    {
        $per = (int) $request->query('per', 10);
        $per = in_array($per, [10, 25, 50], true) ? $per : 10;

        /* Ringkasan */
        $total  = ArsipFisik::count();
        $dibuat = ArsipLabel::count();
        $ringkas = [
            'total'       => $total,
            'dibuat'      => $dibuat,
            'belum'       => max(0, $total - $dibuat),
            'pctDibuat'   => $total > 0 ? round($dibuat / $total * 100, 1) : 0,
            'siap'        => ArsipLabel::where('status', 'siap')->count(),
            'tercetak'    => (int) ArsipLabel::sum('qty'),
            'lokasiBelum' => ArsipFisik::whereNull('arsip_rak_id')->count(),
        ];

        /* Tabel pemilihan arsip */
        $daftar = $this->saring($request)
            ->with(['siswa:id,nis,nama,kelas', 'rak.lemari.ruang'])
            ->orderBy('arsip_fisik.kode_arsip')
            ->paginate($per)->withQueryString()->fragment('tabel');

        $data = [];
        foreach ($daftar as $a) {
            $data[$a->id] = $this->dataLabel($a);
        }

        /* Riwayat pembuatan & pencetakan */
        $riwayat = $this->queryRiwayat($request)
            ->with('arsip.siswa:id,nis,nama,kelas')
            ->orderByDesc('updated_at')->orderByDesc('id')
            ->paginate(6, ['*'], 'riwayat_page')->withQueryString()->fragment('riwayat');

        return view('cetak-label', [
            'ringkas'  => $ringkas,
            'daftar'   => $daftar,
            'data'     => $data,
            'riwayat'  => $riwayat,
            'per'      => $per,
            'opsi'     => [
                'ruang'  => ArsipRuang::orderBy('nama')->get(['id', 'nama']),
                'status' => SiswaAktif::whereNotNull('status')->where('status', '!=', '')->distinct()->orderBy('status')->pluck('status'),
            ],
        ]);
    }

    /* ======================================================================
       BUAT LABEL / MASUK ANTREAN CETAK
       ====================================================================== */
    public function buat(Request $request)
    {
        $data = $request->validate([
            'ids'      => 'required|array|min:1|max:500',
            'ids.*'    => 'integer|exists:arsip_fisik,id',
            'mode'     => ['required', Rule::in(['buat', 'antrean'])],
            'template' => ['nullable', Rule::in(self::TEMPLATE)],
            'ukuran'   => 'nullable|string|max:20',
        ], [
            'required' => 'Pilih minimal satu arsip.',
            'min'      => 'Pilih minimal satu arsip.',
            'max'      => 'Maksimal 500 arsip dalam satu kali proses.',
            'exists'   => 'Ada arsip yang tidak ditemukan.',
        ]);

        $ids     = array_values(array_unique($data['ids']));
        $petugas = optional(auth()->user())->name ?? 'Admin';
        $baru    = 0;
        $antrean = 0;

        DB::transaction(function () use ($ids, $data, $petugas, &$baru, &$antrean) {
            foreach ($ids as $id) {
                $l = ArsipLabel::firstOrNew(['arsip_fisik_id' => $id]);

                if (! $l->exists) {
                    $l->status      = 'dibuat';
                    $l->qty         = 0;
                    $l->dibuat_oleh = $petugas;
                    $baru++;
                }
                if ($data['mode'] === 'antrean' && $l->status !== 'siap') {
                    $l->status = 'siap';
                    $antrean++;
                }

                $l->template = $data['template'] ?? $l->template ?? 'standar';
                $l->ukuran   = $data['ukuran'] ?? $l->ukuran ?? '50x30';
                $l->save();
            }
        });

        $pesan = $data['mode'] === 'antrean'
            ? "{$antrean} arsip dimasukkan ke antrean cetak."
            : "{$baru} label QR baru dibuat" . (count($ids) - $baru > 0 ? ' (' . (count($ids) - $baru) . ' sudah ada sebelumnya).' : '.');

        return back()->with('status', $pesan);
    }

    /* ======================================================================
       CATAT PENCETAKAN (dipanggil JavaScript tepat sebelum dialog cetak dibuka)
       ====================================================================== */
    public function cetak(Request $request)
    {
        $data = $request->validate([
            'ids'      => 'required|array|min:1|max:500',
            'ids.*'    => 'integer|exists:arsip_fisik,id',
            'salinan'  => 'required|integer|min:1|max:20',
            'template' => ['nullable', Rule::in(self::TEMPLATE)],
            'ukuran'   => 'nullable|string|max:20',
        ]);

        $ids     = array_values(array_unique($data['ids']));
        $petugas = optional(auth()->user())->name ?? 'Admin';

        DB::transaction(function () use ($ids, $data, $petugas) {
            foreach ($ids as $id) {
                $l = ArsipLabel::firstOrNew(['arsip_fisik_id' => $id]);

                if (! $l->exists) {
                    $l->qty         = 0;
                    $l->dibuat_oleh = $petugas;
                }
                $l->qty         += (int) $data['salinan'];
                $l->status       = 'selesai';
                $l->template     = $data['template'] ?? $l->template ?? 'standar';
                $l->ukuran       = $data['ukuran'] ?? $l->ukuran ?? '50x30';
                $l->dicetak_oleh = $petugas;
                $l->dicetak_at   = now();
                $l->save();
            }
        });

        return response()->json(['ok' => true, 'arsip' => count($ids), 'stiker' => count($ids) * (int) $data['salinan']]);
    }

    /* ======================================================================
       EKSPOR LOG (CSV)
       ====================================================================== */
    public function ekspor(Request $request)
    {
        $baris = $this->queryRiwayat($request)->with('arsip.siswa:id,nis,nama,kelas')->orderBy('id')->get();

        return response()->streamDownload(function () use ($baris) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['No', 'Kode Arsip', 'Dokumen', 'Siswa', 'NIS', 'Waktu Pembuatan QR', 'Waktu Cetak Terakhir', 'Jumlah Stiker', 'Operator', 'Status']);
            foreach ($baris as $i => $l) {
                $a = $l->arsip;
                $s = $a ? $a->siswa : null;
                fputcsv($out, [
                    $i + 1, $a ? $a->kode_arsip : '-', $a ? $a->jenis : '-',
                    $s ? $s->nama : '-', $s ? $s->nis : '-',
                    $l->created_at->format('d-m-Y H:i'),
                    $l->dicetak_at ? $l->dicetak_at->format('d-m-Y H:i') : '-',
                    $l->qty, $l->dicetak_oleh ?: $l->dibuat_oleh, ArsipLabel::STATUS[$l->status] ?? $l->status,
                ]);
            }
            fclose($out);
        }, 'log-label-qr-' . now()->format('Ymd-His') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /* ======================================================================
       PEMBANTU
       ====================================================================== */

    /** Arsip fisik + status label, dengan semua filter dari URL. */
    private function saring(Request $r)
    {
        $q = ArsipFisik::query()
            ->leftJoin('arsip_label', 'arsip_label.arsip_fisik_id', '=', 'arsip_fisik.id')
            ->select('arsip_fisik.*', 'arsip_label.status as label_status');

        if (($j = (string) $r->query('kategori', '')) !== '' && isset(ArsipFisikController::DOKUMEN[$j])) {
            $q->where('arsip_fisik.jenis', $j);
        }
        if ($id = (int) $r->query('ruang')) {
            $q->whereHas('rak.lemari', fn ($w) => $w->where('arsip_ruang_id', $id));
        }

        $label = (string) $r->query('label', '');
        if ($label === 'belum') {
            $q->whereNull('arsip_label.id');
        } elseif (in_array($label, ['dibuat', 'siap', 'selesai'], true)) {
            $q->where('arsip_label.status', $label);
        }

        if (($st = (string) $r->query('siswa', '')) !== '') {
            $q->whereIn('arsip_fisik.siswa_aktif_id', SiswaAktif::where('status', $st)->select('id'));
        }
        if ($r->query('fokus') === 'lokasi') {
            $q->whereNull('arsip_fisik.arsip_rak_id');
        }

        if (($cari = trim((string) $r->query('q', ''))) !== '') {
            $idSiswa = SiswaAktif::where('nama', 'like', "%{$cari}%")
                ->orWhere('nis', 'like', "%{$cari}%")->orWhere('nisn', 'like', "%{$cari}%")->pluck('id');

            $q->where(function ($w) use ($cari, $idSiswa) {
                $w->where('arsip_fisik.kode_arsip', 'like', "%{$cari}%")
                  ->orWhere('arsip_fisik.jenis', 'like', "%{$cari}%")
                  ->orWhere('arsip_fisik.kode_map', 'like', "%{$cari}%")
                  ->orWhereIn('arsip_fisik.siswa_aktif_id', $idSiswa)
                  ->orWhereHas('rak.lemari', fn ($l) => $l->where('kode', 'like', "%{$cari}%")
                      ->orWhereHas('ruang', fn ($ru) => $ru->where('nama', 'like', "%{$cari}%")));
            });
        }

        return $q;
    }

    private function queryRiwayat(Request $r)
    {
        $q = ArsipLabel::query();
        if (in_array($r->query('riwayat'), self::TAB_RIWAYAT, true)) {
            $q->where('status', $r->query('riwayat'));
        }
        return $q;
    }

    /** Data satu arsip untuk pratinjau & pencetakan label di JavaScript. */
    private function dataLabel(ArsipFisik $a): array
    {
        $rak   = $a->rak;
        $lem   = $rak ? $rak->lemari : null;
        $ruang = $lem ? $lem->ruang : null;
        $s     = $a->siswa;

        return [
            'id'      => $a->id,
            'kode'    => $a->kode_arsip,
            'jenis'   => $a->jenis,
            'kategori'=> (ArsipFisikController::DOKUMEN[$a->jenis] ?? ['Pendukung'])[0],
            'nama'    => $s ? $s->nama : '-',
            'nis'     => $s ? $s->nis : '-',
            'kelas'   => $s ? $s->kelas : '-',
            'lokasi'  => $rak ? implode(' • ', array_filter([$ruang->nama, $lem->kode, $rak->kode, $a->kode_map])) : null,
            'alamat'  => $ruang ? $ruang->alamat : null,
            'label'   => $a->label_status ?: 'belum',
            // QR hanya memuat tautan ke sistem dengan kode arsip (tanpa data pribadi)
            'qr'      => route('arsip.fisik', ['q' => $a->kode_arsip]),
        ];
    }
}