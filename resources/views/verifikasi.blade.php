<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verifikasi Berkas | MAS YPI SUMBER HARJO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#0b1f3a;--green:#0f7a4f;--mint:#d9f5e8;--bg:#f3f5f9;--line:#e5e9f0;--tx:#0f1b2d;--mu:#64748b;--red:#dc2626;--soft:#eef3fa;--amber:#d97706;--blue:#2563eb}
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
.btn:hover:not(:disabled){transform:translateY(-2px);box-shadow:0 8px 18px rgba(11,31,58,.12)}.btn:active:not(:disabled){transform:scale(.97)}
.btn:disabled{opacity:.45;cursor:not-allowed}
.btn.g{background:var(--green);border-color:var(--green);color:#fff}.btn.r{background:#b91c1c;border-color:#b91c1c;color:#fff}.btn.s{background:#dbe7fb;border-color:#dbe7fb;color:#27498a}
.user{display:flex;align-items:center;gap:10px}
.av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--green),#142d4e);color:#fff;display:grid;place-items:center;font-weight:700}
.user small{display:block;color:var(--mu);font-size:11px}
.user form button{border:0;background:none;color:var(--red);font:600 12px Inter;cursor:pointer;padding:6px}
.wrap{padding:22px 28px 50px;max-width:1320px}
.crumb{color:var(--mu);font-size:12px;margin-bottom:10px}.crumb a{color:inherit;text-decoration:none}.crumb b{color:var(--tx);font-weight:600}
.card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:20px;transition:box-shadow .3s}
.head{display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;align-items:center;margin-bottom:18px}
.head h1{font-size:26px;font-weight:800;letter-spacing:-.02em;display:flex;align-items:center;gap:12px;flex-wrap:wrap}.head h1::before{content:"";width:8px;height:30px;background:var(--green);border-radius:4px}
.head p{color:var(--mu);margin-top:6px}.tools{display:flex;gap:8px;flex-wrap:wrap}
select.in,input.in,textarea.in{width:100%;padding:11px 12px;border:1.5px solid transparent;border-radius:10px;background:var(--soft);font:inherit;font-weight:500;color:var(--tx);outline:0;transition:.25s}
select.in{cursor:pointer;width:auto}select.in:focus,input.in:focus,textarea.in:focus{border-color:var(--green);background:#fff}
textarea.in{resize:vertical;min-height:84px;line-height:1.5}.bad .in{border-color:var(--red);animation:shake .4s}@keyframes shake{25%{transform:translateX(-5px)}75%{transform:translateX(5px)}}
.kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:16px;margin-bottom:18px}
.kpi{border-left:5px solid var(--c);transition:transform .3s,box-shadow .3s}.kpi:hover{transform:translateY(-4px);box-shadow:0 14px 34px rgba(11,31,58,.09)}
.kpi .t{display:flex;justify-content:space-between;color:var(--mu);font-weight:500}.ico{width:38px;height:38px;border-radius:50%;display:grid;place-items:center;background:var(--bgc);color:var(--c)}
.kpi strong{font-size:34px;font-weight:800;margin-right:8px}.kpi .tg{padding:3px 9px;border-radius:99px;font-size:11px;font-weight:600;background:var(--bgc);color:var(--c)}.kpi p{color:var(--mu);margin-top:6px}
.fb{display:flex;gap:10px;align-items:center;flex-wrap:wrap}.fb .search{flex:1;min-width:220px}
.fi{margin-top:12px;color:var(--mu);display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap}.fi b{color:var(--tx)}
.lay{display:grid;grid-template-columns:430px 1fr;gap:18px;margin-top:18px;align-items:start}.col{display:grid;gap:18px;min-width:0}
.stu{display:flex;gap:14px}.ava{width:62px;height:76px;border-radius:10px;display:grid;place-items:center;color:#fff;font-weight:800;font-size:20px;flex:none;background:linear-gradient(160deg,#b91c1c,#7f1d1d)}
.stu h2{font-size:19px;line-height:1.25}.stu small{color:var(--green);font-weight:600;display:block;margin-top:3px}.mono{font-family:ui-monospace,Consolas,monospace;font-size:11.5px;color:var(--mu)}
.sc{padding:5px 10px;border-radius:99px;font-size:11px;font-weight:600;white-space:nowrap;height:fit-content}
.cM{background:#fef3c7;color:#92400e}.cS{background:#dbeafe;color:#1d4ed8}.cT{background:#dcfce7;color:#166534}.cP{background:#fee2e2;color:#b91c1c}.cR{background:#e2e8f0;color:#334155}.cB{background:#eef2f7;color:#64748b}
.box{background:var(--soft);border-radius:12px;padding:12px 14px;margin-top:14px;line-height:1.5}.box .g2{display:grid;grid-template-columns:1fr 1fr;gap:10px}.box small{color:var(--mu);font-size:11px;display:block}.box b{font-size:14px}
.pb{height:8px;border-radius:9px;background:#dfe7f2;display:flex;overflow:hidden;margin:8px 0 6px}.pb i{display:block;height:100%;transition:width .9s cubic-bezier(.2,.8,.2,1)}
.pl{display:flex;justify-content:space-between;color:var(--mu);font-size:11px}
h3{font-size:17px;font-weight:700}.sh{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}
.doc{border-radius:12px;background:var(--soft);padding:12px 14px;margin-bottom:10px;cursor:pointer;border:2px solid transparent;transition:.25s}
.doc:hover{transform:translateX(3px)}.doc.on{border-color:var(--green);background:#f0fbf5;box-shadow:0 6px 18px rgba(15,122,79,.12)}.doc.fx{background:#fff3ee}
.doc .r1{display:flex;justify-content:space-between;align-items:center;gap:8px;font-weight:600}.doc .r2{display:flex;justify-content:space-between;gap:8px;margin-top:6px;color:var(--mu);font-size:12px;align-items:center}
.doc .r2 span:first-child{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.lk{border:0;background:none;color:#1d4ed8;font:600 12px Inter;cursor:pointer}
.nt{margin-top:8px;padding:9px 11px;background:#fff;border-radius:8px;color:#b91c1c;line-height:1.5;font-size:12px}
.q{display:flex;align-items:center;gap:10px;padding:11px 12px;border-radius:12px;background:var(--soft);margin-top:10px;cursor:pointer;transition:.25s;animation:rise .5s ease backwards}.q:hover{transform:translateX(4px);background:#e6eefb}
.qa{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;background:var(--mint);color:var(--green);font-weight:700;font-size:11px;flex:none}.q b{display:block}.q div{flex:1;min-width:0}.q small{color:var(--mu)}
.vh{background:#e4ecfa;border-radius:12px;padding:14px;margin:-6px -6px 0}.vh b{font-size:14px}.vh .mono{margin-top:3px}
.tb{display:flex;gap:6px;align-items:center;background:#fff;border-radius:10px;padding:6px 10px;width:fit-content;margin-top:12px;flex-wrap:wrap}
.tb button{border:0;background:none;width:30px;height:30px;border-radius:8px;font:700 15px Inter;cursor:pointer;color:#475569;transition:.2s}.tb button:hover{background:var(--soft);color:var(--green)}.tb span{min-width:48px;text-align:center;font-weight:600}
.vw{background:#dfe7f2;border-radius:12px;margin-top:12px;height:560px;overflow:auto;padding:26px;display:flex;justify-content:center}.vw:fullscreen{padding:40px}
.paper{background:#fff;width:100%;max-width:560px;height:max-content;min-height:700px;padding:34px 38px;box-shadow:0 10px 30px rgba(11,31,58,.2);position:relative;transform:scale(var(--z,1)) rotate(var(--r,0deg));transform-origin:top center;transition:transform .35s cubic-bezier(.2,.8,.2,1);animation:paper .6s cubic-bezier(.2,.8,.2,1);font-family:Georgia,serif;font-size:12px;line-height:1.7}
@keyframes paper{from{opacity:0;transform:scale(.95) translateY(14px)}}
.paper .hd{text-align:center;border-bottom:3px double #111;padding-bottom:10px;margin-bottom:18px;font-size:11px}.paper .hd b{display:block;font-size:13px}
.paper h4{text-align:center;text-decoration:underline;font-size:15px;margin-bottom:14px}.paper table{width:100%;margin:12px 0}.paper td{padding:2px 4px;border:0;vertical-align:top}.paper td:first-child{width:130px;color:#475569}
.wm{position:absolute;inset:0;display:grid;place-items:center;font:800 54px Arial;color:rgba(15,31,58,.06);transform:rotate(-30deg);pointer-events:none}
.lulus{text-align:center;letter-spacing:.4em;font-weight:700;color:#0f5132;font-size:16px;margin:14px 0}
.sig{margin:26px 0 0 auto;width:210px;text-align:center;position:relative}.stamp{position:absolute;left:-30px;top:20px;width:66px;height:66px;border:2px solid #dc2626;border-radius:50%;color:#dc2626;font:700 8px Arial;display:grid;place-items:center;opacity:.75}
.stamp.bl{filter:blur(2px);opacity:.4}.flag{position:absolute;right:14px;bottom:14px;background:#dc2626;color:#fff;padding:6px 10px;border-radius:8px;font:600 11px Inter;box-shadow:0 6px 16px rgba(220,38,38,.4);animation:pulse 1.8s infinite}
@keyframes pulse{50%{transform:scale(1.06)}}.photo34{width:150px;height:200px;margin:30px auto;background:linear-gradient(160deg,#b91c1c,#7f1d1d);color:#fff;display:grid;place-items:center;font:800 40px Arial;border-radius:4px}
.seg{display:grid;grid-template-columns:repeat(3,1fr);gap:6px;background:var(--soft);padding:6px;border-radius:12px;margin:14px 0}
.seg button{border:0;background:none;padding:12px 8px;border-radius:9px;font:600 12.5px Inter;cursor:pointer;color:var(--mu);transition:.25s}.seg button:hover{background:#fff}
.seg .v.on{background:#dcfce7;color:#166534}.seg .f.on{background:#fee2e2;color:#b91c1c;box-shadow:0 4px 12px rgba(220,38,38,.2)}.seg .r.on{background:#e2e8f0;color:#334155}
.lb{display:flex;justify-content:space-between;font-weight:600;margin:14px 0 7px;gap:10px}.lb em{font-style:normal;font-weight:500;color:var(--mu);font-size:11.5px}.lb em.rq{color:var(--red)}
.acts{display:grid;grid-template-columns:1fr 1.1fr 1fr;gap:10px;margin-top:18px}
.tl{margin-top:16px;position:relative}.tl::before{content:"";position:absolute;left:15px;top:10px;bottom:10px;width:2px;background:var(--line)}
.ev{display:flex;gap:14px;margin-bottom:12px;animation:slide .55s cubic-bezier(.2,.8,.2,1) backwards}@keyframes slide{from{opacity:0;transform:translateX(-18px)}}
.dt{width:32px;height:32px;border-radius:50%;display:grid;place-items:center;color:#fff;font-size:13px;flex:none;position:relative;z-index:1;background:var(--c)}
.eb{flex:1;background:var(--soft);border-radius:10px;padding:12px 14px;line-height:1.6;display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap}.eb small{color:var(--mu);white-space:nowrap}
#toast{position:fixed;right:24px;bottom:24px;background:var(--navy);color:#fff;padding:12px 18px;border-radius:12px;font-weight:600;transform:translateY(90px);opacity:0;transition:.4s cubic-bezier(.2,.8,.2,1);z-index:50;max-width:340px}#toast.show{transform:none;opacity:1}
.in-a{animation:rise .8s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--d,0)*90ms)}@keyframes rise{from{opacity:0;transform:translateY(22px)}}
.sw{animation:swp .5s cubic-bezier(.2,.8,.2,1)}@keyframes swp{from{opacity:.2;transform:translateY(10px)}}
@media(max-width:1100px){.lay{grid-template-columns:1fr}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.pill.h,.top .search{display:none}}
@media(max-width:600px){.wrap{padding:16px 14px}.acts{grid-template-columns:1fr}.head h1{font-size:21px}.paper{padding:22px 18px}}
@media(prefers-reduced-motion:reduce){*,*::before{animation:none!important;transition:none!important}}
</style>
</head>
<body>
@php $nama=auth()->user()->name; $ic=fn($n)=>'<svg class="i"><use href="#'.$n.'"/></svg>'; @endphp
@include('partials.sidebar')
<div class="main">
  <header class="top in-a" style="--d:1">
    <label class="search" style="width:280px">{!! $ic('search') !!}<input id="gs" placeholder="Cari nama, NISN, atau berkas..."></label>
    <span class="pill h">Sistem Aktif</span><small class="mu">TA 2026/2027 — Ganjil</small><span class="sp"></span>
    <button class="btn g" id="qa">{!! $ic('plus') !!}Quick Action</button>
    <div class="user"><div class="av">{{ strtoupper(substr($nama,0,1)) }}</div><div><b>{{ $nama }}</b><small>Administrator</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form></div>
  </header>
  <div class="wrap">
    <div class="crumb in-a" style="--d:2"><a href="{{ route('dashboard') }}">Dashboard Utama</a> › <a href="{{ route('penerimaan') }}">Penerimaan Siswa Baru (PPDB)</a> › <b>Verifikasi Berkas</b></div>
    <section class="card head in-a" style="--d:3">
      <div><h1>Verifikasi Berkas Calon Siswa <span class="pill" style="background:#dbe7fb;color:#27498a">ADMIN WORKSPACE</span></h1><p>Periksa kelengkapan, autentikasi stempel legalisir, dan validitas dokumen pendaftaran MAS YPI SUMBER HARJO.</p></div>
      <div class="tools"><a class="btn s" href="{{ route('calon') }}">← Kembali ke Data Calon Siswa</a><select class="in"><option>TA 2026/2027 (Aktif)</option></select><select class="in"><option>Gelombang 1 (Aktif)</option><option>Gelombang 2</option></select></div>
    </section>
    <section class="kpis" id="kpis"></section>
    <section class="card in-a" style="--d:8">
      <div class="fb"><label class="search">{!! $ic('search') !!}<input id="q" placeholder="Cari nama atau nomor registrasi..."></label>
        <select class="in" id="fS"><option value="">Status: Semua</option><option value="M">Menunggu</option><option value="S">Sedang Diperiksa</option><option value="P">Perlu Perbaikan</option><option value="T">Terverifikasi</option></select>
        <select class="in" id="fD"><option value="">Dokumen: Semua</option><option value="0">Kartu Keluarga</option><option value="1">Akta Kelahiran</option><option value="2">SKL / Ijazah</option><option value="3">Rapor</option><option value="4">Pas Foto</option></select>
        <button class="btn s" id="rst">Reset</button><button class="btn g" id="apply">{!! $ic('chart') !!}Terapkan Filter</button></div>
      <div class="fi"><span id="info"></span><span>Modus Tinjauan: <span class="pill">Fokus Dokumen Tunggal</span></span></div>
    </section>
    <div class="lay">
      <div class="col">
        <section class="card sw" id="stu"></section>
        <section class="card"><div class="sh"><h3>Berkas Administrasi Wajib</h3><span class="pill" style="background:var(--soft);color:var(--mu)">PPDB 2026</span></div><div id="docs"></div></section>
        <section class="card"><div class="sh"><span class="mu" style="letter-spacing:.06em;font-weight:600">ANTREAN BERIKUTNYA</span><b style="color:var(--green)" id="rem"></b></div><div id="que"></div></section>
      </div>
      <div class="col">
        <section class="card" id="vcard">
          <div class="vh"><b id="vt"></b><div class="mono" id="vm"></div>
            <div class="tb"><button id="zo" title="Perkecil">−</button><span id="zv">100%</span><button id="zi" title="Perbesar">+</button><button id="rt" title="Putar">⟳</button><button id="ft" title="Sesuaikan">⊡</button><button id="fs" title="Layar penuh">⛶</button><button id="dw" title="Unduh">⤓</button></div></div>
          <div class="vw" id="vw"></div>
        </section>
        <section class="card" id="dcard"></section>
      </div>
    </div>
    <section class="card in-a" style="--d:10;margin-top:18px"><div class="sh"><h3>Riwayat Aktivitas & Audit Trail Verifikasi</h3><span class="mono" id="rg"></span></div><div class="tl" id="tl"></div></section>
  </div>
</div>
<div id="toast"></div>

<script>
const $=s=>document.querySelector(s),esc=s=>String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const DT=[['Kartu Keluarga (KK)','KK_{n}_2026.pdf','1.4 MB'],['Akta Kelahiran','Akta_Kelahiran_{n}.pdf','980 KB'],['Surat Keterangan Lulus (SKL)','SKL_{s}_Scan.jpg','2.1 MB'],['Rapor Semester 1 - 5','Rapor_Terpadu_MTs.pdf','4.8 MB'],['Pas Foto Formal 3x4 (Merah)','Pasfoto_Merah_{n}.jpg','850 KB']];
const CAT=['Cap legalisir atau stempel madrasah asal buram / tidak terbaca jelas','Dokumen terpotong atau tidak lengkap','Foto tidak sesuai ketentuan (latar / seragam)','Data tidak cocok dengan Dukcapil / EMIS','Resolusi terlalu rendah / dokumen buram','Lainnya'];
const SD=[['Muhammad Rizki Pratama','L','Reguler Umum',15,'MTsN 1 Buay Madang','0078129482','1608031205080001','vvfvp',0],['Siti Aisyah Putri','P','Prestasi',15,'MTs Al-Falah','0078129483','1608031205080002','vvvvv',0],['Ahmad Fadli Rahman','L','Afirmasi',16,'SMPN 2 Madang','0078129484','1608031205080003','vpfpf',1],['Nurul Hikmah','P','Reguler',15,'MTs Darul Ulum','0078129485','1608031205080004','vvvvv',0],['Bagas Dwi Prasetyo','L','Reguler',15,'MTs YPI Sumber Harjo','0081927364','1608031205080005','ppppp',0],['Dewi Anggraini','P','Prestasi Tahfidz',15,'SMP IT Madani OKU','0082910391','1608031205080006','vpppp',0],['Rafi Alfarizi','L','Reguler',16,'SMPN 1 Belitang','0079182390','1608031205080007','fppvp',1],['Salsabila Nur','P','Afirmasi',15,'MTs Nurul Huda','0083310921','1608031205080008','ppppp',0]];
const now=()=>new Date().toLocaleString('id-ID',{day:'numeric',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'})+' WIB';
const S=SD.map((r,i)=>({id:i,name:r[0],sex:r[1],jalur:r[2],age:r[3],school:r[4],nisn:r[5],nik:r[6],ret:!!r[8],reg:'REG-2026-'+String(i+1).padStart(4,'0'),
 docs:DT.map((d,j)=>({t:d[0],file:d[1].replace('{n}',r[0].split(' ').slice(0,2).join('_')).replace('{s}',r[4].split(' ')[0]+'_'+(r[4].split(' ')[1]||'')),size:d[2],st:{v:'v',f:'f',p:'p'}[r[7][j]],cat:r[7][j]=='f'?CAT[0]:'',note:r[7][j]=='f'?'Mohon unggah ulang scan atau foto dokumen asli/legalisir yang menampilkan stempel madrasah dan tanda tangan kepala sekolah secara terang dan tidak terpotong.':'',int:''})),
 log:[{h:'Sistem SIADDS mencatat pembuatan akun & registrasi tiket PPDB baru<br><span class="mu">Nomor Registrasi resmi diterbitkan: <b>REG-2026-'+String(i+1).padStart(4,'0')+'</b></span>',t:'12 Okt 2026, 09:15 WIB',c:'#64748b',i:'⚙'}]}));
S[0].docs[2].int='Nilai rata-rata rapor 86,40 sudah sesuai kriteria, hanya butuh fisik SKL yang lebih jelas.';
S[0].log.unshift({h:'<b>Calon Siswa</b> mengunggah 5 berkas awal administrasi<br><span class="mu">Ukuran total file: 10.08 MB melalui Portal Pendaftaran.</span>',t:'12 Okt 2026, 09:30 WIB',c:'#2563eb',i:'☁'},{h:'<b>Ahmad Fauzi</b> memvalidasi <b style="color:#0f7a4f">Kartu Keluarga (KK)</b> & <b style="color:#0f7a4f">Akta Kelahiran</b><br><span class="mu">Seluruh data identitas NIK dan NISN cocok dengan pangkalan data EMIS.</span>',t:'12 Okt 2026, 14:10 WIB',c:'#0f7a4f',i:'✓'},{h:'<b>Ahmad Fauzi</b> menandai SKL sebagai <b style="color:#dc2626">"Perlu Perbaikan"</b><br><span class="mu">Catatan: "Cap legalisir buram / terpotong pada stempel basah madrasah asal."</span>',t:'12 Okt 2026, 14:15 WIB',c:'#dc2626',i:'✎'});
const stat=s=>s.docs.every(d=>d.st=='v')?'T':s.ret?'P':s.docs.every(d=>d.st=='p')?'M':'S';
const SN={M:'Menunggu',S:'Sedang Diperiksa',T:'Terverifikasi',P:'Perlu Perbaikan'},DS={v:['Valid','cT'],f:['Perlu Perbaikan','cP'],p:['Belum Diperiksa','cB'],r:['Ditolak','cR']};
let cur=0,dc=2,dec=null,z=100,rot=0,F={s:'',d:'',q:''};
const initials=n=>n.split(' ').map(w=>w[0]).slice(0,2).join('');
function count(el,to){const t0=performance.now();(function f(n){const p=Math.min((n-t0-300)/1100,1);if(p<0)return requestAnimationFrame(f);el.textContent=Math.round(to*(1-Math.pow(1-p,3)));if(p<1)requestAnimationFrame(f)})(t0)}
const inF=s=>(!F.s||stat(s)==F.s)&&(!F.d||s.docs[+F.d].st!='v')&&(!F.q||(s.name+s.reg).toLowerCase().includes(F.q.toLowerCase()));
let kfirst=true;
function kpis(){const c=k=>S.filter(s=>stat(s)==k).length;
 const K=[['M','Menunggu Verifikasi','Antrean Baru','Berkas belum diperiksa panitia','#d97706','#fef3c7','◷'],['S','Sedang Diperiksa','In Progress','Pemeriksaan sedang berlangsung','#2563eb','#dbeafe','▣'],['T','Terverifikasi','Memenuhi Syarat','Dokumen dinyatakan lengkap & sah','#0f7a4f','#dcfce7','✔'],['P','Perlu Perbaikan','Revisi','Memerlukan tindak lanjut calon siswa','#dc2626','#fee2e2','⚠']];
 $('#kpis').innerHTML=K.map((k,i)=>`<div class="card kpi ${kfirst?'in-a':''}" style="--c:${k[4]};--bgc:${k[5]};--d:${4+i}"><div class="t"><span>${k[1]}</span><span class="ico">${k[6]}</span></div><div style="margin-top:8px"><strong data-n="${c(k[0])}">${kfirst?0:c(k[0])}</strong><span class="tg">${k[2]}</span></div><p>${k[3]}</p></div>`).join('');
 if(kfirst)document.querySelectorAll('[data-n]').forEach(e=>count(e,+e.dataset.n));kfirst=false}
function info(){const l=S.filter(inF);$('#info').innerHTML=`● Menampilkan antrean aktif: <b>${l.filter(s=>stat(s)=='M').length} Menunggu</b> • <b>${l.filter(s=>stat(s)=='S').length} Sedang Diperiksa</b> (${l.length} calon siswa cocok filter)`}
function student(){const s=S[cur],v=s.docs.filter(d=>d.st=='v').length,f=s.docs.filter(d=>d.st=='f'||d.st=='r').length,n=5-v-f,st=stat(s);
 $('#stu').innerHTML=`<div class="stu"><div class="ava">${initials(s.name)}</div><div style="flex:1"><div style="display:flex;justify-content:space-between;gap:8px"><h2>${esc(s.name)}</h2><span class="sc c${st}">${SN[st]}</span></div><small>Jalur ${s.jalur} • ${s.age} Tahun</small><span class="mono">${s.reg}</span></div></div>
 <div class="box"><div class="g2"><div><small>NISN</small><b>${s.nisn}</b></div><div><small>NIK</small><b>${s.nik}</b></div></div><div style="margin-top:8px"><small>Asal Madrasah/Sekolah</small><b>${esc(s.school)}, Oku Timur</b></div><div class="pl" style="margin-top:8px"><span>Terdaftar: 12 Oktober 2026</span><a href="{{ route('calon') }}" style="color:#1d4ed8;font-weight:600;text-decoration:none">Lihat Profil Lengkap ↗</a></div></div>
 <div style="margin-top:16px"><div class="pl" style="font-weight:600"><span>Validasi Kelengkapan Berkas</span><span style="color:var(--green)">${v} dari 5 Dokumen Selesai (${v*20}%)</span></div><div class="pb"><i style="background:var(--green);width:0" data-w="${v*20}"></i><i style="background:var(--red);width:0" data-w="${f*20}"></i></div><div class="pl"><span>${v} Valid</span><span>${f} Perlu Perbaikan</span><span>${n} Belum Diperiksa</span></div></div>`;
 setTimeout(()=>document.querySelectorAll('[data-w]').forEach(e=>e.style.width=e.dataset.w+'%'),60)}
function docs(){const s=S[cur];$('#docs').innerHTML=s.docs.map((d,i)=>`<div class="doc ${i==dc?'on':''} ${d.st=='f'?'fx':''}" data-d="${i}" style="animation:rise .5s ease ${i*60}ms backwards"><div class="r1"><span>${d.st=='v'?'✅':d.st=='f'?'⚠️':'○'} ${i+1}. ${d.t}</span><span class="sc ${DS[d.st][1]}">${DS[d.st][0]}</span></div><div class="r2"><span>${esc(d.file)} (${d.size})</span><span><button class="lk" data-pv="${i}">${d.st=='p'?'Periksa':'Pratinjau'}</button> • <button class="lk" data-dl="${i}" style="color:var(--mu)">Unduh</button></span></div>${d.st=='f'||d.st=='r'?`<div class="nt">ⓘ Catatan: ${esc(d.note||d.cat)}</div>`:''}</div>`).join('')}
function queue(){const l=S.filter(s=>s.id!=cur&&inF(s));$('#rem').textContent='Tersisa '+l.length+' Pendaftar';
 $('#que').innerHTML=l.length?l.map((s,i)=>{const v=s.docs.filter(d=>d.st=='v').length,f=s.docs.filter(d=>d.st!='v'&&d.st!='p').length,bad=f&&stat(s)!='T';return `<div class="q" data-s="${s.id}" style="animation-delay:${i*60}ms"><span class="qa">${initials(s.name)}</span><div><b>${esc(s.name)}</b><small>${s.reg} • ${esc(s.school)}</small></div><span class="sc ${bad?'cP':'cT'}">${bad?f+'/5 Perbaikan':v+'/5 Lengkap'}</span></div>`}).join(''):'<p class="mu" style="padding:14px;text-align:center">Tidak ada antrean yang cocok.</p>'}
function paper(){const s=S[cur],d=s.docs[dc];$('#vt').textContent=d.t+(dc==2?' / Ijazah Sementara':'');$('#vm').textContent=`Berkas: ${d.file} • ${d.size} • Diunggah 12 Okt 2026`;
 const rows=(a)=>a.map(r=>`<tr><td>${r[0]}</td><td>: ${r[1]}</td></tr>`).join('');
 let body;
 if(dc==4)body=`<div class="photo34">${initials(s.name)}</div><p style="text-align:center">Pas foto formal 3 × 4, latar merah<br><b>${esc(s.name)}</b></p>`;
 else{const extra=dc==2?`<p>Berdasarkan hasil kriteria kelulusan Tahun Ajaran 2025/2026, yang bersangkutan dinyatakan:</p><div class="lulus">L U L U S</div>`:dc==3?`<p>Rekap nilai semester 1 - 5 dinyatakan lengkap dengan nilai rata-rata <b>86,40</b>.</p>`:'';
  body=`<div class="hd">KEMENTERIAN AGAMA REPUBLIK INDONESIA<b>${esc(s.school.toUpperCase())}</b>Jalan Lintas Komering No. 14, Kec. Buay Madang Timur</div><h4>${d.t.toUpperCase()}</h4><table>${rows([['Nama Lengkap',`<b>${esc(s.name.toUpperCase())}</b>`],['Jenis Kelamin',s.sex=='L'?'Laki-laki':'Perempuan'],['NISN / NIK',s.nisn+' / '+s.nik],['Asal Sekolah',esc(s.school)],['Jalur',s.jalur]])}</table>${extra}<div class="sig">Buay Madang, 10 Juni 2026<br>Kepala Madrasah,<div class="stamp ${d.st=='f'?'bl':''}">${esc(s.school.split(' ')[0])}<br>MADRASAH</div><br><br><br><b>Drs. H. MARZUKI, M.Pd.I</b></div>`}
 $('#vw').innerHTML=`<div class="paper" id="pp"><div class="wm">MAS YPI PPDB</div>${body}${d.st=='f'&&dc!=4?'<div class="flag">⛔ Stempel Buram / Terpotong</div>':''}</div>`;zoom()}
function zoom(){const p=$('#pp');if(p){p.style.setProperty('--z',z/100);p.style.setProperty('--r',rot+'deg')}$('#zv').textContent=z+'%'}
function decision(){const s=S[cur],d=s.docs[dc],all=s.docs.every(x=>x.st=='v');
 $('#dcard').innerHTML=`<div style="display:flex;justify-content:space-between;gap:10px"><div><h3>Keputusan Hasil Verifikasi Dokumen</h3><p class="mu" style="margin-top:4px">Tentukan validitas dokumen ini dan berikan instruksi perbaikan jika diperlukan.</p></div><span class="mono">ID-DOC:<br>${98000+cur*10+dc}</span></div>
 <div class="seg" id="seg"><button class="v ${dec=='v'?'on':''}" data-k="v">✔ Valid / Diterima</button><button class="f ${dec=='f'?'on':''}" data-k="f">⚠ Perlu Perbaikan${dec=='f'?'<br>(Aktif)':''}</button><button class="r ${dec=='r'?'on':''}" data-k="r">✕ Tolak Dokumen</button></div>
 <div class="lb"><span>Kategori Alasan Perbaikan</span><em class="rq">*Wajib diisi bila status perbaikan</em></div><div data-f="cat"><select class="in" id="cat" style="width:100%" ${dec=='f'?'':'disabled'}><option value="">- Pilih kategori -</option>${CAT.map(c=>`<option ${d.cat==c?'selected':''}>${c}</option>`).join('')}</select></div>
 <div class="lb"><span>✉ Catatan untuk Calon Siswa (Portal Siswa & WhatsApp)</span><em id="nc">Maks. 250 Karakter</em></div><div data-f="note"><textarea class="in" id="note" maxlength="250">${esc(d.note)}</textarea></div>
 <div class="lb"><span>🔒 Catatan Internal Panitia (hanya dilihat Panitia PPDB)</span></div><input class="in" id="int" style="width:100%" value="${esc(d.int)}">
 <div class="acts"><button class="btn s" id="sv">Simpan Progres Draft</button><button class="btn r" id="rtn">▶ Kembalikan untuk Perbaikan</button><button class="btn g" id="acc" ${all?'':'disabled'}>Terima Seluruh Berkas</button></div>`;cnt()}
const cnt=()=>{const n=$('#note');if(n)$('#nc').textContent=n.value.length+' / 250 Karakter'};
function audit(){const s=S[cur];$('#rg').textContent='Registrasi: '+s.reg;$('#tl').innerHTML=s.log.map((l,i)=>`<div class="ev" style="animation-delay:${i*70}ms"><span class="dt" style="--c:${l.c}">${l.i}</span><div class="eb"><span>${l.h}</span><small>${l.t}</small></div></div>`).join('')}
function all(){kpis();info();student();docs();queue();paper();decision();audit()}
function pick(i,j){cur=i;dc=j??Math.max(0,S[i].docs.findIndex(d=>d.st!='v'));const d=S[i].docs[dc];dec=d.st=='v'?'v':d.st=='f'?'f':d.st=='r'?'r':null;z=100;rot=0;all();$('#stu').classList.remove('sw');$('#stu').offsetHeight;$('#stu').classList.add('sw')}
function addLog(h,c,i){S[cur].log.unshift({h,t:now(),c,i})}
function toast(m){const t=$('#toast');t.textContent=m;t.classList.add('show');clearTimeout(t._t);t._t=setTimeout(()=>t.classList.remove('show'),2800)}
document.addEventListener('click',e=>{const t=e.target,b=t.closest('button');
 const pv=t.closest('[data-pv]');if(pv){pick(cur,+pv.dataset.pv);return}
 if(t.closest('[data-dl]')){toast('Unduhan aktif setelah penyimpanan berkas tersambung ke server');return}
 const dd=t.closest('[data-d]');if(dd){pick(cur,+dd.dataset.d);return}
 const q=t.closest('[data-s]');if(q){pick(+q.dataset.s);scrollTo({top:300,behavior:'smooth'});return}
 const k=t.closest('[data-k]');if(k){dec=k.dataset.k;decision();return}
 if(!b)return;
 if(b.id=='zi'){z=Math.min(200,z+25);zoom()}if(b.id=='zo'){z=Math.max(50,z-25);zoom()}if(b.id=='rt'){rot=(rot+90)%360;zoom()}if(b.id=='ft'){z=100;rot=0;zoom()}
 if(b.id=='fs')($('#vw').requestFullscreen||(()=>{})).call($('#vw'));if(b.id=='dw')toast('Unduhan aktif setelah penyimpanan berkas tersambung ke server');
 if(b.id=='qa')toast('Pilih antrean di bagian bawah untuk mulai memeriksa');
 if(b.id=='apply'){F.s=$('#fS').value;F.d=$('#fD').value;F.q=$('#q').value;info();queue();const l=S.filter(inF);if(l.length&&!inF(S[cur]))pick(l[0].id);toast(l.length+' calon siswa cocok filter')}
 if(b.id=='rst'){F={s:'',d:'',q:''};$('#fS').value='';$('#fD').value='';$('#q').value='';info();queue();toast('Filter direset')}
 if(b.id=='sv')save();if(b.id=='rtn')ret();if(b.id=='acc')acc();
});
document.addEventListener('input',e=>{if(e.target.id=='note')cnt();if(e.target.id=='gs'){$('#q').value=e.target.value;F.q=e.target.value;info();queue()}});
function bad(k){const w=document.querySelector(`[data-f="${k}"]`);w.classList.remove('bad');w.offsetHeight;w.classList.add('bad')}
function save(){const s=S[cur],d=s.docs[dc];if(!dec)return toast('Pilih keputusan terlebih dahulu');
 const cat=$('#cat').value,note=$('#note').value.trim();
 if(dec=='f'&&!cat){bad('cat');return toast('Kategori alasan wajib dipilih')}
 if(dec!='v'&&!note){bad('note');return toast('Catatan untuk calon siswa wajib diisi')}
 d.st=dec;d.cat=dec=='f'?cat:'';d.note=dec=='v'?'':note;d.int=$('#int').value;
 const nm=d.t.replace(/ \(.*/,'');addLog(`<b>Ahmad Fauzi</b> menandai ${nm} sebagai <b style="color:${dec=='v'?'#0f7a4f':'#dc2626'}">"${dec=='v'?'Valid':dec=='f'?'Perlu Perbaikan':'Ditolak'}"</b>${note?`<br><span class="mu">Catatan: "${esc(note)}"</span>`:''}`,dec=='v'?'#0f7a4f':'#dc2626',dec=='v'?'✓':'✎');
 if(dec=='v'&&s.docs.every(x=>x.st=='v'))s.ret=false;
 all();toast('Progres verifikasi disimpan')}
function ret(){const s=S[cur];if(!s.docs.some(d=>d.st=='f'||d.st=='r'))return toast('Belum ada dokumen yang ditandai perlu perbaikan');
 s.ret=true;addLog('<b>Ahmad Fauzi</b> mengembalikan berkas ke calon siswa untuk perbaikan<br><span class="mu">Notifikasi terkirim melalui Portal Siswa & WhatsApp.</span>','#dc2626','▶');all();toast('Berkas dikembalikan. Notifikasi dikirim ke calon siswa')}
function acc(){const s=S[cur];s.ret=false;addLog('<b>Ahmad Fauzi</b> menerima seluruh berkas<br><span class="mu">Status calon siswa: <b style="color:#0f7a4f">Terverifikasi</b>.</span>','#0f7a4f','✓');
 const nx=S.find(x=>x.id!=cur&&stat(x)!='T');toast(s.name+' dinyatakan terverifikasi');if(nx)setTimeout(()=>pick(nx.id),700);else all()}
pick(0,2);
</script>

@include('partials.verifikasi-db')
@include('partials.verifikasi-tata-letak')
@include('partials.verifikasi-tambahan')
</body>
</html>