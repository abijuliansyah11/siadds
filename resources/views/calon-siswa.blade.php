<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Calon Siswa | MAS YPI SUMBER HARJO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#0b1f3a;--green:#0f7a4f;--mint:#d9f5e8;--bg:#f3f5f9;--line:#e5e9f0;--tx:#0f1b2d;--mu:#64748b;--red:#dc2626;--soft:#eef3fa}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Inter,Arial,sans-serif;background:var(--bg);color:var(--tx);font-size:13px}
svg.i{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex:none}
.main{margin-left:248px}
.top{position:sticky;top:0;z-index:10;display:flex;align-items:center;gap:12px;padding:12px 28px;background:rgba(255,255,255,.85);backdrop-filter:blur(12px);border-bottom:1px solid var(--line)}
.search{display:flex;align-items:center;gap:8px;padding:10px 12px;border:1px solid var(--line);border-radius:10px;background:var(--soft);color:var(--mu);transition:.25s}
.search:focus-within{border-color:var(--green);background:#fff;box-shadow:0 0 0 4px rgba(15,122,79,.12)}
.search input{border:0;outline:0;background:none;width:100%;font:inherit;color:var(--tx)}
.pill{padding:5px 10px;border-radius:99px;background:var(--mint);color:#0a5c3b;font-weight:600;font-size:11.5px;white-space:nowrap}
.sp{flex:1}
.btn{display:inline-flex;align-items:center;gap:7px;padding:10px 15px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--tx);font:600 12.5px Inter,sans-serif;cursor:pointer;text-decoration:none;transition:transform .25s,box-shadow .25s,background .25s;white-space:nowrap}
.btn:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(11,31,58,.12)}.btn:active{transform:scale(.97)}
.btn.g{background:var(--green);border-color:var(--green);color:#fff}.btn.r{background:#dc2626;border-color:#dc2626;color:#fff}
.user{display:flex;align-items:center;gap:10px}
.av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--green),#142d4e);color:#fff;display:grid;place-items:center;font-weight:700}
.user small{display:block;color:var(--mu);font-size:11px}
.user form button{border:0;background:none;color:var(--red);font:600 12px Inter;cursor:pointer;padding:6px}
.wrap{padding:22px 28px 50px;max-width:1320px}
.crumb{color:var(--mu);font-size:12px;margin-bottom:6px}.crumb a{color:inherit;text-decoration:none}.crumb b{color:var(--tx);font-weight:600}
.head{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap;margin-bottom:20px;align-items:flex-end}
.head h1{font-size:27px;font-weight:800;letter-spacing:-.02em}.head p{color:var(--mu);line-height:1.6;max-width:600px;margin-top:6px}
.tools{display:flex;gap:8px}
.card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:22px;transition:box-shadow .3s}
.kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:20px}
.kpi{padding:0;overflow:hidden;transition:transform .3s,box-shadow .3s}.kpi:hover{transform:translateY(-4px);box-shadow:0 14px 34px rgba(11,31,58,.09)}
.kpi .t{padding:20px 20px 14px;display:flex;justify-content:space-between}.kpi small{font-size:11px;letter-spacing:.06em;color:var(--mu);font-weight:600}
.kpi strong{display:block;font-size:34px;font-weight:800;margin-top:10px;letter-spacing:-.02em}
.ico{width:44px;height:44px;border-radius:50%;display:grid;place-items:center;background:var(--mint);color:var(--green);flex:none}
.kpi .f{padding:12px 20px;background:#f8fafc;display:flex;justify-content:space-between;align-items:center;color:var(--mu);font-size:12px;gap:8px}
.tag{padding:4px 10px;border-radius:99px;font-size:11px;font-weight:600;background:var(--mint);color:#0a5c3b;white-space:nowrap}
.bar{height:6px;background:#dfe7f2;border-radius:9px;overflow:hidden;flex:1;margin-left:10px}.bar i{display:block;height:100%;background:var(--green);width:0;transition:width 1s cubic-bezier(.2,.8,.2,1) .5s}
.flt{margin-bottom:20px}
.flt .search{padding:14px 16px;font-size:14px}.kbd{font-size:10.5px;background:#fff;border:1px solid var(--line);padding:2px 7px;border-radius:6px;white-space:nowrap}
.fg{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin:18px 0}
.fg label{display:block;font-size:11px;letter-spacing:.06em;color:var(--mu);font-weight:600;margin-bottom:6px}
select.in,input.in{width:100%;padding:11px 12px;border:1.5px solid transparent;border-radius:10px;background:var(--soft);font:inherit;font-weight:500;color:var(--tx);outline:0;cursor:pointer;transition:.25s}
input.in{cursor:text}select.in:focus,input.in:focus{border-color:var(--green);background:#fff}
.fb{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;color:var(--mu)}.fb b{color:var(--tx)}
.lnk{border:0;background:none;color:#27498a;font:600 12.5px Inter;cursor:pointer}
.bulk{display:none;align-items:center;gap:10px;flex-wrap:wrap;background:var(--navy);color:#fff;border-radius:14px;padding:12px 16px;margin-bottom:16px}
.bulk.show{display:flex;animation:drop .45s cubic-bezier(.2,.8,.2,1)}@keyframes drop{from{opacity:0;transform:translateY(-14px) scale(.98)}}
.bulk label{display:flex;gap:8px;align-items:center;font-weight:600;cursor:pointer}
.bulk .cnt{background:rgba(52,211,153,.18);color:#6ee7b7;padding:4px 10px;border-radius:99px;font-weight:600;font-size:11.5px}
.bulk .sp{min-width:10px}.bulk .btn{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.12);color:#fff;font-size:12px;padding:9px 12px}
.bulk .btn.g{background:var(--green)}.bulk .btn.r{background:#dc2626}
input[type=checkbox]{width:17px;height:17px;accent-color:var(--green);cursor:pointer}
.tw{overflow-x:auto}table{width:100%;border-collapse:collapse;min-width:980px}
th{text-align:left;font-size:10.5px;color:var(--mu);padding:14px 10px;background:#f3f6fb;letter-spacing:.05em;white-space:nowrap}
th:first-child{border-radius:12px 0 0 0}th:last-child{border-radius:0 12px 0 0}
td{padding:12px 10px;border-top:1px solid var(--line);vertical-align:middle}
tbody tr{transition:background .25s;animation:rise .5s ease backwards}tbody tr:hover{background:#f8fafc}tbody tr.sel{background:#e9f9f0}
.who{display:flex;align-items:center;gap:11px;min-width:190px}.who b{display:block;font-size:14px}
.ava{width:42px;height:42px;border-radius:50%;display:grid;place-items:center;color:#fff;font-weight:700;font-size:13px;flex:none}
.ch{display:inline-block;padding:2px 8px;border-radius:6px;font-size:10.5px;font-weight:600;margin-top:3px;background:#e0e7ff;color:#3730a3}
.ch.p{background:#dcfce7;color:#166534}.ch.a{background:#dbeafe;color:#1d4ed8}
.sx{display:flex;align-items:center;gap:6px;font-size:12px;color:var(--mu)}
.st{padding:4px 10px;border-radius:99px;font-size:11px;font-weight:600;white-space:nowrap;display:inline-block}
.sT,.sLolos{background:#dcfce7;color:#166534}.sM,.sCadangan{background:#fef3c7;color:#92400e}.sP,.sTidak{background:#fee2e2;color:#b91c1c}.sBelum{background:#eef2f7;color:#64748b}
.sCadangan{background:#dbeafe;color:#1d4ed8}
.act{display:flex;gap:4px}.act button{width:32px;height:32px;border:0;border-radius:8px;background:none;color:#475569;cursor:pointer;display:grid;place-items:center;transition:.2s}
.act button:hover{background:var(--soft);color:var(--green);transform:translateY(-2px)}.act button.d:hover{background:#fee2e2;color:var(--red)}
.pg{display:flex;justify-content:space-between;align-items:center;margin-top:16px;gap:12px;flex-wrap:wrap;color:var(--mu)}
.pg .n{display:flex;gap:6px;align-items:center}.pg .n button{min-width:32px;height:32px;border-radius:8px;border:0;background:none;font:600 12.5px Inter;cursor:pointer;transition:.2s}
.pg .n button:hover:not(:disabled){background:var(--soft)}.pg .n button.on{background:var(--green);color:#fff}.pg .n button:disabled{opacity:.35;cursor:default}
.pg select.in{width:auto;padding:7px 10px;font-size:12px}
.empty{text-align:center;padding:40px;color:var(--mu)}
dialog{border:0;border-radius:18px;padding:26px;width:min(480px,94vw);margin:auto;box-shadow:0 30px 80px rgba(11,31,58,.35)}
dialog::backdrop{background:rgba(11,31,58,.55);backdrop-filter:blur(4px)}
dialog[open]{animation:pop .4s cubic-bezier(.2,.8,.2,1)}@keyframes pop{from{opacity:0;transform:scale(.9) translateY(16px)}}
dialog h3{font-size:19px;margin-bottom:4px}dialog label{display:block;font-weight:600;margin:14px 0 6px}
.dg{display:grid;grid-template-columns:1fr 1fr;gap:0 14px}.da{display:flex;gap:8px;justify-content:flex-end;margin-top:22px}
.det{display:flex;gap:14px;align-items:center;margin:16px 0}.kv{display:flex;justify-content:space-between;gap:12px;padding:9px 0;border-top:1px solid var(--line)}.kv b{text-align:right}
#toast{position:fixed;right:24px;bottom:24px;background:var(--navy);color:#fff;padding:12px 18px;border-radius:12px;font-weight:600;transform:translateY(90px);opacity:0;transition:.4s cubic-bezier(.2,.8,.2,1);z-index:50}
#toast.show{transform:none;opacity:1}
.in-a{animation:rise .8s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--d,0)*90ms)}
@keyframes rise{from{opacity:0;transform:translateY(22px)}}
@media(max-width:1100px){.fg{grid-template-columns:repeat(2,1fr)}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.pill.h,.top .search{display:none}}
@media(max-width:600px){.wrap{padding:16px 14px}.fg,.dg{grid-template-columns:1fr}.head h1{font-size:22px}.card{padding:16px}}
@media(prefers-reduced-motion:reduce){*,*::before{animation:none!important;transition:none!important}}
</style>
</head>
<body>
@php $nama=auth()->user()->name; $ic=fn($n)=>'<svg class="i"><use href="#'.$n.'"/></svg>'; @endphp
@include('partials.sidebar')
<svg width="0" height="0" style="position:absolute">
<symbol id="eye" viewBox="0 0 24 24"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></symbol>
<symbol id="edit" viewBox="0 0 24 24"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></symbol>
<symbol id="trash" viewBox="0 0 24 24"><path d="M3 6h18M8 6V4h8v2M6 6l1 14h10l1-14M10 11v5M14 11v5"/></symbol>
<symbol id="bolt" viewBox="0 0 24 24"><path d="M13 2L4 14h7l-1 8 9-12h-7z"/></symbol>
<symbol id="doc" viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 9h8M8 13h8M8 17h5"/></symbol>
</svg>

<div class="main">
  <header class="top in-a" style="--d:1">
    <label class="search" style="width:260px">{!! $ic('search') !!}<input id="gs" placeholder="Cari nama, NISN, atau menu..."></label>
    <span class="pill h">Sistem Aktif</span><small class="mu" style="color:var(--mu)">TA 2026/2027 — Ganjil</small><span class="sp"></span>
    <button class="btn g" data-add>{!! $ic('plus') !!}Quick Action</button>
    <div class="user"><div class="av">{{ strtoupper(substr($nama,0,1)) }}</div><div><b>{{ $nama }}</b><small>Administrator</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form></div>
  </header>

  <div class="wrap">
    <div class="crumb in-a" style="--d:2"><a href="{{ route('dashboard') }}">Dashboard Utama</a> › <a href="{{ route('penerimaan') }}">Penerimaan Siswa Baru</a> › <b>Data Calon Siswa</b></div>
    <section class="head in-a" style="--d:3">
      <div><h1>Data Calon Siswa</h1><p>Kelola, telusuri, dan pantau seluruh data calon siswa yang mendaftar di MAS YPI SUMBER HARJO secara terpusat dan terverifikasi.</p></div>
      <div class="tools"><button class="btn" id="exp">{!! $ic('download') !!}Ekspor Data</button><button class="btn g" data-add>{!! $ic('user') !!}+ Tambah Calon Siswa</button></div>
    </section>

    <section class="kpis">
      <div class="card kpi in-a" style="--d:4"><div class="t"><div><small>TOTAL CALON SISWA</small><strong id="k1">0</strong></div><span class="ico">{!! $ic('users') !!}</span></div><div class="f"><span>Tahun Ajaran 2026/2027</span><span class="tag">+18% TA lalu</span></div></div>
      <div class="card kpi in-a" style="--d:5"><div class="t"><div><small>PENDAFTARAN BARU</small><strong id="k2">0</strong></div><span class="ico" style="background:#e0ecff;color:#2563eb">{!! $ic('user') !!}</span></div><div class="f"><span>7 hari kalender terakhir</span><span class="tag" style="background:#e0ecff;color:#1d4ed8">Minggu ini</span></div></div>
      <div class="card kpi in-a" style="--d:6"><div class="t"><div><small>BERKAS BELUM LENGKAP</small><strong id="k3" style="color:#b91c1c">0</strong></div><span class="ico" style="background:#fee2e2;color:#dc2626">{!! $ic('file') !!}</span></div><div class="f"><span>Perlu tindak lanjut</span><span class="tag" style="background:#fee2e2;color:#b91c1c">Perlu Verifikasi</span></div></div>
      <div class="card kpi in-a" style="--d:7"><div class="t"><div><small>LOLOS SELEKSI</small><strong id="k4">0</strong></div><span class="ico">{!! $ic('check') !!}</span></div><div class="f"><span id="cap">Kapasitas: 0 / 160 Kursi</span><div class="bar"><i id="capb"></i></div></div></div>
    </section>

    <section class="card flt in-a" style="--d:8">
      <label class="search">{!! $ic('search') !!}<input id="q" placeholder="Cari nama calon siswa, nomor registrasi, NISN, atau NIK..."><span class="kbd">Ctrl K</span></label>
      <div class="fg">
        <div><label>TAHUN AJARAN</label><select class="in"><option>TA 2026/2027 (Aktif)</option><option>TA 2025/2026</option></select></div>
        <div><label>GELOMBANG</label><select class="in" id="fG"><option value="">Semua Gelombang</option><option value="1" selected>Gelombang 1 (Aktif)</option><option value="2">Gelombang 2</option></select></div>
        <div><label>JENIS KELAMIN</label><select class="in" id="fS"><option value="">Semua Gender</option><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div>
        <div><label>STATUS BERKAS</label><select class="in" id="fB"><option value="">Semua Status</option><option value="T">Terverifikasi</option><option value="M">Menunggu</option><option value="P">Perlu Perbaikan</option></select></div>
        <div><label>STATUS SELEKSI</label><select class="in" id="fL"><option value="">Semua Status</option><option>Lolos</option><option>Cadangan</option><option>Tidak Lolos</option><option>Belum</option></select></div>
      </div>
      <div class="fb"><span id="info"></span><span><button class="lnk" id="rst">Reset Filter</button> &nbsp; <button class="btn g" id="apply">Terapkan Filter</button></span></div>
    </section>

    <div class="bulk" id="bulk">
      <label><input type="checkbox" id="allF"> Pilih Semua (<span id="allN">0</span>)</label><span class="cnt" id="cnt"></span><span class="sp"></span>
      <button class="btn" id="bExp">{!! $ic('download') !!}Ekspor Terpilih</button>
      <button class="btn" id="bSt">{!! $ic('chart') !!}Ubah Status Massal</button>
      <button class="btn g" id="bVer"><svg class="i"><use href="#bolt"/></svg>Verifikasi Cepat</button>
      <button class="btn r" id="bDel"><svg class="i"><use href="#trash"/></svg>Hapus Terpilih</button>
    </div>

    <section class="card in-a" style="--d:9">
      <div class="tw"><table><thead><tr><th><input type="checkbox" id="allP"></th><th>NO.</th><th>NO. REGISTRASI</th><th>IDENTITAS CALON SISWA</th><th>NISN</th><th>JENIS KELAMIN</th><th>ASAL SEKOLAH</th><th>STATUS BERKAS</th><th>SELEKSI</th><th>AKSI</th></tr></thead><tbody id="tb"></tbody></table></div>
      <div class="pg"><span id="pinfo"></span><span>Baris: <select class="in" id="per"><option value="10">10 per halaman</option><option value="20">20 per halaman</option><option value="50">50 per halaman</option></select></span><div class="n" id="pn"></div></div>
    </section>
  </div>
</div>

<dialog id="dF"><h3 id="fT">Tambah Calon Siswa</h3><p class="mu" style="color:var(--mu)">Lengkapi data berikut lalu simpan.</p>
  <form id="frm"><label>Nama Lengkap</label><input class="in" name="name" required maxlength="60">
    <div class="dg"><div><label>NISN (10 digit)</label><input class="in" name="nisn" required pattern="\d{10}" maxlength="10" title="10 digit angka"></div><div><label>Jenis Kelamin</label><select class="in" name="sex"><option value="L">Laki-laki</option><option value="P">Perempuan</option></select></div></div>
    <label>Asal Sekolah</label><input class="in" name="school" required maxlength="60">
    <div class="dg"><div><label>Jalur</label><select class="in" name="jalur"><option>Reguler</option><option>Prestasi</option><option>Afirmasi</option><option>Prestasi Tahfidz</option></select></div><div><label>Gelombang</label><select class="in" name="g"><option>1</option><option>2</option></select></div>
    <div><label>Status Berkas</label><select class="in" name="st"><option value="M">Menunggu</option><option value="T">Terverifikasi</option><option value="P">Perlu Perbaikan</option></select></div><div><label>Status Seleksi</label><select class="in" name="sel"><option>Belum</option><option>Lolos</option><option>Cadangan</option><option>Tidak Lolos</option></select></div></div>
    <div class="da"><button type="button" class="btn" data-x>Batal</button><button class="btn g">Simpan</button></div></form></dialog>
<dialog id="dD"><h3>Detail Calon Siswa</h3><div id="dB"></div><div class="da"><button class="btn" data-x>Tutup</button></div></dialog>
<dialog id="dS"><h3>Ubah Status Massal</h3><p class="mu" style="color:var(--mu)" id="sN"></p>
  <label>Status Berkas</label><select class="in" id="mB"><option value="">- Tidak diubah -</option><option value="T">Terverifikasi</option><option value="M">Menunggu</option><option value="P">Perlu Perbaikan</option></select>
  <label>Status Seleksi</label><select class="in" id="mL"><option value="">- Tidak diubah -</option><option>Lolos</option><option>Cadangan</option><option>Tidak Lolos</option><option>Belum</option></select>
  <div class="da"><button type="button" class="btn" data-x>Batal</button><button class="btn g" id="mOk">Terapkan</button></div></dialog>
<div id="toast"></div>

<script>
const $=s=>document.querySelector(s),esc=s=>String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const COL=['#2d6a8f','#f59e0b','#0f7a4f','#dc2626','#0b4fa8','#7c3aed','#0d9488'];
const FM=['Muhammad Rizki','Ahmad Fadli','Bagas Dwi','Farhan','Fajar','Rafi','Dimas','Rian'],FF=['Siti Aisyah','Nurul Hikmah','Dewi','Salsabila','Intan','Anisa','Putri','Zaskia'],LS=['Pratama','Prasetyo','Ramadhan','Saputra','Putri','Hidayati','Nur Azizah'];
const SC=['MTsN 1 Buay Madang','MTs Sumber Makmur','SMP Negeri 2 Buay Madang','MTs Nurul Huda OKU Timur','MTs YPI Sumber Harjo','SMP IT Madani OKU','SMPN 1 Belitang','MTs Al-Ikhlas'],JL=['Reguler','Prestasi','Afirmasi','Prestasi Tahfidz'];
const SL=['Belum','Lolos','Belum','Cadangan','Lolos','Belum','Tidak Lolos'];
let D=Array.from({length:48},(_,i)=>{const f=i%2==0,d=new Date();d.setDate(d.getDate()-Math.floor(i*0.9));
 return{id:i+1,reg:'REG-2026-'+String(i+1).padStart(4,'0'),name:(f?FM:FF)[i%8]+' '+LS[(i*3)%7],sex:f?'L':'P',nisn:'00'+(78129482+i),nik:'1608'+String(3120508000001+i*7).padStart(12,'0'),
 school:SC[i%8],jalur:JL[i%4],age:15+(i%2),g:i<36?1:2,st:['T','T','M','P','T'][i%5],sel:SL[i%7],date:d.toISOString().slice(0,10)}});
let nid=100;const S={f:{g:'1',s:'',b:'',l:''},q:'',page:1,per:10},sel=new Set();let edit=null;
const SN={T:'Terverifikasi',M:'Menunggu',P:'Perlu Perbaikan'};
const selc=l=>l=='Lolos'?'sLolos':l=='Cadangan'?'sCadangan':l=='Tidak Lolos'?'sTidak':'sBelum';
const cc=j=>j=='Reguler'?'':j=='Afirmasi'?'a':'p';

function filtered(){const q=S.q.toLowerCase();return D.filter(r=>(!S.f.g||String(r.g)==S.f.g)&&(!S.f.s||r.sex==S.f.s)&&(!S.f.b||r.st==S.f.b)&&(!S.f.l||r.sel==S.f.l)&&(!q||(r.name+r.reg+r.nisn+r.nik).toLowerCase().includes(q)))}
function count(el,to){const t0=performance.now();(function f(n){const p=Math.min((n-t0-300)/1200,1);if(p<0)return requestAnimationFrame(f);el.textContent=Math.round(to*(1-Math.pow(1-p,3)));if(p<1)requestAnimationFrame(f)})(t0)}
let first=true;
function kpi(){const w=new Date();w.setDate(w.getDate()-7);const ws=w.toISOString().slice(0,10);
 const v=[D.length,D.filter(r=>r.date>=ws).length,D.filter(r=>r.st!='T').length,D.filter(r=>r.sel=='Lolos').length];
 ['#k1','#k2','#k3','#k4'].forEach((id,i)=>first?count($(id),v[i]):$(id).textContent=v[i]);
 $('#cap').textContent=`Kapasitas: ${v[3]} / 160 Kursi`;$('#capb').style.width=Math.min(100,v[3]/160*100)+'%';first=false}

function render(){
 const r=filtered(),pages=Math.max(1,Math.ceil(r.length/S.per));S.page=Math.min(S.page,pages);const s=(S.page-1)*S.per,p=r.slice(s,s+S.per);
 $('#tb').innerHTML=p.length?p.map((x,i)=>`<tr class="${sel.has(x.id)?'sel':''}" style="animation-delay:${i*45}ms"><td><input type="checkbox" data-c="${x.id}" ${sel.has(x.id)?'checked':''}></td><td>${String(s+i+1).padStart(2,'0')}</td><td>${x.reg}</td>
 <td><div class="who"><span class="ava" style="background:${COL[x.id%7]}">${esc(x.name.split(' ').map(w=>w[0]).slice(0,2).join(''))}</span><div><b>${esc(x.name)}</b><span class="ch ${cc(x.jalur)}">${x.jalur}</span> <span class="mu" style="color:var(--mu)">• ${x.age} Th</span></div></div></td>
 <td>${x.nisn}</td><td><span class="sx">${x.sex=='L'?'♂ Laki-laki':'♀ Perempuan'}</span></td><td>${esc(x.school)}</td>
 <td><span class="st s${x.st}">${SN[x.st]}</span></td><td><span class="st ${selc(x.sel)}">${x.sel}</span></td>
 <td><div class="act"><button data-a="v" data-id="${x.id}" title="Detail"><svg class="i"><use href="#eye"/></svg></button><button data-a="e" data-id="${x.id}" title="Ubah"><svg class="i"><use href="#edit"/></svg></button><button data-a="q" data-id="${x.id}" title="Verifikasi cepat"><svg class="i"><use href="#doc"/></svg></button><button class="d" data-a="d" data-id="${x.id}" title="Hapus"><svg class="i"><use href="#trash"/></svg></button></div></td></tr>`).join(''):'<tr><td colspan="10" class="empty">Tidak ada calon siswa yang cocok dengan filter.</td></tr>';
 $('#info').innerHTML=`Menampilkan <b>${p.length}</b> dari <b>${D.length}</b> Calon Siswa ${r.length!=D.length?`(<b>${r.length}</b> cocok filter)`:''} <span class="pill">${S.f.g?'Gelombang '+S.f.g+(S.f.g=='1'?' Aktif':''):'Semua Gelombang'}</span>`;
 $('#pinfo').innerHTML=r.length?`Menampilkan <b>${s+1}–${s+p.length}</b> dari <b>${r.length}</b> calon siswa`:'Tidak ada data';
 const L=[];for(let i=1;i<=pages;i++)if(i==1||i==pages||Math.abs(i-S.page)<=1)L.push(i);else if(L[L.length-1]!='…')L.push('…');
 $('#pn').innerHTML=`<button data-p="${S.page-1}" ${S.page==1?'disabled':''}>‹</button>`+L.map(i=>i=='…'?'<span>…</span>':`<button data-p="${i}" class="${i==S.page?'on':''}">${i}</button>`).join('')+`<button data-p="${S.page+1}" ${S.page==pages?'disabled':''}>›</button>`;
 $('#allP').checked=p.length>0&&p.every(x=>sel.has(x.id));
 $('#allN').textContent=r.length;$('#allF').checked=r.length>0&&r.every(x=>sel.has(x.id));
 $('#bulk').classList.toggle('show',sel.size>0);$('#cnt').textContent='● '+sel.size+' Calon Siswa Terpilih';kpi()}

/* Interaksi */
document.addEventListener('click',e=>{const t=e.target,b=t.closest('button');
 const c=t.closest('[data-c]');if(c){c.checked?sel.add(+c.dataset.c):sel.delete(+c.dataset.c);render();return}
 if(t.closest('[data-p]')&&b&&!b.disabled){S.page=+b.dataset.p;render();return}
 if(t.closest('[data-x]'))t.closest('dialog').close();
 if(t.closest('[data-add]')){edit=null;$('#fT').textContent='Tambah Calon Siswa';$('#frm').reset();$('#dF').showModal()}
 if(!b)return;const id=+b.dataset.id,r=D.find(x=>x.id==id);
 if(b.dataset.a=='v'){$('#dB').innerHTML=`<div class="det"><span class="ava" style="background:${COL[r.id%7]};width:54px;height:54px">${esc(r.name.split(' ').map(w=>w[0]).slice(0,2).join(''))}</span><div><b style="font-size:16px">${esc(r.name)}</b><br><span class="mu" style="color:var(--mu)">${r.reg}</span></div></div>`+[['NISN',r.nisn],['NIK',r.nik],['Jenis Kelamin',r.sex=='L'?'Laki-laki':'Perempuan'],['Usia',r.age+' tahun'],['Asal Sekolah',esc(r.school)],['Jalur',r.jalur],['Gelombang',r.g],['Tanggal Daftar',r.date],['Status Berkas',SN[r.st]],['Status Seleksi',r.sel]].map(k=>`<div class="kv"><span class="mu" style="color:var(--mu)">${k[0]}</span><b>${k[1]}</b></div>`).join('');$('#dD').showModal()}
 if(b.dataset.a=='e'){edit=r;$('#fT').textContent='Ubah Data Calon Siswa';const f=$('#frm').elements;f.name.value=r.name;f.nisn.value=r.nisn;f.sex.value=r.sex;f.school.value=r.school;f.jalur.value=r.jalur;f.g.value=r.g;f.st.value=r.st;f.sel.value=r.sel;$('#dF').showModal()}
 if(b.dataset.a=='q'){r.st='T';render();toast('Berkas '+r.name+' diverifikasi')}
 if(b.dataset.a=='d'&&confirm('Hapus data '+r.name+'?')){D=D.filter(x=>x.id!=id);sel.delete(id);render();toast('Data dihapus')}
});
$('#allP').onchange=e=>{const s=(S.page-1)*S.per;filtered().slice(s,s+S.per).forEach(x=>e.target.checked?sel.add(x.id):sel.delete(x.id));render()};
$('#allF').onchange=e=>{filtered().forEach(x=>e.target.checked?sel.add(x.id):sel.delete(x.id));render()};
$('#q').oninput=e=>{S.q=e.target.value;S.page=1;render()};
$('#gs').oninput=e=>{$('#q').value=e.target.value;S.q=e.target.value;S.page=1;render()};
$('#per').onchange=e=>{S.per=+e.target.value;S.page=1;render()};
$('#apply').onclick=()=>{S.f={g:$('#fG').value,s:$('#fS').value,b:$('#fB').value,l:$('#fL').value};S.page=1;render();toast('Filter diterapkan')};
$('#rst').onclick=()=>{['#fG','#fS','#fB','#fL'].forEach(i=>$(i).selectedIndex=i=='#fG'?1:0);S.f={g:'1',s:'',b:'',l:''};S.q='';$('#q').value='';S.page=1;render();toast('Filter direset')};
document.addEventListener('keydown',e=>{if((e.ctrlKey||e.metaKey)&&e.key.toLowerCase()=='k'){e.preventDefault();$('#q').focus()}});

/* Simpan tambah / ubah */
$('#frm').onsubmit=e=>{e.preventDefault();const f=Object.fromEntries(new FormData(e.target));
 const v={name:f.name.trim(),nisn:f.nisn,sex:f.sex,school:f.school.trim(),jalur:f.jalur,g:+f.g,st:f.st,sel:f.sel};
 if(edit){Object.assign(edit,v);toast('Data berhasil diperbarui')}
 else{const id=++nid;D.unshift({id,reg:'REG-2026-'+String(D.length+1).padStart(4,'0'),nik:'-',age:15,date:new Date().toISOString().slice(0,10),...v});S.page=1;toast('Calon siswa baru ditambahkan')}
 $('#dF').close();render()};

/* Aksi massal */
const ids=()=>D.filter(x=>sel.has(x.id));
$('#bVer').onclick=()=>{ids().forEach(x=>x.st='T');render();toast(sel.size+' berkas diverifikasi')};
$('#bDel').onclick=()=>{if(confirm('Hapus '+sel.size+' calon siswa terpilih?')){const n=sel.size;D=D.filter(x=>!sel.has(x.id));sel.clear();render();toast(n+' data dihapus')}};
$('#bSt').onclick=()=>{$('#sN').textContent=sel.size+' calon siswa akan diubah.';$('#mB').value='';$('#mL').value='';$('#dS').showModal()};
$('#mOk').onclick=()=>{const b=$('#mB').value,l=$('#mL').value;ids().forEach(x=>{if(b)x.st=b;if(l)x.sel=l});$('#dS').close();render();toast('Status massal diterapkan')};
function csv(rows,name){const h='No Registrasi,Nama,NISN,NIK,Jenis Kelamin,Asal Sekolah,Jalur,Status Berkas,Seleksi';const l=rows.map(x=>[x.reg,x.name,x.nisn,x.nik,x.sex=='L'?'Laki-laki':'Perempuan',x.school,x.jalur,SN[x.st],x.sel].map(v=>'"'+String(v).replace(/"/g,'""')+'"').join(','));
 const a=document.createElement('a');a.href=URL.createObjectURL(new Blob(['\ufeff'+[h,...l].join('\n')],{type:'text/csv'}));a.download=name;a.click();toast('Berkas '+name+' diunduh')}
$('#exp').onclick=()=>csv(filtered(),'data-calon-siswa.csv');$('#bExp').onclick=()=>csv(ids(),'calon-siswa-terpilih.csv');
function toast(m){const t=$('#toast');t.textContent=m;t.classList.add('show');clearTimeout(t._t);t._t=setTimeout(()=>t.classList.remove('show'),2600)}
render();
</script>
@include('partials.calon-siswa-data')
@include('partials.calon-siswa-aksi')
@include('partials.calon-siswa-tambahan')
</body>
</html>