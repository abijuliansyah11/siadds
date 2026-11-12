<?php

namespace App\Http\Controllers;

use App\Models\SiswaAktif;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class KelengkapanDokumenController extends Controller
{
    /** Status kelengkapan satu siswa (ditentukan dari 6 dokumen wajib). */
    public const STATUS = [
        'lengkap'  => 'Lengkap',
        'menunggu' => 'Menunggu Verifikasi',
        'belum'    => 'Belum Lengkap',
        'revisi'   => 'Perlu Revisi',
    ];

    /** Dokumen wajib => singkatan kolom tabel (urutan = urutan kolom). */
    public const KOLOM = [
        'Kartu Keluarga (KK)'               => 'KK',
        'Akta Kelahiran'                    => 'AKTA',
        'Ijazah / SKL MTs'                  => 'IJAZAH',
        'Pas Foto Resmi 3x4'                => 'FOTO',
        'KTP Orang Tua (Ayah & Ibu)'        => 'KTP ORTU',
        'Surat Pernyataan Kesediaan Santri' => 'SURAT',
    ];

    private const JENIS_IJAZAH = 'Ijazah / SKL MTs';
    private const BATAS_PENGINGAT = 100;

    /* ------------------------------------------------------------------
       HALAMAN UTAMA
       ------------------------------------------------------------------ */
    public function index(Request $request)
    {
        [$scope, $baris] = $this->kumpulkan($request);

        /* Ringkasan (mengikuti cakupan filter: kelas, angkatan, kata kunci, tab) */
        $hit = ['lengkap' => 0, 'menunggu' => 0, 'belum' => 0, 'revisi' => 0];
        $slot = ['kosong' => 0, 'menunggu' => 0, 'revisi' => 0];
        $ijazahMenunggu = 0;
        foreach ($scope as $r) {
            $hit[$r['status']]++;
            $slot['kosong']   += $r['n']['kosong'];
            $slot['menunggu'] += $r['n']['menunggu'];
            $slot['revisi']   += $r['n']['revisi'];
            if (($r['sel'][self::JENIS_IJAZAH] ?? '') === 'menunggu') $ijazahMenunggu++;
        }
        $total = $scope->count();

        $ringkas = [
            'total'    => $total,
            'hit'      => $hit,
            'slot'     => $slot,
            'segera'   => $hit['belum'] + $hit['revisi'],
            'ijazah'   => $ijazahMenunggu,
            'sinkron'  => now()->locale('id')->translatedFormat('H:i') . ' WIB',
        ];

        /* Halaman tabel */
        $per   = (int) $request->query('per', 10);
        $per   = in_array($per, [10, 25, 50], true) ? $per : 10;
        $hal   = max(1, (int) $request->query('page', 1));
        $halaman = (new LengthAwarePaginator(
            $baris->forPage($hal, $per)->values(), $baris->count(), $per, $hal,
            ['path' => $request->url(), 'query' => $request->except('page')]
        ))->fragment('tabel');

        /* Data panel detail: baris halaman ini + siswa yang dipilih */
        $pilih = (int) $request->query('pilih');
        $pertama = $halaman->first();
        $idPilih = $baris->contains(fn ($r) => $r['model']->id === $pilih)
            ? $pilih
            : ($pertama ? $pertama['model']->id : null);

        $detail = [];
        foreach ($halaman as $r) {
            $detail[$r['model']->id] = $this->detail($r);
        }
        if ($idPilih && ! isset($detail[$idPilih])) {
            $detail[$idPilih] = $this->detail($baris->first(fn ($r) => $r['model']->id === $idPilih));
        }

        /* Daftar pengingat massal (siswa belum lengkap / perlu revisi pada hasil filter) */
        $butuh = $baris->filter(fn ($r) => in_array($r['status'], ['belum', 'revisi'], true));
        $pengingat = [
            'jumlah' => $butuh->count(),
            'daftar' => $butuh->take(self::BATAS_PENGINGAT)->map(fn ($r) => [
                'nama'   => $r['model']->nama,
                'kelas'  => $r['model']->kelas,
                'kurang' => count($r['kurang']),
                'wa'     => $this->waLink($r['model'], $r['kurang']),
            ])->values()->all(),
            'batas'  => self::BATAS_PENGINGAT,
        ];

        return view('kelengkapan-dokumen', [
            'ringkas'       => $ringkas,
            'halaman'       => $halaman,
            'idPilih'       => $idPilih,
            'detail'        => $detail,
            'pengingat'     => $pengingat,
            'jumlahTab'     => ['semua' => SiswaAktif::count(), 'aktif' => $this->queryAktif(SiswaAktif::query())->count()],
            'daftarKelas'   => SiswaAktif::whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas'),
            'daftarAngkatan'=> SiswaAktif::whereNotNull('tahun_masuk')->distinct()->orderByDesc('tahun_masuk')->pluck('tahun_masuk'),
            'per'           => $per,
        ]);
    }

    /* ------------------------------------------------------------------
       EKSPOR CSV (mengikuti filter aktif)
       ------------------------------------------------------------------ */
    public function ekspor(Request $request)
    {
        [, $baris] = $this->kumpulkan($request);

        $teks = ['sah' => 'Sah', 'menunggu' => 'Menunggu', 'revisi' => 'Perlu Revisi', 'kosong' => 'Belum Diunggah'];

        return response()->streamDownload(function () use ($baris, $teks) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, array_merge(
                ['No', 'NIS', 'NISN', 'Nama', 'Kelas'],
                array_keys(self::KOLOM),
                ['Terverifikasi', 'Persentase', 'Status Kelengkapan', 'No HP Wali']
            ));
            foreach ($baris->values() as $i => $r) {
                $m = $r['model'];
                fputcsv($out, array_merge(
                    [$i + 1, $m->nis, $m->nisn, $m->nama, $m->kelas],
                    array_map(fn ($j) => $teks[$r['sel'][$j]], array_keys(self::KOLOM)),
                    [$r['n']['sah'] . '/' . $r['total'], $r['persen'] . '%', self::STATUS[$r['status']], $m->no_hp_wali]
                ));
            }
            fclose($out);
        }, 'kelengkapan-dokumen-' . now()->format('Ymd-His') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /* ------------------------------------------------------------------
       PEMBANTU — pengambilan & perhitungan data
       ------------------------------------------------------------------ */

    /**
     * @return array [cakupan (semua siswa sesuai filter dasar), baris (setelah filter status/fokus)]
     */
    private function kumpulkan(Request $request): array
    {
        $query = SiswaAktif::query();

        if ($request->query('cakupan') === 'aktif') {
            $this->queryAktif($query);
        }
        if ($kelas = (string) $request->query('kelas', '')) {
            $query->where('kelas', $kelas);
        }
        if ($angkatan = (string) $request->query('angkatan', '')) {
            $query->where('tahun_masuk', $angkatan);
        }
        if (($q = trim((string) $request->query('q', ''))) !== '') {
            $query->where(function ($w) use ($q) {
                $w->where('nama', 'like', "%{$q}%")
                  ->orWhere('nis', 'like', "%{$q}%")
                  ->orWhere('nisn', 'like', "%{$q}%")
                  ->orWhere('kelas', 'like', "%{$q}%");
            });
        }

        $scope = $query->with('dokumen')->orderBy('nis')->get()->map(fn ($s) => $this->hitung($s));

        $baris = $scope;
        $status = (string) $request->query('status', '');
        if (array_key_exists($status, self::STATUS)) {
            $baris = $baris->where('status', $status);
        }
        switch ($request->query('fokus')) {
            case 'segera':
                $baris = $baris->filter(fn ($r) => in_array($r['status'], ['belum', 'revisi'], true));
                break;
            case 'ijazah':
                $baris = $baris->filter(fn ($r) => ($r['sel'][self::JENIS_IJAZAH] ?? '') === 'menunggu');
                break;
        }

        return [$scope->values(), $baris->values()];
    }

    private function queryAktif($query)
    {
        return $query->whereRaw('LOWER(status) = ?', ['aktif']);
    }

    /** Hitung kelengkapan 6 dokumen wajib untuk satu siswa. */
    private function hitung(SiswaAktif $s): array
    {
        $dok    = $s->dokumen->keyBy('jenis');
        $sel    = [];
        $n      = ['sah' => 0, 'menunggu' => 0, 'revisi' => 0, 'kosong' => 0];
        $kurang = [];

        foreach (array_keys(self::KOLOM) as $jenis) {
            $d = $dok->get($jenis);
            $g = $d ? ArsipDigitalController::golongan($d->status) : 'kosong';
            $sel[$jenis] = $g;
            $n[$g]++;
            if (in_array($g, ['kosong', 'revisi'], true)) {
                $kurang[] = $jenis;
            }
        }

        $total  = count(self::KOLOM);
        // Prioritas: revisi > belum diunggah > menunggu verifikasi > lengkap
        $status = $n['revisi'] > 0 ? 'revisi'
               : ($n['kosong'] > 0 ? 'belum'
               : ($n['menunggu'] > 0 ? 'menunggu' : 'lengkap'));

        return [
            'model' => $s, 'sel' => $sel, 'n' => $n, 'kurang' => $kurang,
            'total' => $total, 'persen' => (int) round($n['sah'] / $total * 100), 'status' => $status,
        ];
    }

    /** Data panel "Detail Kelengkapan Siswa" (dikirim sebagai JSON ke JavaScript). */
    private function detail(array $r): array
    {
        $s   = $r['model'];
        $dok = $s->dokumen->keyBy('jenis');
        $cek = [];

        foreach (array_keys(self::KOLOM) as $jenis) {
            $d = $dok->get($jenis);
            $g = $r['sel'][$jenis];

            switch ($g) {
                case 'sah':      $sub = $this->tanggal($d) . ' • Terverifikasi'; break;
                case 'menunggu': $sub = ($d->nama_file ?: '-') . ($d->ukuran ? " ({$d->ukuran})" : ''); break;
                case 'revisi':   $sub = $d->catatan ?: 'Perlu diunggah ulang'; break;
                default:         $sub = 'Belum diunggah';
            }

            $cek[] = [
                'jenis'  => $jenis,
                'st'     => $g,
                'sub'    => $sub,
                'id'     => $d ? $d->id : null,
                'nama'   => $d ? $d->nama_file : null,
                'lihat'  => $d && $d->path && Storage::disk('public')->exists($d->path) ? route('arsip.digital.lihat', $d->id) : null,
                'upload' => route('upload.dokumen', ['siswa' => $s->id, 'jenis' => $jenis]) . '#unggah',
            ];
        }

        return [
            'id'      => $s->id,
            'nama'    => $s->nama,
            'nis'     => $s->nis,
            'nisn'    => $s->nisn,
            'kelas'   => $s->kelas,
            'foto'    => $s->foto_url,
            'statusSiswa' => $s->status ?: 'Aktif',
            'status'  => $r['status'],
            'label'   => self::STATUS[$r['status']],
            'persen'  => $r['persen'],
            'n'       => $r['n'],
            'total'   => $r['total'],
            'cek'     => $cek,
            'wa'      => $this->waLink($s, $r['kurang']),
            'upload'  => route('upload.dokumen', ['siswa' => $s->id]) . '#unggah',
            'profil'  => route('siswa.detail', ['id' => $s->id]),
        ];
    }

    private function tanggal($dok): string
    {
        $t = $dok ? ($dok->tanggal_unggah ?: $dok->created_at) : null;
        return $t ? $t->locale('id')->translatedFormat('d M Y') : '-';
    }

    /** Tautan WhatsApp pengingat ke wali siswa (null jika tidak ada nomor / tidak ada yang kurang). */
    private function waLink(SiswaAktif $s, array $kurang): ?string
    {
        $hp = preg_replace('/\D+/', '', (string) $s->no_hp_wali);
        if ($hp === '' || ! $kurang) {
            return null;
        }
        if (str_starts_with($hp, '0')) {
            $hp = '62' . substr($hp, 1);
        } elseif (str_starts_with($hp, '8')) {
            $hp = '62' . $hp;
        }

        $daftar = implode("\n", array_map(fn ($j) => '- ' . $j, $kurang));
        $pesan  = "Assalamu'alaikum Bapak/Ibu wali dari {$s->nama} (NIS {$s->nis}).\n\n"
                . "Kami dari MAS YPI Sumber Harjo mohon bantuan untuk melengkapi berkas berikut:\n{$daftar}\n\n"
                . "Berkas dapat diserahkan ke bagian Tata Usaha madrasah. Terima kasih.";

        return 'https://wa.me/' . $hp . '?text=' . rawurlencode($pesan);
    }
}