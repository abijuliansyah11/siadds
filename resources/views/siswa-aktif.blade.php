<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Siswa Aktif | MAS YPI SUMBER HARJO</title>
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

/* ===== Tambahan khusus halaman Data Siswa Aktif ===== */
.crumb{color:var(--mu);font-size:12px;margin-bottom:10px}
.sbox{width:100%;padding:11px 14px;border:1px solid var(--line);border-radius:10px;background:var(--bg);font:inherit;color:var(--tx);outline:0}
.sbox:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
.fil{display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap;margin-top:12px}
.fil label{display:block;font-size:11px;color:var(--mu);font-weight:600;margin-bottom:4px}
.fil select{padding:10px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font:inherit;color:var(--tx);min-width:120px}
.tags{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-top:14px;color:var(--mu);font-size:12px}
.tg{padding:3px 10px;border:1px solid var(--line);border-radius:99px;font-size:11px}
.tw{overflow-x:auto;margin-top:6px}.tw table{min-width:920px}
tr.rw{cursor:pointer}tr.sel td{background:#eefaf3}
td{vertical-align:middle}
.avt{width:36px;height:36px;border-radius:50%;object-fit:cover;display:grid;place-items:center;background:linear-gradient(135deg,var(--green),var(--navy2));color:#fff;font-weight:700}
.lp{display:inline-grid;place-items:center;width:24px;height:24px;border-radius:50%;font-weight:700;font-size:11px}
.lp.L{background:#dbeafe;color:#1d4ed8}.lp.P{background:#f3e8ff;color:#7e22ce}
.pr{height:6px;background:#e8edf4;border-radius:9px;overflow:hidden;margin-top:5px}
.pr i{display:block;height:100%;border-radius:9px;background:var(--green)}.pr.w i{background:#f59e0b}
.dk{display:flex;justify-content:space-between;gap:10px;font-size:11px;font-weight:600;min-width:150px;color:var(--green)}.dk.w{color:#b45309}
.ok{background:var(--mint);color:#0a5c3b}
.pgr{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin-top:14px;color:var(--mu)}
.pgn{display:flex;gap:6px;align-items:center}
.pgn a,.pgn span{min-width:30px;height:30px;line-height:30px;text-align:center;border-radius:8px;padding:0 8px;text-decoration:none;color:var(--tx)}
.pgn .on{background:var(--green);color:#fff;font-weight:700}.pgn .off{color:#b8c1cc}
.pgn a:hover{background:var(--bg)}
.dhead{display:flex;gap:16px;align-items:center;flex-wrap:wrap}
.dhead .avt{width:56px;height:56px;border-radius:12px;font-size:20px}
.dhead h2{font-size:18px;font-weight:800}
.dtabs{display:flex;gap:24px;border-bottom:1px solid var(--line);margin:18px 0 14px}
.dtabs a{padding:10px 0;color:var(--mu);font-weight:600;text-decoration:none}.dtabs a.on{color:var(--green);border-bottom:2px solid var(--green)}
.note{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;background:#e8f6ef;padding:12px 16px;border-radius:10px;margin-bottom:14px}
.note small{color:var(--mu);display:block;margin-top:2px}
.docs{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px}
.dc{border:1px solid var(--line);border-radius:12px;padding:14px}
.dc .r{display:flex;justify-content:space-between;gap:8px}.dc b{display:block}.dc small{color:var(--mu)}
.dc .by{margin:10px 0;font-size:11px;color:var(--mu)}.dc .btn{width:100%;justify-content:center}
.dc.kosong{border-style:dashed;background:#fffbf2}
.vl{color:var(--green);font-size:10.5px;font-weight:700}.dc.kosong .vl{color:#b45309}
.empty{padding:28px;text-align:center;color:var(--mu)}
form.f{margin:0}

/* ===== Fungsi tambahan Data Siswa Aktif ===== */
[hidden]{display:none!important}
.alert{background:#fff1f1;border:1px solid #fbcaca;color:#b91c1c;border-radius:12px;padding:12px 16px}
.alert ul{margin:6px 0 0 18px;line-height:1.6}
.qa{position:relative}
.qa-menu{position:absolute;right:0;top:calc(100% + 8px);min-width:240px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 20px 44px rgba(11,31,58,.18);padding:6px;z-index:40;animation:dlg .3s cubic-bezier(.2,.8,.2,1)}
.qa-menu a,.qa-menu button{display:block;width:100%;text-align:left;padding:10px 12px;border:0;background:none;border-radius:9px;color:var(--tx);text-decoration:none;font:600 12.5px Inter,sans-serif;cursor:pointer;transition:background .2s}
.qa-menu a:hover,.qa-menu button:hover{background:var(--bg)}
.tpn{display:none}.tpn.on{display:block;animation:tabIn .5s cubic-bezier(.2,.8,.2,1)}
@keyframes tabIn{from{opacity:0;transform:translateY(12px)}}
.dtabs a{cursor:pointer}
.kv{display:grid;grid-template-columns:200px 1fr;gap:12px 18px;margin:0}.kv dt{color:var(--mu)}.kv dd{font-weight:600;margin:0}
.tl{position:relative;padding-left:26px;margin:0;list-style:none}
.tl::before{content:"";position:absolute;left:6px;top:6px;bottom:6px;width:2px;background:var(--line)}
.tl li{position:relative;margin-bottom:18px;animation:rise .6s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--i)*80ms)}
.tl li::before{content:"";position:absolute;left:-26px;top:4px;width:12px;height:12px;border-radius:50%;background:var(--green);box-shadow:0 0 0 4px #e3f6ec}
.tl small{color:var(--mu)}
dialog{border:0;border-radius:18px;padding:0;box-shadow:0 30px 80px rgba(11,31,58,.35);width:min(480px,92vw);color:var(--tx)}
dialog#dlgEdit{width:min(780px,94vw)}
dialog::backdrop{background:rgba(11,31,58,.45);backdrop-filter:blur(4px)}
dialog[open]{animation:dlg .4s cubic-bezier(.2,.8,.2,1)}
@keyframes dlg{from{opacity:0;transform:translateY(18px) scale(.97)}}
dialog form{padding:22px;max-height:88vh;overflow:auto}dialog h3{font-size:18px;margin:0 0 4px}
dialog label.f{display:block;margin-top:14px;font-size:11.5px;font-weight:600}
dialog .g2 label.f{margin-top:0}
dialog .g2{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px}.dialog .full,dialog .full{grid-column:1/-1}
dialog select,dialog input[type=file],dialog input[type=text],dialog input[type=date],dialog input[type=number],dialog input[type=tel],dialog textarea{width:100%;margin-top:5px;padding:11px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font:inherit;color:var(--tx);outline:0}
dialog input:focus,dialog select:focus,dialog textarea:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
dialog textarea{resize:vertical;min-height:70px}
.dact{display:flex;justify-content:flex-end;gap:8px;margin-top:20px}
.toast{position:fixed;right:24px;bottom:24px;z-index:60;padding:14px 18px;border-radius:14px;background:var(--navy);color:#fff;box-shadow:0 18px 40px rgba(11,31,58,.35);transform:translateY(30px);opacity:0;pointer-events:none;transition:transform .5s cubic-bezier(.2,.8,.2,1),opacity .4s;max-width:360px}
.toast.show{transform:none;opacity:1}
@media(max-width:700px){.kv{grid-template-columns:1fr}dialog .g2{grid-template-columns:1fr}}
@media print{.side,.top,.acts,.actions,.qa,dialog,.toast,.pgr,.fil,form.f,.dtabs{display:none!important}.main{margin-left:0!important}.tpn{display:block!important;animation:none}.in{animation:none!important}}
</style>
</head>
<body>
@php
$nama = auth()->user()->name ?? 'Admin';
@endphp

@include('partials.sidebar')

<div class="main">
  <header class="top in" style="--d:1">
    <form class="f" method="GET" action="{{ route('siswa.aktif') }}">
      <label class="search"><input type="search" name="q" value="{{ request('q') }}" placeholder="Cari siswa..."></label>
    </form>
    <span class="pill">Sistem Aktif</span><small class="mu">TA 2026/2027 - Ganjil (Asia/Jakarta)</small>
    <span class="sp"></span>
    <div class="qa">
      <button type="button" class="btn g" id="qaBtn" aria-haspopup="true" aria-expanded="false">+ Quick Action</button>
      <div class="qa-menu" id="qaMenu" hidden>
        <a href="{{ route('siswa.baru') }}">Tambah Siswa Baru</a>
        <a href="{{ route('pendaftaran') }}">Pendaftaran Baru (PPDB)</a>
        <a href="{{ route('siswa.detail', $terpilih ? ['id' => $terpilih->id] : []) }}">Detail Profil Siswa</a>
        <a href="{{ route('alumni') }}">Data Alumni</a>
        <button type="button" data-dlg="dlgImpor">Impor Data Siswa</button>
      </div>
    </div>
    <div class="user">
      <div class="av">{{ strtoupper(substr($nama, 0, 1)) }}</div>
      <div><b>{{ $nama }}</b><small>Administrator • OP-10492</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
    </div>
  </header>

  <div class="wrap">
    @if(session('status'))<div class="note in" style="--d:1;margin-bottom:14px"><div><b>{{ session('status') }}</b></div>@if(session('tautan'))<a class="btn" href="{{ session('tautan') }}">Lihat Detail Profil</a>@endif</div>@endif
    @if(session('peringatan'))<div class="alert in" style="--d:1;margin-bottom:14px"><b>Perhatian:</b> {{ session('peringatan') }}</div>@endif
    @if($errors->any())<div class="alert in" style="--d:1;margin-bottom:14px"><b>Gagal diproses:</b><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <div class="crumb in" style="--d:2">Dashboard › Data Siswa › <b>Data Siswa Aktif</b></div>

    <section class="hero in" style="--d:2">
      <div>
        <span class="tag">TA 2026/2027</span>
        <h1>Data Siswa Aktif</h1>
        <p>Kelola data identitas siswa aktif dan pantau kelengkapan dokumen digital serta lokasi arsip fisik MAS YPI SUMBER HARJO.</p>
      </div>
      <div class="acts">
        <a href="{{ route('siswa.baru') }}" class="btn d">+ Tambah Siswa</a>
        <a class="btn" href="{{ route('siswa.aktif.ekspor', request()->query()) }}">Ekspor Data</a>
        <button type="button" class="btn" onclick="window.print()">Cetak Data</button>
        <button type="button" class="btn" data-dlg="dlgImpor">Impor Data</button>
      </div>
    </section>

    <section class="kpis">
      <div class="card kpi in" style="--d:3"><small>Total Siswa Aktif</small><strong>{{ number_format($total) }}</strong><span>Terdaftar pada TA 2026/2027</span></div>
      <div class="card kpi in" style="--d:4"><small>Siswa Laki-laki</small><strong>{{ number_format($laki) }}</strong><span>{{ $persen($laki) }}% dari total siswa</span></div>
      <div class="card kpi in" style="--d:5"><small>Siswa Perempuan</small><strong>{{ number_format($perempuan) }}</strong><span>{{ $persen($perempuan) }}% dari total siswa</span></div>
      <div class="card kpi in" style="--d:6"><small>Rombel Kelas</small><strong>{{ number_format($jumlahRombel) }}</strong><span>Rombel aktif</span></div>
      <div class="card kpi in" style="--d:7"><small>Dokumen Belum Lengkap</small><strong class="rd">{{ number_format($belumLengkap) }}</strong><span>{{ $persen($belumLengkap) }}% perlu dilengkapi</span></div>
    </section>

    <section class="card in" style="--d:8;margin-bottom:22px">
      <form class="f" method="GET" action="{{ route('siswa.aktif') }}">
        <input class="sbox" type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama siswa, NIS, NISN, atau nama orang tua...">
        <div class="fil">
          <div><label>Tingkat / Rombel</label>
            <select name="tingkat"><option value="">Semua Kelas</option>
              @foreach(['X','XI','XII'] as $t)<option value="{{ $t }}" @selected(request('tingkat') === $t)>Kelas {{ $t }}</option>@endforeach
            </select></div>
          <div><label>Jenis Kelamin</label>
            <select name="jk"><option value="">Semua</option>
              <option value="L" @selected(request('jk') === 'L')>Laki-laki</option>
              <option value="P" @selected(request('jk') === 'P')>Perempuan</option>
            </select></div>
          <div><label>Status Dokumen</label>
            <select name="status_dokumen"><option value="">Semua Status</option>
              <option value="lengkap" @selected(request('status_dokumen') === 'lengkap')>Lengkap</option>
              <option value="belum" @selected(request('status_dokumen') === 'belum')>Belum Lengkap</option>
            </select></div>
          <div><label>Tahun Masuk</label>
            <select name="tahun"><option value="">Semua Tahun</option>
              @foreach($daftarTahun as $th)<option value="{{ $th }}" @selected((string) request('tahun') === (string) $th)>{{ $th }}</option>@endforeach
            </select></div>
          <div><label>Tampilkan</label>
            <select name="per_page">
              @foreach([10, 25, 50] as $n)<option value="{{ $n }}" @selected($perPage === $n)>{{ $n }} baris</option>@endforeach
            </select></div>
          <button class="btn g" type="submit">Terapkan</button>
          <a class="btn" href="{{ route('siswa.aktif') }}">Reset</a>
        </div>
      </form>
      <div class="tags">
        <span>Menampilkan {{ $siswa->count() }} dari {{ number_format($siswa->total()) }} siswa aktif</span>
        <span class="tg">Filter: TA 2026/2027</span><span class="tg">Status: Siswa Aktif</span>
        @if(request('q'))<span class="tg">Cari: {{ request('q') }}</span>@endif
      </div>

      <div class="tw">
      <table>
        <thead><tr><th>NO.</th><th>FOTO</th><th>NIS</th><th>NISN</th><th>NAMA LENGKAP &amp; PANGGILAN</th><th>L/P</th><th>KELAS / ROMBEL</th><th>MASUK</th><th>KELENGKAPAN DOKUMEN</th><th>STATUS</th></tr></thead>
        <tbody>
        @forelse($siswa as $i => $s)
          @php
            $valid = min($s->dokumen_valid_count, $wajib);
            $pct   = round($valid / $wajib * 100);
            $lengkap = $valid >= $wajib;
          @endphp
          <tr class="rw {{ $terpilih && $terpilih->id === $s->id ? 'sel' : '' }}" onclick="location.href='{{ request()->fullUrlWithQuery(['id' => $s->id]) }}#detail'">
            <td>{{ str_pad($siswa->firstItem() + $i, 2, '0', STR_PAD_LEFT) }}</td>
            <td>@if($s->foto)<img class="avt" src="{{ asset('storage/' . $s->foto) }}" alt="{{ $s->nama }}">@else<span class="avt">{{ strtoupper(substr($s->nama, 0, 1)) }}</span>@endif</td>
            <td><b>{{ $s->nis }}</b></td>
            <td>{{ $s->nisn }}</td>
            <td><b>{{ $s->nama }}</b><br><small class="mu">Panggilan: {{ $s->panggilan ?: '-' }}</small></td>
            <td><span class="lp {{ $s->jenis_kelamin }}">{{ $s->jenis_kelamin }}</span></td>
            <td><b>{{ $s->kelas }}</b><br><small class="mu">{{ $s->rombel }}</small></td>
            <td>{{ $s->tahun_masuk }}</td>
            <td>
              <div class="dk {{ $lengkap ? '' : 'w' }}"><span>{{ $lengkap ? 'Lengkap' : 'Kurang ' . ($wajib - $valid) . ' Berkas' }} ({{ $valid }}/{{ $wajib }})</span><span>{{ $pct }}%</span></div>
              <div class="pr {{ $lengkap ? '' : 'w' }}"><i style="width: {{ $pct }}%"></i></div>
            </td>
            <td><span class="chip ok">{{ $s->status }}</span></td>
          </tr>
        @empty
          <tr><td colspan="10" class="empty">Tidak ada siswa yang cocok. Ubah kata kunci atau filter, lalu klik Terapkan.</td></tr>
        @endforelse
        </tbody>
      </table>
      </div>

      @if($siswa->total() > 0)
      <div class="pgr">
        <span>Menampilkan <b>{{ $siswa->firstItem() }}–{{ $siswa->lastItem() }}</b> dari <b>{{ number_format($siswa->total()) }}</b> siswa aktif</span>
        <div class="pgn">
          @if($siswa->onFirstPage())<span class="off">Sebelumnya</span>@else<a href="{{ $siswa->previousPageUrl() }}">Sebelumnya</a>@endif
          @if($siswa->currentPage() > 2)<a href="{{ $siswa->url(1) }}">1</a><span>…</span>@endif
          @foreach(range(max(1, $siswa->currentPage() - 1), min($siswa->lastPage(), $siswa->currentPage() + 1)) as $p)
            @if($p === $siswa->currentPage())<span class="on">{{ $p }}</span>@else<a href="{{ $siswa->url($p) }}">{{ $p }}</a>@endif
          @endforeach
          @if($siswa->currentPage() < $siswa->lastPage() - 1)<span>…</span><a href="{{ $siswa->url($siswa->lastPage()) }}">{{ $siswa->lastPage() }}</a>@endif
          @if($siswa->hasMorePages())<a href="{{ $siswa->nextPageUrl() }}">Selanjutnya</a>@else<span class="off">Selanjutnya</span>@endif
        </div>
      </div>
      @endif
    </section>

    @if($terpilih)
    @php
      $validT = $dokumenTerpilih->where('status', 'valid')->count();
      $pctT   = round(min($validT, $wajib) / $wajib * 100);
      $lengkapT = $validT >= $wajib;
    @endphp
    <section class="card in" style="--d:9;margin-bottom:22px" id="detail">
      <div class="dhead">
        @if($terpilih->foto)<img class="avt" src="{{ asset('storage/' . $terpilih->foto) }}" alt="{{ $terpilih->nama }}">@else<span class="avt">{{ strtoupper(substr($terpilih->nama, 0, 1)) }}</span>@endif
        <div style="flex:1;min-width:220px">
          <h2>{{ $terpilih->nama }} <span class="chip ok">Siswa {{ $terpilih->status }}</span> <span class="chip wait">Kelas {{ $terpilih->kelas }}{{ $terpilih->rombel ? ' (' . $terpilih->rombel . ')' : '' }}</span></h2>
          <div class="mu" style="margin-top:6px">NIS: {{ $terpilih->nis }} • NISN: {{ $terpilih->nisn }} • Tgl Masuk: <b>{{ optional($terpilih->tanggal_masuk)->format('d-m-Y') ?? '-' }}</b></div>
          <div class="mu" style="margin-top:4px">Wali Kelas: <b>{{ $terpilih->wali_kelas ?: '-' }}</b></div>
        </div>
        <div class="acts">
          <button type="button" class="btn" data-dlg="dlgEdit">Edit Profil Siswa</button>
          <button type="button" class="btn g" data-up="">Unggah Berkas</button>
          <a class="btn" href="{{ route('siswa.aktif.buku', ['id' => $terpilih->id, 'print' => 1]) }}" target="_blank" rel="noopener">Cetak Buku Induk</a>
          <a class="btn" href="{{ route('siswa.detail', ['id' => $terpilih->id]) }}">Detail Profil</a>
          @if(str_starts_with($terpilih->kelas, 'XII-'))<form method="POST" action="{{ route('alumni.proses') }}" style="display:inline" onsubmit="return confirm('Luluskan siswa ini dan pindahkan ke Data Alumni?')">@csrf<input type="hidden" name="_form" value="proses"><input type="hidden" name="siswa_ids[]" value="{{ $terpilih->id }}"><input type="hidden" name="tahun_lulus" value="{{ now()->year }}"><input type="hidden" name="tanggal_kelulusan" value="{{ now()->format('Y-m-d') }}"><button type="submit" class="btn">Luluskan Siswa</button></form>@endif
        </div>
      </div>

      <div class="dtabs">
        <a class="on" href="#detail" data-tab="arsip">Arsip Dokumen Digital ({{ $dokumenTerpilih->count() }} Berkas)</a>
        <a href="#detail" data-tab="lokasi">Lokasi Penyimpanan Fisik</a>
        <a href="#detail" data-tab="riwayat">Riwayat Aktivitas &amp; Log Audit</a>
      </div>

      <div class="tpn on" id="tpn-arsip">
      <div class="note">
        <div><b>Status Berkas Wajib: {{ $lengkapT ? 'Lengkap' : 'Belum Lengkap' }} ({{ $validT }} dari {{ $wajib }} Dokumen Terverifikasi)</b>
        <small>{{ $lengkapT ? 'Semua dokumen persyaratan madrasah telah diverifikasi.' : 'Masih ada dokumen persyaratan yang perlu diunggah atau diverifikasi.' }}</small></div>
        <div style="min-width:170px"><div class="dk {{ $lengkapT ? '' : 'w' }}"><span></span><span>{{ $pctT }}% Selesai</span></div><div class="pr {{ $lengkapT ? '' : 'w' }}"><i style="width: {{ $pctT }}%"></i></div></div>
      </div>

      <div class="docs">
        @foreach(\App\Models\SiswaAktif::DOKUMEN_WAJIB as $jenis)
          @php $d = $dokumenTerpilih->get($jenis); @endphp
          @if($d)
          <div class="dc">
            <div class="r"><div><b>{{ $d->jenis }}</b><small>{{ $d->nama_file }}{{ $d->ukuran ? ' (' . $d->ukuran . ')' : '' }}</small></div><span class="vl">{{ strtoupper($d->status) }}</span></div>
            <div class="by">Diunggah: {{ optional($d->tanggal_unggah)->format('d-m-Y') ?? '-' }} • Oleh: {{ $d->diunggah_oleh ?: '-' }}</div>
            @if($d->path)<a class="btn" href="{{ asset('storage/' . $d->path) }}" target="_blank" rel="noopener">Pratinjau</a>@else<button type="button" class="btn" data-toast="Berkas fisik belum tersedia untuk data contoh ini. Unggah berkas melalui tombol Unggah Berkas.">Pratinjau</button>@endif
          </div>
          @else
          <div class="dc kosong">
            <div class="r"><div><b>{{ $jenis }}</b><small>Belum diunggah</small></div><span class="vl">BELUM ADA</span></div>
            <div class="by">Berkas ini perlu dilengkapi oleh operator.</div>
            <button type="button" class="btn" data-up="{{ $jenis }}">Unggah Berkas</button>
          </div>
          @endif
        @endforeach
      </div>
      </div>

      <div class="tpn" id="tpn-lokasi">
        <dl class="kv"><dt>Ruang Penyimpanan</dt><dd>{{ $terpilih->ruang_arsip ?: '-' }}</dd><dt>Lemari Berkas</dt><dd>{{ $terpilih->lemari ?: '-' }}</dd><dt>Nomor Rak</dt><dd>{{ $terpilih->rak ?: '-' }}</dd><dt>Kode Label Map Ordner</dt><dd>{{ $terpilih->kode_map ?: '-' }}</dd></dl>
      </div>

      <div class="tpn" id="tpn-riwayat">
        @php
          $logAudit = collect([['judul' => 'Siswa terdaftar di arsip digital', 'oleh' => 'Sistem SIADDS', 'waktu' => $terpilih->created_at]])
            ->merge($terpilih->dokumen->map(fn ($d) => ['judul' => 'Dokumen ' . $d->jenis . ' diunggah', 'oleh' => $d->diunggah_oleh ?: '-', 'waktu' => $d->updated_at ?? $d->created_at]))
            ->sortByDesc('waktu')->values();
        @endphp
        <ul class="tl">
          @foreach($logAudit as $i => $l)
            <li style="--i:{{ $i }}"><b>{{ $l['judul'] }}</b><br><small>{{ $l['oleh'] }} • {{ $l['waktu'] ? $l['waktu']->format('d-m-Y H:i') : '-' }}</small></li>
          @endforeach
        </ul>
      </div>
    </section>
    @endif


    <div id="reopen" data-f="{{ $errors->any() ? old('_form') : '' }}" hidden></div>

    <dialog id="dlgImpor">
      <form method="POST" action="{{ route('siswa.aktif.impor') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_form" value="impor">
        <h3>Impor Data Siswa</h3>
        <p class="mu" style="line-height:1.6">Unggah berkas CSV (bisa dibuat dari Excel dengan Save As → CSV). Kolom wajib: nis, nisn, nama, jenis_kelamin, kelas, tahun_masuk.</p>
        <p style="margin-top:8px"><a class="lnk" style="color:var(--green);font-weight:700" href="{{ route('siswa.aktif.template') }}">⬇ Unduh template CSV</a></p>
        <label class="f">Berkas CSV (maks. 2 MB)<input type="file" name="berkas" accept=".csv,.txt" required></label>
        <div class="dact"><button type="button" class="btn" data-close>Batal</button><button type="submit" class="btn g">Impor Sekarang</button></div>
      </form>
    </dialog>

    @if($terpilih)
    @php
      $opsiKelas = [];
      foreach (['X', 'XI', 'XII'] as $tk) { foreach (['A', 'B', 'C', 'D'] as $rk) { $opsiKelas[] = $tk . '-' . $rk; } }
      if (! in_array($terpilih->kelas, $opsiKelas, true)) { $opsiKelas[] = $terpilih->kelas; }
      $tg = fn ($f) => optional($terpilih->{$f})->format('Y-m-d');
    @endphp
    <dialog id="dlgEdit">
      <form method="POST" action="{{ route('siswa.aktif.update', $terpilih->id) }}">
        @csrf @method('PUT')
        <input type="hidden" name="_form" value="edit">
        <h3>Edit Profil Siswa</h3><p class="mu">{{ $terpilih->nama }} • perubahan langsung tersimpan ke database.</p>
        <div class="g2">
          <label class="f full">Nama lengkap *<input type="text" name="nama" value="{{ old('nama', $terpilih->nama) }}" required maxlength="100"></label>
          <label class="f">Nama panggilan<input type="text" name="panggilan" value="{{ old('panggilan', $terpilih->panggilan) }}" maxlength="50"></label>
          <label class="f">Jenis kelamin *<select name="jenis_kelamin" required><option value="L" @selected(old('jenis_kelamin', $terpilih->jenis_kelamin) === 'L')>Laki-laki</option><option value="P" @selected(old('jenis_kelamin', $terpilih->jenis_kelamin) === 'P')>Perempuan</option></select></label>
          <label class="f">NIS *<input type="text" name="nis" value="{{ old('nis', $terpilih->nis) }}" required maxlength="20"></label>
          <label class="f">NISN * (10 digit)<input type="text" name="nisn" value="{{ old('nisn', $terpilih->nisn) }}" required maxlength="10" inputmode="numeric"></label>
          <label class="f">Kelas *<select name="kelas" required>@foreach($opsiKelas as $k)<option value="{{ $k }}" @selected(old('kelas', $terpilih->kelas) === $k)>{{ $k }}</option>@endforeach</select></label>
          <label class="f">Peminatan / Rombel<input type="text" name="rombel" value="{{ old('rombel', $terpilih->rombel) }}" maxlength="80"></label>
          <label class="f">Tahun masuk *<input type="number" name="tahun_masuk" value="{{ old('tahun_masuk', $terpilih->tahun_masuk) }}" required min="2000" max="2100"></label>
          <label class="f">Tanggal masuk<input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $tg('tanggal_masuk')) }}"></label>
          <label class="f">Wali kelas<input type="text" name="wali_kelas" value="{{ old('wali_kelas', $terpilih->wali_kelas) }}" maxlength="100"></label>
          <label class="f">Tempat lahir<input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $terpilih->tempat_lahir) }}" maxlength="60"></label>
          <label class="f">Tanggal lahir<input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $tg('tanggal_lahir')) }}"></label>
          <label class="f">NIK (16 digit)<input type="text" name="nik" value="{{ old('nik', $terpilih->nik) }}" maxlength="16" inputmode="numeric"></label>
          <label class="f">Asal sekolah<input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $terpilih->asal_sekolah) }}" maxlength="150"></label>
          <label class="f">Nama ayah<input type="text" name="nama_ayah" value="{{ old('nama_ayah', $terpilih->nama_ayah) }}" maxlength="100"></label>
          <label class="f">Nama ibu<input type="text" name="nama_ibu" value="{{ old('nama_ibu', $terpilih->nama_ibu) }}" maxlength="100"></label>
          <label class="f">No. HP wali<input type="tel" name="no_hp_wali" value="{{ old('no_hp_wali', $terpilih->no_hp_wali) }}" maxlength="20"></label>
          <label class="f">Lemari berkas<input type="text" name="lemari" value="{{ old('lemari', $terpilih->lemari) }}" maxlength="40"></label>
          <label class="f">Nomor rak<input type="text" name="rak" value="{{ old('rak', $terpilih->rak) }}" maxlength="20"></label>
          <label class="f full">Alamat<textarea name="alamat" maxlength="500">{{ old('alamat', $terpilih->alamat) }}</textarea></label>
        </div>
        <div class="dact"><button type="button" class="btn" data-close>Batal</button><button type="submit" class="btn g">Simpan Perubahan</button></div>
      </form>
    </dialog>

    <dialog id="dlgUnggah">
      <form method="POST" action="{{ route('siswa.aktif.unggah', $terpilih->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_form" value="unggah">
        <h3>Unggah Berkas</h3><p class="mu">{{ $terpilih->nama }} • PDF / JPG / PNG, maks. 5 MB. Berkas yang sama akan diganti.</p>
        <label class="f">Jenis dokumen<select name="jenis" id="upJenis">@foreach(\App\Models\SiswaAktif::DOKUMEN_WAJIB as $j)<option value="{{ $j }}">{{ $j }}</option>@endforeach</select></label>
        <label class="f">Berkas<input type="file" name="berkas" accept=".pdf,.jpg,.jpeg,.png" required></label>
        <div class="dact"><button type="button" class="btn" data-close>Batal</button><button type="submit" class="btn g">Unggah</button></div>
      </form>
    </dialog>
    @endif

    <footer class="foot in" style="--d:10"><span>Sistem Informasi Arsip Digital &amp; Data Siswa (SIADDS) • MAS YPI Sumber Harjo</span><span>Kemenag Kab. OKU Timur</span><span>NPSN: 10648892</span><span>Tahun Ajaran 2026/2027</span></footer>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
