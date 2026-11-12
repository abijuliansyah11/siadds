$cari = 'REG-2026-0007';
$lewati = ['migrations', 'sessions', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs', 'password_reset_tokens'];
$ketemu = [];

foreach (collect(\Illuminate\Support\Facades\Schema::getTables())->pluck('name') as $tabel) {
    if (in_array($tabel, $lewati, true)) {
        continue;
    }
    foreach (\Illuminate\Support\Facades\Schema::getColumnListing($tabel) as $kolom) {
        try {
            $jumlah = \Illuminate\Support\Facades\DB::table($tabel)->where($kolom, 'like', '%' . $cari . '%')->count();
        } catch (\Throwable $e) {
            continue;
        }
        if ($jumlah > 0) {
            $ketemu[] = $tabel . '.' . $kolom . '  (' . $jumlah . ' baris)';
        }
    }
}

echo PHP_EOL . '=== Nomor ' . $cari . ' ditemukan di: ===' . PHP_EOL;
echo $ketemu ? implode(PHP_EOL, $ketemu) : '(tidak ditemukan di tabel mana pun)';
echo PHP_EOL . PHP_EOL . '=== Daftar kolom (hanya nama kolom, tanpa isi data) ===' . PHP_EOL;

$tabelTampil = collect($ketemu)->map(fn ($x) => explode('.', $x)[0])->push('siswa_aktif')->unique();
foreach ($tabelTampil as $tabel) {
    echo $tabel . ': ' . implode(', ', \Illuminate\Support\Facades\Schema::getColumnListing($tabel)) . PHP_EOL;
}