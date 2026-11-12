<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;

/** Data Dashboard Utama dari database (hanya membaca, tidak mengubah apa pun). */
class DashboardController extends Controller
{
    /** Urutan sama dengan 5 slot dokumen pada VerifikasiController. */
    private const DOKUMEN = [
        'Kartu Keluarga (KK)',
        'Akta Kelahiran',
        'Ijazah / SKL SMP/MTs',
        'Pas Foto 3x4',
        'Data Formulir Pendaftaran',
    ];

    public function index()
    {
        $terkirim = Pendaftaran::where('status', 'terkirim')->get();
        $draft    = Pendaftaran::where('status', '!=', 'terkirim')->count();
        $n        = $terkirim->count();

        $file = 0;        // jumlah file berkas yang terunggah
        $lengkap = 0;     // status verifikasi T (semua dokumen valid)
        $belum = 0;       // status M / S (belum / sedang diperiksa)
        $perbaikan = 0;   // status P (dikembalikan untuk perbaikan)
        $masalah = [];    // baris tabel "Dokumen Membutuhkan Tindak Lanjut"

        foreach ($terkirim as $p) {
            $dok = $this->json($p->dokumen);
            $ver = $this->json($p->verifikasi);

            foreach (['kk', 'akta', 'ijazah', 'kip'] as $k) {
                if (! empty($dok[$k]['path'])) {
                    $file++;
                }
            }
            if ($p->foto_path) {
                $file++;
            }

            $st = $p->status_verifikasi ?: 'M';
            if ($st === 'T')      $lengkap++;
            elseif ($st === 'P')  $perbaikan++;
            else                  $belum++;

            if ($st === 'T') {
                continue;   // semua valid: tidak masuk antrean
            }

            $nama = $p->nama ?: '(Tanpa nama)';
            $nisn = 'NISN: ' . ($p->nisn ?: '-');
            $tgl  = $p->created_at ? $p->created_at->format('d-m-Y') : '-';
            $ts   = $p->created_at ? $p->created_at->timestamp : 0;

            // Belum pernah diperiksa: satu baris ringkas per pendaftar
            if ($st === 'M') {
                $masalah[] = [$nama, $nisn, $p->no_registrasi, 'Seluruh berkas (5 dokumen)',
                              'Belum diperiksa operator', $tgl, 'Menunggu Verifikasi', $ts];
                continue;
            }

            // Sedang diperiksa / dikembalikan: satu baris per dokumen yang belum valid
            foreach (self::DOKUMEN as $j => $judul) {
                $d = $ver['docs'][$j] ?? [];
                $s = $d['st'] ?? 'p';
                if ($s === 'v') {
                    continue;
                }
                if ($s === 'p') {
                    $masalah[] = [$nama, $nisn, $p->no_registrasi, $judul,
                                  'Belum diperiksa', $tgl, 'Menunggu Verifikasi', $ts];
                } else {
                    $catatan = ($d['note'] ?? '') ?: (($d['cat'] ?? '') ?: 'Dokumen tidak valid');
                    $masalah[] = [$nama, $nisn, $p->no_registrasi, $judul,
                                  $catatan, $tgl, 'Perlu Perbaikan', $ts];
                }
            }
        }

        // "Perlu Perbaikan" paling atas, lalu yang terbaru
        usort($masalah, fn ($a, $b) =>
            [$b[6] === 'Perlu Perbaikan', $b[7]] <=> [$a[6] === 'Perlu Perbaikan', $a[7]]);

        $pct = $n ? number_format($lengkap / $n * 100, 1, ',', '') : '0';

        // Indeks mengikuti urutan kartu di dashboard.blade.php (0 dan 1 tetap data contoh)
        $kpiDb = [
            2 => ['Calon Baru PPDB',   $n,         $draft ? $draft . ' draft belum dikirim' : 'Semua pendaftar terkirim'],
            3 => ['Total Dokumen',     $file,      'File berkas terunggah'],
            4 => ['Dokumen Lengkap',   $lengkap,   $pct . '% dari ' . $n . ' pendaftar'],
            5 => ['Belum Lengkap',     $belum,     'Perlu tindak lanjut'],
            6 => ['Perlu Perbaikan',   $perbaikan, 'Dikembalikan ke pendaftar'],
        ];

        return view('dashboard', [
            'kpiDb'     => $kpiDb,
            'docsDb'    => array_slice($masalah, 0, 5),
            'docsTotal' => count($masalah),
        ]);
    }

    /** Kolom JSON bisa sudah berupa array (cast) atau masih teks. */
    private function json($v): array
    {
        if (is_array($v)) {
            return $v;
        }
        return json_decode((string) $v, true) ?: [];
    }
}