(function () {
  function $(s, c) { return (c || document).querySelector(s); }
  function $$(s, c) { return [].slice.call((c || document).querySelectorAll(s)); }

  var tst = $('#toast'), th;
  function toast(m) { tst.textContent = m; tst.classList.add('show'); clearTimeout(th); th = setTimeout(function () { tst.classList.remove('show'); }, 4200); }
  $$('[data-toast]').forEach(function (b) { b.addEventListener('click', function () { toast(b.dataset.toast); }); });

  function bukaDialog(id) { var d = document.getElementById(id); if (d && !d.open) { d.showModal(); } }
  $$('[data-dlg]').forEach(function (b) {
    b.addEventListener('click', function () { var m = $('#qaMenu'); if (m) { m.hidden = true; } bukaDialog(b.dataset.dlg); });
  });
  $$('[data-close]').forEach(function (b) { b.addEventListener('click', function () { b.closest('dialog').close(); }); });
  $$('dialog').forEach(function (d) { d.addEventListener('click', function (e) { if (e.target === d) { d.close(); } }); });
  $$('[data-up]').forEach(function (b) {
    b.addEventListener('click', function () { var s = $('#upJenis'); if (s && b.dataset.up) { s.value = b.dataset.up; } bukaDialog('dlgUnggah'); });
  });

  var qb = $('#qaBtn'), qm = $('#qaMenu');
  if (qb && qm) {
    qb.addEventListener('click', function (e) { e.stopPropagation(); qm.hidden = !qm.hidden; qb.setAttribute('aria-expanded', String(!qm.hidden)); });
    document.addEventListener('click', function (e) { if (!qm.hidden && !qm.contains(e.target)) { qm.hidden = true; qb.setAttribute('aria-expanded', 'false'); } });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { qm.hidden = true; } });
  }

  var tabs = $$('.dtabs a[data-tab]'), panes = $$('.tpn');
  tabs.forEach(function (t) {
    t.addEventListener('click', function (e) {
      e.preventDefault();
      tabs.forEach(function (x) { x.classList.toggle('on', x === t); });
      panes.forEach(function (p) { p.classList.toggle('on', p.id === 'tpn-' + t.dataset.tab); });
    });
  });

  var ro = $('#reopen');
  if (ro && ro.dataset.f) { bukaDialog({ edit: 'dlgEdit', unggah: 'dlgUnggah', impor: 'dlgImpor' }[ro.dataset.f]); }
})();
</script>
</body>
</html>