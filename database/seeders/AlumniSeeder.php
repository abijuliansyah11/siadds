<?php

namespace Database\Seeders;

use App\Models\Alumni;
use Illuminate\Database\Seeder;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        // [nis, nisn, nama, panggilan, jk, kelas, jurusan, masuk, lulus, nomor ijazah, jumlah dokumen, status ijazah, rata-rata]
        $data = [
            ['2023001', '0051234501', 'Ahmad Fauzan',   'Fauzan', 'L', 'XII-A', 'MIPA 1', 2023, 2026, 'MA-16-08-2026-00192', 6, 'diambil',   89.40],
            ['2023002', '0051234502', 'Siti Aisyah',    'Aisyah', 'P', 'XII-A', 'MIPA 1', 2023, 2026, 'MA-16-08-2026-00193', 6, 'diambil',   91.10],
            ['2022003', '0041234503', 'Muhammad Rizki', 'Rizki',  'L', 'XII-B', 'IPS',    2022, 2025, 'MA-15-08-2025-00141', 5, 'tersimpan', 84.75],
            ['2022004', '0041234504', 'Nur Aulia',      'Aulia',  'P', 'XII-A', 'MIPA 2', 2022, 2025, 'MA-15-08-2025-00142', 6, 'diambil',   88.20],
            ['2021005', '0031234505', 'Dimas Pratama',  'Dimas',  'L', 'XII-B', 'IPS',    2021, 2024, 'MA-14-08-2024-00098', 5, 'tersimpan', 82.60],
            ['2023006', '0051234506', 'Dewi Anggraini', 'Dewi',   'P', 'XII-C', 'Tahfidz', 2023, 2026, 'MA-16-08-2026-00194', 6, 'diambil',   90.30],
            ['2023007', '0051234507', 'Fajar Ramadhan', 'Fajar',  'L', 'XII-B', 'IPS',    2023, 2026, 'MA-16-08-2026-00195', 5, 'menunggu',  83.90],
        ];

        foreach ($data as [$nis, $nisn, $nama, $panggilan, $jk, $kelas, $jurusan, $masuk, $lulus, $nomor, $jumlahDok, $status, $rata]) {
            $alumni = Alumni::updateOrCreate(['nis' => $nis], [
                'nisn'                => $nisn,
                'nama'                => $nama,
                'panggilan'           => $panggilan,
                'jenis_kelamin'       => $jk,
                'nik'                 => '16080312' . substr($nisn, -8),
                'kelas_terakhir'      => $kelas,
                'jurusan'             => $jurusan,
                'tahun_masuk'         => $masuk,
                'tahun_lulus'         => $lulus,
                'angkatan'            => $lulus - 2020,
                'tanggal_kelulusan'   => "{$lulus}-06-15",
                'nomor_ijazah'        => $nomor,
                'nomor_skl'           => '421.3/SKL/MAS-SH/' . $lulus,
                'rata_rata'           => $rata,
                'prestasi'            => "Juara harapan lomba karya ilmiah remaja tingkat kabupaten\nPeserta aktif ekstrakurikuler Pramuka",
                'status_ijazah'       => $status,
                'tanggal_pengambilan' => $status === 'diambil' ? "{$lulus}-08-20" : null,
                'diambil_oleh'        => $status === 'diambil' ? $nama : null,
                'ruang_arsip'         => 'Ruang Arsip Lt. 2',
                'lemari'              => 'Lemari A-01',
                'rak'                 => 'Rak 02',
                'kode_map'            => 'M-ALUMNI-' . $lulus . '-' . substr($nis, -3),
            ]);

            $alumni->dokumen()->delete();
            foreach (array_slice(Alumni::DOKUMEN, 0, $jumlahDok) as $i => $d) {
                $alumni->dokumen()->create([
                    'jenis'          => $d['label'],
                    'nama_file'      => $d['key'] . '_' . $nis . '.pdf',
                    'ukuran'         => (1000 + $i * 450) . ' KB',
                    'status'         => 'valid',
                    'diunggah_oleh'  => 'Ahmad Fauzi, S.Pd.',
                    'tanggal_unggah' => "{$lulus}-07-" . (18 + $i),
                ]);
            }
        }
    }
}