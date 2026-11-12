<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Status & Seleksi | MAS YPI SUMBER HARJO</title>
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
.btn:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 8px 18px rgba(11,31,58,.12)}.btn:active:not(:disabled){transform:scale(.97)}.btn:disabled{opacity:.5;cursor:not-allowed}
.btn.g{background:var(--green);border-color:var(--green);color:#fff}.btn.s{background:#dbe7fb;border-color:#dbe7fb;color:#27498a}
.user{display:flex;align-items:center;gap:10px}
.av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--green),#142d4e);color:#fff;display:grid;place-items:center;font-weight:700}
.user small{display:block;color:var(--mu);font-size:11px}
.user form button{border:0;background:none;color:var(--red);font:600 12px Inter;cursor:pointer;padding:6px}
.wrap{padding:22px 28px 50px;max-width:1320px}
.crumb{color:var(--mu);font-size:12px;margin-bottom:10px;display:flex;justify-content:space-between;flex-wrap:wrap;gap:8px}.crumb a{color:inherit;text-decoration:none}.crumb b{color:var(--tx);font-weight:600}
.card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:20px;transition:box-shadow .3s}
.head{display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;align-items:flex-end;margin-bottom:18px}
.head h1{font-size:26px;font-weight:800;letter-spacing:-.02em}.head p{color:var(--mu);margin-top:6px;max-width:520px;line-height:1.6}.tools{display:flex;gap:8px;flex-wrap:wrap}
select.in,input.in,textarea.in{padding:11px 12px;border:1.5px solid transparent;border-radius:10px;background:var(--soft);font:inherit;font-weight:500;color:var(--tx);outline:0;transition:.25s}
select.in{cursor:pointer}select.in:focus,textarea.in:focus,input.in:focus{border-color:var(--green);background:#fff}
textarea.in{width:100%;resize:vertical;min-height:70px;line-height:1.5}.bad{animation:shake .4s}@keyframes shake{25%{transform:translateX(-5px)}75%{transform:translateX(5px)}}
.kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:16px;margin-bottom:18px}
.kpi{transition:transform .3s,box-shadow .3s}.kpi:hover{transform:translateY(-4px);box-shadow:0 14px 34px rgba(11,31,58,.09)}
.kpi .t{display:flex;justify-content:space-between;align-items:center;color:var(--mu);font-size:11px;letter-spacing:.06em;font-weight:600}
.ico{width:36px;height:36px;border-radius:50%;display:grid;place-items:center;background:var(--bgc);color:var(--c);font-size:15px}
.kpi strong{display:block;font-size:34px;font-weight:800;margin:8px 0 6px;color:var(--c);letter-spacing:-.02em}.kpi small{color:var(--mu)}
h3{font-size:16px;font-weight:700}
.tahap{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin:16px 0}
.th{padding:12px;border-radius:12px;cursor:pointer;transition:.3s;border:2px solid transparent}.th:hover{background:var(--soft);transform:translateY(-2px)}
.th.on{background:#e3edff;border-color:#bcd2fb}.th .n{display:flex;align-items:center;gap:8px;font-weight:700;margin-bottom:6px}
.nb{width:22px;height:22px;border-radius:50%;display:grid;place-items:center;font-size:11px;background:#e2e8f0;color:#475569;flex:none}.nb.ok{background:var(--green);color:#fff}.nb.cu{background:var(--blue);color:#fff}
.th small{display:block;color:var(--mu);line-height:1.5}.th .s{font-weight:600;margin-top:4px;color:var(--green)}
.note{padding:12px 14px;border-radius:10px;background:var(--soft);color:#27498a;display:flex;gap:8px;line-height:1.5}
.tabs{display:flex;gap:8px;flex-wrap:wrap;margin:18px 0}
.tab{padding:9px 14px;border-radius:99px;border:1px solid var(--line);background:#fff;font:600 12px Inter;cursor:pointer;transition:.25s;display:flex;gap:8px;align-items:center}
.tab:hover{transform:translateY(-2px)}.tab.on{background:var(--navy);color:#fff;border-color:var(--navy)}.tab em{font-style:normal;background:var(--soft);color:#475569;padding:1px 8px;border-radius:99px;font-size:11px}.tab.on em{background:rgba(255,255,255,.2);color:#fff}
.fb{display:flex;gap:10px;align-items:center;flex-wrap:wrap}.fb .search{flex:1;min-width:220px}.fi{margin-top:12px;display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;color:var(--mu)}.fi b{color:var(--tx)}
.tw{overflow-x:auto;margin-top:6px}table{width:100%;border-collapse:collapse;min-width:1020px}
th{text-align:left;font-size:10.5px;color:var(--mu);padding:13px 10px;background:#f3f6fb;letter-spacing:.05em;white-space:nowrap}
td{padding:12px 10px;border-top:1px solid var(--line);vertical-align:middle}
tbody tr{transition:background .25s;animation:rise .5s ease backwards}tbody tr:hover{background:#f8fafc}tbody tr.sel{background:#e9f9f0}tbody tr.cur{box-shadow:inset 3px 0 0 var(--green)}
input[type=checkbox],input[type=radio]{accent-color:var(--green);cursor:pointer;width:16px;height:16px}
.who{display:flex;align-items:center;gap:10px;min-width:170px}.who b{display:block}.who small{color:var(--green);font-weight:500}
.ava{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;color:#fff;font-weight:700;font-size:11px;flex:none}
.st{padding:5px 11px;border-radius:99px;font-size:11px;font-weight:600;white-space:nowrap;display:inline-block}
.bT,.sL{background:#dcfce7;color:#166534}.bP,.sX{background:#fee2e2;color:#b91c1c}.bM,.sM{background:#e0e7ff;color:#3730a3}.sD{background:#dbeafe;color:#1d4ed8}.sC{background:#fef3c7;color:#92400e}
.pg{display:flex;justify-content:space-between;align-items:center;margin-top:16px;gap:12px;flex-wrap:wrap;color:var(--mu)}.pg .n{display:flex;gap:6px;align-items:center}
.pg .n button{min-width:32px;height:32px;border-radius:8px;border:0;background:none;font:600 12.5px Inter;cursor:pointer;transition:.2s}.pg .n button:hover:not(:disabled){background:var(--soft)}.pg .n button.on{background:var(--green);color:#fff}.pg .n button:disabled{opacity:.35}
.lk{border:0;background:none;color:#1d4ed8;font:600 12px Inter;cursor:pointer}
.lay{display:grid;grid-template-columns:1.55fr 1fr;gap:18px;margin-top:18px;align-items:start}.col{display:grid;gap:18px;min-width:0}
.sh{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:14px}.sh small{color:var(--mu);display:block;margin-top:2px}
.who2{display:flex;gap:12px;align-items:center;padding:14px;border-radius:12px;background:#e8f0fc;justify-content:space-between;flex-wrap:wrap}
.ck{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin:12px 0 16px}.ci{display:flex;gap:10px;align-items:center;padding:10px;border-radius:10px;background:var(--soft);line-height:1.4;font-size:12px}
.ci i{width:22px;height:22px;border-radius:50%;display:grid;place-items:center;font-style:normal;color:#fff;font-size:11px;flex:none;background:var(--green)}.ci.no i{background:var(--red)}.ci b{margin-left:auto;font-size:11px;color:var(--green)}.ci.no b{color:var(--red)}
.ops{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin:10px 0 14px}
.op{display:flex;gap:10px;padding:12px;border-radius:10px;background:var(--soft);cursor:pointer;border:2px solid transparent;transition:.25s;align-items:flex-start;line-height:1.4}
.op:hover{transform:translateY(-2px)}.op.on{border-color:var(--green);background:#e8f8ef}.op.on.x{border-color:var(--red);background:#fff1f1}.op b{display:block;font-size:12.5px}.op small{color:var(--mu)}.op.lock{pointer-events:none;opacity:.6}
.acts{display:flex;justify-content:space-between;align-items:center;margin-top:14px;gap:10px;flex-wrap:wrap}
.bar{height:8px;background:#dfe7f2;border-radius:9px;overflow:hidden;margin:8px 0}.bar i{display:block;height:100%;background:var(--green);width:0;transition:width 1s cubic-bezier(.2,.8,.2,1) .4s}
.kv{display:flex;justify-content:space-between;padding:6px 0}.kv b{font-weight:700}.gbox{background:var(--soft);border-radius:12px;padding:10px 14px;margin:12px 0}
.log{padding:10px 0 10px 16px;border-left:2px solid var(--line);margin-left:5px;position:relative;line-height:1.5;animation:slide .5s ease backwards}.log::before{content:"";position:absolute;left:-5px;top:15px;width:8px;height:8px;border-radius:50%;background:var(--c)}.log small{display:block;color:var(--mu)}
@keyframes slide{from{opacity:0;transform:translateX(-16px)}}
dialog{border:0;border-radius:18px;padding:26px;width:min(460px,94vw);margin:auto;box-shadow:0 30px 80px rgba(11,31,58,.35)}dialog::backdrop{background:rgba(11,31,58,.55);backdrop-filter:blur(4px)}
dialog[open]{animation:pop .4s cubic-bezier(.2,.8,.2,1)}@keyframes pop{from{opacity:0;transform:scale(.9) translateY(16px)}}
dialog h3{margin-bottom:6px}dialog .op{margin-top:8px}.da{display:flex;gap:8px;justify-content:flex-end;margin-top:20px}.sk{max-height:300px;overflow:auto;margin-top:12px;font-size:12.5px}.sk li{padding:6px 0;border-bottom:1px solid var(--line);margin-left:18px}
#toast{position:fixed;right:24px;bottom:24px;background:var(--navy);color:#fff;padding:12px 18px;border-radius:12px;font-weight:600;transform:translateY(90px);opacity:0;transition:.4s cubic-bezier(.2,.8,.2,1);z-index:50;max-width:340px}#toast.show{transform:none;opacity:1}
.in-a{animation:rise .8s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--d,0)*90ms)}@keyframes rise{from{opacity:0;transform:translateY(22px)}}
.sw{animation:swp .5s cubic-bezier(.2,.8,.2,1)}@keyframes swp{from{opacity:.2;transform:translateY(10px)}}
@media(max-width:1100px){.lay{grid-template-columns:1fr}.tahap{grid-template-columns:repeat(2,1fr)}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.pill.h,.top .search{display:none}}
@media(max-width:600px){.wrap{padding:16px 14px}.ck,.ops{grid-template-columns:1fr}.head h1{font-size:21px}}
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
    <div class="crumb in-a" style="--d:2"><span><a href="{{ route('dashboard') }}">Dashboard Utama</a> › <a href="{{ route('penerimaan') }}">Penerimaan Siswa Baru</a> › <b>Status & Seleksi</b></span><span class="pill" style="background:#e0ecff;color:#1d4ed8">📅 Periode Sidang Pleno Seleksi: 25 Mei – 02 Juni 2026 • Penetapan Panitia PPDB</span></div>
    <section class="head in-a" style="--d:3">
      <div><h1>Status & Seleksi Calon Siswa</h1><p>Pantau kelayakan administrasi, proses seleksi, dan penetapan hasil penerimaan peserta didik baru MAS YPI SUMBER HARJO.</p></div>
      <div class="tools"><select class="in"><option>TA 2026/2027 (Aktif)</option></select><select class="in"><option>Gelombang 1</option><option>Gelombang 2</option></select><a class="btn s" href="{{ route('calon') }}">← Data Calon Siswa</a><button class="btn" id="exp">{!! $ic('download') !!}Ekspor Hasil</button><button class="btn g" id="mass">☑ + Tetapkan Hasil Massal</button></div>
    </section>
    <section class="kpis" id="kpis"></section>
    <section class="card in-a" style="--d:8"><div class="sh" style="margin:0"><h3>⑂ Tahapan Seleksi PPDB MAS YPI Sumber Harjo</h3><small class="mu">Siklus Penilaian Terpadu • Gelombang 1</small></div>
      <div class="tahap" id="tahap"></div><div class="note" id="tnote"></div></section>
    <div class="tabs in-a" style="--d:9" id="tabs"></div>
    <section class="card in-a" style="--d:10">
      <div class="fb"><label class="search">{!! $ic('search') !!}<input id="q" placeholder="Cari nama siswa, No. Registrasi, NISN, atau NIK..."></label>
        <select class="in" id="fL"><option value="">Status Seleksi: Semua</option><option value="M">Menunggu Seleksi</option><option value="D">Dalam Proses</option><option value="L">Lolos Seleksi</option><option value="C">Cadangan</option><option value="X">Tidak Lolos</option></select>
        <select class="in" id="fB"><option value="">Status Berkas: Semua</option><option value="T">Terverifikasi</option><option value="P">Perlu Perbaikan</option><option value="M">Menunggu Syarat</option></select>
        <select class="in" id="fJ"><option value="">Jalur: Semua</option><option>Reguler</option><option>Prestasi Akademik</option><option>Afirmasi</option><option>Prestasi Tahfidz</option></select>
        <button class="btn g" id="apply">Filter</button><button class="btn" id="rst" title="Reset">↻</button></div>
      <div class="fi"><span id="info"></span><span>Pembaruan data otomatis tersaring</span></div>
      <div style="display:flex;justify-content:space-between;align-items:center;margin-top:18px"><h3>Daftar Status & Hasil Seleksi Masuk</h3><span class="lk" id="selc" style="color:var(--green)">Tandai Terpilih (0)</span></div>
      <div class="tw"><table><thead><tr><th><input type="checkbox" id="allP"></th><th>NO</th><th>NO. REGISTRASI</th><th>CALON SISWA</th><th>NISN</th><th>ASAL SEKOLAH</th><th>STATUS BERKAS</th><th>STATUS SELEKSI</th><th>TGL & PETUGAS</th><th>AKSI</th></tr></thead><tbody id="tb"></tbody></table></div>
      <div class="pg"><span id="pinfo"></span><span>Baris: <select class="in" id="per" style="padding:6px 8px"><option>10</option><option>20</option><option>50</option></select></span><div class="n" id="pn"></div></div>
    </section>
    <div class="lay">
      <section class="card in-a" style="--d:11" id="dcard"></section>
      <div class="col">
        <section class="card in-a" style="--d:12" id="ready"></section>
        <section class="card in-a" style="--d:13"><div class="sh"><h3>Audit Trail Penetapan</h3><small class="mu">Log Resmi</small></div><div id="logs"></div><p style="text-align:center;margin-top:10px"><button class="lk" id="more">Lihat Seluruh Log Transaksi Sistem</button></p></section>
      </div>
    </div>
  </div>
</div>
<dialog id="dM"><h3>Tetapkan Hasil Massal</h3><p class="mu" id="mN"></p><div id="mO"></div><div class="da"><button class="btn" data-x>Batal</button><button class="btn g" id="mOk">Terapkan</button></div></dialog>
<dialog id="dK"><h3>Pratinjau Surat Keputusan (SK)</h3><p class="mu">Daftar peserta didik yang ditetapkan lolos seleksi:</p><ol class="sk" id="skl"></ol><div class="da"><button class="btn" data-x>Tutup</button><button class="btn g" id="skd">Unduh Daftar (CSV)</button></div></dialog>
<div id="toast"></div>

<script>
const $=s=>document.querySelector(s),esc=s=>String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const COL=['#2d6a8f','#f59e0b','#0f7a4f','#dc2626','#0b4fa8','#7c3aed','#0d9488'];
const SN={M:'Menunggu Seleksi',D:'Dalam Proses',L:'Lolos Seleksi',C:'Cadangan',X:'Tidak Lolos'},BN={T:'Terverifikasi (5/5)',P:'Perlu Perbaikan SKL',M:'Menunggu Syarat'};
const OP=[['M','Menunggu Seleksi','Tunda keputusan hingga sesi berikutnya'],['D','Dalam Proses Penilaian','Perlu klarifikasi nilai & wawancara'],['L','Lolos Seleksi (Diterima)','Memenuhi seluruh kriteria MAS YPI'],['C','Cadangan (Waiting List)','Pengganti bila kuota belum terpenuhi'],['X','Tidak Lolos Seleksi','Tidak memenuhi batas minimum atau kuota habis']];
const FN=['Muhammad Rizki','Siti Aisyah','Ahmad Fadli','Nurul Hikmah','Bagas Dwi','Dewi','Rafi','Salsabila'],LN=['Pratama','Putri','Prasetyo','Ramadhan','Saputra','Hidayati','Anggraini'];
const SC=['MTsN 1 Buay Madang','MTs Sumber Makmur','SMP Negeri 2 Buay Madang','MTs Nurul Huda OKU Timur','MTs YPI Sumber Harjo','SMP IT Madani OKU'],JL=['Reguler','Prestasi Akademik','Afirmasi','Prestasi Tahfidz'];
const OF=['Ahmad Fauzi, S.Pd.','Panitia PPDB','Petugas Seleksi'],QT=160;
const SELP=['L','M','X','D','L','C','M'];
const D=Array.from({length:40},(_,i)=>{const b=['T','T','P','T','T','M','T'][i%7],d=new Date(2026,4,24-Math.floor(i/4),8+(i%9),(i*7)%60);
 return{id:i+1,reg:'REG-2026-'+String(i+1).padStart(4,'0'),name:FN[i%8]+' '+LN[(i*3)%7],age:15+(i%2),jalur:JL[i%4],nisn:'00'+(78129482+i),school:SC[i%6],b:b,sel:b=='T'?SELP[i%7]:(i%2?'D':'M'),score:+(70+((i*7)%23)+(i%3)*.4).toFixed(1),zon:1+(i%3),d:d,off:OF[i%3],lock:false,note:''}});
D[0].sel='M';
let LOGS=[['<b>Ahmad Fauzi, S.Pd.</b> menetapkan Siti Aisyah Putri menjadi <b>\'Lolos Seleksi\'</b> (Prestasi Akademik).','24 Mei 2026, 14:30 WIB','#0f7a4f'],['<b>Panitia PPDB</b> memverifikasi kelengkapan arsip Muhammad Rizki Pratama (Siap Masuk Sidang).','24 Mei 2026, 10:15 WIB','#2563eb'],['<b>Ahmad Fauzi, S.Pd.</b> menandai Ahmad Fadli \'Menunggu Persyaratan\' (Klarifikasi legalisir SKL).','23 Mei 2026, 16:00 WIB','#d97706'],['<b>Sidang Komite</b> menetapkan Nurul Hikmah \'Tidak Lolos\' dikarenakan kuota afirmasi terpenuhi.','23 Mei 2026, 10:20 WIB','#dc2626']];
let S={tab:'',L:'',B:'',J:'',q:'',page:1,per:10},sel=new Set(),cur=0,dec=null,allLogs=false,kfirst=true;
const now=()=>new Date().toLocaleString('id-ID',{day:'numeric',month:'long',year:'numeric',hour:'2-digit',minute:'2-digit'})+' WIB';
const fd=d=>d.toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'})+', '+String(d.getHours()).padStart(2,'0')+':'+String(d.getMinutes()).padStart(2,'0');
const ini=n=>n.split(' ').map(w=>w[0]).slice(0,2).join('');
const cn=k=>D.filter(x=>x.sel==k).length;
function flt(skipTab){const q=S.q.toLowerCase();return D.filter(x=>(skipTab||!S.tab||x.sel==S.tab)&&(!S.L||x.sel==S.L)&&(!S.B||x.b==S.B)&&(!S.J||x.jalur==S.J)&&(!q||(x.name+x.reg+x.nisn).toLowerCase().includes(q)))}
function count(el,to){const t0=performance.now();(function f(n){const p=Math.min((n-t0-300)/1100,1);if(p<0)return requestAnimationFrame(f);el.textContent=Math.round(to*(1-Math.pow(1-p,3)));if(p<1)requestAnimationFrame(f)})(t0)}
function kpis(){const v=[D.length,cn('M'),cn('D'),cn('L'),cn('X')];
 const K=[['TOTAL PENDAFTAR','Pendaftar TA 2026/2027','#0b1f3a','#e0e7ff','👥'],['MENUNGGU SELEKSI','Berkas valid siap sidang','#2563eb','#dbeafe','◷'],['SEDANG DIPROSES','Peninjauan kriteria penilaian','#2563eb','#dbeafe','▣'],['LOLOS SELEKSI',Math.round(v[3]/QT*100)+'% dari Kuota ('+QT+' Kursi)','#0f7a4f','#dcfce7','✔'],['TIDAK LOLOS','Tidak memenuhi ambang batas','#dc2626','#fee2e2','✕']];
 $('#kpis').innerHTML=K.map((k,i)=>`<div class="card kpi ${kfirst?'in-a':''}" style="--c:${k[2]};--bgc:${k[3]};--d:${4+i}"><div class="t"><span>${k[0]}</span><span class="ico">${k[4]}</span></div><strong data-n="${v[i]}">${kfirst?0:v[i]}</strong><small>${k[1]}</small></div>`).join('');
 if(kfirst)document.querySelectorAll('[data-n]').forEach(e=>count(e,+e.dataset.n));kfirst=false}
const TN=['Pendaftaran akun & berkas dibuka dan ditutup sesuai jadwal. Seluruh pendaftar telah tercatat.','Verifikasi dokumen oleh panitia: berkas yang valid diteruskan ke tahap penilaian kriteria.','Calon siswa diproses secara transparan menurut bobot nilai rapor, domisili, dan kelengkapan arsip yang disidangkan secara pleno.','Penetapan pleno: hasil seleksi dikunci dan dicatat pada audit trail.','Daftar ulang & konversi calon siswa menjadi siswa aktif (jadwal 10 Juni 2026).'];
let tp=2;
function tahap(){const T=[['Pendaftaran Akun & Berkas','Selesai (100%)'],['Verifikasi Dokumen',D.filter(x=>x.b=='T').length+' Berkas Valid'],['Pemeriksaan Kriteria',cn('D')+' Siswa Diproses'],['Penetapan Pleno',cn('L')+' Lolos Bertahap'],['Daftar Ulang & Konversi','Jadwal: 10 Juni 2026']];
 $('#tahap').innerHTML=T.map((t,i)=>`<div class="th ${i==tp?'on':''}" data-t="${i}"><div class="n"><span class="nb ${i<2?'ok':i==2?'cu':''}">${i<2?'✓':i+1}</span>Tahap ${i+1}${i==2?' (Berjalan)':''}</div><small>${t[0]}</small><div class="s" style="${i>2?'color:var(--mu)':''}">${t[1]}</div></div>`).join('');$('#tnote').innerHTML='🛡 <span>'+TN[tp]+'</span>'}
function tabs(){const T=[['','Semua Calon Siswa',D.length],['M','Menunggu Seleksi',cn('M')],['D','Sedang Diproses',cn('D')],['L','Lolos Seleksi',cn('L')],['X','Tidak Lolos',cn('X')],['C','Cadangan',cn('C')]];
 $('#tabs').innerHTML=T.map(t=>`<button class="tab ${S.tab==t[0]?'on':''}" data-tab="${t[0]}">${t[1]} <em>${t[2]}</em></button>`).join('')}
function table(){const r=flt(),pages=Math.max(1,Math.ceil(r.length/S.per));S.page=Math.min(S.page,pages);const s=(S.page-1)*S.per,p=r.slice(s,s+S.per);
 $('#tb').innerHTML=p.length?p.map((x,i)=>`<tr class="${sel.has(x.id)?'sel':''} ${x.id==cur?'cur':''}" style="animation-delay:${i*40}ms"><td><input type="checkbox" data-c="${x.id}" ${sel.has(x.id)?'checked':''}></td><td>${String(s+i+1).padStart(2,'0')}</td><td>${x.reg}</td>
 <td><div class="who"><span class="ava" style="background:${COL[x.id%7]}">${ini(x.name)}</span><div><b>${esc(x.name)}</b><small>${x.jalur} • ${x.age} Th</small></div></div></td><td>${x.nisn}</td><td>${esc(x.school)}</td>
 <td><span class="st b${x.b}">${BN[x.b]}</span></td><td><span class="st s${x.sel}">${x.lock?'🔒 ':''}${SN[x.sel]}${x.sel=='L'||x.sel=='D'?` (${x.score})`:''}</span></td>
 <td style="font-size:12px;line-height:1.5">${fd(x.d)}<br><span class="mu">${x.off}</span></td><td><button class="btn s" style="padding:7px 12px" data-set="${x.id}">Tetapkan</button></td></tr>`).join(''):'<tr><td colspan="10" style="text-align:center;padding:36px;color:var(--mu)">Tidak ada data yang cocok.</td></tr>';
 $('#info').innerHTML=`Menampilkan <b>${p.length}</b> dari <b>${D.length}</b> Calon Siswa <span class="pill" style="background:#e0ecff;color:#1d4ed8">Gelombang 1</span>`;
 $('#pinfo').innerHTML=r.length?`Menampilkan <b>${s+1}–${s+p.length}</b> dari <b>${r.length}</b> calon siswa`:'Tidak ada data';
 const L=[];for(let i=1;i<=pages;i++)if(i==1||i==pages||Math.abs(i-S.page)<=1)L.push(i);else if(L[L.length-1]!='…')L.push('…');
 $('#pn').innerHTML=`<button data-p="${S.page-1}" ${S.page==1?'disabled':''}>‹</button>`+L.map(i=>i=='…'?'<span>…</span>':`<button data-p="${i}" class="${i==S.page?'on':''}">${i}</button>`).join('')+`<button data-p="${S.page+1}" ${S.page==pages?'disabled':''}>›</button>`;
 $('#allP').checked=p.length>0&&p.every(x=>sel.has(x.id));$('#selc').textContent=`Tandai Terpilih (${sel.size})`}
function panel(){const x=D.find(y=>y.id==cur),ok=x.b=='T',cks=[[ok,'Arsip Administratif (KK, Akta, SKL)',ok?'Lengkap':'Belum'],[x.age<21,'Kesesuaian Usia Masuk (< 21 Th)',x.age+' Tahun'],[x.score>=75,'Nilai Rapor (Min. 75.00)',x.score.toFixed(2)],[true,'Zonasi & Domisili Madrasah','Prioritas '+x.zon]];
 $('#dcard').innerHTML=`<div class="sh"><div><h3>✎ Penetapan Hasil Seleksi Individual</h3><small>Simulasi Sidang Pleno Panitia Penerimaan</small></div><span class="pill">${x.lock?'🔒 Terkunci':'Sidang Aktif'}</span></div>
 <div class="who2"><div style="display:flex;gap:12px;align-items:center"><span class="ava" style="background:${COL[x.id%7]};width:42px;height:42px">${ini(x.name)}</span><div><b style="font-size:15px">${esc(x.name)}</b><br><span class="mu">${x.reg} • NISN: ${x.nisn}<br>${esc(x.school)} • Jalur ${x.jalur}</span></div></div><div style="text-align:right"><small class="mu">Status Dokumen:</small><br><span class="st b${x.b}">${BN[x.b]}</span></div></div>
 <p style="font-weight:600;margin-top:16px">Checklist Pemenuhan Kriteria Penerimaan:</p><div class="ck">${cks.map(c=>`<div class="ci ${c[0]?'':'no'}"><i>${c[0]?'✓':'!'}</i><span>${c[1]}</span><b>${c[2]}</b></div>`).join('')}</div>
 <p style="font-weight:600">Keputusan Hasil Sidang Panitia:</p><div class="ops" id="ops">${OP.map(o=>`<label class="op ${dec==o[0]?'on':''} ${o[0]=='X'?'x':''} ${x.lock?'lock':''}" data-o="${o[0]}"><input type="radio" name="dec" ${dec==o[0]?'checked':''}><span><b ${o[0]=='X'?'style="color:var(--red)"':''}>${o[1]}</b><small>${o[2]}</small></span></label>`).join('')}</div>
 <p style="font-weight:600;margin-bottom:6px">Catatan Keputusan & Rekomendasi Jurusan:</p><div id="nw"><textarea class="in" id="note" ${x.lock?'disabled':''} placeholder="Contoh: Dinyatakan DITERIMA pada Pilihan 1 (Peminatan IPA)...">${esc(x.note)}</textarea></div>
 <div class="acts"><button class="lk" id="rf" style="color:#27498a">Reset Formulir</button><span style="display:flex;gap:8px">${x.lock?'<button class="btn" id="unl">🔓 Buka Kunci</button>':'<button class="btn s" id="dr">Simpan Draft</button><button class="btn g" id="lk">Kunci & Tetapkan Keputusan</button>'}</span></div>`}
function ready(){const l=cn('L'),pend=cn('M')+cn('D');$('#ready').innerHTML=`<div class="sh"><h3>📢 Kesiapan Pengumuman</h3><span class="pill" style="background:#e0ecff;color:#1d4ed8">Kuota ${Math.round(l/QT*100)}%</span></div>
 <div style="display:flex;justify-content:space-between;font-weight:600"><span>Kapasitas Daya Tampung</span><span style="color:var(--green)">${l} / ${QT} Siswa</span></div><div class="bar"><i id="qb"></i></div>
 <div class="kv mu"><span>Sisa Kuota: ${QT-l} Kursi</span><span>Target Sidang: 02 Juni 2026</span></div>
 <div class="gbox"><div class="kv"><span class="mu">Ditetapkan Lolos:</span><b style="color:var(--green)">${l} Siswa</b></div><div class="kv"><span class="mu">Tidak Lolos:</span><b style="color:var(--red)">${cn('X')} Siswa</b></div><div class="kv"><span class="mu">Menunggu / Sedang Diproses:</span><b style="color:var(--blue)">${pend} Siswa</b></div></div>
 <button class="btn s" id="sk" style="width:100%;margin-bottom:8px">🖶 Pratinjau Surat Keputusan (SK)</button><button class="btn ${pend?'s':'g'}" id="pub" style="width:100%" ${pend?'':''}>${pend?'🔒 Publikasi Online (Terkunci Sidang Pleno)':'🌐 Publikasi Hasil Online'}</button>`;
 setTimeout(()=>{const b=$('#qb');if(b)b.style.width=Math.min(100,l/QT*100)+'%'},60)}
function logs(){const L=allLogs?LOGS:LOGS.slice(0,4);$('#logs').innerHTML=L.map((l,i)=>`<div class="log" style="--c:${l[2]};animation-delay:${i*60}ms">${l[0]}<small>${l[1]}</small></div>`).join('');$('#more').textContent=allLogs?'Ringkas Log':`Lihat Seluruh Log Transaksi Sistem (${LOGS.length} Riwayat)`}
function all(){kpis();tahap();tabs();table();panel();ready();logs()}
function setCur(id){cur=id;dec=D.find(x=>x.id==id).sel;panel();table();const c=$('#dcard');c.classList.remove('sw');c.offsetHeight;c.classList.add('sw')}
function toast(m){const t=$('#toast');t.textContent=m;t.classList.add('show');clearTimeout(t._t);t._t=setTimeout(()=>t.classList.remove('show'),2800)}
function shake(id){const e=$(id);e.classList.remove('bad');e.offsetHeight;e.classList.add('bad')}
const addLog=(h,c)=>LOGS.unshift([h,now(),c]);
document.addEventListener('click',e=>{const t=e.target,b=t.closest('button');
 const c=t.closest('[data-c]');if(c){c.checked?sel.add(+c.dataset.c):sel.delete(+c.dataset.c);table();return}
 const tb=t.closest('[data-tab]');if(tb){S.tab=tb.dataset.tab;S.page=1;tabs();table();return}
 const th=t.closest('[data-t]');if(th){tp=+th.dataset.t;tahap();return}
 const o=t.closest('[data-o]');if(o){dec=o.dataset.o;panel();return}
 if(b&&b.dataset.p){S.page=+b.dataset.p;table();return}
 if(b&&b.dataset.set){setCur(+b.dataset.set);$('#dcard').scrollIntoView({behavior:'smooth',block:'center'});return}
 if(t.closest('[data-x]'))t.closest('dialog').close();
 if(!b)return;const x=D.find(y=>y.id==cur);
 if(b.id=='apply'){S.L=$('#fL').value;S.B=$('#fB').value;S.J=$('#fJ').value;S.page=1;table();toast(flt().length+' calon siswa cocok filter')}
 if(b.id=='rst'){S={...S,tab:'',L:'',B:'',J:'',q:'',page:1};['#fL','#fB','#fJ'].forEach(i=>$(i).value='');$('#q').value='';tabs();table();toast('Filter direset')}
 if(b.id=='rf'){dec=x.sel;x.note='';panel();toast('Formulir direset')}
 if(b.id=='dr'){x.note=$('#note').value;toast('Draft disimpan (belum dikunci)')}
 if(b.id=='unl'){x.lock=false;addLog(`<b>Ahmad Fauzi, S.Pd.</b> membuka kunci keputusan ${esc(x.name)}.`,'#d97706');all();toast('Kunci dibuka')}
 if(b.id=='lk')lock(x);
 if(b.id=='more'){allLogs=!allLogs;logs()}
 if(b.id=='sk'){const l=D.filter(y=>y.sel=='L');$('#skl').innerHTML=l.length?l.map(y=>`<li>${esc(y.name)} — ${y.reg}</li>`).join(''):'<li>Belum ada peserta yang ditetapkan lolos.</li>';$('#dK').showModal()}
 if(b.id=='pub'){const p=cn('M')+cn('D');p?toast('Terkunci: masih ada '+p+' calon siswa belum ditetapkan'):toast('Hasil seleksi dipublikasikan (simulasi)')}
 if(b.id=='skd')csv(D.filter(y=>y.sel=='L'),'sk-lolos-seleksi.csv');
 if(b.id=='exp')csv(flt(),'hasil-seleksi.csv');
 if(b.id=='qa')toast('Pilih calon siswa lalu klik Tetapkan');
 if(b.id=='mass'){if(!sel.size)return toast('Tandai calon siswa terlebih dahulu');$('#mN').textContent=sel.size+' calon siswa terpilih. Pilih keputusan:';$('#mO').innerHTML=OP.map((o,i)=>`<label class="op" data-m="${o[0]}"><input type="radio" name="md" ${i==0?'checked':''}><span><b>${o[1]}</b><small>${o[2]}</small></span></label>`).join('');$('#dM').showModal()}
 if(b.id=='mOk'){const v=document.querySelector('[name=md]:checked')?.closest('[data-m]').dataset.m;let ok=0,sk=0;D.filter(y=>sel.has(y.id)).forEach(y=>{if(y.lock||(v=='L'&&y.b!='T')){sk++;return}y.sel=v;y.d=new Date();y.off='Ahmad Fauzi, S.Pd.';ok++});
  if(ok)addLog(`<b>Ahmad Fauzi, S.Pd.</b> menetapkan ${ok} calon siswa menjadi <b>'${SN[v]}'</b> secara massal.`,'#2563eb');sel.clear();$('#dM').close();all();toast(ok+' diperbarui'+(sk?`, ${sk} dilewati (berkas belum terverifikasi / terkunci)`:''))}
});
document.addEventListener('change',e=>{if(e.target.id=='allP'){const s=(S.page-1)*S.per;flt().slice(s,s+S.per).forEach(x=>e.target.checked?sel.add(x.id):sel.delete(x.id));table()}if(e.target.id=='per'){S.per=+e.target.value;S.page=1;table()}});
document.addEventListener('input',e=>{if(e.target.id=='q'||e.target.id=='gs'){S.q=e.target.value;$('#q').value=e.target.value;S.page=1;table()}});
function lock(x){const n=$('#note').value.trim();if(!dec){shake('#ops');return toast('Pilih keputusan sidang terlebih dahulu')}
 if(dec=='L'&&x.b!='T'){shake('#ops');return toast('Tidak dapat meloloskan: berkas belum terverifikasi')}
 if(dec=='L'&&x.score<75){shake('#ops');return toast('Nilai rapor di bawah batas minimum 75.00')}
 if(dec=='L'&&cn('L')>=QT&&x.sel!='L')return toast('Kuota penuh');
 if(dec=='X'&&!n){shake('#nw');return toast('Alasan wajib dicatat untuk keputusan Tidak Lolos')}
 x.sel=dec;x.note=n;x.lock=true;x.d=new Date();x.off='Ahmad Fauzi, S.Pd.';
 addLog(`<b>Ahmad Fauzi, S.Pd.</b> menetapkan ${esc(x.name)} menjadi <b>'${SN[dec]}'</b> (${x.jalur}).`,dec=='L'?'#0f7a4f':dec=='X'?'#dc2626':'#2563eb');all();toast('Keputusan dikunci: '+SN[dec])}
function csv(rows,name){const l=rows.map(x=>[x.reg,x.name,x.nisn,x.school,x.jalur,BN[x.b],SN[x.sel],x.score].map(v=>'"'+String(v).replace(/"/g,'""')+'"').join(','));
 const a=document.createElement('a');a.href=URL.createObjectURL(new Blob(['\ufeff'+['No Registrasi,Nama,NISN,Asal Sekolah,Jalur,Status Berkas,Status Seleksi,Nilai'].concat(l).join('\n')],{type:'text/csv'}));a.download=name;a.click();toast('Berkas '+name+' diunduh')}
cur=1;dec='M';all();setTimeout(()=>setCur(1),0);
</script>

@include('partials.seleksi-db')
@include('partials.seleksi-tambahan')
</body>
</html>