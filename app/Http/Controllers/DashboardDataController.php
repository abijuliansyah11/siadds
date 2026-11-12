<?php

namespace App\Http\Controllers;

use App\Models\SiswaAktif;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Data hidup untuk Dashboard Utama (JSON). Hanya membaca tabel yang sudah ada;
 * setiap bagian dilindungi agar satu tabel yang belum ada tidak merusak seluruh dashboard.
 */
class DashboardDataController extends Controller
{
    private const SAH = ['valid', 'tambahan'];

    /* ======================================================================
       DATA TAMBAHAN DASHBOARD
       Angka KPI, kelas, gender, audit, dan tabel tindak lanjut sudah dirender
       DashboardController + dashboard.blade.php dari database, sehingga TIDAK diulang di sini
       (supaya tidak ada dua sumber angka yang berbeda). Di sini hanya bagian yang belum hidup:
       tahun ajaran, tren pendaftaran, riwayat aktivitas lintas modul, dan kartu arsip fisik.
       ====================================================================== */
    public function data()
    {
        $sekarang = Carbon::now('Asia/Jakarta');

        return response()->json([
            'ok'      => true,
            'ta'      => $this->tahunAjaran($sekarang),
            'sync'    => $sekarang->copy()->locale('id')->translatedFormat('d M Y, H:i') . ' WIB',
            'tren'    => $this->tren(),
            'riwayat' => $this->riwayat(),
            'arsip'   => $this->arsip(),
        ]);
    }

    /* ======================================================================
       PENCARIAN CEPAT (kotak cari di header)
       ====================================================================== */
    public function cari(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        if (mb_strlen($q) < 2) {
            return response()->json(['ok' => true, 'hasil' => []]);
        }
        $like  = '%' . str_replace(['%', '_'], ['\%', '\_'], $q) . '%';
        $hasil = [];

        $this->aman(function () use ($like, &$hasil) {
            foreach (DB::table('siswa_aktif')->where(fn ($w) => $w->where('nama', 'like', $like)->orWhere('nis', 'like', $like)->orWhere('nisn', 'like', $like))
                ->orderBy('nama')->limit(5)->get(['id', 'nama', 'nis', 'kelas']) as $s) {
                $hasil[] = ['judul' => $s->nama, 'sub' => 'Siswa • ' . $s->kelas . ' • NIS ' . $s->nis, 'url' => route('siswa.detail', ['id' => $s->id])];
            }
        }, null);

        $this->aman(function () use ($like, &$hasil) {
            if (! $this->ada('calon_siswa')) {
                return;
            }
            foreach (DB::table('calon_siswa')->where(fn ($w) => $w->where('nama', 'like', $like)->orWhere('reg', 'like', $like)->orWhere('nisn', 'like', $like))
                ->orderBy('nama')->limit(4)->get(['reg', 'nama']) as $c) {
                $hasil[] = ['judul' => $c->nama, 'sub' => 'Calon siswa • ' . $c->reg, 'url' => route('penerimaan', ['q' => $c->reg])];
            }
        }, null);

        $this->aman(function () use ($like, &$hasil) {
            if (! $this->ada('alumni')) {
                return;
            }
            foreach (DB::table('alumni')->where(fn ($w) => $w->where('nama', 'like', $like)->orWhere('nis', 'like', $like)->orWhere('nisn', 'like', $like))
                ->orderBy('nama')->limit(4)->get(['id', 'nama', 'tahun_lulus']) as $a) {
                $hasil[] = ['judul' => $a->nama, 'sub' => 'Alumni • lulus ' . $a->tahun_lulus, 'url' => route('alumni', ['id' => $a->id])];
            }
        }, null);

        return response()->json(['ok' => true, 'hasil' => $hasil]);
    }

