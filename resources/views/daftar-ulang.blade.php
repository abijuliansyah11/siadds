<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar Ulang & Konversi | MAS YPI SUMBER HARJO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#0b1f3a;--green:#0f7a4f;--mint:#d9f5e8;--bg:#f3f5f9;--line:#e5e9f0;--tx:#0f1b2d;--mu:#64748b;--red:#dc2626;--soft:#eef3fa;--blue:#2563eb}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Inter,Arial,sans-serif;background:var(--bg);color:var(--tx);font-size:13px}
svg.i{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex:none}
.main{margin-left:248px}.mu{color:var(--mu)}
.top{position:sticky;top:0;z-index:10;display:flex;align-items:center;gap:12px;padding:12px 28px;background:rgba(255,255,255,.85);backdrop-filter:blur(12px);border-bottom:1px solid var(--line)}
.search{display:flex;align-items:center;gap:8px;padding:10px 12px;border:1px solid var(--line);border-radius:10px;background:var(--soft);color:var(--mu);transition:.25s}
.search:focus-within{border-color:var(--green);background:#fff;box-shadow:0 0 0 4px rgba(15,122,79,.12)}
.search input{border:0;outline:0;background:none;width:100%;font:inherit;color:var(--tx)}
.pill{padding:5px 10px;border-radius:99px;background:var(--mint);color:#0a5c3b;font-weight:600;font-size:11.5px;white-space:nowrap}
.sp{flex:1}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:7px;padding:10px 15px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--tx);font:600 12.5px Inter,sans-serif;cursor:pointer;text-decoration:none;transition:transform .25s,box-shadow .25s,opacity .25s;white-space:nowrap}
.btn:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 8px 18px rgba(11,31,58,.12)}.btn:active:not(:disabled){transform:scale(.97)}.btn:disabled{opacity:.45;cursor:not-allowed}
.btn.g{background:var(--green);border-color:var(--green);color:#fff}.btn.s{background:#dbe7fb;border-color:#dbe7fb;color:#27498a}
.user{display:flex;align-items:center;gap:10px}
.av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--green),#142d4e);color:#fff;display:grid;place-items:center;font-weight:700}
.user small{display:block;color:var(--mu);font-size:11px}
.user form button{border:0;background:none;color:var(--red);font:600 12px Inter;cursor:pointer;padding:6px}
.wrap{padding:22px 28px 50px;max-width:1320px}
.crumb{color:var(--mu);font-size:12px;margin-bottom:10px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px}.crumb a{color:inherit;text-decoration:none}.crumb b{color:var(--tx);font-weight:600}
.card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:20px;transition:box-shadow .3s}
.head{display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;align-items:center;margin-bottom:18px}
.ht{display:flex;gap:14px;align-items:center}.hi{width:52px;height:52px;border-radius:14px;background:var(--mint);color:var(--green);display:grid;place-items:center;font-size:22px;flex:none}
.head h1{font-size:25px;font-weight:800;letter-spacing:-.02em}.head p{color:var(--mu);margin-top:4px;max-width:520px;line-height:1.6}.tools{display:flex;gap:8px;flex-wrap:wrap}
select.in,input.in{padding:11px 12px;border:1.5px solid transparent;border-radius:10px;background:var(--soft);font:inherit;font-weight:500;color:var(--tx);outline:0;transition:.25s}
select.in{cursor:pointer}select.in:focus,input.in:focus{border-color:var(--green);background:#fff}input.in:read-only{color:var(--mu)}
.kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:18px}
.kpi{padding:0;overflow:hidden;transition:transform .3s,box-shadow .3s}.kpi:hover{transform:translateY(-4px);box-shadow:0 14px 34px rgba(11,31,58,.09)}
.kpi .t{padding:20px 20px 12px;display:flex;justify-content:space-between;gap:10px}.kpi small{font-size:11px;letter-spacing:.06em;color:var(--mu);font-weight:600}
.kpi strong{display:block;font-size:34px;font-weight:800;margin:8px 0 4px;color:var(--c);letter-spacing:-.02em}.kpi p{color:var(--mu);line-height:1.5}
.ico{width:40px;height:40px;border-radius:50%;display:grid;place-items:center;background:var(--bgc);color:var(--c);flex:none}.kpi .f{padding:10px 20px;background:#f8fafc;font-size:11.5px;font-weight:600;color:var(--c)}
.banner{display:flex;gap:10px;align-items:center;padding:14px 16px;border-radius:12px;background:#e3edff;color:#1e3a8a;line-height:1.5;margin-bottom:18px;justify-content:space-between;flex-wrap:wrap}
.lk{border:0;background:none;color:#1d4ed8;font:600 12px Inter;cursor:pointer}
.tabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:18px}
.tab{padding:9px 14px;border-radius:99px;border:1px solid var(--line);background:#fff;font:600 12px Inter;cursor:pointer;transition:.25s;display:flex;gap:8px;align-items:center}
.tab:hover{transform:translateY(-2px)}.tab.on{background:var(--navy);color:#fff;border-color:var(--navy)}.tab em{font-style:normal;background:var(--soft);color:#475569;padding:1px 8px;border-radius:99px;font-size:11px}.tab.on em{background:rgba(255,255,255,.2);color:#fff}
.fb{display:flex;gap:10px;align-items:center;flex-wrap:wrap}.fb .search{flex:1;min-width:220px}.fi{margin-top:12px;display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;color:var(--mu)}.fi b{color:var(--tx)}
.tw{overflow-x:auto;margin-top:16px}table{width:100%;border-collapse:collapse;min-width:1020px}
th{text-align:left;font-size:10.5px;color:var(--mu);padding:13px 10px;background:#f3f6fb;letter-spacing:.05em;white-space:nowrap}
td{padding:12px 10px;border-top:1px solid var(--line);vertical-align:middle}
tbody tr{transition:background .25s;animation:rise .5s ease backwards}tbody tr:hover{background:#f8fafc}tbody tr.sel{background:#e9f9f0}tbody tr.cur{box-shadow:inset 3px 0 0 var(--green)}
input[type=checkbox]{accent-color:var(--green);cursor:pointer;width:16px;height:16px}input[type=checkbox]:disabled{cursor:not-allowed}
.who{display:flex;align-items:center;gap:10px;min-width:180px}.who b{display:block;font-size:13.5px}
.ava{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;color:#fff;font-weight:700;font-size:11px;flex:none}
.ch{display:inline-block;padding:2px 8px;border-radius:6px;font-size:10.5px;font-weight:600;background:#e0e7ff;color:#3730a3;margin-top:3px}
.st{padding:5px 11px;border-radius:99px;font-size:11px;font-weight:600;white-space:nowrap;display:inline-block}
.dS,.kK{background:#dcfce7;color:#166534}.dD{background:#dbeafe;color:#1d4ed8}.dM{background:#e0e7ff;color:#3730a3}.kB{background:#eef2f7;color:#64748b}.kA{background:var(--navy);color:#fff}
.pb{height:6px;background:#dfe7f2;border-radius:9px;overflow:hidden;width:110px;margin-top:5px}.pb i{display:block;height:100%;background:var(--green);width:0;transition:width .9s cubic-bezier(.2,.8,.2,1)}
.pg{display:flex;justify-content:space-between;align-items:center;margin-top:16px;gap:12px;flex-wrap:wrap;color:var(--mu)}.pg .n{display:flex;gap:6px;align-items:center}
.pg .n button{min-width:32px;height:32px;border-radius:8px;border:0;background:none;font:600 12.5px Inter;cursor:pointer;transition:.2s;padding:0 8px}.pg .n button:hover:not(:disabled){background:var(--soft)}.pg .n button.on{background:var(--green);color:#fff}.pg .n button:disabled{opacity:.35}
.lay{display:grid;grid-template-columns:1.5fr 1fr;gap:18px;margin-top:18px;align-items:start}.col{display:grid;gap:18px;min-width:0}
.sh{display:flex;justify-content:space-between;align-items:flex-start;gap:10px;margin-bottom:14px}h3{font-size:16px;font-weight:700}.sh small{color:var(--mu);display:block;margin-top:3px}
.sbox{display:flex;gap:14px;padding:14px;border-radius:12px;background:#e8f0fc;align-items:center}.sbox .ava{width:62px;height:76px;border-radius:10px;font-size:18px}
.g3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:8px 14px;margin-top:8px}.g3 small{display:block;color:var(--mu);font-size:10.5px}.g3 b{font-size:12px;word-break:break-all}
.ck{display:flex;gap:12px;align-items:center;padding:12px;border-radius:10px;background:var(--soft);margin-top:10px;cursor:pointer;transition:.25s;border:2px solid transparent;line-height:1.4}
.ck:hover{transform:translateX(3px);border-color:#cfe0f7}.ck.ok{background:#eefaf3}.ck i{width:26px;height:26px;border-radius:50%;display:grid;place-items:center;font-style:normal;flex:none;border:2px solid #b7c4d9;color:#fff;transition:.3s}
.ck.ok i{background:var(--green);border-color:var(--green);transform:scale(1.1)}.ck div{flex:1}.ck small{color:var(--mu);display:block}.ck em{font-style:normal;font-size:11px;font-weight:600;padding:5px 10px;border-radius:6px;background:#dcfce7;color:#166534}.ck:not(.ok) em{background:#eef2f7;color:#64748b}
.dup{display:flex;gap:10px;padding:14px;border-radius:12px;margin:14px 0;line-height:1.5;background:#e3edff;color:#1e3a8a}.dup.bad{background:#fee2e2;color:#991b1b}
.cf{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:12px}.cf label{display:flex;justify-content:space-between;font-weight:600;margin-bottom:6px;font-size:12px}.cf label em{font-style:normal;color:var(--green);font-size:10.5px}.cf small{display:block;color:var(--mu);margin-top:5px;font-size:11px}.cf .in{width:100%}
.acts{display:flex;justify-content:center;gap:10px;margin-top:20px;flex-wrap:wrap}
.bar{height:10px;background:#dfe7f2;border-radius:9px;overflow:hidden;margin:8px 0}.bar i{display:block;height:100%;background:var(--green);width:0;transition:width 1s cubic-bezier(.2,.8,.2,1) .4s}
.rb{display:flex;justify-content:space-between;align-items:center;padding:7px 0;gap:8px}.rb span:first-child{display:flex;gap:8px;align-items:center}.dt{width:8px;height:8px;border-radius:50%;background:var(--c)}
.tg{font-size:10.5px;font-weight:600;padding:3px 9px;border-radius:6px;white-space:nowrap}.tH{background:#dcfce7;color:#166534}.tA{background:#dbeafe;color:#1d4ed8}.tB{background:#eef2f7;color:#64748b}.tP{background:#fee2e2;color:#b91c1c}
.log{padding:10px 0 10px 16px;border-left:2px solid var(--line);margin-left:5px;position:relative;line-height:1.5;animation:slide .5s ease backwards}.log::before{content:"";position:absolute;left:-5px;top:15px;width:8px;height:8px;border-radius:50%;background:var(--c)}.log small{display:block;color:var(--mu)}
@keyframes slide{from{opacity:0;transform:translateX(-16px)}}
.dir{display:flex;align-items:center;gap:14px;padding:18px 20px;border-radius:16px;background:linear-gradient(135deg,#0b1f3a,#12396a);color:#fff;cursor:pointer;transition:.3s;border:0;width:100%;text-align:left;font:inherit}
.dir:hover{transform:translateY(-4px);box-shadow:0 16px 34px rgba(11,31,58,.3)}.dir b{display:block;font-size:14px}.dir small{color:#9fb4d4}.dir span:last-child{margin-left:auto;font-size:18px}
.dir .ico{background:rgba(255,255,255,.12);color:#fff;border-radius:12px}
dialog{border:0;border-radius:18px;padding:26px;width:min(460px,94vw);margin:auto;box-shadow:0 30px 80px rgba(11,31,58,.35)}dialog::backdrop{background:rgba(11,31,58,.55);backdrop-filter:blur(4px)}
dialog[open]{animation:pop .4s cubic-bezier(.2,.8,.2,1)}@keyframes pop{from{opacity:0;transform:scale(.9) translateY(16px)}}dialog h3{margin-bottom:10px}dialog li{margin:0 0 8px 18px;line-height:1.6}.da{display:flex;justify-content:flex-end;margin-top:16px}
#toast{position:fixed;right:24px;bottom:24px;background:var(--navy);color:#fff;padding:12px 18px;border-radius:12px;font-weight:600;transform:translateY(90px);opacity:0;transition:.4s cubic-bezier(.2,.8,.2,1);z-index:50;max-width:340px}#toast.show{transform:none;opacity:1}
.in-a{animation:rise .8s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--d,0)*90ms)}@keyframes rise{from{opacity:0;transform:translateY(22px)}}
.sw{animation:swp .5s cubic-bezier(.2,.8,.2,1)}@keyframes swp{from{opacity:.2;transform:translateY(10px)}}.bad2{animation:shake .4s}@keyframes shake{25%{transform:translateX(-5px)}75%{transform:translateX(5px)}}
@media(max-width:1100px){.lay{grid-template-columns:1fr}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.pill.h,.top .search{display:none}}
@media(max-width:600px){.wrap{padding:16px 14px}.cf,.g3{grid-template-columns:1fr}.head h1{font-size:21px}}
@media(prefers-reduced-motion:reduce){*,*::before{animation:none!important;transition:none!important}}
</style>
</head>
<body>
@php $nama=auth()->user()->name; $ic=fn($n)=>'<svg class="i"><use href="#'.$n.'"/></svg>'; @endphp
@include('partials.sidebar')
<div class="main">
  <header class="top in-a" style="--d:1">
    <label class="search" style="width:280px">{!! $ic('search') !!}<input id="gs" placeholder="Cari nama, NISN, atau menu..."></label>
    <span class="pill h">Sistem Aktif</span><small class="mu">TA 2026/2027 — Ganjil</small><span class="sp"></span>
    <button class="btn g" id="qa">{!! $ic('plus') !!}Quick Action</button>
    <div class="user"><div class="av">{{ strtoupper(substr($nama,0,1)) }}</div><div><b>{{ $nama }}</b><small>Administrator</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form></div>
  </header>
  <div class="wrap">
    <div class="crumb in-a" style="--d:2"><span><a href="{{ route('dashboard') }}">Dashboard Utama</a> › <a href="{{ route('penerimaan') }}">Penerimaan Siswa Baru (PPDB)</a> › <b>Daftar Ulang & Konversi</b></span><a class="btn s" style="padding:7px 12px" href="{{ route('seleksi') }}">← Kembali ke Status & Seleksi</a></div>
    <section class="card head in-a" style="--d:3">
      <div class="ht"><span class="hi">{!! $ic('user') !!}</span><div><h1>Daftar Ulang & Konversi Siswa</h1><p>Kelola proses daftar ulang dan konversi calon siswa yang lolos seleksi menjadi siswa aktif MAS YPI SUMBER HARJO tanpa input ulang data.</p></div></div>
      <div class="tools"><select class="in"><option>📅 TA 2026/2027 (Aktif)</option></select><select class="in" id="hG"><option value="1">Gelombang 1</option><option value="2">Gelombang 2</option></select><button class="btn" id="exp">{!! $ic('download') !!}Ekspor Laporan</button><button class="btn g" id="batch">{!! $ic('user') !!}+ Konversi Terpilih (Batch)</button></div>
    </section>
    <section class="kpis" id="kpis"></section>
    <div class="banner in-a" style="--d:8"><span>🛡 <b>Validasi Integrasi Data:</b> Data konversi terhubung langsung ke Master Data Siswa Aktif tanpa membuat rekaman ganda (anti-duplikasi NIK/NISN terproteksi real-time).</span><button class="lk" id="rule">Pelajari Aturan Sinkronisasi ↗</button></div>
    <div class="tabs in-a" style="--d:9" id="tabs"></div>
    <section class="card in-a" style="--d:10">
      <div class="fb"><label class="search">{!! $ic('search') !!}<input id="q" placeholder="Cari nama, nomor registrasi, NISN, atau NIK..."></label>
        <select class="in" id="fG"><option value="">Semua Gelombang</option><option value="1" selected>Gelombang 1</option><option value="2">Gelombang 2</option></select>
        <select class="in" id="fD"><option value="">Status Daftar Ulang: Semua</option><option value="M">Menunggu</option><option value="D">Dalam Proses</option><option value="S">Selesai</option></select>
        <select class="in" id="fK"><option value="">Status Konversi: Semua</option><option value="B">Belum Siap</option><option value="K">Siap Dikonversi</option><option value="A">Siswa Aktif</option></select>
        <button class="btn g" id="apply">Terapkan</button><button class="btn" id="rst" title="Reset">↻</button></div>
      <div class="fi"><span id="info"></span><span>Urutkan: <b>Prioritas Validasi Kelengkapan</b></span></div>
      <div class="tw"><table><thead><tr><th><input type="checkbox" id="allP"></th><th>NO.</th><th>NO. REGISTRASI</th><th>CALON SISWA</th><th>NISN</th><th>ASAL SEKOLAH</th><th>TANGGAL LOLOS</th><th>PROGRES SYARAT</th><th>STATUS DU</th><th>STATUS KONVERSI</th></tr></thead><tbody id="tb"></tbody></table></div>
      <div class="pg"><span id="pinfo"></span><div class="n" id="pn"></div></div>
    </section>
    <div class="lay">
      <section class="card in-a" style="--d:11" id="pcard"></section>
      <div class="col">
        <section class="card in-a" style="--d:12" id="cap"></section>
        <section class="card in-a" style="--d:13"><div class="sh"><h3>🕘 Audit Trail Konversi</h3><small class="mu">Live System Feed</small></div><div id="logs"></div></section>
        <button class="dir in-a" style="--d:14" id="dir"><span class="ico">🎓</span><span><b>Direktori Siswa Aktif</b><small>Buka Master Data & Buku Induk Digital MAS YPI</small></span><span>→</span></button>
      </div>
    </div>
  </div>
</div>
<dialog id="dR"><h3>Aturan Sinkronisasi Konversi</h3><ol><li>Konversi hanya untuk calon siswa berstatus <b>Lolos Seleksi</b> dengan 5 dari 5 syarat daftar ulang terpenuhi.</li><li>NISN dan NIK dicek unik pada Master Data Siswa Aktif. Rekaman ganda otomatis ditolak.</li><li>NIS (Nomor Induk Siswa) dibuat berurutan: tahun masuk + nomor urut 4 digit.</li><li>Data identitas, orang tua, dan arsip berkas dipindahkan tanpa input ulang.</li><li>Setiap konversi dicatat pada audit trail dan tidak dapat dibatalkan dari halaman ini.</li></ol><div class="da"><button class="btn g" data-x>Mengerti</button></div></dialog>
<div id="toast"></div>

<script>
const $=s=>document.querySelector(s),esc=s=>String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const COL=['#2d6a8f','#f59e0b','#0f7a4f','#dc2626','#0b4fa8','#7c3aed','#0d9488'];
const SY=[['Surat Pernyataan Kesediaan & Tata Tertib Siswa','Telah ditandatangani orang tua di atas materai Rp10.000','Lengkap & Bermaterai'],['Verifikasi Ijazah Asli / SKL Legalisir Sah','Nomor seri SKL/MTs-SM/2026/089 telah dicocokkan','Valid & Sesuai EMIS'],['Konfirmasi Data Orang Tua / Wali & Kontak Darurat','Ayah: Hendra Gunawan (0812-7890-XXXX)','Tervalidasi WhatsApp'],['Penyerahan Pas Foto Fisik 3x4 (4 Lembar)','Latar belakang merah untuk kebutuhan buku induk dan kartu pelajar','Arsip Kotak PPDB-A'],['Pengukuran Seragam & Administrasi Madrasah','Seragam batik, pramuka, dan olahraga ukuran Medium','Ukuran M / Selesai']];
const RB=[['X-1','MIPA',32,27],['X-2','MIPA',32,26],['X-3','IPS',32,0],['X-4','IPS',32,0],['X-5','Agama',32,0]],TARGET=160;
const FN=['Muhammad Rizki','Siti Aisyah','Ahmad Fadli','Nurul Hikmah','Bagas Dwi','Dewi','Rafi','Salsabila','Dinda','Fajar'],LN=['Pratama','Putri','Prasetyo','Ramadhan','Saputra','Hidayati','Maharani'];
const SC=['MTsN 1 Buay Madang','MTs Sumber Makmur','SMP Negeri 1 Buay Madang','MTs YPI Sumber Harjo','SMP IT Madani OKU','MTs Nurul Huda'],JL=['Reguler','Prestasi Akademik','Afirmasi','Prestasi Tahfidz'];
const SP=[['Muhammad Rizki Pratama','Reguler',15,'0078129482','MTsN 1 Buay Madang',5,'2026-05-24'],['Siti Aisyah Putri','Prestasi Akademik',15,'0078129483','MTs Sumber Makmur',5,'2026-05-24'],['Dewi Anggraini','Prestasi Tahfidz',15,'0082910391','SMP IT Madani OKU',5,'2026-05-22'],['Dinda Maharani','Reguler',15,'0078129486','MTs YPI Sumber Harjo',2,'2026-05-23'],['Fajar Ramadhan','Reguler',16,'0078129487','SMP Negeri 1 Buay Madang',0,'2026-05-25']];
const REG=[1,2,6,5,7],PAT=[5,3,0,5,1,4,5,2,0,5];
const D=Array.from({length:24},(_,i)=>{const p=SP[i],k=p?p[5]:PAT[i%10],r=p?REG[i]:i+3;
 return{id:i+1,reg:'REG-2026-'+String(r+(i>4?5:0)).padStart(4,'0'),name:p?p[0]:FN[i%10]+' '+LN[(i*3)%7],jalur:p?p[1]:JL[i%4],age:p?p[2]:15+(i%2),nisn:p?p[3]:'00'+(78130000+i*3),nik:'16080352080'+String(80000+i).padStart(5,'0'),school:p?p[4]:SC[i%6],date:p?p[6]:'2026-05-'+String(20+(i%6)).padStart(2,'0'),nilai:+(72+((i*7)%22)+.5).toFixed(1),sy:[0,1,2,3,4].map(j=>j<k),g:i<20?1:2,nis:null,kelas:null}});
D[0].sy=[1,1,1,1,1].map(Boolean);D[0].nis='20261001';D[0].kelas='X-1';D[1].nilai=92.5;
const cnt=x=>x.sy.filter(Boolean).length,dS=x=>{const c=cnt(x);return c==5?'S':c?'D':'M'},kS=x=>x.nis?'A':cnt(x)==5?'K':'B';
const DN={M:'Menunggu',D:'Dalam Proses',S:'Selesai'},KN={B:'Belum Siap',K:'Siap Dikonversi',A:'Siswa Aktif'};
let LOGS=[['<b>Ahmad Fauzi, S.Pd.</b> mengonversi <b>Muhammad Rizki Pratama</b> menjadi Siswa Aktif<br><small>NIS: 20261001 • Hari ini, 09:15 WIB</small>','#0f7a4f'],['Panitia PPDB memverifikasi kelengkapan 5/5 dokumen fisik <b>Siti Aisyah Putri</b><br><small>Dokumen Lengkap • Hari ini, 08:40 WIB</small>','#2563eb'],['Siti Aisyah Putri menyerahkan berkas fisik dan surat kesediaan santri ke meja panitia<br><small>Loket PPDB • 25 Mei 2026, 14:20 WIB</small>','#64748b'],['Sistem SIADDS mendeteksi 42 calon siswa lolos seleksi telah memenuhi prasyarat konversi<br><small>Validasi Otomatis • 25 Mei 2026, 11:00 WIB</small>','#94a3b8']];
let S={tab:'',G:'1',D:'',K:'',q:'',page:1},sel=new Set(),cur=2,kfirst=true;const PER=5;
const now=()=>new Date().toLocaleString('id-ID',{day:'numeric',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'})+' WIB';
const fd=s=>new Date(s+'T00:00').toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'});
const ini=n=>n.split(' ').map(w=>w[0]).slice(0,2).join('');
const rank=x=>kS(x)=='K'?0:kS(x)=='B'?(cnt(x)?1:2):3,pr=x=>rank(x)*10-cnt(x);
const base=()=>D.filter(x=>!S.G||String(x.g)==S.G);
const inTab=x=>!S.tab||(S.tab=='M'&&dS(x)=='M')||(S.tab=='D'&&dS(x)=='D')||(S.tab=='S'&&dS(x)=='S')||(S.tab=='K'&&kS(x)=='K')||(S.tab=='A'&&kS(x)=='A');
function flt(){const q=S.q.toLowerCase();return base().filter(x=>inTab(x)&&(!S.D||dS(x)==S.D)&&(!S.K||kS(x)==S.K)&&(!q||(x.name+x.reg+x.nisn+x.nik).toLowerCase().includes(q))).sort((a,b)=>pr(a)-pr(b)||a.id-b.id)}
function count(el,to){const t0=performance.now();(function f(n){const p=Math.min((n-t0-300)/1100,1);if(p<0)return requestAnimationFrame(f);el.textContent=Math.round(to*(1-Math.pow(1-p,3)));if(p<1)requestAnimationFrame(f)})(t0)}
const nC=k=>base().filter(x=>k=='D'||k=='M'||k=='S'?dS(x)==k:kS(x)==k).length;
function kpis(){const v=[base().length,nC('M'),nC('S'),nC('K')],A=nC('A');
 const K=[['LOLOS SELEKSI','Calon siswa berhak daftar ulang','✔ 100% kuota tersaring gelombang '+S.G,'#0f7a4f','#dcfce7','✔'],['MENUNGGU DAFTAR ULANG','Belum konfirmasi & lengkapi syarat','ⓘ Batas akhir: 30 Juni 2026','#2563eb','#dbeafe','◷'],['DAFTAR ULANG SELESAI','Persyaratan administrasi tuntas','↗ +14 diverifikasi hari ini','#2563eb','#dbeafe','✔'],['SIAP DIKONVERSI','Layak & tervalidasi jadi Siswa Aktif','⟳ '+A+' siswa sudah dialihkan ke buku induk','#0f7a4f','#dcfce7','👤']];
 $('#kpis').innerHTML=K.map((k,i)=>`<div class="card kpi ${kfirst?'in-a':''}" style="--c:${k[3]};--bgc:${k[4]};--d:${4+i}"><div class="t"><div><small>${k[0]}</small><strong data-n="${v[i]}">${kfirst?0:v[i]}</strong><p>${k[1]}</p></div><span class="ico">${k[5]}</span></div><div class="f">${k[2]}</div></div>`).join('');
 if(kfirst)document.querySelectorAll('[data-n]').forEach(e=>count(e,+e.dataset.n));kfirst=false}
function tabs(){const T=[['','Semua Siswa Lolos',base().length],['M','Menunggu Daftar Ulang',nC('M')],['D','Dalam Proses',nC('D')],['S','Daftar Ulang Selesai',nC('S')],['K','Siap Dikonversi',nC('K')],['A','Sudah Dikonversi',nC('A')]];
 $('#tabs').innerHTML=T.map(t=>`<button class="tab ${S.tab==t[0]?'on':''}" data-tab="${t[0]}">${t[1]} <em>${t[2]}</em></button>`).join('')}
function table(){const r=flt(),pages=Math.max(1,Math.ceil(r.length/PER));S.page=Math.min(S.page,pages);const s=(S.page-1)*PER,p=r.slice(s,s+PER);
 $('#tb').innerHTML=p.length?p.map((x,i)=>{const c=cnt(x),k=kS(x);return `<tr class="${sel.has(x.id)?'sel':''} ${x.id==cur?'cur':''}" data-r="${x.id}" style="animation-delay:${i*45}ms;cursor:pointer"><td><input type="checkbox" data-c="${x.id}" ${sel.has(x.id)?'checked':''} ${k=='K'?'':'disabled'}></td><td>${s+i+1}</td><td>${x.reg}</td>
 <td><div class="who"><span class="ava" style="background:${COL[x.id%7]}">${ini(x.name)}</span><div><b>${esc(x.name)}</b><span class="ch">${x.jalur}</span> <span class="mu">• ${x.age} Th</span></div></div></td><td>${x.nisn}</td><td>${esc(x.school)}</td><td>${fd(x.date)}</td>
 <td><b style="font-size:11.5px">${c}/5 Syarat &nbsp; <span style="color:var(--green)">${c*20}%</span></b><div class="pb"><i data-w="${c*20}"></i></div></td><td><span class="st d${dS(x)}">${DN[dS(x)]}</span></td><td><span class="st k${k}">${k=='A'?'Siswa Aktif ('+x.nis+')':KN[k]}</span></td></tr>`}).join(''):'<tr><td colspan="10" style="text-align:center;padding:36px;color:var(--mu)">Tidak ada data yang cocok.</td></tr>';
 setTimeout(()=>document.querySelectorAll('.pb i').forEach(e=>e.style.width=e.dataset.w+'%'),60);
 $('#info').innerHTML=`● Menampilkan <b>${r.length?s+1:0} - ${s+p.length}</b> dari <b>${base().length}</b> calon siswa berhak daftar ulang`;
 $('#pinfo').textContent=`Menampilkan ${p.length} baris per halaman`;
 const L=[];for(let i=1;i<=pages;i++)if(i==1||i==pages||Math.abs(i-S.page)<=1)L.push(i);else if(L[L.length-1]!='…')L.push('…');
 $('#pn').innerHTML=`<button data-p="${S.page-1}" ${S.page==1?'disabled':''}>Sebelumnya</button>`+L.map(i=>i=='…'?'<span>…</span>':`<button data-p="${i}" class="${i==S.page?'on':''}">${i}</button>`).join('')+`<button data-p="${S.page+1}" ${S.page==pages?'disabled':''}>Selanjutnya</button>`;
 const ok=p.filter(x=>kS(x)=='K');$('#allP').disabled=!ok.length;$('#allP').checked=ok.length>0&&ok.every(x=>sel.has(x.id))}
const used=k=>D.filter(x=>x.kelas==k).length,rn=r=>r[3]+used(r[0]);
let kls=null;
function panel(){const x=D.find(y=>y.id==cur),c=cnt(x),k=kS(x),act=k=='A',dup=D.some(y=>y.id!=x.id&&y.nis&&(y.nisn==x.nisn||y.nik==x.nik));
 const nis=x.nis||nextNIS();
 const opts=RB.map(r=>`<option value="${r[0]}" ${rn(r)>=r[2]&&x.kelas!=r[0]?'disabled':''} ${(x.kelas||kls)==r[0]?'selected':''}>${r[0]} (${r[1]=='IPS'?'Peminatan IPS':r[1]=='MIPA'?'Peminatan MIPA':'Agama'}) — Sisa ${r[2]-rn(r)} Kursi</option>`).join('');
 $('#pcard').innerHTML=`<div class="sh"><div><h3>Panel Verifikasi Persyaratan Akhir & Penetapan NIS</h3><small>Studi Kasus Konversi: Memproses Calon Siswa Terpilih</small></div><span class="pill">${act?'Sudah Aktif':c==5?'Memenuhi Syarat Konversi':c+'/5 Syarat'}</span></div>
 <div class="sbox"><span class="ava" style="background:linear-gradient(160deg,${COL[x.id%7]},#0b1f3a)">${ini(x.name)}</span><div style="flex:1"><div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap"><b style="font-size:17px">${esc(x.name)}</b><span class="pill" style="background:var(--green);color:#fff">${x.reg}</span></div>
 <div class="g3"><div><small>NISN</small><b>${x.nisn}</b></div><div><small>NIK</small><b>${x.nik}</b></div><div><small>Asal Sekolah</small><b>${esc(x.school)}</b></div><div><small>Nilai Seleksi</small><b style="color:var(--green)">${x.nilai} (${x.nilai>=85?'Peringkat 2':'Memenuhi'})</b></div><div style="grid-column:span 2"><small>Jalur Pendaftaran</small><b>${x.jalur}</b></div></div></div></div>
 <div style="display:flex;justify-content:space-between;margin-top:18px;font-weight:700"><span>Checklist Administrasi Fisik & Kelengkapan</span><span style="font-size:11px;color:var(--green)">Status: ${c} dari 5 Terpenuhi</span></div>
 ${SY.map((s,i)=>`<div class="ck ${x.sy[i]?'ok':''}" data-s="${i}"><i>${x.sy[i]?'✓':''}</i><div><b style="font-size:12.5px">${s[0]}</b><small>${s[1]}</small></div><em>${x.sy[i]?s[2]:'Belum diverifikasi'}</em></div>`).join('')}
 <div class="dup ${dup?'bad':''}">${dup?'⚠':'🛡'}<span><b>${dup?'Duplikasi Terdeteksi:':'Pengecekan Duplikasi Sukses:'}</b> NISN (${x.nisn}) dan NIK (${x.nik}) ${dup?'sudah ada pada Master Data Siswa Aktif. Konversi ditolak.':'teridentifikasi unik. Belum pernah tercatat sebagai siswa aktif pada pangkalan data madrasah.'}</span></div>
 <h3 style="font-size:14.5px;margin-top:6px">🎓 Konfigurasi Atribut Siswa Baru MAS YPI SUMBER HARJO</h3>
 <div class="cf"><div><label>Nomor Induk Siswa (NIS Internal) <em>Auto-Generated</em></label><input class="in" readonly value="${nis}"><small>Urutan otomatis nomor buku induk tahun 2026</small></div><div><label>Kelas Awal / Rombongan Belajar</label><select class="in" id="kls" ${act?'disabled':''}>${opts}</select><small>Penempatan otomatis disesuaikan dengan nilai seleksi</small></div>
 <div><label>Tahun Ajaran Masuk</label><input class="in" readonly value="2026/2027"></div><div><label>Tanggal Terdaftar Aktif</label><input class="in" type="date" id="tgl" value="${new Date().toISOString().slice(0,10)}" ${act?'disabled':''}></div></div>
 <div class="acts"><button class="btn s" id="dr" ${act?'disabled':''}>Simpan Progres Draft</button><button class="btn g" id="cv" ${act?'disabled':''}>${act?'✔ Sudah Siswa Aktif ('+x.nis+')':'👤 Konfirmasi & Konversi ke Siswa Aktif'}</button></div>`}
function capc(){const tot=RB.reduce((a,r)=>a+rn(r),0),pct=tot/TARGET*100;
 $('#cap').innerHTML=`<div class="sh"><div><h3>Kapasitas Siswa Baru Kelas X</h3><small>Target daya tampung TA 2026/2027</small></div><span class="pill" style="background:#e0ecff;color:#1d4ed8">${RB.length} Rombel</span></div>
 <div style="background:var(--soft);border-radius:12px;padding:14px"><div style="display:flex;justify-content:space-between;font-weight:600"><span>${tot} / ${TARGET} Siswa Terkonfirmasi</span><span style="color:var(--green)">${pct.toFixed(1)}% Terpenuhi</span></div><div class="bar"><i id="cb"></i></div><small class="mu">Sisa kuota penerimaan: ${TARGET-tot} kursi</small></div>
 <div style="margin-top:12px">${RB.map(r=>{const n=rn(r),t=n>=r[2]?['Penuh','tP']:n>=28?['Hampir Penuh','tH']:n>0?['Aktif Mengisi','tA']:['Belum Dibuka','tB'];return `<div class="rb"><span><i class="dt" style="--c:${n>=28?'#0f7a4f':n?'#2563eb':'#94a3b8'}"></i>Kelas ${r[0]} (${r[1]})</span><span class="mu">${n} / ${r[2]} Siswa</span><span class="tg ${t[1]}">${t[0]}</span></div>`}).join('')}</div>`;
 setTimeout(()=>{const b=$('#cb');if(b)b.style.width=Math.min(100,pct)+'%'},60)}
function logs(){$('#logs').innerHTML=LOGS.slice(0,5).map((l,i)=>`<div class="log" style="--c:${l[1]};animation-delay:${i*60}ms">${l[0]}</div>`).join('')}
function all(){kpis();tabs();table();panel();capc();logs()}
function setCur(id){cur=id;kls=null;panel();table();const c=$('#pcard');c.classList.remove('sw');c.offsetHeight;c.classList.add('sw')}
function toast(m){const t=$('#toast');t.textContent=m;t.classList.add('show');clearTimeout(t._t);t._t=setTimeout(()=>t.classList.remove('show'),3000)}
const addLog=(h,c)=>LOGS.unshift([h+'<br><small>'+now()+'</small>',c]);
const nextNIS=()=>'2026'+String(1001+D.filter(y=>y.nis).length).padStart(4,'0');
function convert(x,kelas){if(cnt(x)<5)return 'syarat belum lengkap';if(x.nis)return 'sudah aktif';
 if(D.some(y=>y.id!=x.id&&y.nis&&(y.nisn==x.nisn||y.nik==x.nik)))return 'duplikasi NISN/NIK';
 const r=RB.find(r=>r[0]==kelas);if(!r||rn(r)>=r[2])return 'kelas penuh';x.nis=nextNIS();x.kelas=kelas;
 addLog(`<b>Ahmad Fauzi, S.Pd.</b> mengonversi <b>${esc(x.name)}</b> menjadi Siswa Aktif<br><small>NIS: ${x.nis} • Kelas ${kelas}</small>`,'#0f7a4f');return ''}
document.addEventListener('click',e=>{const t=e.target,b=t.closest('button');
 const c=t.closest('[data-c]');if(c){c.checked?sel.add(+c.dataset.c):sel.delete(+c.dataset.c);table();return}
 const tb=t.closest('[data-tab]');if(tb){S.tab=tb.dataset.tab;S.page=1;tabs();table();return}
 if(b&&b.dataset.p){S.page=+b.dataset.p;table();return}
 const sy=t.closest('[data-s]');if(sy){const x=D.find(y=>y.id==cur);if(x.nis)return toast('Siswa sudah aktif, checklist terkunci');const i=+sy.dataset.s;x.sy[i]=!x.sy[i];
  addLog(`<b>Ahmad Fauzi, S.Pd.</b> ${x.sy[i]?'memverifikasi':'membatalkan verifikasi'} syarat "${SY[i][0]}" untuk <b>${esc(x.name)}</b>`,x.sy[i]?'#2563eb':'#d97706');kls=$('#kls')?.value||null;all();return}
 const row=t.closest('[data-r]');if(row&&!t.closest('input')){setCur(+row.dataset.r);return}
 if(t.closest('[data-x]'))t.closest('dialog').close();
 if(!b)return;const x=D.find(y=>y.id==cur);
 if(b.id=='apply'){S.G=$('#fG').value;S.D=$('#fD').value;S.K=$('#fK').value;S.page=1;all();toast(flt().length+' calon siswa cocok filter')}
 if(b.id=='rst'){S={tab:'',G:'1',D:'',K:'',q:'',page:1};$('#fG').value='1';$('#fD').value='';$('#fK').value='';$('#q').value='';all();toast('Filter direset')}
 if(b.id=='dr'){kls=$('#kls').value;toast('Progres draft tersimpan (belum dikonversi)')}
 if(b.id=='cv'){const err=convert(x,$('#kls').value);if(err){const c=$('#cv');c.classList.remove('bad2');c.offsetHeight;c.classList.add('bad2');return toast('Konversi ditolak: '+err)}
  toast(x.name+' kini Siswa Aktif • NIS '+x.nis);sel.delete(x.id);const nx=D.filter(y=>kS(y)=='K'&&y.id!=x.id).sort((a,b)=>a.id-b.id)[0];all();if(nx)setTimeout(()=>setCur(nx.id),900)}
 if(b.id=='batch'){if(!sel.size)return toast('Centang calon siswa yang berstatus Siap Dikonversi');let ok=0,sk=0;
  D.filter(y=>sel.has(y.id)).forEach(y=>{const r=RB.find(r=>rn(r)<r[2]);const err=r?convert(y,r[0]):'kelas penuh';err?sk++:ok++});sel.clear();all();toast(ok+' siswa dikonversi'+(sk?`, ${sk} dilewati`:''))}
 if(b.id=='exp'){const l=flt().map(x=>[x.reg,x.name,x.nisn,x.nik,x.school,cnt(x)+'/5',DN[dS(x)],KN[kS(x)],x.nis||'-'].map(v=>'"'+String(v).replace(/"/g,'""')+'"').join(','));
  const a=document.createElement('a');a.href=URL.createObjectURL(new Blob(['\ufeff'+['No Registrasi,Nama,NISN,NIK,Asal Sekolah,Syarat,Status DU,Status Konversi,NIS'].concat(l).join('\n')],{type:'text/csv'}));a.download='daftar-ulang-konversi.csv';a.click();toast('Laporan diunduh')}
 if(b.id=='rule')$('#dR').showModal();if(b.id=='dir'||t.closest('#dir'))toast('Halaman Direktori Siswa Aktif belum dibuat');if(b.id=='qa')toast('Pilih siswa pada tabel untuk mulai memproses');
});
document.addEventListener('change',e=>{if(e.target.id=='allP'){const s=(S.page-1)*PER;flt().slice(s,s+PER).filter(x=>kS(x)=='K').forEach(x=>e.target.checked?sel.add(x.id):sel.delete(x.id));table()}
 if(e.target.id=='kls')kls=e.target.value;if(e.target.id=='hG'){S.G=e.target.value;$('#fG').value=e.target.value;S.page=1;all()}});
document.addEventListener('input',e=>{if(e.target.id=='q'||e.target.id=='gs'){S.q=e.target.value;$('#q').value=e.target.value;S.page=1;table()}});
all();
</script>
@include('partials.daftar-ulang-db')
</body>
</html>