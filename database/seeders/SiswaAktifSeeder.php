<?php

namespace Database\Seeders;

use App\Models\SiswaAktif;
use Illuminate\Database\Seeder;

class SiswaAktifSeeder extends Seeder
{
    public function run(): void
    {
        // [nis, nisn, nama, panggilan, jk, kelas, rombel, tahun masuk, jumlah dokumen valid]
        $data = [
            ['2026001', '0081234567', 'Ahmad Fauzan',   'Fauzan', 'L', 'X-A',   'Peminatan MIPA 1',     2026, 6],
            ['2026002', '0081234568', 'Siti Aisyah',    'Aisyah', 'P', 'X-A',   'Peminatan MIPA 1',     2026, 4],
            ['2025003', '0071234569', 'Muhammad Rizki', 'Rizki',  'L', 'XI-A',  'MIPA 1 (Reguler)',     2025, 6],
            ['2025004', '0071234570', 'Nur Aulia',      'Aulia',  'P', 'XI-B',  'Peminatan IPS 1',      2025, 5],
            ['2024005', '0061234571', 'Dimas Pratama',  'Dimas',  'L', 'XII-A', 'MIPA Unggulan',        2024, 6],
            ['2026006', '0082910391', 'Dewi Anggraini', 'Dewi',   'P', 'X-B',   'Kelas Khusus Tahfidz', 2026, 6],
            ['2026007', '0078129487', 'Fajar Ramadhan', 'Fajar',  'L', 'X-C',   'Peminatan IPS 2',      2026, 3],
        ];

        foreach ($data as [$nis, $nisn, $nama, $panggilan, $jk, $kelas, $rombel, $tahun, $jumlahDok]) {
            $siswa = SiswaAktif::updateOrCreate(['nis' => $nis], [
                'nisn'           => $nisn,
                'nama'           => $nama,
                'panggilan'      => $panggilan,
                'jenis_kelamin'  => $jk,
                'kelas'          => $kelas,
                'rombel'         => $rombel,
                'tahun_masuk'    => $tahun,
                'tanggal_masuk'  => "{$tahun}-07-15",
                'wali_kelas'     => 'Dra. Hj. Nurjanah',
                'nama_orang_tua' => 'Bapak ' . $panggilan,
                'status'         => 'Aktif',
                'tahun_ajaran'   => '2026/2027',
            ]);

            $siswa->dokumen()->delete();
            foreach (array_slice(SiswaAktif::DOKUMEN_WAJIB, 0, $jumlahDok) as $i => $jenis) {
                $siswa->dokumen()->create([
                    'jenis'          => $jenis,
                    'nama_file'      => str_replace([' ', '/', '(', ')', '&'], '_', $jenis) . '_' . $panggilan . '.pdf',
                    'ukuran'         => (800 + $i * 150) . ' KB',
                    'status'         => 'valid',
                    'diunggah_oleh'  => 'Ahmad Fauzi, S.Pd.',
                    'tanggal_unggah' => '2026-07-' . (15 + $i % 3),
                ]);
            }
        }
    }
}