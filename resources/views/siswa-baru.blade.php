<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tambah Siswa Baru | MAS YPI SUMBER HARJO</title>
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

/* ===== Tambah Siswa Baru ===== */
.crumb{color:var(--mu);font-size:12px;margin-bottom:10px}
.ph{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;flex-wrap:wrap;margin-bottom:18px}
.ph h1{font-size:28px;font-weight:800;letter-spacing:-.02em;display:flex;gap:12px;align-items:center;flex-wrap:wrap}
.ph p{color:var(--mu);margin-top:6px;max-width:580px;line-height:1.6}
.ph-r{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
.dchip{display:inline-flex;gap:7px;align-items:center;padding:8px 13px;border-radius:99px;background:#fff;border:1px solid var(--line);color:var(--mu);font-size:11.5px;font-weight:600}
.dchip i{width:7px;height:7px;border-radius:50%;background:#34d399;animation:pulse 2s infinite}
.ok{background:var(--mint);color:#0a5c3b}.okt{color:var(--green);font-weight:600}
.prog{padding:20px 22px;margin-bottom:20px}
.prog-h{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap}
.prog-h small{letter-spacing:.06em;font-size:10.5px;font-weight:700;color:var(--mu)}
.prog-h b{display:block;font-size:15px;margin-top:3px}
.pw{display:flex;align-items:center;gap:12px;flex:1;max-width:320px;min-width:180px}
.pt{flex:1;height:8px;background:#e8edf4;border-radius:9px;overflow:hidden}
.pt i{display:block;height:100%;width:0;background:linear-gradient(90deg,var(--green),#34d399);border-radius:9px;transition:width .9s cubic-bezier(.2,.8,.2,1)}
.stepper{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin-top:16px}
.stp-b{display:flex;gap:10px;align-items:center;padding:11px 12px;border-radius:12px;background:#f6f8fb;border:1px solid transparent;text-align:left;font:inherit;cursor:pointer;color:var(--mu);transition:background .35s,transform .35s,box-shadow .35s}
.stp-b:hover{transform:translateY(-2px)}
.stp-b .n{width:26px;height:26px;border-radius:50%;display:grid;place-items:center;font-weight:700;font-size:11px;background:#e5e9f0;color:var(--mu);flex:none;transition:background .4s,color .4s}
.stp-b small{display:block;font-size:9.5px;letter-spacing:.05em;font-weight:700}
.stp-b b{display:block;font-size:12px;color:var(--tx)}
.stp-b.done{background:#eefaf3}.stp-b.done .n{background:var(--green);color:#fff;animation:pop .5s}
.stp-b.on{background:var(--navy);color:#9fb3cf;box-shadow:0 12px 26px rgba(11,31,58,.25);transform:translateY(-2px)}
.stp-b.on b{color:#fff}.stp-b.on .n{background:var(--green);color:#fff}
@keyframes pop{0%{transform:scale(.4)}60%{transform:scale(1.25)}100%{transform:scale(1)}}
.cols{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:20px;align-items:start}
.rt{position:sticky;top:84px;display:grid;gap:16px}
.panel{display:none}.panel.on{display:block;animation:stepIn .6s cubic-bezier(.2,.8,.2,1)}
form.back .panel.on{animation-name:stepBack}
@keyframes stepIn{from{opacity:0;transform:translateX(30px)}}
@keyframes stepBack{from{opacity:0;transform:translateX(-30px)}}
.ph2{margin-bottom:16px}.ph2 h3{font-size:18px;margin:8px 0 4px}
.g2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.fld{display:block}.fld.full{grid-column:1/-1}
.fld>span{display:block;font-size:11.5px;font-weight:600;margin-bottom:5px}.fld>span em{color:var(--red);font-style:normal}
.fld input,.fld select,.fld textarea{width:100%;padding:11px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font:inherit;color:var(--tx);outline:0;transition:border-color .25s,box-shadow .25s}
.fld textarea{resize:vertical;min-height:72px}
.fld input:focus,.fld select:focus,.fld textarea:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.13)}
.fld input[readonly]{background:#f6f8fb;color:var(--mu)}
.fld .err{display:none;color:var(--red);font-size:11px;margin-top:4px}
.fld.inv input,.fld.inv select,.fld.inv textarea{border-color:var(--red);animation:shake .4s}.fld.inv .err{display:block}
@keyframes shake{25%{transform:translateX(-4px)}75%{transform:translateX(4px)}}
.alert{background:#fff1f1;border:1px solid #fbcaca;color:#b91c1c;border-radius:14px;padding:14px 18px;margin-bottom:16px}
.alert ul{margin:6px 0 4px 18px;line-height:1.6}
.dtop{display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;align-items:flex-start;margin-bottom:14px}
.dsum{min-width:210px;padding:10px 14px;border-radius:12px;background:#f6f8fb}
.dsum small{display:flex;justify-content:space-between;gap:10px;font-weight:600}
.dsum .pt{margin:7px 0}
.dc{border:1px solid var(--line);border-radius:14px;padding:14px 16px;margin-bottom:12px;background:#fff;transition:box-shadow .3s,transform .3s;animation:rise .7s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--i)*80ms)}
.dc:hover{box-shadow:0 12px 28px rgba(11,31,58,.08);transform:translateY(-2px)}
.dc-h{display:flex;gap:12px;align-items:center;flex-wrap:wrap}
.dc-ic{width:38px;height:38px;border-radius:11px;background:#e8eefb;color:#334e8a;display:grid;place-items:center;flex:none}
.dc-t{flex:1;min-width:170px}.dc-t b{font-size:13px}
.bdg{padding:2px 8px;border-radius:99px;font-size:10px;font-weight:700;margin-left:6px}.bdg.w{background:#fee2e2;color:#b91c1c}.bdg.o{background:#eef2f7;color:var(--mu)}
.dc-s{display:inline-flex;gap:6px;align-items:center;padding:4px 10px;border-radius:99px;background:#eef2f7;color:var(--mu);font-size:11px;font-weight:600}
.dc-s i{width:6px;height:6px;border-radius:50%;background:currentColor}
.dc.has .dc-s{background:var(--mint);color:#0a5c3b}
.dz{margin-top:12px;border:1.5px dashed #cbd5e1;border-radius:12px;padding:16px;text-align:center;background:#fafcfe;cursor:pointer;color:var(--mu);transition:border-color .25s,background .25s,transform .25s}
.dz:hover,.dz.drag{border-color:var(--green);background:#f1faf5;transform:scale(1.01)}.dz u{color:var(--green);font-weight:600}
.dc-f{display:none;gap:10px;align-items:center;flex-wrap:wrap;margin-top:12px;padding:10px 12px;border-radius:10px;background:#f6f8fb;animation:rise .5s backwards}
.dc.has .dz{display:none}.dc.has .dc-f{display:flex}
.dc-f .fn{font-weight:600;max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.dc-f .btn{padding:6px 10px;font-size:11.5px}
.dc.off .dz{opacity:.45;pointer-events:none}
.derr{display:none;color:var(--red);font-size:11px;margin-top:6px}
.chk{display:flex;gap:8px;align-items:center;margin-top:10px;font-size:12px;color:var(--tx)}
.rc{border:1px solid var(--line);border-radius:12px;margin-bottom:10px;background:#fff;overflow:hidden}
.rc summary{display:flex;gap:12px;align-items:center;padding:12px 14px;cursor:pointer;list-style:none}
.rc summary::-webkit-details-marker{display:none}
.rc .rn{width:26px;height:26px;border-radius:50%;background:var(--mint);color:#0a5c3b;display:grid;place-items:center;font-weight:700;font-size:11px;flex:none}
.rtx{flex:1;min-width:0}.rtx b{display:block}.rtx small{color:var(--mu)}
.lnk{border:0;background:none;color:var(--green);font:600 12px Inter,sans-serif;cursor:pointer}
.rc dl{display:grid;grid-template-columns:160px 1fr;gap:6px 14px;padding:4px 16px 14px 52px;font-size:12px;animation:rise .4s backwards}
.rc dt{color:var(--mu)}.rc dd{font-weight:600}
.kta{border-radius:18px;padding:18px;color:#a9bbd4;background:linear-gradient(145deg,#0b1f3a,#10335c);position:relative;overflow:hidden;transition:transform .25s ease-out;box-shadow:0 20px 44px rgba(11,31,58,.3)}
.kta::after{content:"";position:absolute;inset:0;background:linear-gradient(105deg,transparent 35%,rgba(255,255,255,.13) 50%,transparent 65%);transform:translateX(-120%);animation:shine 5s ease-in-out 1.4s infinite;pointer-events:none}
@keyframes shine{to{transform:translateX(120%)}}
.kta-h{display:flex;justify-content:space-between;align-items:center;font-size:10px;letter-spacing:.06em;font-weight:700;margin-bottom:14px}
.kta-c{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.12);border-radius:14px;padding:14px}
.kta-top{display:flex;gap:14px;align-items:center}
.kta-ph{width:62px;height:78px;border-radius:9px;background:#e2e8f0 center/cover no-repeat;display:grid;place-items:center;color:#0b1f3a;font-weight:800;font-size:24px;flex:none}
.kta h4{color:#fff;font-size:15px;margin:3px 0 5px}.kta small{font-size:10px;letter-spacing:.05em}
.kta-b{display:flex;justify-content:space-between;gap:10px;margin-top:14px;padding-top:12px;border-top:1px solid rgba(255,255,255,.12)}
.kta-b b{display:block;color:#fff;font-size:12px;margin-top:2px}
.anti{display:flex;gap:12px;align-items:flex-start;padding:14px}
.anti .ai{width:26px;height:26px;border-radius:50%;display:grid;place-items:center;background:#e5e9f0;color:var(--mu);font-weight:700;flex:none;transition:background .3s}
.anti.ok .ai{background:var(--mint);color:#0a5c3b}.anti.dup .ai{background:#fee2e2;color:#b91c1c}
.anti small{display:block;color:var(--mu);margin-top:2px;line-height:1.5}
.vn{background:#eefaf3;border-color:#cfeedd}.vn p{line-height:1.6;color:var(--mu);margin-top:4px}
.bar2{position:sticky;bottom:14px;z-index:15;display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;padding:12px 16px;margin-top:20px;background:rgba(255,255,255,.92);backdrop-filter:blur(12px);border:1px solid var(--line);border-radius:16px;box-shadow:0 14px 34px rgba(11,31,58,.12)}
.bar2 .gp{display:flex;gap:8px;flex-wrap:wrap}
[hidden]{display:none!important}
.toast{position:fixed;right:24px;bottom:96px;z-index:60;display:flex;gap:12px;align-items:center;padding:14px 16px;border-radius:14px;background:var(--navy);color:#cbd5e1;box-shadow:0 18px 40px rgba(11,31,58,.35);transform:translateY(30px);opacity:0;pointer-events:none;transition:transform .5s cubic-bezier(.2,.8,.2,1),opacity .4s;max-width:340px}
.toast.show{transform:none;opacity:1;pointer-events:auto}
.toast b{color:#fff;display:block}.toast small{font-size:11.5px}
.toast .tk{width:28px;height:28px;border-radius:50%;background:var(--green);color:#fff;display:grid;place-items:center;flex:none}
.toast button{border:0;background:none;color:#8ea3c0;font-size:18px;cursor:pointer}
@media(max-width:1100px){.cols{grid-template-columns:1fr}.rt{position:static}.stepper{grid-template-columns:repeat(2,1fr)}}
@media(max-width:700px){.g2{grid-template-columns:1fr}.rc dl{grid-template-columns:1fr;padding-left:16px}}

/* ===== Perbaikan fungsi ===== */
.fld{scroll-margin:150px}
.qa{position:relative}
.qa-menu{position:absolute;right:0;top:calc(100% + 8px);min-width:260px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 20px 44px rgba(11,31,58,.18);padding:6px;z-index:40;animation:qaIn .3s cubic-bezier(.2,.8,.2,1)}
@keyframes qaIn{from{opacity:0;transform:translateY(10px) scale(.98)}}
.qa-menu a,.qa-menu button{display:block;width:100%;text-align:left;padding:10px 12px;border:0;background:none;border-radius:9px;color:var(--tx);text-decoration:none;font:600 12.5px Inter,sans-serif;cursor:pointer;transition:background .2s}
.qa-menu a:hover,.qa-menu button:hover{background:var(--bg)}
.qa-menu hr{border:0;border-top:1px solid var(--line);margin:5px 4px}
</style>
</head>
<body>
@php
$ic = fn($n) => '<svg class="i"><use href="#'.$n.'"/></svg>';
$nama = auth()->user()->name ?? 'Admin';
$petaStep = ['nama'=>1,'panggilan'=>1,'nisn'=>1,'nis'=>1,'jenis_kelamin'=>1,'tempat_lahir'=>1,'tanggal_lahir'=>1,'nik'=>1,'alamat'=>1,'kelas'=>2,'rombel'=>2,'tahun_masuk'=>2,'tanggal_masuk'=>2,'asal_sekolah'=>2,'wali_kelas'=>2,'tahun_ajaran'=>2,'nama_ayah'=>3,'nama_ibu'=>3,'no_hp_wali'=>3];
$stepErr = 1;
if ($errors->any()) {
    $stepErr = min(array_map(fn($k) => $petaStep[$k] ?? 4, array_keys($errors->messages())));
}
$namaStep = ['Identitas Siswa','Informasi Pendidikan','Orang Tua / Wali','Unggah Dokumen','Pemeriksaan & Simpan'];
@endphp

@include('partials.sidebar')

<div class="main">
  <header class="top in" style="--d:1">
    <form method="GET" action="{{ route('siswa.aktif') }}" style="margin:0">
      <label class="search"><input type="search" name="q" placeholder="Cari siswa..."></label>
    </form>
    <span class="pill">Sistem Aktif</span><small class="mu">TA 2026/2027 - Ganjil (Asia/Jakarta)</small>
    <span class="sp"></span>
    <div class="qa">
      <button type="button" class="btn g" id="qaBtn" aria-haspopup="true" aria-expanded="false">+ Quick Action</button>
      <div class="qa-menu" id="qaMenu" hidden>
        <button type="button" id="qaSave">Simpan Draft Sekarang</button>
        <button type="button" id="qaReset">Kosongkan Formulir &amp; Hapus Draft</button>
        <hr>
        <a href="{{ route('siswa.aktif') }}">Data Siswa Aktif</a>
        <a href="{{ route('siswa.detail') }}">Detail Profil Siswa</a>
        <a href="{{ route('alumni') }}">Data Alumni</a>
        <a href="{{ route('pendaftaran') }}">Pendaftaran Baru (PPDB)</a>
      </div>
    </div>
    <div class="user">
      <div class="av">{{ strtoupper(substr($nama, 0, 1)) }}</div>
      <div><b>{{ $nama }}</b><small>Administrator • OP-10492</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
    </div>
  </header>

  <div class="wrap">
    <div class="crumb in" style="--d:1">Dashboard › Data Siswa › <b>Tambah Siswa Baru</b></div>
    <section class="ph in" style="--d:2">
      <div>
        <h1>Tambah Siswa Baru <span class="tag" style="margin:0">● TA 2026/2027</span></h1>
        <p>Masukkan identitas siswa, informasi pendidikan, data orang tua atau wali, dan dokumen persyaratan untuk melengkapi arsip digital siswa madrasah.</p>
      </div>
      <div class="ph-r">
        <span class="dchip"><i></i><span id="draftChip">Draft belum disimpan</span></span>
        <a class="btn" href="{{ route('siswa.aktif') }}">← Kembali ke Data Siswa</a>
      </div>
    </section>

    <form id="sbForm" method="POST" action="{{ route('siswa.baru.simpan') }}" enctype="multipart/form-data" novalidate
          data-start="{{ $stepErr }}" data-cek="{{ route('siswa.baru.cek') }}" data-old="{{ $errors->any() ? 1 : 0 }}" data-maxfile="{{ $batasFile ?? 0 }}" data-maxtotal="{{ $batasTotal ?? 0 }}">
      @csrf

      <section class="card prog in" style="--d:3">
        <div class="prog-h">
          <div><small>TAHAPAN PENDAFTARAN DIGITAL</small><b id="plabel">Progres Pengisian</b></div>
          <div class="pw"><div class="pt"><i id="pbar"></i></div><b id="ppct">0%</b></div>
        </div>
        <div class="stepper">
          @foreach($namaStep as $i => $ns)
            <button type="button" class="stp-b" data-step="{{ $i + 1 }}"><span class="n">{{ $i + 1 }}</span><span><small>TAHAP {{ $i + 1 }}</small><b>{{ $ns }}</b></span></button>
          @endforeach
        </div>
      </section>

      <div class="cols">
        <div class="in" style="--d:4;min-width:0">
          @if($errors->any())
            <div class="alert"><b>Data belum bisa disimpan:</b><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul><small>Pilih ulang berkas dokumen jika ada yang perlu diunggah.</small></div>
          @endif

          <div class="panel {{ $stepErr === 1 ? 'on' : '' }}" data-s="1"><div class="card">
            <div class="ph2"><span class="tag">TAHAP 1 DARI 5</span><h3>Identitas Siswa</h3><p class="mu">Data diri sesuai akta kelahiran dan Kartu Keluarga. Kolom bertanda * wajib diisi.</p></div>
            
<div class="g2">
 <label class="fld full"><span>Nama Lengkap <em>*</em></span><input type="text" name="nama" value="{{ old('nama') }}" data-req placeholder="Sesuai akta kelahiran" maxlength="100"><small class="err">Wajib diisi</small></label>
 <label class="fld"><span>Nama Panggilan</span><input type="text" name="panggilan" value="{{ old('panggilan') }}" maxlength="50"><small class="err"></small></label>
 <label class="fld"><span>Jenis Kelamin <em>*</em></span><select name="jenis_kelamin" data-req><option value="">Pilih...</option><option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option><option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option></select><small class="err">Wajib diisi</small></label>
 <label class="fld"><span>NISN <em>*</em></span><input type="text" name="nisn" value="{{ old('nisn') }}" data-req data-digits="10" inputmode="numeric" maxlength="10" placeholder="10 digit"><small class="err">Wajib diisi</small></label>
 <label class="fld"><span>NIS <em>*</em></span><input type="text" name="nis" value="{{ old('nis', $nisSaran) }}" data-req data-nis maxlength="20"><small class="err">Wajib diisi</small></label>
 <label class="fld"><span>Tempat Lahir</span><input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" maxlength="60"><small class="err"></small></label>
 <label class="fld"><span>Tanggal Lahir <em>*</em></span><input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" data-req data-past max="{{ now()->subDay()->format('Y-m-d') }}"><small class="err">Wajib diisi</small></label>
 <label class="fld full"><span>NIK (16 digit)</span><input type="text" name="nik" value="{{ old('nik') }}" data-digits="16" inputmode="numeric" maxlength="16"><small class="err"></small></label>
 <label class="fld full"><span>Alamat Lengkap</span><textarea name="alamat" maxlength="500">{{ old('alamat') }}</textarea><small class="err"></small></label>
</div>
          </div></div>

          <div class="panel {{ $stepErr === 2 ? 'on' : '' }}" data-s="2"><div class="card">
            <div class="ph2"><span class="tag">TAHAP 2 DARI 5</span><h3>Informasi Pendidikan &amp; Madrasah</h3><p class="mu">Kelas, rombel, dan riwayat sekolah sebelumnya.</p></div>
            
<div class="g2">
 <label class="fld"><span>Tahun Ajaran</span><input type="text" name="tahun_ajaran" value="{{ old('tahun_ajaran', '2026/2027') }}" readonly><small class="err"></small></label>
 <label class="fld"><span>Tahun Masuk <em>*</em></span><input type="number" name="tahun_masuk" value="{{ old('tahun_masuk', $tahun) }}" data-req min="2000" max="2100"><small class="err">Wajib diisi</small></label>
 <label class="fld"><span>Kelas / Rombel <em>*</em></span><select name="kelas" data-req><option value="">Pilih kelas...</option>@foreach($daftarKelas as $k)<option value="{{ $k }}" @selected(old('kelas') === $k)>{{ $k }}</option>@endforeach</select><small class="err">Wajib diisi</small></label>
 <label class="fld"><span>Peminatan / Nama Rombel</span><input type="text" name="rombel" value="{{ old('rombel') }}" maxlength="80" placeholder="mis. Peminatan MIPA 1"><small class="err"></small></label>
 <label class="fld"><span>Tanggal Masuk</span><input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', now()->format('Y-m-d')) }}"><small class="err"></small></label>
 <label class="fld"><span>Wali Kelas</span><input type="text" name="wali_kelas" value="{{ old('wali_kelas') }}" maxlength="100"><small class="err"></small></label>
 <label class="fld full"><span>Asal Sekolah (SMP/MTs) <em>*</em></span><input type="text" name="asal_sekolah" value="{{ old('asal_sekolah') }}" data-req maxlength="150"><small class="err">Wajib diisi</small></label>
</div>
          </div></div>

          <div class="panel {{ $stepErr === 3 ? 'on' : '' }}" data-s="3"><div class="card">
            <div class="ph2"><span class="tag">TAHAP 3 DARI 5</span><h3>Data Orang Tua / Wali</h3><p class="mu">Kontak yang dapat dihubungi pihak madrasah.</p></div>
            
<div class="g2">
 <label class="fld"><span>Nama Ayah <em>*</em></span><input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" data-req maxlength="100"><small class="err">Wajib diisi</small></label>
 <label class="fld"><span>Nama Ibu <em>*</em></span><input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" data-req maxlength="100"><small class="err">Wajib diisi</small></label>
 <label class="fld full"><span>No. HP / WhatsApp Wali <em>*</em></span><input type="tel" name="no_hp_wali" value="{{ old('no_hp_wali') }}" data-req data-phone maxlength="20" placeholder="08xxxxxxxxxx"><small class="err">Wajib diisi</small></label>
</div>
          </div></div>

          <div class="panel {{ $stepErr >= 4 ? 'on' : '' }}" data-s="4">
            <div class="card" style="margin-bottom:16px">
              <div class="dtop">
                <div class="ph2" style="margin:0"><span class="tag">TAHAP 4 DARI 5 • <span id="draftId">ID Draft</span></span><h3>Arsip Digital &amp; Dokumen Persyaratan</h3><p class="mu">Unggah berkas digital siswa secara valid. Format: PDF, JPG, PNG (maks. 5 MB).</p></div>
                <div class="dsum"><small><span>Dokumen Wajib:</span><b id="dCount">0 / 5</b></small><div class="pt"><i id="dBar" style="width:0"></i></div><small id="dMiss" class="rd">-</small></div>
              </div>
              @foreach($dokumen as $i => $d)
              <div class="dc" style="--i:{{ $i }}" data-key="{{ $d['key'] }}" data-wajib="{{ $d['wajib'] ? 1 : 0 }}" data-short="{{ $d['short'] }}">
                <input type="file" name="dok_{{ $d['key'] }}" accept=".pdf,.jpg,.jpeg,.png" hidden>
                <div class="dc-h">
                  <span class="dc-ic">{!! $ic($d['icon']) !!}</span>
                  <div class="dc-t"><b>{{ $i + 1 }}. {{ $d['label'] }}</b><span class="bdg {{ $d['wajib'] ? 'w' : 'o' }}">{{ $d['wajib'] ? 'Wajib' : 'Opsional' }}</span><small class="mu" style="display:block;margin-top:2px">{{ $d['hint'] }}</small></div>
                  <span class="dc-s"><i></i><em style="font-style:normal">Belum Diunggah</em></span>
                </div>
                @if($d['key'] === 'kip')<label class="chk"><input type="checkbox" name="tanpa_kip" value="1" {{ old('tanpa_kip') ? 'checked' : '' }}> Siswa tidak memiliki kartu bantuan pemerintah</label>@endif
                <div class="dz">Tarik &amp; lepaskan berkas di sini, atau <u>Pilih File</u></div>
                <div class="dc-f"><span class="fn">-</span><span class="mu fs"></span><span class="sp"></span>
                  <button type="button" class="btn act-lihat">Pratinjau</button><button type="button" class="btn act-ganti">Ganti</button><button type="button" class="btn act-hapus">Hapus</button></div>
                <small class="derr"></small>
              </div>
              @endforeach
            </div>
            <div class="card"><div class="ph2" style="margin-bottom:10px"><h3 style="margin:0">Data Tahapan Sebelumnya</h3><p class="mu">Klik "Ubah Data" untuk melompat ke tahap terkait.</p></div><div class="recap"></div></div>
          </div>

          <div class="panel {{ $stepErr === 5 ? 'on' : '' }}" data-s="5"><div class="card">
            <div class="ph2"><span class="tag">TAHAP 5 DARI 5</span><h3>Pemeriksaan &amp; Simpan</h3><p class="mu">Periksa kembali seluruh data. Setelah disimpan, siswa langsung masuk ke Data Siswa Aktif.</p></div>
            <div class="recap"></div>
            <div class="note" style="margin-top:14px"><div><b>Ringkasan Dokumen</b><small id="sumDocs">-</small></div></div>
          </div></div>
        </div>

        <aside class="rt">
          <div class="kta in" id="kta" style="--d:5">
            <div class="kta-h"><span>PRATINJAU KTA SEMENTARA</span><span class="chip ok">Draft Aktif</span></div>
            <div class="kta-c">
              <div class="kta-top"><div class="kta-ph" id="kPh"><span id="kIni">?</span></div><div><small>MAS YPI SUMBER HARJO</small><h4 id="kNama">Nama Siswa</h4><div>NIS: <span id="kNis">-</span></div><div>NISN: <span id="kNisn">-</span></div></div></div>
              <div class="kta-b"><div><small>PEMINATAN</small><b id="kRom">-</b></div><div><small>TAHUN MASUK</small><b id="kThn">-</b></div></div>
            </div>
          </div>
          <div class="card anti in" id="anti" style="--d:6"><span class="ai" id="antiI">…</span><div id="antiT"><b>Anti-Duplikasi: menunggu data</b><small>Isi NISN, NIS, dan NIK untuk memeriksa duplikasi.</small></div></div>
          <div class="card in" style="--d:7">
            <h3 style="margin:0 0 4px">Penetapan Arsip Fisik Madrasah</h3>
            <p class="mu" style="margin-bottom:12px;line-height:1.5">Lokasi penyimpanan map fisik ijazah asli &amp; berkas basah siswa di ruang arsip pusat.</p>
            <div class="g2" style="gap:10px">
              <label class="fld full"><span>Ruang Penyimpanan Arsip</span><input type="text" name="ruang_arsip" value="{{ old('ruang_arsip', 'Ruang Tata Usaha & Arsip Induk (Lt. 1)') }}" readonly></label>
              <label class="fld"><span>Lemari Berkas</span><select name="lemari">@foreach(['Lemari Besi B-1','Lemari Besi B-2','Lemari Besi B-3'] as $l)<option @selected(old('lemari') === $l)>{{ $l }}</option>@endforeach</select></label>
              <label class="fld"><span>Nomor Rak</span><select name="rak">@foreach(range(1, 10) as $r)<option value="Rak {{ sprintf('%02d', $r) }}" @selected(old('rak') === 'Rak ' . sprintf('%02d', $r))>Rak {{ sprintf('%02d', $r) }}</option>@endforeach</select></label>
              <label class="fld full"><span>Kode Label Map Ordner (Auto)</span><input type="text" name="kode_map" value="{{ old('kode_map') }}" readonly></label>
            </div>
            <p class="mu" style="margin-top:10px;font-size:11.5px">Petugas Entri: <b>{{ $nama }}</b></p>
          </div>
          <div class="card vn in" style="--d:8"><b>Catatan Verifikator SIADDS:</b><p id="vNote">-</p></div>
        </aside>
      </div>

      <div class="bar2 in" style="--d:9">
        <div class="gp"><a class="btn" id="bBatal" href="{{ route('siswa.aktif') }}">✕ Batal</a><button type="button" class="btn" id="bDraft">Simpan Draft</button></div>
        <div class="gp">
          <button type="button" class="btn" id="bPrev" style="visibility:hidden">← <span id="bPrevT">Kembali</span></button>
          <button type="button" class="btn g" id="bNext"><span id="bNextT">Lanjut</span> →</button>
          <button type="submit" class="btn g" id="bSave" hidden><span>Simpan Siswa Baru</span></button>
        </div>
      </div>
    </form>

    <footer class="foot in" style="--d:10"><span>Sistem Informasi Arsip Digital &amp; Data Siswa (SIADDS) • MAS YPI Sumber Harjo</span><span>Kemenag Kab. OKU Timur</span><span>NPSN: 10648892</span></footer>
  </div>
</div>

<div class="toast" id="toast"><span class="tk">✓</span><div><b></b><small></small></div><button type="button" aria-label="Tutup">×</button></div>

<script>
(function () {
  var form = document.getElementById('sbForm');
  var panels = [].slice.call(form.querySelectorAll('.panel'));
  var btns = [].slice.call(document.querySelectorAll('.stp-b'));
  var NAMA = ['Identitas Siswa', 'Informasi Pendidikan', 'Orang Tua / Wali', 'Unggah Dokumen', 'Pemeriksaan Data'];
  var TOTAL = 5, cur = parseInt(form.dataset.start, 10) || 1, DKEY = 'siadds_draft_siswa_baru';
  function $(s, c) { return (c || document).querySelector(s); }
  function $$(s, c) { return [].slice.call((c || document).querySelectorAll(s)); }
  function val(n) { var e = form.elements[n]; return e ? String(e.value).trim() : ''; }
  function setT(id, t) { var e = document.getElementById(id); if (e) e.textContent = t; }
  function esc(s) { return String(s).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }

  /* ---------- validasi ---------- */
  function checkField(el) {
    var v = el.value.trim(), ok = true, msg = 'Wajib diisi';
    if (el.hasAttribute('data-req') && !v) { ok = false; }
    else if (v && el.dataset.digits && !new RegExp('^\\d{' + el.dataset.digits + '}$').test(v)) { ok = false; msg = 'Harus ' + el.dataset.digits + ' digit angka'; }
    else if (v && el.hasAttribute('data-nis') && !/^[A-Za-z0-9\-]+$/.test(v)) { ok = false; msg = 'Hanya huruf, angka, dan tanda hubung'; }
    else if (v && el.hasAttribute('data-phone') && !/^[0-9+\- ]{8,20}$/.test(v)) { ok = false; msg = 'No. HP tidak valid (8-20 karakter angka)'; }
    else if (v && el.hasAttribute('data-past') && new Date(v) >= new Date(new Date().toDateString())) { ok = false; msg = 'Tanggal harus sebelum hari ini'; }
    var w = el.closest('.fld');
    if (w) { w.classList.toggle('inv', !ok); var er = w.querySelector('.err'); if (er) er.textContent = msg; }
    return ok;
  }
  function validStep(s) {
    var ok = true, first = null;
    $$('.panel[data-s="' + s + '"] [data-req], .panel[data-s="' + s + '"] [data-digits]').forEach(function (el) {
      if (!checkField(el)) { ok = false; first = first || el; }
    });
    if (s === 1 && dupFlag) {
      ok = false; first = first || form.elements.nisn;
      toast('Data duplikat terdeteksi', 'NISN, NIS, atau NIK sudah terdaftar. Periksa kembali data siswa.');
    } else if (!ok) {
      toast('Lengkapi data terlebih dahulu', 'Ada kolom wajib yang belum diisi atau belum valid (ditandai merah).');
    }
    if (first) {
      try { first.scrollIntoView({ behavior: 'smooth', block: 'center' }); } catch (e) { }
      first.focus({ preventScroll: true });
    }
    return ok;
  }

  /* ---------- navigasi tahap ---------- */
  function show(n, fwd, quiet) {
    form.classList.toggle('back', !fwd);
    cur = n;
    panels.forEach(function (p) { p.classList.toggle('on', +p.dataset.s === n); });
    render();
    if (!quiet) { window.scrollTo({ top: 0, behavior: 'smooth' }); }
  }
  function go(n) {
    if (n < 1 || n > TOTAL || n === cur) { return; }
    if (n > cur) {
      for (var s = cur; s < n; s++) {
        if (!validStep(s)) { if (s !== cur) { show(s, false); validStep(s); } return; }
      }
    }
    show(n, n > cur);
  }
  function render() {
    btns.forEach(function (b, i) {
      var s = i + 1;
      b.classList.toggle('done', s < cur); b.classList.toggle('on', s === cur);
      b.querySelector('.n').textContent = s < cur ? '✓' : s;
    });
    var pct = Math.round((cur - 1) / (TOTAL - 1) * 100);
    $('#pbar').style.width = pct + '%'; setT('ppct', pct + '%');
    setT('plabel', 'Progres Pengisian: ' + pct + '% Selesai (Tahap ' + cur + ' dari ' + TOTAL + ')');
    $('#bPrev').style.visibility = cur > 1 ? 'visible' : 'hidden';
    setT('bPrevT', 'Ke Tahap ' + (cur - 1));
    var last = cur === TOTAL;
    $('#bNext').hidden = last; $('#bSave').hidden = !last;
    setT('bNextT', 'Lanjut ke Tahap ' + (cur + 1) + ': ' + (NAMA[cur] || ''));
    if (cur >= 4) { recap(); }
  }

  /* ---------- ringkasan data ---------- */
  var RC = [
    ['Identitas Siswa', 1, [['Nama Lengkap', 'nama'], ['Panggilan', 'panggilan'], ['Jenis Kelamin', 'jenis_kelamin'], ['NISN', 'nisn'], ['NIS', 'nis'], ['Tempat Lahir', 'tempat_lahir'], ['Tanggal Lahir', 'tanggal_lahir'], ['NIK', 'nik'], ['Alamat', 'alamat']],
      function () { return val('nama') + ' (NISN: ' + val('nisn') + ')'; }],
    ['Informasi Akademik & Madrasah', 2, [['Tahun Ajaran', 'tahun_ajaran'], ['Tahun Masuk', 'tahun_masuk'], ['Kelas', 'kelas'], ['Peminatan / Rombel', 'rombel'], ['Tanggal Masuk', 'tanggal_masuk'], ['Wali Kelas', 'wali_kelas'], ['Asal Sekolah', 'asal_sekolah']],
      function () { return 'Tahun Ajaran ' + val('tahun_ajaran') + ' • ' + (val('kelas') || '-') + (val('rombel') ? ' • ' + val('rombel') : ''); }],
    ['Data Orang Tua / Wali', 3, [['Nama Ayah', 'nama_ayah'], ['Nama Ibu', 'nama_ibu'], ['No. HP Wali', 'no_hp_wali']],
      function () { return (val('nama_ayah') || '-') + ' & ' + (val('nama_ibu') || '-'); }]
  ];
  function recap() {
    var h = '';
    RC.forEach(function (r, i) {
      h += '<details class="rc"><summary><span class="rn">' + (i + 1) + '</span><span class="rtx"><b>' + r[0] + '</b><small>' + esc(r[3]()) + '</small></span><button type="button" class="lnk" data-go="' + r[1] + '">Ubah Data</button></summary><dl>';
      r[2].forEach(function (f) {
        var v = val(f[1]);
        if (f[1] === 'jenis_kelamin') { v = v === 'L' ? 'Laki-laki' : (v === 'P' ? 'Perempuan' : ''); }
        h += '<dt>' + f[0] + '</dt><dd>' + (v ? esc(v) : '—') + '</dd>';
      });
      h += '</dl></details>';
    });
    $$('.recap').forEach(function (el) { el.innerHTML = h; });
  }

  /* ---------- pratinjau KTA & kode map ---------- */
  function preview() {
    var n = val('nama'), nis = val('nis'), th = val('tahun_masuk'), tk = val('kelas').split('-')[0], s3 = nis.slice(-3);
    setT('kNama', n || 'Nama Siswa'); setT('kIni', n ? n.charAt(0).toUpperCase() : '?');
    setT('kNis', nis || '-'); setT('kNisn', val('nisn') || '-');
    setT('kRom', (val('rombel') || '-') + (val('kelas') ? ' (Kelas ' + val('kelas') + ')' : ''));
    setT('kThn', val('tahun_ajaran').replace('/', ' / ') || '-');
    setT('draftId', 'ID Draft: #DFT-' + (th || '----') + '-' + (s3 || '000'));
    if (form.elements.kode_map) { form.elements.kode_map.value = 'MAP-' + (tk || 'X') + '-' + (th || '0000') + '-' + (s3 || '000'); }
  }

  /* ---------- dokumen ---------- */
  function fmt(b) { return b >= 1048576 ? (b / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(b / 1024)) + ' KB'; }
  function docs() {
    var all = $$('.dc'), w = all.filter(function (d) { return d.dataset.wajib === '1'; });
    var done = w.filter(function (d) { return d.classList.contains('has'); });
    var miss = w.filter(function (d) { return !d.classList.contains('has'); });
    var pct = Math.round(done.length / w.length * 100);
    setT('dCount', done.length + ' / ' + w.length + ' Berkas (' + pct + '%)'); $('#dBar').style.width = pct + '%';
    var m = $('#dMiss');
    m.textContent = miss.length ? miss.length + ' berkas ' + miss.map(function (d) { return d.dataset.short; }).join(', ') + ' tertunda' : 'Semua berkas wajib lengkap';
    m.className = miss.length ? 'rd' : 'okt';
    setT('vNote', miss.length ? 'Siswa dengan ' + miss.length + ' berkas wajib yang belum lengkap tetap dapat disimpan sementara dengan status "Pending Kelengkapan Dokumen" tanpa menghapus data akademik yang telah dicatat.' : 'Seluruh berkas wajib sudah lengkap. Data siap disimpan ke arsip digital madrasah.');
    setT('sumDocs', all.filter(function (d) { return d.classList.contains('has'); }).length + ' berkas diunggah • ' + done.length + ' dari ' + w.length + ' berkas wajib lengkap');
  }
  function setFile(dc, inp) {
    var f = inp.files && inp.files[0], er = $('.derr', dc);
    er.style.display = 'none';
    if (f) {
      var maxFile = 5 * 1048576, srvFile = parseInt(form.dataset.maxfile, 10) || 0, maxTotal = parseInt(form.dataset.maxtotal, 10) || 0, pesan = '';
      if (srvFile > 0 && srvFile < maxFile) { maxFile = srvFile; }
      if (!/\.(pdf|jpe?g|png)$/i.test(f.name)) { pesan = 'Berkas harus berformat PDF, JPG, atau PNG.'; }
      else if (f.size > maxFile) { pesan = 'Ukuran berkas maksimal ' + (maxFile / 1048576).toFixed(maxFile % 1048576 ? 1 : 0) + ' MB.'; }
      else if (maxTotal > 0) {
        var total = f.size;
        $$('input[type=file]', form).forEach(function (i) { if (i !== inp && i.files && i.files[0]) { total += i.files[0].size; } });
        if (total > maxTotal - 262144) { pesan = 'Total ukuran seluruh berkas melebihi batas unggah server (' + Math.round(maxTotal / 1048576) + ' MB). Kecilkan ukuran berkas.'; }
      }
      if (pesan) { er.textContent = pesan; er.style.display = 'block'; inp.value = ''; f = null; }
    }
    dc.classList.toggle('has', !!f);
    $('.dc-s em', dc).textContent = f ? 'Terunggah' : 'Belum Diunggah';
    if (f) { $('.fn', dc).textContent = f.name; $('.fs', dc).textContent = fmt(f.size); }
    if (dc.dataset.key === 'foto') {
      var ph = $('#kPh');
      if (f && /^image\//.test(f.type)) { ph.style.backgroundImage = 'url(' + URL.createObjectURL(f) + ')'; $('#kIni').hidden = true; }
      else { ph.style.backgroundImage = ''; $('#kIni').hidden = false; }
    }
    docs();
  }
  $$('.dc').forEach(function (dc) {
    var inp = $('input[type=file]', dc), dz = $('.dz', dc);
    dz.addEventListener('click', function () { inp.click(); });
    ['dragenter', 'dragover'].forEach(function (ev) { dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.add('drag'); }); });
    ['dragleave', 'drop'].forEach(function (ev) { dz.addEventListener(ev, function (e) { e.preventDefault(); dz.classList.remove('drag'); }); });
    dz.addEventListener('drop', function (e) { if (e.dataTransfer.files.length) { inp.files = e.dataTransfer.files; setFile(dc, inp); } });
    inp.addEventListener('change', function () { setFile(dc, inp); });
    $('.act-ganti', dc).addEventListener('click', function () { inp.click(); });
    $('.act-hapus', dc).addEventListener('click', function () { inp.value = ''; setFile(dc, inp); });
    $('.act-lihat', dc).addEventListener('click', function () { if (inp.files[0]) { window.open(URL.createObjectURL(inp.files[0]), '_blank'); } });
    var kip = $('input[name=tanpa_kip]', dc);
    if (kip) { var t = function () { dc.classList.toggle('off', kip.checked); }; kip.addEventListener('change', t); t(); }
  });

  /* ---------- anti-duplikasi ---------- */
  var tc, dupFlag = false;
  function cek() {
    clearTimeout(tc);
    tc = setTimeout(function () {
      if (val('nisn').length !== 10 && !val('nis')) { return; }
      var q = new URLSearchParams({ nisn: val('nisn').length === 10 ? val('nisn') : '', nis: val('nis'), nik: val('nik').length === 16 ? val('nik') : '' });
      fetch(form.dataset.cek + '?' + q.toString(), { headers: { 'Accept': 'application/json' } })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          var dup = d.nisn || d.nis || d.nik, el = $('#anti'), what = [d.nisn ? 'NISN' : '', d.nis ? 'NIS' : '', d.nik ? 'NIK' : ''].filter(Boolean).join(', ');
          dupFlag = !!dup;
          el.className = 'card anti ' + (dup ? 'dup' : 'ok');
          setT('antiI', dup ? '!' : '✓');
          $('#antiT').innerHTML = dup ? '<b>Anti-Duplikasi: DUPLIKAT</b><small>' + what + ' sudah terdaftar di database madrasah.</small>' : '<b>Anti-Duplikasi: LOLOS</b><small>NISN, NIS, dan NIK unik, tidak ada rekaman ganda dalam database madrasah.</small>';
        }).catch(function () { });
    }, 500);
  }

  /* ---------- draft & toast ---------- */
  function toast(a, b) {
    var t = $('#toast'); t.querySelector('b').textContent = a; t.querySelector('small').textContent = b;
    t.classList.add('show'); clearTimeout(t._h); t._h = setTimeout(function () { t.classList.remove('show'); }, 4200);
  }
  $('#toast button').addEventListener('click', function () { $('#toast').classList.remove('show'); });
  function snapshot() {
    var o = {};
    $$('input[type=text], input[type=tel], input[type=number], input[type=date], select, textarea', form).forEach(function (e) { if (e.name && e.name !== 'kode_map') { o[e.name] = e.value; } });
    return o;
  }
  function saveDraft(manual) {
    try { localStorage.setItem(DKEY, JSON.stringify(snapshot())); } catch (e) { }
    var d = new Date();
    setT('draftChip', 'Draft Tersimpan (' + ('0' + d.getHours()).slice(-2) + ':' + ('0' + d.getMinutes()).slice(-2) + ' WIB)');
    if (manual) { toast('Draft Siswa Berhasil Disimpan', 'Isian tersimpan di peramban ini. Berkas dokumen perlu dipilih ulang.'); }
  }
  function restore() {
    if (form.dataset.old === '1') { return; }
    try {
      var o = JSON.parse(localStorage.getItem(DKEY) || 'null');
      if (!o) { return; }
      Object.keys(o).forEach(function (k) { var e = form.elements[k]; if (e && o[k] !== '' && !e.readOnly && e.type !== 'file') { e.value = o[k]; } });
      setT('draftChip', 'Draft dipulihkan');
    } catch (e) { }
  }
  var ts;
  form.addEventListener('input', function (e) {
    var t = e.target;
    if (t.dataset && t.dataset.digits) { t.value = t.value.replace(/\D/g, ''); }
    var w = t.closest && t.closest('.fld'); if (w) { w.classList.remove('inv'); }
    preview();
    if (cur >= 4) { recap(); }
    if (/^(nisn|nis|nik)$/.test(t.name)) { cek(); }
    clearTimeout(ts); ts = setTimeout(function () { saveDraft(false); markClean(); }, 900);
  });
  form.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT') && e.target.type !== 'submit' && e.target.type !== 'button' && e.target.type !== 'file') { e.preventDefault(); if (cur < TOTAL) { go(cur + 1); } }
  });

  /* ---------- tombol ---------- */
  btns.forEach(function (b) { b.addEventListener('click', function () { go(+b.dataset.step); }); });
  $('#bPrev').addEventListener('click', function () { go(cur - 1); });
  $('#bNext').addEventListener('click', function () { go(cur + 1); });
  $('#bDraft').addEventListener('click', function () { saveDraft(true); markClean(); });
  document.addEventListener('click', function (e) {
    var l = e.target.closest && e.target.closest('.lnk');
    if (l) { e.preventDefault(); e.stopPropagation(); go(+l.dataset.go); }
  });
  form.addEventListener('submit', function (e) {
    for (var s = 1; s <= 3; s++) {
      if (!validStep(s)) { e.preventDefault(); show(s, false); validStep(s); return; }
    }
    try { localStorage.removeItem(DKEY); } catch (x) { }
    submitting = true;
    var b = $('#bSave'); b.disabled = true; b.querySelector('span').textContent = 'Menyimpan…';
  });

  /* ---------- efek miring kartu KTA ---------- */
  var kta = $('#kta');
  kta.addEventListener('mousemove', function (e) {
    var r = kta.getBoundingClientRect(), x = (e.clientX - r.left) / r.width - 0.5, y = (e.clientY - r.top) / r.height - 0.5;
    kta.style.transform = 'perspective(700px) rotateY(' + (x * 8) + 'deg) rotateX(' + (-y * 8) + 'deg)';
  });
  kta.addEventListener('mouseleave', function () { kta.style.transform = ''; });

  /* ---------- Quick Action, penjaga data, batalkan ---------- */
  var submitting = false, initSnap = '';
  function dirty() {
    if (JSON.stringify(snapshot()) !== initSnap) { return true; }
    return $$('input[type=file]', form).some(function (i) { return i.files && i.files.length; });
  }
  function markClean() { initSnap = JSON.stringify(snapshot()); }
  var qb = $('#qaBtn'), qm = $('#qaMenu');
  if (qb && qm) {
    qb.addEventListener('click', function (e) { e.stopPropagation(); qm.hidden = !qm.hidden; qb.setAttribute('aria-expanded', String(!qm.hidden)); });
    document.addEventListener('click', function (e) { if (!qm.hidden && !qm.contains(e.target)) { qm.hidden = true; qb.setAttribute('aria-expanded', 'false'); } });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { qm.hidden = true; } });
    $('#qaSave').addEventListener('click', function () { qm.hidden = true; saveDraft(true); markClean(); });
    $('#qaReset').addEventListener('click', function () {
      qm.hidden = true;
      if (confirm('Kosongkan seluruh isian dan hapus draft tersimpan?')) {
        try { localStorage.removeItem(DKEY); } catch (x) { }
        submitting = true; location.href = location.pathname;
      }
    });
  }
  window.addEventListener('beforeunload', function (e) { if (!submitting && dirty()) { e.preventDefault(); e.returnValue = ''; } });
  $('#bBatal').addEventListener('click', function (e) {
    if (dirty() && !confirm('Batalkan pengisian formulir? Berkas yang sudah dipilih akan dilepas.')) { e.preventDefault(); } else { submitting = true; }
  });

  /* ---------- mulai ---------- */
  restore(); preview(); docs(); render(); markClean();
  setTimeout(render, 450);
  if (val('nisn').length === 10) { cek(); }
})();
</script>
@include('partials.siswa-baru-tambahan')
</body>
</html>