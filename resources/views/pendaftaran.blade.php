<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pendaftaran Baru | MAS YPI SUMBER HARJO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#0b1f3a;--green:#0f7a4f;--mint:#d9f5e8;--bg:#f3f5f9;--line:#e5e9f0;--tx:#0f1b2d;--mu:#64748b;--red:#dc2626;--soft:#eef3fa}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Inter,Arial,sans-serif;background:var(--bg);color:var(--tx);font-size:13px}
svg.i{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex:none}
.main{margin-left:248px}
.top{position:sticky;top:0;z-index:10;display:flex;align-items:center;gap:12px;padding:12px 28px;background:rgba(255,255,255,.85);backdrop-filter:blur(12px);border-bottom:1px solid var(--line)}
.search{display:flex;align-items:center;gap:8px;padding:9px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;color:var(--mu);width:260px}
.search input{border:0;outline:0;background:none;width:100%;font:inherit}
.pill{padding:5px 10px;border-radius:99px;background:var(--mint);color:#0a5c3b;font-weight:600;font-size:11.5px;white-space:nowrap}
.sp{flex:1}
.btn{display:inline-flex;align-items:center;gap:7px;padding:10px 15px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--tx);font:600 12.5px Inter,sans-serif;cursor:pointer;text-decoration:none;transition:transform .25s,box-shadow .25s,background .25s}
.btn:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(11,31,58,.12)}.btn:active{transform:scale(.97)}
.btn.g{background:var(--green);border-color:var(--green);color:#fff}.btn.s{background:#dbe7fb;border-color:#dbe7fb;color:#27498a}
.user{display:flex;align-items:center;gap:10px}
.av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--green),#142d4e);color:#fff;display:grid;place-items:center;font-weight:700}
.user small{display:block;color:var(--mu);font-size:11px}
.user form button{border:0;background:none;color:var(--red);font:600 12px Inter;cursor:pointer;padding:6px}
.wrap{padding:22px 28px 50px;max-width:1320px}
.crumb{color:var(--mu);font-size:12px;margin-bottom:6px}.crumb a{color:inherit;text-decoration:none}.crumb b{color:var(--green);font-weight:600}
.head{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap;margin-bottom:20px}
.head h1{font-size:27px;font-weight:800;letter-spacing:-.02em;display:inline}
.head p{color:var(--mu);line-height:1.6;max-width:620px;margin-top:8px}
.tools{display:flex;gap:8px;align-content:flex-start}
.card{background:#fff;border:1px solid var(--line);border-radius:16px;padding:24px;transition:box-shadow .3s}
.card:hover{box-shadow:0 14px 34px rgba(11,31,58,.07)}
/* Stepper */
.stp{display:flex;align-items:center;margin-bottom:20px;padding:22px 26px;overflow-x:auto;gap:0}
.sti{display:flex;align-items:center;gap:10px;flex:1;min-width:0;cursor:pointer}
.sti:last-child{flex:0 0 auto}
.sti:not(:last-child)::after{content:"";flex:1;height:2px;margin:0 12px;border-radius:2px;background:linear-gradient(var(--green),var(--green)) no-repeat left/0 100%,#dbe5f3;transition:background-size .8s ease}
.sti.ok:not(:last-child)::after{background-size:100% 100%}
.sn{width:38px;height:38px;border-radius:50%;display:grid;place-items:center;font-weight:700;background:#dbe7fb;color:#27498a;flex:none;transition:.35s}
.sti.on .sn{background:var(--green);color:#fff;box-shadow:0 0 0 4px #fff,0 0 0 6px var(--green)}
.sti.ok .sn{background:var(--green);color:#fff}
.sti b{display:block;font-size:12.5px;white-space:nowrap}.sti small{color:var(--mu);font-size:11px;white-space:nowrap}
.lay{display:grid;grid-template-columns:1fr 370px;gap:22px;align-items:start}
.lbl{font-size:11px;font-weight:700;letter-spacing:.05em;color:var(--green)}
h2{font-size:25px;font-weight:800;letter-spacing:-.02em;margin:4px 0 6px}
.mu{color:var(--mu)}
.pane{animation:swap .55s cubic-bezier(.2,.8,.2,1)}
@keyframes swap{from{opacity:0;transform:translateX(26px)}}
.note{display:flex;gap:10px;padding:14px 16px;border-radius:12px;background:var(--soft);color:#27498a;line-height:1.6;margin:18px 0}
.photo{display:flex;gap:18px;align-items:center;padding:18px;border-radius:14px;background:var(--soft);margin-bottom:20px;flex-wrap:wrap}
.ph{width:105px;height:130px;border-radius:10px;background:#cdd9ec center/cover;display:grid;place-items:end center;color:#fff;font-size:10.5px;overflow:hidden;position:relative;transition:.3s}
.ph span{background:rgba(0,0,0,.45);width:100%;text-align:center;padding:3px}
.photo h4{font-size:15px;margin-bottom:4px}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:16px 22px}.full{grid-column:1/-1}
label.l{display:block;font-weight:600;margin-bottom:7px}label.l i{color:var(--red);font-style:normal}
.in,select.in{width:100%;padding:13px 14px;border:1.5px solid transparent;border-radius:10px;background:var(--soft);font:inherit;color:var(--tx);outline:0;transition:.25s}
.in:focus{background:#fff;border-color:var(--green);box-shadow:0 0 0 4px rgba(15,122,79,.12)}
.bad .in{border-color:var(--red);background:#fff5f5;animation:shake .4s}
@keyframes shake{25%{transform:translateX(-5px)}75%{transform:translateX(5px)}}
.err{color:var(--red);font-size:11.5px;margin-top:5px;min-height:0}
.gen{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.gen button{padding:12px;border-radius:10px;border:0;background:var(--soft);font:600 13px Inter;cursor:pointer;transition:.25s}
.gen button.on{background:var(--green);color:#fff;box-shadow:0 6px 14px rgba(15,122,79,.3)}
.docs{display:grid;gap:12px}
.doc{display:flex;align-items:center;gap:12px;padding:14px;border-radius:12px;background:var(--soft);transition:.3s;flex-wrap:wrap}
.doc.up{background:#e8f8ef}.doc div{flex:1;min-width:150px}.doc small{color:var(--mu);display:block;margin-top:2px}
.doc .ck{width:26px;height:26px;border-radius:50%;border:2px solid #b7c4d9;display:grid;place-items:center;color:#fff;transition:.3s;font-size:13px}
.doc.up .ck{background:var(--green);border-color:var(--green);transform:scale(1.1)}
.nav{display:flex;justify-content:space-between;align-items:center;margin-top:30px;gap:10px;flex-wrap:wrap}
.nav .r{display:flex;gap:10px}
.lnk{border:0;background:none;color:#27498a;font:600 12.5px Inter;cursor:pointer}
/* Ringkasan */
.sum{position:sticky;top:84px}
.sum h3{font-size:17px;display:flex;justify-content:space-between;align-items:center}
.box{background:var(--soft);border-radius:12px;padding:14px;margin:14px 0}
.box small{letter-spacing:.05em;color:var(--mu);font-size:10.5px;font-weight:600}.box b{display:block;font-size:17px;margin:4px 0 8px}
.reg{display:flex;justify-content:space-between;color:var(--mu);font-size:12px}.reg b{display:inline;font-size:13px;color:var(--green);margin:0}
.bar{height:7px;background:#dfe7f2;border-radius:9px;overflow:hidden;margin-top:6px}
.bar i{display:block;height:100%;background:var(--green);border-radius:9px;width:0;transition:width .8s cubic-bezier(.2,.8,.2,1)}
.sl{display:flex;justify-content:space-between;align-items:center;padding:10px 12px;border-radius:10px;background:var(--soft);margin-bottom:8px;font-size:12.5px;transition:.3s}
.sl.ok{background:#e8f8ef}.sl em{font-style:normal;font-size:11.5px;font-weight:600;color:var(--mu)}.sl.ok em{color:var(--green)}
.kv{display:flex;justify-content:space-between;gap:10px;padding:6px 0}.kv b{text-align:right}
.hint{padding:12px;border-radius:10px;background:var(--soft);color:var(--mu);font-size:12px;line-height:1.6;margin:12px 0}
.inst{display:flex;align-items:center;gap:12px;margin-top:18px;padding:18px;line-height:1.4}
.inst span{width:42px;height:42px;border-radius:50%;background:var(--mint);display:grid;place-items:center;color:var(--green)}
dialog{border:0;border-radius:18px;padding:34px;width:min(400px,92vw);margin:auto;text-align:center;box-shadow:0 30px 80px rgba(11,31,58,.35)}
dialog::backdrop{background:rgba(11,31,58,.55);backdrop-filter:blur(4px)}
dialog[open]{animation:pop .45s cubic-bezier(.2,.8,.2,1)}@keyframes pop{from{opacity:0;transform:scale(.85) translateY(20px)}}
.ok-c{width:76px;height:76px;margin:0 auto 14px}.ok-c circle{fill:var(--mint)}
.ok-c path{fill:none;stroke:var(--green);stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-dasharray:40;animation:dr .7s .3s ease backwards}
@keyframes dr{from{stroke-dashoffset:40}}
#toast{position:fixed;right:24px;bottom:24px;background:var(--navy);color:#fff;padding:12px 18px;border-radius:12px;font-weight:600;transform:translateY(90px);opacity:0;transition:.4s cubic-bezier(.2,.8,.2,1);z-index:50}
#toast.show{transform:none;opacity:1}
.in-a{animation:rise .8s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--d,0)*90ms)}
@keyframes rise{from{opacity:0;transform:translateY(22px)}}
@media(max-width:1100px){.lay{grid-template-columns:1fr}.sum{position:static}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.pill.h{display:none}}
@media(max-width:700px){.grid{grid-template-columns:1fr}.wrap{padding:16px 14px}.sti div{display:none}.search{width:100%}.top{flex-wrap:wrap}.head h1{font-size:22px}.card{padding:18px}}
@media(prefers-reduced-motion:reduce){*,*::before{animation:none!important;transition:none!important}}
</style>
</head>
<body>
@php $nama=auth()->user()->name; $ic=fn($n)=>'<svg class="i"><use href="#'.$n.'"/></svg>'; @endphp
@include('partials.sidebar')

<div class="main">
  <header class="top in-a" style="--d:1">
    <label class="search">{!! $ic('search') !!}<input placeholder="Cari nama, NISN, atau menu..."></label>
    <span class="pill h">Sistem Aktif</span><small class="mu">TA 2026/2027 — Ganjil</small>
    <span class="sp"></span>
    <button class="btn g" id="qa">{!! $ic('plus') !!}Quick Action</button>
    <div class="user"><div class="av">{{ strtoupper(substr($nama,0,1)) }}</div><div><b>{{ $nama }}</b><small>Administrator</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form></div>
  </header>

  <div class="wrap">
    <div class="crumb in-a" style="--d:2"><a href="{{ route('dashboard') }}">Dashboard Utama</a> › <a href="{{ route('penerimaan') }}">Penerimaan Siswa Baru (PPDB)</a> › <b>Pendaftaran Baru</b></div>
    <section class="head in-a" style="--d:3">
      <div><h1>Pendaftaran Calon Siswa Baru</h1> <span class="pill">TA 2026/2027</span> <span class="pill" style="background:#e0ecff;color:#1d4ed8">Mode Operator PPDB</span>
        <p>Kelola data pendaftaran calon siswa baru MAS YPI SUMBER HARJO secara terstruktur, terarsip digital, dan terverifikasi.</p></div>
      <div class="tools"><a href="{{ route('penerimaan') }}" class="btn">← Kembali ke PPDB</a><button class="btn s" id="dr1">Simpan Draft</button></div>
    </section>

    <section class="card stp in-a" style="--d:4" id="stp"></section>

    <div class="lay">
      <section class="card in-a" style="--d:5"><div id="pane" class="pane"></div></section>
      <aside class="in-a" style="--d:6">
        <div class="card sum">
          <h3><span>Ringkasan Entri PPDB</span><span class="pill" style="background:#dbe7fb;color:#27498a">Live Preview</span></h3>
          <div class="box"><small>NAMA CALON SISWA</small><b id="sNama">Belum diisi</b><div class="reg"><span>No. Registrasi Sistem:</span><b>REG-2026-0006</b></div></div>
          <div style="display:flex;justify-content:space-between;font-weight:600;font-size:12px;color:var(--green)"><span>Kelengkapan Formulir</span><span id="sPct">0% Lengkap</span></div>
          <div class="bar"><i id="sBar"></i></div>
          <div id="sSteps" style="margin-top:16px"></div>
          <div class="box" style="margin-bottom:0"><div class="kv"><span class="mu">Pilihan Jalur:</span><b id="sJalur">-</b></div><div class="kv"><span class="mu">Asal Madrasah/Sekolah:</span><b id="sSek">-</b></div></div>
          <div class="hint">Setelah formulir disimpan, berkas langsung terdaftar di sistem arsip dan siap untuk proses verifikasi panitia.</div>
          <button class="btn s" id="dl" style="width:100%;justify-content:center">{!! $ic('download') !!}Unduh Bukti Entri Sementara</button>
        </div>
        <div class="card inst"><span>{!! $ic('folder') !!}</span><div><b>MAS YPI SUMBER HARJO</b><br><small class="mu">Kementerian Agama RI — SIADDS</small></div></div>
      </aside>
    </div>
  </div>
</div>

<dialog id="dlg"><svg class="ok-c" viewBox="0 0 76 76"><circle cx="38" cy="38" r="38"/><path d="M23 39l10 10 20-22"/></svg>
  <h2 style="font-size:21px">Pendaftaran Terkirim!</h2><p class="mu" style="margin:8px 0 6px">Calon siswa berhasil didaftarkan dengan nomor</p><b style="color:var(--green);font-size:18px">REG-2026-0006</b>
  <div style="display:flex;gap:10px;justify-content:center;margin-top:22px"><button class="btn" id="again">Daftar Lagi</button><a class="btn g" href="{{ route('penerimaan') }}">Ke Dashboard PPDB</a></div></dialog>
<div id="toast"></div>

<script>
const $=s=>document.querySelector(s),esc=s=>String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const P=[['Kab. OKU Timur']];
const ST=[
{t:'Data Pribadi',s:'Identitas & Kontak',h:'Data Pribadi Calon Siswa',d:'Masukkan identitas calon siswa sesuai dokumen resmi Akta Kelahiran dan Kartu Keluarga.',f:[
 {k:'nama',l:'Nama Lengkap Calon Siswa',full:1,r:1,m:'Nama wajib diisi'},
 {k:'nisn',l:'NISN (10 Digit)',r:1,v:/^\d{10}$/,m:'NISN harus 10 digit angka',max:10},
 {k:'nik',l:'NIK / No. KTP Calon Siswa (16 Digit)',r:1,v:/^\d{16}$/,m:'NIK harus 16 digit angka',max:16},
 {k:'jk',l:'Jenis Kelamin',r:1,type:'gender'},
 {k:'agama',l:'Agama',r:1,type:'select',o:['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu']},
 {k:'tempat',l:'Tempat Lahir',r:1},{k:'tgl',l:'Tanggal Lahir',r:1,type:'date'},
 {k:'hp',l:'Nomor HP / WhatsApp Calon Siswa',r:1,v:/^(\+62|0)[0-9\s-]{8,14}$/,m:'Nomor HP tidak valid (contoh 0821-7890-1234)'},
 {k:'email',l:'Email Aktif Calon Siswa',type:'email',v:/^\S+\x40\S+\.\S+$/,m:'Format email tidak valid'}]},
{t:'Data Alamat',s:'Domisili Sesuai KK',h:'Data Alamat & Domisili',d:'Isi alamat tempat tinggal sesuai Kartu Keluarga.',f:[
 {k:'alamat',l:'Alamat Lengkap (Jalan / Dusun / RT-RW)',full:1,r:1},{k:'desa',l:'Desa / Kelurahan',r:1},{k:'kec',l:'Kecamatan',r:1},
 {k:'kab',l:'Kabupaten / Kota',r:1},{k:'prov',l:'Provinsi',r:1},{k:'pos',l:'Kode Pos',v:/^\d{5}$/,m:'Kode pos 5 digit angka',max:5}]},
{t:'Pendidikan',s:'MTs/SMP & Peminatan',h:'Data Pendidikan Asal',d:'Informasi sekolah asal dan jalur pendaftaran yang dipilih.',f:[
 {k:'sek',l:'Asal Madrasah / Sekolah',full:1,r:1},{k:'lulus',l:'Tahun Lulus',r:1,v:/^20\d{2}$/,m:'Tahun tidak valid',max:4},
 {k:'jalur',l:'Jalur Pendaftaran',r:1,type:'select',o:['Reguler','Prestasi','Afirmasi']},
 {k:'minat',l:'Pilihan Peminatan',type:'select',o:['IPA','IPS','Keagamaan']}]},
{t:'Orang Tua / Wali',s:'Ayah, Ibu & Wali',h:'Data Orang Tua / Wali',d:'Data orang tua atau wali yang dapat dihubungi panitia.',f:[
 {k:'ayah',l:'Nama Ayah',r:1},{k:'ibu',l:'Nama Ibu',r:1},{k:'kerja',l:'Pekerjaan Orang Tua',type:'select',o:['Petani','Wiraswasta','PNS / TNI / Polri','Karyawan Swasta','Buruh','Lainnya']},
 {k:'hpo',l:'Nomor HP Orang Tua / Wali',r:1,v:/^(\+62|0)[0-9\s-]{8,14}$/,m:'Nomor HP tidak valid'},{k:'wali',l:'Nama Wali (jika ada)',full:1}]},
{t:'Dokumen & Final',s:'Arsip Berkas Digital',h:'Dokumen Persyaratan',d:'Unggah berkas asli (PDF/JPG/PNG, maksimal 2 MB per berkas).',docs:1,f:[]}];
const DOCS=[['akta','Akta Kelahiran',1],['kk','Kartu Keluarga',1],['ijazah','Ijazah / SKL',1],['foto','Pas Foto 3x4 (diunggah di langkah 1)',1],['kip','KIP / PKH (opsional, jalur Afirmasi)',0]];
const REQ=ST.flatMap((s,i)=>s.f.filter(f=>f.r).map(f=>({...f,st:i})));
const REQD=DOCS.filter(d=>d[2]);
let V={},cur=0,done=new Set(),maxR=0,photo=null,files={};
try{const d=JSON.parse(localStorage.getItem('siadds_draft'));if(d){V=d.V||{};cur=d.cur||0;maxR=d.maxR||0;done=new Set(d.done||[]);setTimeout(()=>toast('Draft sebelumnya dipulihkan'),900)}}catch(e){}
const ok=k=>REQ.find(f=>f.k==k)&&String(V[k]||'').trim()!=='';
const docUp=k=>k=='foto'?!!photo:!!files[k];

function stepper(){$('#stp').innerHTML=ST.map((s,i)=>`<div class="sti ${i==cur?'on':''} ${done.has(i)?'ok':''}" data-i="${i}"><span class="sn">${done.has(i)&&i!=cur?'✓':i+1}</span><div><b>${s.t}</b><small>${s.s}</small></div></div>`).join('')}
function field(f){
  const v=V[f.k]??'',lab=`<label class="l">${f.l}${f.r?' <i>*</i>':''}</label>`,cls=f.full?'full':'';
  let c;
  if(f.type=='gender')c=`<div class="gen">${[['L','♂ Laki-laki'],['P','♀ Perempuan']].map(g=>`<button type="button" data-g="${g[0]}" class="${v==g[0]?'on':''}">${g[1]}</button>`).join('')}</div>`;
  else if(f.type=='select')c=`<select class="in" data-k="${f.k}">${f.o.map(o=>`<option ${v==o?'selected':''}>${o}</option>`).join('')}</select>`;
  else c=`<input class="in" data-k="${f.k}" type="${f.type||'text'}" value="${esc(v)}" ${f.max?`maxlength="${f.max}" inputmode="numeric"`:''} placeholder="${f.type=='date'?'':'Isi '+f.l.toLowerCase().replace(/ \(.*/,'')}">`;
  return `<div class="${cls}" data-f="${f.k}">${lab}${c}<div class="err"></div></div>`}
function pane(){
  const s=ST[cur];let h=`<span class="lbl">LANGKAH 0${cur+1} / 05</span><div style="display:flex;justify-content:space-between;gap:10px"><h2>${s.h}</h2><span class="pill" style="height:fit-content">🛡 Wajib Valid</span></div><p class="mu" style="line-height:1.6">${s.d}</p>`;
  if(cur==0)h+=`<div class="note">✔<div><b>Validasi NIK & NISN:</b> Pastikan ejaan nama, NIK 16 digit, dan NISN 10 digit sesuai dengan data Dukcapil dan pangkalan data NISN Kemendikbudristek/Kemenag.</div></div>
  <div class="photo"><div class="ph" id="ph" style="${photo?`background-image:url(${photo})`:''}"><span>3 × 4 Formal</span></div><div><h4>Pas Foto Formal Siswa</h4><p class="mu" style="line-height:1.6;margin-bottom:10px">Format JPG/PNG, maksimal 2.0 MB. Latar belakang merah atau biru mengenakan seragam sekolah asal.</p><button type="button" class="btn g" id="pick">{!! $ic('upload') !!}Pilih Foto</button> <button type="button" class="btn s" id="delph">Hapus</button><input type="file" id="pf" accept="image/*" hidden></div></div>`;
  h+=s.docs?`<div class="docs" style="margin-top:20px">${DOCS.map(d=>`<div class="doc ${docUp(d[0])?'up':''}" data-d="${d[0]}"><span class="ck">${docUp(d[0])?'✓':''}</span><div><b>${d[1]}</b><small>${d[0]=='foto'?(photo?'Foto terunggah':'Belum ada foto'):files[d[0]]?esc(files[d[0]]):d[2]?'Wajib diunggah':'Opsional'}</small></div><button type="button" class="btn ${docUp(d[0])?'':'g'}" data-up="${d[0]}">${d[0]=='foto'?'Ke Langkah 1':docUp(d[0])?'Ganti':'Pilih Berkas'}</button></div>`).join('')}<input type="file" id="df" accept=".pdf,image/*" hidden></div><div class="err" id="derr" style="margin-top:8px"></div>`:`<div class="grid" style="margin-top:20px">${s.f.map(field).join('')}</div>`;
  h+=`<div class="nav"><button type="button" class="lnk" id="${cur?'back':'reset'}">${cur?'← Sebelumnya':'Reset Isian'}</button><div class="r"><button type="button" class="btn s" id="dr2">Simpan Draft</button><button type="button" class="btn g" id="next">${cur==4?'Kirim Pendaftaran ✓':'Simpan & Lanjutkan →'}</button></div></div>`;
  const el=$('#pane');el.innerHTML=h;el.style.animation='none';el.offsetHeight;el.style.animation='';stepper();summary()}

function stepValid(i,show){
  let good=true;const s=ST[i];
  if(s.docs){const miss=REQD.filter(d=>!docUp(d[0]));if(miss.length){good=false;if(show)$('#derr').textContent='Berkas wajib belum lengkap: '+miss.map(d=>d[1].replace(/ \(.*/,'')).join(', ')}return good}
  s.f.forEach(f=>{const val=String(V[f.k]||'').trim();let m='';
    if(f.r&&!val)m=f.m&&!f.v?f.m:'Wajib diisi';else if(val&&f.v&&!f.v.test(val))m=f.m;
    if(m){good=false;if(show){const w=document.querySelector(`[data-f="${f.k}"]`);w.classList.remove('bad');w.offsetHeight;w.classList.add('bad');w.querySelector('.err').textContent=m}}});
  return good}

function summary(){
  const filled=REQ.filter(f=>ok(f.k)).length+REQD.filter(d=>docUp(d[0])).length,tot=REQ.length+REQD.length,pct=Math.round(filled/tot*100);
  $('#sNama').textContent=V.nama?.trim()||'Belum diisi';$('#sPct').textContent=pct+'% Lengkap';$('#sBar').style.width=pct+'%';
  $('#sJalur').textContent=V.jalur||'-';$('#sSek').textContent=V.sek||'-';
  $('#sSteps').innerHTML=ST.map((s,i)=>{const r=REQ.filter(f=>f.st==i),n=s.docs?REQD.filter(d=>docUp(d[0])).length:r.filter(f=>ok(f.k)).length,t=s.docs?REQD.length:r.length;
    return `<div class="sl ${done.has(i)?'ok':''}"><span>${done.has(i)?'✔':'○'} ${i+1}. ${s.t}</span><em>${done.has(i)?'Selesai':n+'/'+t+(s.docs?' Terunggah':' Terisi')}</em></div>`}).join('')}

/* Event: isi form */
document.addEventListener('input',e=>{const k=e.target.dataset?.k;if(!k)return;V[k]=e.target.value;const w=e.target.closest('[data-f]');w?.classList.remove('bad');if(w)w.querySelector('.err').textContent='';summary()});
document.addEventListener('click',e=>{
  const t=e.target,g=t.closest('[data-g]');
  if(g){V.jk=g.dataset.g;document.querySelectorAll('[data-g]').forEach(b=>b.classList.toggle('on',b===g));const w=g.closest('[data-f]');w.classList.remove('bad');w.querySelector('.err').textContent='';summary();return}
  const st=t.closest('.sti');if(st){const i=+st.dataset.i;if(i<=maxR||done.has(i-1)){cur=i;pane()}else toast('Selesaikan langkah sebelumnya dahulu');return}
  const up=t.closest('[data-up]');if(up){if(up.dataset.up=='foto'){cur=0;pane();return}$('#df').dataset.for=up.dataset.up;$('#df').click();return}
  const id=t.closest('button')?.id;
  if(id=='pick')$('#pf').click();
  if(id=='delph'){photo=null;$('#ph').style.backgroundImage='';summary();toast('Foto dihapus')}
  if(id=='back'){cur--;pane()}
  if(id=='reset'&&confirm('Kosongkan semua isian pada langkah ini?')){ST[cur].f.forEach(f=>delete V[f.k]);done.delete(cur);pane()}
  if(id=='dr1'||id=='dr2')draft();
  if(id=='next')next();
  if(id=='again'){location.reload()}
});
document.addEventListener('change',e=>{
  const f=e.target.files?.[0];if(!f)return;
  if(f.size>2*1024*1024){toast('Ukuran berkas melebihi 2 MB');e.target.value='';return}
  if(e.target.id=='pf'){if(!f.type.startsWith('image/')){toast('Foto harus berformat JPG/PNG');return}photo=URL.createObjectURL(f);$('#ph').style.backgroundImage=`url(${photo})`;summary();toast('Foto berhasil dipilih')}
  if(e.target.id=='df'){files[e.target.dataset.for]=f.name;e.target.value='';$('#derr').textContent='';pane();toast('Berkas diunggah: '+f.name)}
});
$('#qa').onclick=()=>{cur=0;pane();document.querySelector('.in')?.focus()};

function next(){
  if(!stepValid(cur,true)){toast('Lengkapi isian yang ditandai merah');return}
  done.add(cur);if(cur<4){cur++;maxR=Math.max(maxR,cur);pane();scrollTo({top:0,behavior:'smooth'});toast('Langkah tersimpan')}
  else{summary();stepper();draftClear();$('#dlg').showModal()}}
function draft(){try{localStorage.setItem('siadds_draft',JSON.stringify({V,cur,maxR,done:[...done]}));toast('Draft tersimpan (foto & berkas tidak ikut disimpan)')}catch(e){toast('Draft gagal disimpan')}}
function draftClear(){try{localStorage.removeItem('siadds_draft')}catch(e){}}
$('#dl').onclick=()=>{const t=['BUKTI ENTRI SEMENTARA - SIADDS MAS YPI SUMBER HARJO','No. Registrasi: REG-2026-0006','Nama: '+(V.nama||'-'),'NISN: '+(V.nisn||'-'),'Jalur: '+(V.jalur||'-'),'Asal Sekolah: '+(V.sek||'-'),'Kelengkapan: '+$('#sPct').textContent,'Dicetak: '+new Date().toLocaleString('id-ID')].join('\n');
  const a=document.createElement('a');a.href=URL.createObjectURL(new Blob([t],{type:'text/plain'}));a.download='bukti-entri-REG-2026-0006.txt';a.click();toast('Bukti entri diunduh')};
function toast(m){const t=$('#toast');t.textContent=m;t.classList.add('show');clearTimeout(t._t);t._t=setTimeout(()=>t.classList.remove('show'),2600)}
V.jalur=V.jalur||'Reguler';V.agama=V.agama||'Islam';V.minat=V.minat||'IPA';V.kerja=V.kerja||'Petani';
pane();
</script>
@include('partials.pendaftaran-simpan')
@include('partials.pendaftaran-tambahan')
</body>
</html>