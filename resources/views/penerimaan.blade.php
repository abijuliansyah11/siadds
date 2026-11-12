<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Penerimaan | MAS YPI SUMBER HARJO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#0b1f3a;--green:#0f7a4f;--mint:#d9f5e8;--bg:#f3f5f9;--line:#e5e9f0;--tx:#0f1b2d;--mu:#64748b;--red:#dc2626;--amber:#d97706}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Inter,Arial,sans-serif;background:var(--bg);color:var(--tx);font-size:13px}
svg.i{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex:none}
.main{margin-left:248px}
.top{position:sticky;top:0;z-index:10;display:flex;align-items:center;gap:12px;padding:12px 28px;background:rgba(255,255,255,.85);backdrop-filter:blur(12px);border-bottom:1px solid var(--line)}
.search{display:flex;align-items:center;gap:8px;padding:9px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;color:var(--mu);transition:.25s;width:260px}
.search:focus-within{border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
.search input{border:0;outline:0;background:none;width:100%;font:inherit;color:var(--tx)}
.pill{padding:6px 10px;border-radius:99px;background:var(--mint);color:#0a5c3b;font-weight:600;font-size:11.5px}
.sp{flex:1}
.btn{display:inline-flex;align-items:center;gap:7px;padding:10px 15px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--tx);font:600 12.5px Inter,sans-serif;cursor:pointer;text-decoration:none;transition:transform .25s,box-shadow .25s}
.btn:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(11,31,58,.12)}.btn:active{transform:scale(.97)}
.btn.g{background:var(--green);border-color:var(--green);color:#fff}
.user{display:flex;align-items:center;gap:10px}
.av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--green),#142d4e);color:#fff;display:grid;place-items:center;font-weight:700}
.user small{display:block;color:var(--mu);font-size:11px}
.user form button{border:0;background:none;color:var(--red);font:600 12px Inter;cursor:pointer;padding:6px}
.wrap{padding:22px 28px 40px;max-width:1320px}
.crumb{color:var(--mu);font-size:12px;margin-bottom:6px}.crumb b{color:var(--tx);font-weight:500}
.head{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap;margin-bottom:22px}
.head h1{font-size:27px;font-weight:800;letter-spacing:-.02em;margin:6px 0}
.head p{color:var(--mu);line-height:1.6;max-width:540px}
.tools{display:flex;gap:8px;flex-wrap:wrap;align-content:flex-start;justify-content:flex-end}
select{padding:10px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font:600 12.5px Inter;color:var(--tx);cursor:pointer;outline:0}
select:focus{border-color:var(--green)}
.card{background:#fff;border:1px solid var(--line);border-radius:14px;padding:20px;transition:box-shadow .3s,transform .3s}
.card:hover{box-shadow:0 14px 34px rgba(11,31,58,.09)}
.kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:22px}
.kpi:hover{transform:translateY(-4px)}
.kpi small{font-size:10.5px;letter-spacing:.05em;color:var(--mu);font-weight:600}
.kpi .v{display:flex;justify-content:space-between;align-items:center;margin:8px 0 16px}
.kpi strong{font-size:34px;font-weight:800;letter-spacing:-.02em}
.ico{width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:var(--mint);color:var(--green)}
.kpi .f{display:flex;justify-content:space-between;align-items:center;color:var(--mu);font-size:12px}
.tag{padding:3px 9px;border-radius:99px;font-size:11px;font-weight:600;background:var(--mint);color:#0a5c3b}
.track{height:7px;background:#e8edf4;border-radius:9px;overflow:hidden;width:55%}
.fill{height:100%;background:var(--green);border-radius:9px;width:var(--w);animation:grow 1.2s cubic-bezier(.2,.8,.2,1) .7s backwards;transform-origin:left;transition:width .6s}
@keyframes grow{from{transform:scaleX(0)}}
.row{display:grid;gap:18px;margin-bottom:22px}.r1{grid-template-columns:1.7fr 1fr}.r2{grid-template-columns:1.8fr 1fr;align-items:start}
h3{font-size:17px;font-weight:700;margin-bottom:4px}.mu{color:var(--mu)}
.ch{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap}
.seg{display:inline-flex;background:#eef2f8;border-radius:10px;padding:3px;height:fit-content}
.seg button{border:0;background:none;padding:7px 12px;border-radius:8px;font:600 11.5px Inter;color:var(--mu);cursor:pointer;transition:.25s}
.seg button.on{background:var(--green);color:#fff;box-shadow:0 4px 10px rgba(15,122,79,.3)}
.chartbox{position:relative;margin-top:14px}
#chart{width:100%;height:240px;display:block}
.ln{fill:none;stroke-width:2.6;stroke-linecap:round;stroke-dasharray:1;animation:draw 1.6s ease backwards}
@keyframes draw{from{stroke-dashoffset:1}}
.ar{animation:fade 1.4s ease .8s backwards}@keyframes fade{from{opacity:0}}
#chart circle{cursor:pointer;transition:r .2s}#chart circle:hover{r:7}
#tip{position:absolute;pointer-events:none;background:var(--navy);color:#fff;padding:6px 10px;border-radius:8px;font-size:11.5px;font-weight:600;opacity:0;transform:translate(-50%,-130%);transition:opacity .2s;white-space:nowrap}
.legend{display:flex;gap:18px;font-size:12px;margin-top:8px;padding:10px 14px;background:var(--bg);border-radius:10px;flex-wrap:wrap}
.legend i{display:inline-block;width:9px;height:9px;border-radius:50%;margin-right:6px}
.donutw{display:flex;align-items:center;gap:22px;margin:18px 0;flex-wrap:wrap;justify-content:center}
.donut{position:relative;width:150px;height:150px}.donut svg{transform:rotate(-90deg)}
.donut circle{fill:none;stroke-width:13;transition:stroke-dasharray 1.4s cubic-bezier(.2,.8,.2,1)}
.donut div{position:absolute;inset:0;display:grid;place-content:center;text-align:center}
.donut b{font-size:30px;line-height:1}.donut small{color:var(--mu)}
.lg{display:grid;gap:9px;font-size:12.5px}.lg div{display:flex;align-items:center;gap:8px}.lg span{margin-left:auto;padding:2px 8px;border-radius:6px;background:var(--bg);font-weight:600;font-size:11px}
.dot{width:9px;height:9px;border-radius:50%;flex:none}
.folder{display:flex;align-items:center;gap:10px;padding:13px 14px;border-radius:10px;background:var(--bg);color:var(--mu);text-decoration:none;transition:.25s}
.folder:hover{background:var(--mint);color:var(--green)}.folder b{margin-left:auto;color:var(--green);font-size:11.5px}
.flt{display:flex;gap:8px;flex-wrap:wrap;margin:14px 0}
.chip{padding:6px 12px;border-radius:99px;border:1px solid var(--line);background:#fff;font:600 12px Inter;cursor:pointer;transition:.25s}
.chip:hover{transform:translateY(-1px)}.chip.on{background:var(--navy);color:#fff;border-color:var(--navy)}
.tw{overflow-x:auto;margin-top:12px;border-radius:10px;border:1px solid var(--line)}
table{width:100%;border-collapse:collapse;min-width:720px}
th{text-align:left;font-size:10.5px;color:var(--mu);padding:12px 10px;background:#f7f9fc;letter-spacing:.04em}
td{padding:12px 10px;border-top:1px solid var(--line);vertical-align:middle}
tbody tr{transition:background .2s;animation:rise .5s ease backwards}tbody tr:hover{background:#f8fafc}
.who{display:flex;align-items:center;gap:9px}.who b{display:block}.who small{color:var(--mu)}
.ava{width:30px;height:30px;border-radius:50%;display:grid;place-items:center;color:#fff;font-size:10.5px;font-weight:700;flex:none}
.st{padding:4px 9px;border-radius:99px;font-size:11px;font-weight:600;white-space:nowrap}
.sT{background:#dcfce7;color:#166534}.sM{background:#fef3c7;color:#92400e}.sP{background:#fee2e2;color:#b91c1c}
.pg{display:flex;justify-content:space-between;align-items:center;margin-top:16px;flex-wrap:wrap;gap:10px}
.pg div{display:flex;gap:6px}.pg button{width:30px;height:30px;border-radius:8px;border:0;background:none;font:600 12px Inter;cursor:pointer;transition:.2s}
.pg button:hover{background:var(--bg)}.pg button.on{background:var(--green);color:#fff}
.agenda{background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:14px;margin:14px 0;line-height:1.6}
.agenda b{display:flex;justify-content:space-between}.agenda .tag{background:#fde68a;color:#92400e}
.rev{background:#eef6ff;border-radius:12px;padding:14px;line-height:1.6;margin-bottom:12px}
.rev .btn{width:100%;justify-content:center;margin-top:10px;background:var(--green);color:#fff;border-color:var(--green)}
.kv{display:flex;justify-content:space-between;padding:8px 0}
.log{padding:10px 0 10px 16px;border-left:2px solid var(--line);margin-left:6px;position:relative;line-height:1.5;animation:rise .6s ease backwards}
.log::before{content:"";position:absolute;left:-5px;top:15px;width:8px;height:8px;border-radius:50%;background:var(--c,var(--green))}
.log small{display:block;color:var(--mu)}
.live{font-size:11px;color:var(--mu)}
dialog{border:0;border-radius:16px;padding:24px;width:min(420px,92vw);margin:auto;box-shadow:0 30px 80px rgba(11,31,58,.35)}
dialog::backdrop{background:rgba(11,31,58,.5);backdrop-filter:blur(3px)}
dialog[open]{animation:pop .35s cubic-bezier(.2,.8,.2,1)}@keyframes pop{from{opacity:0;transform:scale(.92) translateY(14px)}}
dialog label{display:block;font-weight:600;margin:14px 0 6px}
dialog input,dialog select{width:100%;padding:11px 12px;border:1px solid var(--line);border-radius:9px;font:inherit}
dialog input:focus{outline:0;border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
.da{display:flex;gap:8px;justify-content:flex-end;margin-top:20px}
#toast{position:fixed;right:24px;bottom:24px;background:var(--navy);color:#fff;padding:12px 18px;border-radius:12px;font-weight:600;transform:translateY(90px);opacity:0;transition:.4s cubic-bezier(.2,.8,.2,1);z-index:50}
#toast.show{transform:none;opacity:1}
.foot{text-align:center;color:var(--mu);font-size:11.5px;margin-top:10px}
.in{animation:rise .8s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--d,0)*90ms)}
@keyframes rise{from{opacity:0;transform:translateY(22px)}}
@media(max-width:1100px){.r1,.r2{grid-template-columns:1fr}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.pill{display:none}}
@media(max-width:600px){.wrap{padding:16px 14px}.search{width:100%}.top{flex-wrap:wrap}.head h1{font-size:22px}}
@media(prefers-reduced-motion:reduce){*,*::before{animation:none!important;transition:none!important}}
</style>
</head>
<body>
@php
$nama=auth()->user()->name;
$ic=fn($n)=>'<svg class="i"><use href="#'.$n.'"/></svg>';
$rows=[
['Muhammad Rizki Pratama','L','Reguler','0087419201','MTs Negeri 1 OKU Timur','2026-05-24','T'],
['Siti Aisyah Putri','P','Prestasi','0091823445','SMP IT Madani Martapura','2026-05-24','T'],
['Ahmad Fadli','L','Afirmasi','0086251433','MTs YPI Sumber Harjo','2026-05-23','M'],
['Nurul Hikmah','P','Reguler','0093847291','SMP Negeri 2 Belitang','2026-05-23','P'],
['Bagas Dwi Prasetyo','L','Reguler','0081927364','MTs Nurul Huda','2026-05-22','T'],
['Dewi Anggraini','P','Reguler','0095123876','MTs Al-Ikhlas','2026-05-22','M'],
['Rafi Alfarizi','L','Prestasi','0089912345','SMP Negeri 1 Buay Madang','2026-05-21','T'],
['Salsabila Nur','P','Afirmasi','0092233451','MTs Darul Ulum','2026-05-21','M'],
['Fajar Ramadhan','L','Reguler','0085512367','SMP Muhammadiyah Belitang','2026-05-20','M'],
['Intan Permata','P','Reguler','0094477123','MTs Negeri 2 OKU Timur','2026-05-20','T'],
];
@endphp
@include('partials.sidebar')

<div class="main">
  <header class="top in" style="--d:1">
    <label class="search">{!! $ic('search') !!}<input id="gsearch" type="search" placeholder="Cari nama, NISN, atau menu..."></label>
    <span class="pill">Sistem Aktif</span><small class="mu">TA 2026/2027 — Ganjil</small>
    <span class="sp"></span>
    <button class="btn g" data-open>{!! $ic('plus') !!}Quick Action</button>
    <div class="user"><div class="av">{{ strtoupper(substr($nama,0,1)) }}</div><div><b>{{ $nama }}</b><small>Administrator</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form></div>
  </header>

  <div class="wrap">
    <div class="crumb in" style="--d:2"><a href="{{ route('dashboard') }}" style="color:inherit;text-decoration:none">Dashboard Utama</a> › Penerimaan Siswa Baru › <b>Dashboard Penerimaan</b></div>
    <section class="head in" style="--d:3">
      <div><h1>Dashboard Penerimaan Siswa Baru</h1><span class="pill">● Gelombang 1 Aktif</span>
        <p style="margin-top:10px">Pantau alur pendaftaran, verifikasi berkas digital, seleksi tes terpadu, dan kuota penerimaan calon siswa MAS YPI Sumber Harjo.</p></div>
      <div class="tools">
        <select><option>TA 2026/2027</option><option>TA 2025/2026</option></select>
        <select><option>Gelombang 1 (Aktif)</option><option>Gelombang 2</option></select>
        <button class="btn" id="exp">{!! $ic('download') !!}Ekspor Laporan</button>
        <button class="btn g" data-open>{!! $ic('user') !!}+ Pendaftaran Baru</button>
      </div>
    </section>

    <section class="kpis">
      <div class="card kpi in" style="--d:4"><small>TOTAL PENDAFTAR</small><div class="v"><strong id="kTot">0</strong><span class="ico">{!! $ic('users') !!}</span></div><div class="f"><span>Seluruh calon siswa terdaftar</span><span class="tag">+18%</span></div></div>
      <div class="card kpi in" style="--d:5"><small>BERKAS TERVERIFIKASI</small><div class="v"><strong id="kOk">0</strong><span class="ico" style="background:#e0ecff;color:#2563eb">{!! $ic('check') !!}</span></div><div class="f"><span>Taraf Penyelesaian <b id="kPct">63%</b></span></div><div class="track" style="width:100%;margin-top:8px"><div class="fill" id="kBar" style="--w:63%"></div></div></div>
      <div class="card kpi in" style="--d:6"><small>MENUNGGU VERIFIKASI</small><div class="v"><strong id="kWait" style="color:var(--amber)">0</strong><span class="ico" style="background:#fef3c7;color:var(--amber)">{!! $ic('file') !!}</span></div><div class="f"><span>Butuh respon panitia</span><span class="tag" style="background:#fef3c7;color:#92400e">Tindakan Segera</span></div></div>
      <div class="card kpi in" style="--d:7"><small>LOLOS SELEKSI & DITERIMA</small><div class="v"><strong>112</strong><span class="ico">{!! $ic('users') !!}</span></div><div class="f"><span>Kapasitas Rombel PPDB</span><span class="tag" style="background:#e0ecff;color:#1d4ed8">112 / 160 (70%)</span></div></div>
    </section>

    <section class="row r1">
      <div class="card in" style="--d:8">
        <div class="ch"><div><h3>Tren Pendaftaran Calon Siswa</h3><p class="mu">Pergerakan submit akun dan berkas per pekan</p></div>
          <div class="seg" id="seg"><button data-r="7">7 Hari</button><button data-r="30" class="on">30 Hari</button><button data-r="all">Seluruh TA</button></div></div>
        <div class="chartbox"><svg id="chart" viewBox="0 0 600 240" preserveAspectRatio="none"></svg><div id="tip"></div></div>
        <div class="legend"><span><i style="background:var(--green)"></i>Submit Lengkap</span><span><i style="background:var(--navy)"></i>Akun Terdaftar</span><span class="mu" id="avg"></span></div>
      </div>
      <div class="card in" style="--d:9">
        <h3>Status Verifikasi Berkas</h3><p class="mu">Kelengkapan arsip akta, KK, ijazah, & foto</p>
        <div class="donutw">
          <div class="donut"><svg viewBox="0 0 100 100" width="150" height="150" id="donut"></svg><div><small>TOTAL</small><b id="dTot">0</b><small>Berkas</small></div></div>
          <div class="lg" id="lg"></div>
        </div>
        <a href="#" class="folder">{!! $ic('folder') !!}Folder Arsip Digital TA 2026 <b>Buka Direktori →</b></a>
      </div>
    </section>

    <section class="row r2">
      <div class="card in" style="--d:10" id="tblcard">
        <div class="ch"><div><h3>Pendaftar Terbaru <span class="pill">Live</span></h3><p class="mu">Calon siswa yang baru melakukan entri dan unggah berkas</p></div>
          <select id="sort"><option value="desc">Waktu Pendaftaran (Terbaru)</option><option value="asc">Waktu Pendaftaran (Terlama)</option><option value="name">Nama (A-Z)</option></select></div>
        <div class="flt" id="flt"><button class="chip on" data-f="all">Semua</button><button class="chip" data-f="M">Menunggu</button><button class="chip" data-f="T">Terverifikasi</button><button class="chip" data-f="P">Perlu Perbaikan</button></div>
        <label class="search" style="width:100%">{!! $ic('search') !!}<input id="q" placeholder="Filter nama, NISN, atau asal sekolah..."></label>
        <div class="tw"><table><thead><tr><th>NO</th><th>NO. REGISTRASI</th><th>CALON SISWA</th><th>NISN</th><th>ASAL SEKOLAH</th><th>TGL MASUK</th><th>STATUS BERKAS</th></tr></thead><tbody id="tb"></tbody></table></div>
        <div class="pg"><span class="mu" id="info"></span><div id="pager"></div></div>
      </div>
      <div class="in" style="--d:11">
        <div class="card">
          <h3>Agenda & Tindakan Cepat</h3>
          <div class="agenda"><b>Batas Akhir Gelombang 1 <span class="tag">Tersisa 6 Hari</span></b>Pendaftaran jalur reguler & prestasi ditutup 31 Mei 2026 pukul 23:59 WIB.</div>
          <div class="rev"><b>Review Berkas Menumpuk <span class="mu" id="revN"></span></b><br>Dokumen pendaftar baru butuh otentikasi SKL dan Rapor oleh tim TU.<button class="btn" id="goRev">{!! $ic('check') !!}Buka Ruang Verifikasi</button></div>
          <div class="kv"><span class="mu">Ujian CBT & Wawancara:</span><b>03 Juni 2026</b></div>
          <div class="kv"><span class="mu">Pengumuman Kelulusan:</span><b>10 Juni 2026</b></div>
        </div>
        <div class="card" style="margin-top:18px">
          <div class="ch"><h3>Aktivitas Terkini</h3><span class="live">Realtime</span></div>
          <div id="feed"></div>
        </div>
      </div>
    </section>
    <p class="foot">Sistem Informasi Arsip Digital & PPDB MAS YPI Sumber Harjo</p>
  </div>
</div>

<dialog id="dlg"><h3>Pendaftaran Baru</h3><p class="mu">Tambahkan calon siswa ke daftar pendaftar.</p>
  <form id="frm">
    <label>Nama Lengkap</label><input name="name" required maxlength="60" placeholder="Nama calon siswa">
    <label>Asal Sekolah</label><input name="school" required maxlength="60" placeholder="Contoh: MTs Negeri 1 OKU Timur">
    <label>Jalur</label><select name="jalur"><option>Reguler</option><option>Prestasi</option><option>Afirmasi</option></select>
    <label>Jenis Kelamin</label><select name="sex"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select>
    <div class="da"><button type="button" class="btn" id="cancel">Batal</button><button class="btn g">Simpan</button></div>
  </form></dialog>
<div id="toast"></div>

<script>
const $=s=>document.querySelector(s), esc=s=>String(s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const COL=['#2d6a8f','#f59e0b','#0f7a4f','#dc2626','#0b4fa8','#7c3aed'], PER=5;
const D=@json($rows).map((r,i)=>({name:r[0],sex:r[1],jalur:r[2],nisn:r[3],school:r[4],date:r[5],st:r[6],reg:'REG-2026-'+String(i+1).padStart(4,'0')}));
const S={tot:248,T:156,M:57,P:23,R:12,f:'all',q:'',sort:'desc',page:1};
const ST={T:['Terverifikasi','sT'],M:['Menunggu','sM'],P:['Perlu Perbaikan','sP']};
const fmt=d=>new Date(d+'T00:00').toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'});

/* Angka naik */
function count(el,to,dur=1300){const t0=performance.now();(function f(n){const p=Math.min((n-t0-400)/dur,1);if(p<0)return requestAnimationFrame(f);el.textContent=Math.round(to*(1-Math.pow(1-p,3)));if(p<1)requestAnimationFrame(f)})(t0)}

/* KPI & donut */
function stats(anim){
  const set=(id,v)=>anim?count($(id),v):$(id).textContent=v;
  set('#kTot',S.tot);set('#kOk',S.T);set('#kWait',S.M);set('#dTot',S.tot);
  const pct=Math.round(S.T/S.tot*100);$('#kPct').textContent=pct+'%';$('#kBar').style.setProperty('--w',pct+'%');
  $('#revN').textContent=S.M+' Berkas';
  const seg=[['Terverifikasi',S.T,'#0f7a4f'],['Menunggu Review',S.M,'#f59e0b'],['Perlu Perbaikan',S.P,'#ef4444'],['Ditolak / Gugur',S.R,'#64748b']];
  const C=2*Math.PI*40;let off=0;
  $('#donut').innerHTML=seg.map(s=>{const l=s[1]/S.tot*C,o=off;off+=l;return `<circle cx="50" cy="50" r="40" stroke="${s[2]}" stroke-dasharray="${anim?'0 '+C:(l-2)+' '+(C-l+2)}" stroke-dashoffset="${-o}" data-l="${l}" data-c="${C}"/>`}).join('');
  if(anim)setTimeout(()=>document.querySelectorAll('#donut circle').forEach(c=>c.setAttribute('stroke-dasharray',(c.dataset.l-2)+' '+(+c.dataset.c-c.dataset.l+2))),500);
  $('#lg').innerHTML=seg.map(s=>`<div><i class="dot" style="background:${s[2]}"></i>${s[0]}<span>${s[1]} · ${Math.round(s[1]/S.tot*100)}%</span></div>`).join('');
}

/* Grafik */
const CH={7:{l:['Sen','Sel','Rab','Kam','Jum','Sab','Min'],a:[8,12,15,11,18,14,12],b:[10,14,19,13,21,16,15]},
 30:{l:['Mg 1 (01-07 Mei)','Mg 2 (08-14 Mei)','Mg 3 (15-21 Mei)','Mg 4 (22-28 Mei)','Mg 5 (Target)'],a:[5,17,24,34,30],b:[4,15,26,31,36]},
 all:{l:['Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep'],a:[8,14,22,34,28,20,12,9],b:[10,17,26,37,31,23,14,10]}};
function chart(r){
  const d=CH[r],W=600,H=240,L=34,B=34,T=14,max=Math.ceil(Math.max(...d.a,...d.b)/10)*10,n=d.l.length;
  const x=i=>L+i*(W-L-10)/(n-1),y=v=>H-B-v/max*(H-B-T);
  const path=a=>a.map((v,i)=>{if(!i)return `M${x(0)},${y(v)}`;const m=(x(i-1)+x(i))/2;return `C${m},${y(a[i-1])} ${m},${y(v)} ${x(i)},${y(v)}`}).join(' ');
  let g='';for(let k=0;k<=4;k++){const v=max/4*k;g+=`<path d="M${L},${y(v)}H${W}" stroke="#e5e9f0"/><text x="0" y="${y(v)+4}" font-size="10" fill="#94a3b8">${Math.round(v)}</text>`}
  g+=d.l.map((t,i)=>`<text x="${x(i)}" y="${H-10}" font-size="${n>6?10:9}" fill="#64748b" text-anchor="${i==0?'start':i==n-1?'end':'middle'}">${n>6?t:t.split(' (')[0]}</text>`).join('');
  g+=`<path class="ar" d="${path(d.a)} L${x(n-1)},${H-B} L${x(0)},${H-B}Z" fill="rgba(15,122,79,.13)"/>`;
  g+=`<path class="ln" pathLength="1" d="${path(d.b)}" stroke="#0b1f3a" style="stroke-dasharray:.02 .015;animation-name:fade"/>`;
  g+=`<path class="ln" pathLength="1" d="${path(d.a)}" stroke="#0f7a4f"/>`;
  g+=d.a.map((v,i)=>`<circle cx="${x(i)}" cy="${y(v)}" r="4.5" fill="#fff" stroke="#0f7a4f" stroke-width="2.4" data-t="${d.l[i]}: ${v} Siswa"/>`).join('');
  $('#chart').innerHTML=g;
  $('#avg').textContent='Rerata masuk: '+Math.round(d.a.reduce((s,v)=>s+v,0)/n)+' siswa/periode · Puncak: '+Math.max(...d.a)+' calon siswa';
}
$('#seg').onclick=e=>{const b=e.target.closest('button');if(!b)return;document.querySelectorAll('#seg button').forEach(x=>x.classList.toggle('on',x===b));chart(b.dataset.r)};
$('#chart').addEventListener('mouseover',e=>{const c=e.target.closest('circle');if(!c)return;const t=$('#tip'),b=$('.chartbox').getBoundingClientRect(),r=c.getBoundingClientRect();t.textContent=c.dataset.t;t.style.left=(r.left-b.left+r.width/2)+'px';t.style.top=(r.top-b.top)+'px';t.style.opacity=1});
$('#chart').addEventListener('mouseout',()=>$('#tip').style.opacity=0);

/* Tabel */
function view(){
  let r=D.filter(x=>(S.f=='all'||x.st==S.f)&&(x.name+x.nisn+x.school+x.reg).toLowerCase().includes(S.q));
  r.sort((a,b)=>S.sort=='name'?a.name.localeCompare(b.name):S.sort=='asc'?a.date.localeCompare(b.date):b.date.localeCompare(a.date));
  const pages=Math.max(1,Math.ceil(r.length/PER));S.page=Math.min(S.page,pages);const s=(S.page-1)*PER,p=r.slice(s,s+PER);
  $('#tb').innerHTML=p.length?p.map((x,i)=>`<tr style="animation-delay:${i*60}ms"><td>${s+i+1}</td><td>${x.reg}</td><td><div class="who"><span class="ava" style="background:${COL[(s+i)%COL.length]}">${esc(x.name.split(' ').map(w=>w[0]).slice(0,2).join(''))}</span><div><b>${esc(x.name)}</b><small>${x.sex=='L'?'Laki-laki':'Perempuan'} • ${x.jalur}</small></div></div></td><td>${x.nisn}</td><td>${esc(x.school)}</td><td>${fmt(x.date)}</td><td><span class="st ${ST[x.st][1]}">${ST[x.st][0]}</span></td></tr>`).join(''):'<tr><td colspan="7" class="mu" style="text-align:center;padding:30px">Tidak ada data yang cocok.</td></tr>';
  $('#info').textContent=r.length?`Menampilkan ${s+1}-${s+p.length} dari ${r.length} pendaftar (data contoh)`:'Tidak ada data';
  $('#pager').innerHTML=Array.from({length:pages},(_,i)=>`<button class="${i+1==S.page?'on':''}" data-p="${i+1}">${i+1}</button>`).join('');
}
$('#pager').onclick=e=>{if(e.target.dataset.p){S.page=+e.target.dataset.p;view()}};
$('#flt').onclick=e=>{const b=e.target.closest('.chip');if(!b)return;S.f=b.dataset.f;S.page=1;document.querySelectorAll('.chip').forEach(c=>c.classList.toggle('on',c===b));view()};
$('#q').oninput=e=>{S.q=e.target.value.toLowerCase();S.page=1;view()};
$('#gsearch').oninput=e=>{$('#q').value=e.target.value;$('#q').oninput({target:e.target})};
$('#sort').onchange=e=>{S.sort=e.target.value;view()};
$('#goRev').onclick=()=>{document.querySelector('[data-f=M]').click();$('#tblcard').scrollIntoView({behavior:'smooth',block:'start'});toast('Menampilkan berkas yang menunggu verifikasi')};

/* Aktivitas */
const F=[['<b>Muhammad Rizki</b> memperbarui unggahan berkas rapor semester 1-5.','5 menit lalu','#0f7a4f'],['Petugas verifikasi menyetujui berkas milik <b>Siti Aisyah Putri</b>.','28 menit lalu','#2563eb'],['Notifikasi perbaikan KK dikirimkan ke <b>Nurul Hikmah</b> (dokumen buram).','1 jam lalu','#ef4444'],['Pendaftar baru terdaftar secara daring: <b>Deni Setiawan</b>.','2 jam lalu','#475569']];
const feed=(h,t,c)=>`<div class="log" style="--c:${c}">${h}<small>${t}</small></div>`;
$('#feed').innerHTML=F.map(f=>feed(...f)).join('');

/* Tambah pendaftar */
const dlg=$('#dlg');
document.querySelectorAll('[data-open]').forEach(b=>b.onclick=()=>dlg.showModal());
$('#cancel').onclick=()=>dlg.close();
$('#frm').onsubmit=e=>{e.preventDefault();const f=new FormData(e.target);
  D.unshift({name:f.get('name').trim(),sex:f.get('sex'),jalur:f.get('jalur'),school:f.get('school').trim(),nisn:'00'+String(Math.floor(Math.random()*1e8)).padStart(8,'0'),date:new Date().toISOString().slice(0,10),st:'M',reg:'REG-2026-'+String(S.tot+1).padStart(4,'0')});
  S.tot++;S.M++;stats(false);$('#feed').insertAdjacentHTML('afterbegin',feed(`Pendaftar baru: <b>${esc(f.get('name'))}</b>.`,'Baru saja','#f59e0b'));
  S.f='all';S.q='';S.page=1;$('#q').value='';document.querySelectorAll('.chip').forEach((c,i)=>c.classList.toggle('on',!i));view();
  dlg.close();e.target.reset();toast('Pendaftar baru berhasil ditambahkan');};

/* Ekspor CSV */
$('#exp').onclick=()=>{const csv=['No Registrasi,Nama,NISN,Asal Sekolah,Tanggal,Status'].concat(D.map(x=>[x.reg,x.name,x.nisn,x.school,x.date,ST[x.st][0]].map(v=>'"'+String(v).replace(/"/g,'""')+'"').join(','))).join('\n');
  const a=document.createElement('a');a.href=URL.createObjectURL(new Blob(['\ufeff'+csv],{type:'text/csv'}));a.download='laporan-pendaftar.csv';a.click();toast('Laporan diunduh');};

function toast(m){const t=$('#toast');t.textContent=m;t.classList.add('show');clearTimeout(t._t);t._t=setTimeout(()=>t.classList.remove('show'),2600)}
stats(true);chart(30);view();
</script>

@include('partials.penerimaan-aksi')
@include('partials.penerimaan-data')
@include('partials.penerimaan-tambahan')
</body>
</html>