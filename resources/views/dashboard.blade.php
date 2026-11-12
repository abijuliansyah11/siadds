<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | MAS YPI SUMBER HARJO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#0b1f3a;--navy2:#142d4e;--green:#0f7a4f;--mint:#d9f5e8;--bg:#f3f5f9;--card:#fff;--line:#e5e9f0;--tx:#0f1b2d;--mu:#64748b;--red:#dc2626;--blue:#2563eb;--r:14px}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Inter,Arial,sans-serif;background:var(--bg);color:var(--tx);font-size:13px}
svg.i{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex:none}
/* Sidebar */
.side{position:fixed;inset:0 auto 0 0;width:248px;background:linear-gradient(180deg,var(--navy),#0e2748);color:#cbd5e1;padding:18px 14px;overflow-y:auto;z-index:20}
.brand{display:flex;gap:10px;align-items:center;padding:4px 6px 18px}
.brand img{width:38px;height:38px;object-fit:contain;background:#fff;border-radius:10px;padding:3px}
.brand b{color:#fff;font-size:13px;display:block}.brand small{font-size:11px;color:#8ea3c0}
.grp{font-size:10.5px;letter-spacing:.06em;color:#6f87a8;margin:18px 8px 6px;font-weight:600}
.side a{display:flex;align-items:center;gap:10px;padding:9px 10px;border-radius:9px;color:#cbd5e1;text-decoration:none;font-weight:500;transition:background .25s,transform .25s,color .25s}
.side a:hover{background:rgba(255,255,255,.07);color:#fff;transform:translateX(3px)}
.side a.on{background:rgba(255,255,255,.12);color:#fff}
.dbstat{margin:22px 4px 0;padding:11px;border-radius:10px;background:rgba(255,255,255,.06);font-size:11px}
.dbstat b{color:#fff;display:flex;align-items:center;gap:7px}.dot{width:7px;height:7px;border-radius:50%;background:#34d399;animation:pulse 2s infinite}
@keyframes pulse{50%{box-shadow:0 0 0 6px rgba(52,211,153,0)}0%{box-shadow:0 0 0 0 rgba(52,211,153,.6)}}
/* Main */
.main{margin-left:248px}
.top{position:sticky;top:0;z-index:10;display:flex;align-items:center;gap:12px;padding:12px 28px;background:rgba(255,255,255,.85);backdrop-filter:blur(12px);border-bottom:1px solid var(--line)}
.search{display:flex;align-items:center;gap:8px;padding:9px 12px;border:1px solid var(--line);border-radius:10px;width:200px;color:var(--mu);transition:.25s}
.search:focus-within{width:260px;border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
.search input{border:0;outline:0;background:none;width:100%;font:inherit}
.pill{padding:6px 10px;border-radius:99px;background:var(--mint);color:#0a5c3b;font-weight:600;font-size:11.5px}
.sp{flex:1}
.btn{display:inline-flex;align-items:center;gap:7px;padding:10px 15px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--tx);font:600 12.5px Inter,sans-serif;cursor:pointer;text-decoration:none;transition:transform .25s,box-shadow .25s,background .25s}
.btn:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(11,31,58,.12)}
.btn.g{background:var(--green);border-color:var(--green);color:#fff}.btn.d{background:var(--navy);border-color:var(--navy);color:#fff}
.user{display:flex;align-items:center;gap:10px}
.av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--green),var(--navy2));color:#fff;display:grid;place-items:center;font-weight:700}
.user small{display:block;color:var(--mu);font-size:11px}
.user form button{border:0;background:none;color:var(--red);font:600 12px Inter;cursor:pointer;padding:6px}
.wrap{padding:26px 28px 40px;max-width:1320px}
.hero{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap;margin-bottom:22px}
.tag{display:inline-block;padding:4px 10px;border-radius:99px;background:#e8eefb;color:#334e8a;font-size:11px;font-weight:600;margin-bottom:10px}
.hero h1{font-size:28px;line-height:1.2;font-weight:800;letter-spacing:-.02em;max-width:560px}
.hero p{color:var(--mu);margin-top:8px;max-width:520px;line-height:1.6}
.acts{display:flex;gap:8px;flex-wrap:wrap;align-content:flex-start}
.card{background:var(--card);border:1px solid var(--line);border-radius:var(--r);padding:18px;transition:box-shadow .3s,transform .3s}
.card:hover{box-shadow:0 14px 34px rgba(11,31,58,.09)}
.lbl{font-size:11px;font-weight:700;letter-spacing:.04em;color:var(--green)}
h3{font-size:16px;font-weight:700;margin:4px 0 6px}
.kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(135px,1fr));gap:12px;margin:10px 0 22px}
.kpi{padding:14px}.kpi:hover{transform:translateY(-4px)}
.kpi small{color:var(--mu);font-size:11px;display:flex;justify-content:space-between}
.kpi strong{display:block;font-size:26px;font-weight:800;margin:10px 0 4px;letter-spacing:-.02em}
.kpi span{color:var(--mu);font-size:11px}
.row{display:grid;gap:18px;margin-bottom:22px}.r2{grid-template-columns:1.35fr 1fr}.r3{grid-template-columns:1.6fr 1fr}
.bar{margin:16px 0}.bar div{display:flex;justify-content:space-between;margin-bottom:6px;font-weight:600}
.track{height:8px;background:#e8edf4;border-radius:9px;overflow:hidden}
.fill{height:100%;border-radius:9px;background:var(--c);width:var(--w);transform-origin:left;animation:grow 1.2s cubic-bezier(.2,.8,.2,1) .7s backwards}
@keyframes grow{from{transform:scaleX(0)}}
.gender{display:flex;justify-content:space-between;align-items:center;margin-top:26px;padding:14px;border-radius:12px;background:var(--bg)}
.aud{display:flex;justify-content:space-between;align-items:center;padding:12px;border-radius:11px;background:var(--bg);margin-top:9px}
.aud em{font-style:normal;font-weight:700;color:var(--green)}.aud small{color:var(--mu);display:block;margin-top:2px}
.chart{width:100%;height:210px;margin-top:10px}
.line{fill:none;stroke-width:2.5;stroke-dasharray:1;stroke-dashoffset:0;animation:draw 2s ease .9s backwards}
@keyframes draw{from{stroke-dashoffset:1}}
.area{animation:fade 1.6s ease 1.6s backwards}@keyframes fade{from{opacity:0}}
table{width:100%;border-collapse:collapse;margin-top:8px}
th{text-align:left;font-size:10.5px;color:var(--mu);padding:10px 8px;border-bottom:1px solid var(--line)}
td{padding:12px 8px;border-bottom:1px solid var(--line);vertical-align:top;font-size:12px}tr:last-child td{border:0}
tbody tr{transition:background .2s}tbody tr:hover{background:#f8fafc}
.chip{display:inline-block;padding:4px 9px;border-radius:99px;font-size:11px;font-weight:600;white-space:nowrap}
.bad{background:#fee2e2;color:#b91c1c}.wait{background:#e0e7ff;color:#3730a3}.mu{color:var(--mu)}.rd{color:var(--red)}
.log{padding:11px 0 11px 16px;border-left:2px solid var(--line);margin-left:6px;position:relative;line-height:1.5}
.log::before{content:"";position:absolute;left:-5px;top:16px;width:8px;height:8px;border-radius:50%;background:var(--navy)}
.log small{display:block;color:var(--mu)}
.arch{background:linear-gradient(145deg,var(--navy),#10335c);color:#cbd5e1;border:0;margin-top:18px}
.arch h3{color:#fff}.arch .kv{display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid rgba(255,255,255,.1)}
.arch .btn{width:100%;justify-content:center;margin-top:14px;background:var(--green);border-color:var(--green);color:#fff}
.foot{display:flex;gap:26px;flex-wrap:wrap;color:var(--mu);font-size:11.5px;padding-top:6px}
/* Animasi masuk: satu urutan saat halaman dibuka */
.in{animation:rise .8s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--d,0)*90ms)}
@keyframes rise{from{opacity:0;transform:translateY(22px)}}
.side{animation:slide .7s cubic-bezier(.2,.8,.2,1) backwards}@keyframes slide{from{transform:translateX(-100%)}}
@media(max-width:1100px){.r2,.r3{grid-template-columns:1fr}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.search,.pill{display:none}}
@media(max-width:600px){.wrap{padding:18px 14px}.hero h1{font-size:23px}table{display:block;overflow-x:auto}}
@media(prefers-reduced-motion:reduce){*,*::before{animation:none!important;transition:none!important}}
</style>
</head>
<body>
@php
$ic=fn($n)=>'<svg class="i"><use href="#'.$n.'"/></svg>';
$nama=auth()->user()->name;
$kpis=[['Total Seluruh Siswa',342,'+12.4% vs thn lalu'],['Siswa Aktif',286,'Kelas X, XI, XII Rombel'],['Calon Baru PPDB',56,'Gel. 1 & 2 Berjalan'],['Total Dokumen',1842,'PDF & Scan Digital'],['Dokumen Lengkap',248,'86.7% Berkas Wajib'],['Belum Lengkap',38,'Perlu tindak lanjut'],['Perlu Perbaikan',9,'Buram / Format']];
$kelas=[['Kelas X (Fase E - Merdeka)',98,'#0b1f3a','X-A, X-B, X-C'],['Kelas XI (Fase F - Peminatan)',94,'#0f7a4f','XI-IPA, XI-IPS 1, XI-IPS 2'],['Kelas XII (Kurikulum 2013)',94,'#0b1f3a','XII-MIA, XII-IIS 1, XII-IIS 2']];
$audit=[['Kartu Keluarga (KK)','332 / 342 Berkas Terverifikasi',97],['Akta Kelahiran','321 / 342 Berkas Valid',94],['Pas Foto 3x4 Resmi','311 / 342 Berkas Terupload',91],['Ijazah / SKL SMP/MTs','301 / 342 Berkas Lengkap (41 Pending)',88]];
$docs=[['Zaskia Nur Azizah','NISN: 8078921438','PPDB-2024-041','Akta Kelahiran','Resolusi rendah, teks nomor registrasi tidak terbaca','24-10-2024','Perlu Perbaikan'],['Muhammad Farhan','NISN: 8064512903','Kelas X-A','Kartu Keluarga','KK lama (format lama), belum ada barcode Dukcapil','23-10-2024','Perlu Perbaikan'],['Nurul Hidayati','NISN: 8081293341','PPDB-2024-052','Ijazah / SKL SMP','Lembar nilai belakang belum diunggah','23-10-2024','Menunggu Verifikasi'],['Bagas Saputra','NISN: 8059124409','Kelas XI-IPS 1','Pas Foto 3x4','Bukan seragam madrasah & background tidak merah','22-10-2024','Perlu Perbaikan'],['Rian Ardiansyah','NISN: 8087712391','PPDB-2024-055','KIP / PKH (Afirmasi)','Nomor KIP cocok, menunggu scan bukti buku rekening','22-10-2024','Menunggu Verifikasi']];
$logs=[['Operator Fauzi mengunggah file KK siswa Anisa Rahmawati (Kelas X-B).','Hari ini • 09:42 WIB'],['Sistem SIADDS mengonversi Calon Siswa Dimas Pratama menjadi Siswa Aktif NIS 202410045.','Hari ini • 08:15 WIB'],['Verifikator menyetujui Akta Kelahiran & Ijazah M. Rizki (PPDB Jalur Reguler).','Kemarin • 15:30 WIB'],['Penolakan Berkas: Pas Foto Bagas Saputra ditandai perlu perbaikan oleh Admin.','Kemarin • 13:10 WIB']];
@endphp

{{-- LANGKAH 3: angka & tabel dari database. Data contoh di atas tetap ada sebagai cadangan. --}}
@php
if (isset($kpiDb)) { foreach ($kpiDb as $ix => $row) { $kpis[$ix] = $row; } }
if (isset($docsDb)) { $docs = $docsDb; }
@endphp

{{-- DATA SISWA: Siswa Aktif & Alumni terhubung ke dashboard. Data contoh di atas tetap jadi cadangan bila tabel masih kosong. --}}
@php
$ds = ['aktif' => 0, 'alumni' => 0, 'pending' => 0, 'siapLulus' => 0, 'l' => 0, 'p' => 0, 'ada' => false];
try {
    $dsAktif = \App\Models\SiswaAktif::where('status', 'Aktif');
    $ds['aktif']     = (clone $dsAktif)->count();
    $ds['alumni']    = \App\Models\Alumni::count();
    $ds['pending']   = \App\Models\SiswaDokumen::where('status', 'pending')->whereHas('siswa', fn ($q) => $q->where('status', 'Aktif'))->count();
    $ds['siapLulus'] = (clone $dsAktif)->where('kelas', 'like', 'XII-%')->count();
    $ds['ada']       = ($ds['aktif'] + $ds['alumni']) > 0;

    if ($ds['ada']) {
        $kpis[0] = ['Total Seluruh Siswa', $ds['aktif'] + $ds['alumni'], $ds['alumni'] . ' alumni • ' . $ds['aktif'] . ' siswa aktif'];
    }

    if ($ds['aktif'] > 0) {
        $per = (clone $dsAktif)->select('kelas', \Illuminate\Support\Facades\DB::raw('count(*) as c'))->groupBy('kelas')->orderBy('kelas')->get();
        $kpis[1] = ['Siswa Aktif', $ds['aktif'], $per->count() . ' rombel aktif'];

        $lab = ['X' => ['Kelas X (Fase E - Merdeka)', '#0b1f3a'], 'XI' => ['Kelas XI (Fase F - Peminatan)', '#0f7a4f'], 'XII' => ['Kelas XII (Kurikulum 2013)', '#0b1f3a']];
        $kelas = [];
        foreach ($lab as $tk => $l) {
            $baris   = $per->filter(fn ($r) => str_starts_with($r->kelas, $tk . '-'));
            $kelas[] = [$l[0], (int) $baris->sum('c'), $l[1], $baris->pluck('kelas')->implode(', ') ?: '-'];
        }
        $kelasMax = max(1, max(array_column($kelas, 1)));

        $ds['l'] = (clone $dsAktif)->where('jenis_kelamin', 'L')->count();
        $ds['p'] = (clone $dsAktif)->where('jenis_kelamin', 'P')->count();
        $ds['pl'] = round($ds['l'] / $ds['aktif'] * 100, 1);
        $ds['pp'] = round($ds['p'] / $ds['aktif'] * 100, 1);

        $auditDef = [
            ['Kartu Keluarga (KK)', 'Kartu Keluarga (KK)', 'Berkas Terverifikasi'],
            ['Akta Kelahiran', 'Akta Kelahiran', 'Berkas Valid'],
            ['Pas Foto Resmi 3x4', 'Pas Foto 3x4 Resmi', 'Berkas Terupload'],
            ['Ijazah / SKL MTs', 'Ijazah / SKL SMP/MTs', 'Berkas Lengkap'],
        ];
        $audit = [];
        foreach ($auditDef as [$jenis, $label, $kata]) {
            $qd    = \App\Models\SiswaDokumen::where('jenis', $jenis)->whereHas('siswa', fn ($x) => $x->where('status', 'Aktif'));
            $ok    = (clone $qd)->where('status', 'valid')->count();
            $tunda = (clone $qd)->where('status', 'pending')->count();
            $audit[] = [$label, $ok . ' / ' . $ds['aktif'] . ' ' . $kata . ($jenis === 'Ijazah / SKL MTs' ? ' (' . $tunda . ' Pending)' : ''), (int) min(100, round($ok / $ds['aktif'] * 100))];
        }
    }

    if ($ds['ada']) {
        $wkt = function ($t) {
            $t = $t->copy()->timezone('Asia/Jakarta');
            return ($t->isToday() ? 'Hari ini' : ($t->isYesterday() ? 'Kemarin' : $t->format('d-m-Y'))) . ' • ' . $t->format('H:i') . ' WIB';
        };
        $ev = collect();
        foreach (\App\Models\SiswaAktif::latest('created_at')->limit(4)->get() as $x) {
            $ev->push(['t' => $x->created_at, 'm' => 'Siswa ' . $x->nama . ' (Kelas ' . $x->kelas . ') ditambahkan ke Data Siswa Aktif dengan NIS ' . $x->nis . '.']);
        }
        foreach (\App\Models\SiswaDokumen::with('siswa')->latest('updated_at')->limit(4)->get() as $x) {
            if ($x->siswa) {
                $ev->push(['t' => $x->updated_at ?? $x->created_at, 'm' => ($x->diunggah_oleh ?: 'Operator') . ' mengunggah ' . $x->jenis . ' siswa ' . $x->siswa->nama . ' (Kelas ' . $x->siswa->kelas . ').']);
            }
        }
        foreach (\App\Models\Alumni::latest('created_at')->limit(3)->get() as $x) {
            $ev->push(['t' => $x->created_at, 'm' => 'Siswa ' . $x->nama . ' diproses menjadi alumni Angkatan ' . \App\Models\Alumni::romawi((int) $x->angkatan) . ' dengan nomor ijazah ' . ($x->nomor_ijazah ?: '-') . '.']);
        }
        $ev = $ev->filter(fn ($e) => $e['t'])->sortByDesc('t')->take(6);
        if ($ev->isNotEmpty()) {
            $logs = $ev->map(fn ($e) => [$e['m'], $wkt($e['t'])])->values()->all();
        }
    }

    $tunggu = \App\Models\SiswaDokumen::with('siswa')->where('status', 'pending')
        ->whereHas('siswa', fn ($q) => $q->where('status', 'Aktif'))->latest('updated_at')->limit(5)->get();
    if ($tunggu->isNotEmpty()) {
        $baruDocs = $tunggu->map(fn ($x) => [
            $x->siswa->nama, 'NISN: ' . $x->siswa->nisn, 'Kelas ' . $x->siswa->kelas, $x->jenis,
            'Menunggu verifikasi operator', optional($x->tanggal_unggah)->format('d-m-Y') ?? '-', 'Menunggu Verifikasi',
            route('siswa.detail', ['id' => $x->siswa_aktif_id]),
        ])->all();
        $docsTotal = (isset($docsTotal) ? $docsTotal : count($docs)) + count($baruDocs);
        $docs = array_merge($baruDocs, $docs);
    }
} catch (\Throwable $e) {
    // Bila tabel belum tersedia, dashboard tetap tampil memakai data contoh.
}
@endphp

@include('partials.sidebar')

<div class="main">
  <header class="top in" style="--d:1">
    <label class="search">{!! $ic('search') !!}<input type="search" placeholder="Carian..."></label>
    <span class="pill">Sistem Aktif</span><small class="mu">TA 2024/2025 - Ganjil (Asia/Jakarta)</small>
    <span class="sp"></span>
    <a href="#" class="btn g">{!! $ic('plus') !!}Quick Action</a>
    <div class="user">
      <div class="av">{{ strtoupper(substr($nama,0,1)) }}</div>
      <div><b>{{ $nama }}</b><small>Administrator • OP-10492</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
    </div>
  </header>

  <div class="wrap">
    <section class="hero in" style="--d:2">
      <div>
        <span class="tag">SIADDS Versi 2.4.1 Production • ASIA/JAKARTA (WIB) • {{ now()->timezone('Asia/Jakarta')->format('d-m-Y') }}</span>
        <h1>Selamat Datang di SIADDS, {{ $nama }}</h1>
        <p>Pusat Pengelolaan Arsip Digital & Penerimaan Siswa Baru MAS YPI Sumber Harjo — Desa Sumber Harjo, Kec. Buay Madang Timur, Kab. OKU Timur.</p>
      </div>
      <div class="acts">
        <a href="#" class="btn d">{!! $ic('plus') !!}Tambah Siswa</a>
        <a href="{{ route('pendaftaran') }}" class="btn">{!! $ic('user') !!}Pendaftaran Baru (PPDB)</a>
        <a href="#" class="btn">{!! $ic('upload') !!}Upload Dokumen</a>
        <a href="{{ route('seleksi') }}" class="btn">{!! $ic('chart') !!}Status & Seleksi</a>
      </div>
    </section>

    <div class="mu in" style="--d:3;display:flex;justify-content:space-between"><span class="lbl" style="color:var(--mu)">INDIKATOR UTAMA ADMINISTRASI <span class="pill">T.A. 2024/2025</span></span><span>Sinkronisasi Terakhir: 10 Menit lalu</span></div>
    <section class="kpis">
      @foreach($kpis as $i=>$k)
        <div class="card kpi in" style="--d:{{ 4+$i }}"><small>{{ $k[0] }}</small><strong data-count="{{ $k[1] }}">0</strong><span>{{ $k[2] }}</span></div>
      @endforeach
    </section>

    <section class="card in" style="--d:8;margin-bottom:22px">
      <span class="lbl">DATA SISWA</span><h3>Pintasan Siswa Aktif &amp; Alumni</h3>
      <p class="mu" style="line-height:1.6">Alur arsip: Tambah Siswa → Siswa Aktif → Detail Profil → Proses Kelulusan → Data Alumni. Klik kartu untuk membuka halamannya.</p>
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:12px;margin-top:10px">
        <a class="aud" href="{{ route('siswa.aktif') }}" style="text-decoration:none;color:inherit;margin-top:0"><div>Siswa Aktif<small>Buka Data Siswa Aktif</small></div><em data-count="{{ $ds['aktif'] }}">0</em></a>
        <a class="aud" href="{{ route('siswa.detail') }}" style="text-decoration:none;color:inherit;margin-top:0"><div>Dokumen Menunggu Verifikasi<small>Buka Detail Profil Siswa</small></div><em data-count="{{ $ds['pending'] }}">0</em></a>
        <a class="aud" href="{{ route('alumni') }}" style="text-decoration:none;color:inherit;margin-top:0"><div>Kelas XII Siap Lulus<small>Proses di Data Alumni</small></div><em data-count="{{ $ds['siapLulus'] }}">0</em></a>
        <a class="aud" href="{{ route('alumni') }}" style="text-decoration:none;color:inherit;margin-top:0"><div>Total Alumni<small>Buka Data Alumni</small></div><em data-count="{{ $ds['alumni'] }}">0</em></a>
      </div>
      <div class="acts" style="margin-top:14px">
        <a class="btn d" href="{{ route('siswa.baru') }}">{!! $ic('plus') !!}Tambah Siswa Baru</a>
        <a class="btn" href="{{ route('siswa.aktif') }}">{!! $ic('user') !!}Data Siswa Aktif</a>
        <a class="btn" href="{{ route('siswa.detail') }}">{!! $ic('upload') !!}Detail Profil &amp; Unggah Dokumen</a>
        <a class="btn" href="{{ route('alumni') }}">{!! $ic('chart') !!}Data Alumni</a>
      </div>
    </section>

    <section class="row r2">
      <div class="card in" style="--d:9">
        <span class="lbl">DEMOGRAFI AKADEMIK</span><h3>Distribusi Siswa Menurut Tingkat Kelas & Rombel</h3>
        @foreach($kelas as $k)
          <div class="bar"><div><span>{{ $k[0] }}</span><span>{{ $k[1] }} Siswa <small class="mu">({{ $k[3] }})</small></span></div><div class="track" style="display:block"><div class="fill" style="--w:{{ round($k[1]/($kelasMax ?? 98)*100) }}%;--c:{{ $k[2] }}"></div></div></div>
        @endforeach
        <div class="gender"><b>Rasio Gender Siswa Aktif<br><small class="mu">Total {{ $ds['aktif'] > 0 ? $ds['aktif'] : 286 }} Siswa Terdaftar Emis & Simpatika</small></b><span>Laki-laki <b data-count="{{ $ds['aktif'] > 0 ? $ds['l'] : 132 }}">0</b> ({{ $ds['aktif'] > 0 ? $ds['pl'] : '46.2' }}%)</span><span>Perempuan <b data-count="{{ $ds['aktif'] > 0 ? $ds['p'] : 154 }}">0</b> ({{ $ds['aktif'] > 0 ? $ds['pp'] : '53.8' }}%)</span></div>
      </div>
      <div class="card in" style="--d:10">
        <span class="lbl">AUDIT BERKAS WAJIB</span><h3>Status Kelengkapan Arsip</h3>
        <p class="mu" style="line-height:1.6">Tingkat kepatuhan dokumen pokok pendaftar dan siswa aktif terhadap standar audit madrasah.</p>
        @foreach($audit as $a)
          <div class="aud"><div>{{ $a[0] }}<small>{{ $a[1] }}</small></div><div style="width:70px;text-align:right"><em>{{ $a[2] }}%</em><div class="track" style="margin-top:5px"><div class="fill" style="--w:{{ $a[2] }}%;--c:var(--green)"></div></div></div></div>
        @endforeach
        <p class="mu" style="margin-top:14px">Target kelengkapan akreditasi: <b>95.0%</b></p>
      </div>
    </section>

    <section class="card in" style="--d:11;margin-bottom:22px">
      <span class="lbl">AKTIVITAS PPDB 2024</span><h3>Tren Pendaftaran Calon Siswa Mingguan</h3>
      <p class="mu">Perbandingan volume berkas masuk antara Gelombang 1 (Jalur Prestasi) & Gelombang 2 (Reguler)</p>
      <svg class="chart" viewBox="0 0 700 210" preserveAspectRatio="none">
        <g stroke="#e5e9f0"><path d="M0 40H700M0 100H700M0 160H700"/></g>
        <path class="area" fill="rgba(11,31,58,.08)" d="M0 125C80 85 150 45 240 55S400 90 480 115S620 150 700 160V200H0Z"/>
        <path class="area" fill="rgba(15,122,79,.15)" d="M0 150C80 120 150 95 260 92S400 85 480 98S620 45 700 25V200H0Z"/>
        <path class="line" pathLength="1" stroke="#0b1f3a" d="M0 125C80 85 150 45 240 55S400 90 480 115S620 150 700 160"/>
        <path class="line" pathLength="1" stroke="#0f7a4f" d="M0 150C80 120 150 95 260 92S400 85 480 98S620 45 700 25"/>
      </svg>
      <div class="mu" style="display:flex;justify-content:space-between;font-size:11px"><span>Minggu 1 (Ags)</span><span>Minggu 3 (Sep)</span><span>Minggu 1 (Okt)</span><span>Minggu 3 (Okt)</span></div>
    </section>

    <section class="row r3">
      <div class="card in" style="--d:12">
        <h3><span class="rd">●</span> Dokumen Membutuhkan Tindak Lanjut Segera</h3>
        <p class="mu">Antrean berkas siswa yang terdeteksi tidak valid, buram, atau menunggu verifikasi operator.</p>
        <table><thead><tr><th>NAMA SISWA</th><th>KELAS / NO. REG</th><th>JENIS DOKUMEN</th><th>CATATAN MASALAH</th><th>TGL UNGGAH</th><th>STATUS</th></tr></thead><tbody>
        @foreach($docs as $d)
          <tr><td><b>@if(!empty($d[7]))<a href="{{ $d[7] }}" style="color:inherit;text-decoration:none">{{ $d[0] }}</a>@else{{ $d[0] }}@endif</b><br><small class="mu">{{ $d[1] }}</small></td><td>{{ $d[2] }}</td><td>{{ $d[3] }}</td><td class="{{ $d[6]=='Perlu Perbaikan' ? 'rd' : 'mu' }}">{{ $d[4] }}</td><td>{{ $d[5] }}</td><td><span class="chip {{ $d[6]=='Perlu Perbaikan' ? 'bad' : 'wait' }}">{{ $d[6] }}</span></td></tr>
        @endforeach
        </tbody></table>
        @isset($docsTotal)
        <p class="mu" style="margin-top:10px">Menampilkan {{ count($docs) }} dari {{ $docsTotal }} dokumen yang memerlukan atensi</p>
        @else
        <p class="mu" style="margin-top:10px">Menampilkan 5 dari 9 dokumen yang memerlukan atensi</p>
        @endisset
      </div>
      <div class="in" style="--d:13">
        <div class="card">
          <h3>Riwayat Aktivitas Terakhir</h3>
          @foreach($logs as $l)<div class="log">{{ $l[0] }}<small>{{ $l[1] }}</small></div>@endforeach
          <a href="#" class="btn" style="width:100%;justify-content:center;margin-top:12px">Lihat Seluruh Log Keamanan</a>
        </div>
        <div class="card arch">
          <small>Arsip Fisik Madrasah • KODE: RAK-BMT-02</small>
          <h3>Penyimpanan Map Dokumen Baru</h3>
          <p style="line-height:1.6">Batch 5 berkas fisik PPDB terverifikasi telah dialokasikan ke lemari arsip pusat:</p>
          <div style="margin-top:10px"><div class="kv"><span>Lokasi Rak</span><b>Lemari A • Rak 02</b></div><div class="kv"><span>Nomor Map</span><b>Map 041 s/d Map 045</b></div><div class="kv"><span>Label QR Code</span><b>Tercetak & Tertempel</b></div></div>
          <a href="#" class="btn">{!! $ic('print') !!}Cetak Barcode & Label Map</a>
        </div>
      </div>
    </section>

    <footer class="foot in" style="--d:14"><span>Sistem Informasi Arsip Digital & Data Siswa (SIADDS) • MAS YPI Sumber Harjo</span><span>Kemenag Kab. OKU Timur</span><span>NPSN: 10648892</span><span>Tahun Ajaran 2024/2025</span></footer>
  </div>
</div>

@include('partials.dashboard-aksi')
@includeIf('partials.dashboard-tambahan')

<script>
// Angka naik perlahan saat halaman dibuka
document.querySelectorAll('[data-count]').forEach(function (el) {
  var target = +el.dataset.count, start = performance.now(), dur = 1400;
  (function tick(now) {
    var p = Math.min((now - start - 400) / dur, 1);
    if (p < 0) return requestAnimationFrame(tick);
    el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3))).toLocaleString('id-ID');
    if (p < 1) requestAnimationFrame(tick);
  })(start);
});
</script>
</body>
</html>