    /* ======================================================================
       PEMBANTU
       ====================================================================== */
    private function ada(string $tabel): bool
    {
        try {
            return Schema::hasTable($tabel);
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function aman(callable $f, $bawaan)
    {
        try {
            return $f();
        } catch (\Throwable $e) {
            report($e);

            return $bawaan;
        }
    }

    /** Tahun ajaran berjalan: Juli–Desember = Ganjil, Januari–Juni = Genap. */
    private function tahunAjaran(Carbon $t): array
    {
        $awal = $t->month >= 7 ? $t->year : $t->year - 1;

        return ['tahun' => $awal . '/' . ($awal + 1), 'semester' => $t->month >= 7 ? 'Ganjil' : 'Genap', 'tahunPpdb' => $t->year];
    }

    private function waktu($ts): array
    {
        $t = Carbon::parse($ts, config('app.timezone'))->timezone('Asia/Jakarta')->locale('id');
        $hari = Carbon::now('Asia/Jakarta');
        if ($t->isSameDay($hari)) {
            $label = 'Hari ini';
        } elseif ($t->isSameDay($hari->copy()->subDay())) {
            $label = 'Kemarin';
        } else {
            $label = $t->translatedFormat('d M Y');
        }

        return [$t->timestamp, $label . ' • ' . $t->format('H:i') . ' WIB'];
    }

    /** Pendaftar per minggu (8 minggu terakhir): jalur Prestasi vs lainnya. */
    private function tren(): array
    {
        $awal = Carbon::now('Asia/Jakarta')->startOfWeek()->subWeeks(7);
        $label = [];
        $prestasi = array_fill(0, 8, 0);
        $lain = array_fill(0, 8, 0);
        for ($i = 0; $i < 8; $i++) {
            $label[] = $awal->copy()->addWeeks($i)->locale('id')->translatedFormat('d M');
        }

        $this->aman(function () use ($awal, &$prestasi, &$lain) {
            if (! $this->ada('calon_siswa')) {
                return;
            }
            $baris = DB::table('calon_siswa')->where('created_at', '>=', $awal->copy()->timezone(config('app.timezone')))->get(['created_at', 'jalur']);
            foreach ($baris as $b) {
                $t = Carbon::parse($b->created_at, config('app.timezone'))->timezone('Asia/Jakarta');
                $i = (int) floor($awal->diffInDays($t->copy()->startOfDay(), false) / 7);
                if ($i >= 0 && $i < 8) {
                    if (strtolower((string) $b->jalur) === 'prestasi') {
                        $prestasi[$i]++;
                    } else {
                        $lain[$i]++;
                    }
                }
            }
        }, null);

        return ['label' => $label, 'prestasi' => $prestasi, 'lain' => $lain];
    }

    /** Aktivitas terakhir dari berbagai modul, diurutkan terbaru. */
    private function riwayat(): array
    {
        $a = [];
        $tambah = function ($ts, $teks) use (&$a) {
            if ($ts) {
                [$u, $lbl] = $this->waktu($ts);
                $a[] = ['u' => $u, 'teks' => $teks, 'waktu' => $lbl];
            }
        };

        $this->aman(function () use ($tambah) {
            if (! $this->ada('siswa_dokumen')) return;
            foreach (DB::table('siswa_dokumen as d')->join('siswa_aktif as s', 's.id', '=', 'd.siswa_aktif_id')
                ->orderByDesc('d.created_at')->limit(5)->get(['d.jenis', 'd.diunggah_oleh', 'd.created_at', 's.nama', 's.kelas']) as $r) {
                $tambah($r->created_at, ($r->diunggah_oleh ?: 'Operator') . ' mengunggah ' . $r->jenis . ' siswa ' . $r->nama . ' (Kelas ' . $r->kelas . ').');
            }
        }, null);
        $this->aman(function () use ($tambah) {
            foreach (DB::table('siswa_aktif')->orderByDesc('created_at')->limit(4)->get(['nama', 'kelas', 'nis', 'created_at']) as $r) {
                $tambah($r->created_at, 'Siswa ' . $r->nama . ' (Kelas ' . $r->kelas . ') ditambahkan ke Data Siswa Aktif dengan NIS ' . $r->nis . '.');
            }
        }, null);
        $this->aman(function () use ($tambah) {
            if (! $this->ada('calon_siswa')) return;
            foreach (DB::table('calon_siswa')->orderByDesc('created_at')->limit(4)->get(['nama', 'reg', 'jalur', 'created_at']) as $r) {
                $tambah($r->created_at, 'Calon siswa ' . $r->nama . ' terdaftar PPDB (' . $r->reg . ($r->jalur ? ', jalur ' . $r->jalur : '') . ').');
            }
        }, null);
        $this->aman(function () use ($tambah) {
            if (! $this->ada('arsip_fisik_log')) return;
            foreach (DB::table('arsip_fisik_log as l')->leftJoin('arsip_fisik as f', 'f.id', '=', 'l.arsip_fisik_id')
                ->orderByDesc('l.created_at')->limit(4)->get(['l.aksi', 'l.keterangan', 'l.petugas', 'l.created_at', 'f.kode_arsip']) as $r) {
                $tambah($r->created_at, ($r->petugas ?: 'Petugas') . ': ' . ($r->keterangan ?: ('arsip fisik ' . $r->aksi)) . ($r->kode_arsip ? ' (' . $r->kode_arsip . ').' : '.'));
            }
        }, null);
        $this->aman(function () use ($tambah) {
            if (! $this->ada('alumni')) return;
            foreach (DB::table('alumni')->orderByDesc('created_at')->limit(3)->get(['nama', 'tahun_lulus', 'created_at']) as $r) {
                $tambah($r->created_at, $r->nama . ' dicatat sebagai alumni (lulus ' . $r->tahun_lulus . ').');
            }
        }, null);
        $this->aman(function () use ($tambah) {
            if (! $this->ada('skl_log')) return;
            foreach (DB::table('skl_log as l')->leftJoin('alumni as a', 'a.id', '=', 'l.alumni_id')
                ->orderByDesc('l.created_at')->limit(3)->get(['l.nomor', 'l.petugas', 'l.created_at', 'a.nama']) as $r) {
                $tambah($r->created_at, ($r->petugas ?: 'Petugas') . ' mencetak SKL ' . ($r->nama ?: '') . ($r->nomor ? ' (' . $r->nomor . ').' : '.'));
            }
        }, null);
        $this->aman(function () use ($tambah) {
            if (! $this->ada('seleksi_log')) return;
            foreach (DB::table('seleksi_log')->orderByDesc('created_at')->limit(3)->get(['isi', 'created_at']) as $r) {
                $tambah($r->created_at, trim(strip_tags((string) $r->isi)));
            }
        }, null);

        usort($a, fn ($x, $y) => $y['u'] <=> $x['u']);

        return array_map(fn ($r) => ['teks' => $r['teks'], 'waktu' => $r['waktu']], array_slice($a, 0, 25));
    }

    /** Kartu "Arsip Fisik": penempatan terbaru dan cakupan label QR. */
    private function arsip(): array
    {
        $kosong = ['ada' => false, 'total' => 0, 'berlokasi' => 0, 'label' => 0, 'batch' => 0, 'lokasi' => null, 'map' => null, 'kode' => null, 'url' => route('arsip.fisik')];
        if (! $this->ada('arsip_fisik')) {
            return $kosong;
        }

        return $this->aman(function () use ($kosong) {
            $total  = DB::table('arsip_fisik')->count();
            $berlok = DB::table('arsip_fisik')->whereNotNull('arsip_rak_id')->count();
            $label  = $this->ada('arsip_label') ? DB::table('arsip_label')->count() : 0;

            $terbaru = DB::table('arsip_fisik as f')
                ->join('arsip_rak as r', 'r.id', '=', 'f.arsip_rak_id')->join('arsip_lemari as l', 'l.id', '=', 'r.arsip_lemari_id')
                ->join('arsip_ruang as u', 'u.id', '=', 'l.arsip_ruang_id')
                ->orderByDesc('f.updated_at')->limit(5)->get(['f.kode_map', 'r.kode as rak', 'l.kode as lemari', 'u.nama as ruang']);

            $lokasi = null; $map = null; $kode = null;
            if ($terbaru->isNotEmpty()) {
                $p = $terbaru->first();
                $lokasi = 'Lemari ' . $p->lemari . ' • Rak ' . $p->rak;
                $kode   = $p->ruang . ' • ' . $p->lemari . '-' . $p->rak;
                $maps   = $terbaru->pluck('kode_map')->filter()->values();
                $map    = $maps->isEmpty() ? null : ($maps->count() > 1 ? $maps->last() . ' s/d ' . $maps->first() : $maps->first());
            }

            return ['ada' => true, 'total' => $total, 'berlokasi' => $berlok, 'label' => $label, 'batch' => $terbaru->count(), 'lokasi' => $lokasi, 'map' => $map, 'kode' => $kode, 'url' => route('arsip.fisik')];
        }, $kosong);
    }
}