$pengguna = \App\Models\User::first();

if (! $pengguna) {
    echo 'Tidak ada pengguna di tabel users, skrip tidak bisa dijalankan.' . PHP_EOL;
} else {
    \Illuminate\Support\Facades\Auth::guard('web')->setUser($pengguna);
    config(['app.debug' => true]);

    $kernel = app(\Illuminate\Contracts\Http\Kernel::class);
    $idDok  = \Illuminate\Support\Facades\DB::table('siswa_dokumen')->value('id');

    $arsip = [
        '/arsip-digital',
        '/arsip-digital?q=REG-2026-0007',
        '/arsip-digital?kategori=kk&verif=sah&format=png&per=25',
        '/arsip-digital?baru=1&page=2',
        '/arsip-digital/ekspor',
        '/upload-dokumen',
        '/upload-dokumen?tab=hari',
        '/upload-dokumen?tab=ditolak',
        '/upload-dokumen/cari?q=a',
        '/kelengkapan-dokumen',
        '/kelengkapan-dokumen?cakupan=aktif',
        '/kelengkapan-dokumen?status=belum&per=25',
        '/kelengkapan-dokumen?fokus=segera',
        '/kelengkapan-dokumen/ekspor',
        '/arsip-fisik',
        '/arsip-fisik?status=dipinjam',
        '/arsip-fisik?fokus=belum',
        '/arsip-fisik?q=ARS',
        '/cetak-label',
        '/cetak-label?label=belum',
        '/cetak-label?label=siap&per=25',
        '/cetak-label?fokus=lokasi',
        '/cetak-label/ekspor',
    ];
    if ($idDok) {
        $arsip[] = '/arsip-digital/' . $idDok . '/lihat';
        $arsip[] = '/arsip-digital/' . $idDok . '/unduh';
        $arsip[] = '/arsip-digital/' . $idDok . '/hash';
    }

    $lain = [
        '/dashboard', '/penerimaan', '/pendaftaran', '/calon-siswa', '/verifikasi', '/seleksi',
        '/daftar-ulang', '/siswa-aktif', '/siswa-baru', '/siswa-detail', '/alumni',
    ];

    $daftar = ['ARSIP DIGITAL & FISIK (buatan saya)' => $arsip, 'HALAMAN LAIN (milik Anda)' => $lain];
    $baik = 0;
    $gagal = 0;

    foreach ($daftar as $kelompok => $urls) {
        echo PHP_EOL . '=== ' . $kelompok . ' ===' . PHP_EOL;

        foreach ($urls as $url) {
            $kode  = 0;
            $galat = null;
            $info  = '';

            try {
                $res  = $kernel->handle(\Illuminate\Http\Request::create($url, 'GET'));
                $kode = $res->getStatusCode();

                if ($res instanceof \Symfony\Component\HttpFoundation\StreamedResponse) {
                    ob_start();
                    try {
                        $res->sendContent();
                    } catch (\Throwable $e) {
                        $galat = $e;
                    }
                    ob_end_clean();
                }
                if (! $galat && isset($res->exception) && $res->exception) {
                    $galat = $res->exception;
                }
                if ($kode >= 300 && $kode < 400) {
                    $info = '  -> ' . $res->headers->get('Location');
                }
            } catch (\Throwable $e) {
                $galat = $e;
            }

            if ($galat || $kode >= 400 || $kode === 0) {
                $gagal++;
                $pesan = $galat
                    ? get_class($galat) . ': ' . \Illuminate\Support\Str::limit($galat->getMessage(), 230)
                      . ' [' . basename($galat->getFile()) . ':' . $galat->getLine() . ']'
                    : 'kode ' . $kode . ' (lihat storage/logs/laravel.log)';
                echo 'GAGAL ' . $kode . '  ' . $url . PHP_EOL . '        ' . $pesan . PHP_EOL;
            } else {
                $baik++;
                echo 'OK    ' . $kode . '  ' . $url . $info . PHP_EOL;
            }
        }
    }

    echo PHP_EOL . '=== RINGKASAN: ' . $baik . ' OK, ' . $gagal . ' GAGAL ===' . PHP_EOL;
}