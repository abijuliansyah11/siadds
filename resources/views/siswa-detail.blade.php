<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Profil Siswa | MAS YPI SUMBER HARJO</title>
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

/* ===== Detail Profil Siswa ===== */
[hidden]{display:none!important}
.crumb{color:var(--mu);font-size:12px;margin-bottom:10px}
.ph{display:flex;justify-content:space-between;align-items:flex-start;gap:16px;flex-wrap:wrap;margin-bottom:18px}
.ph h1{font-size:28px;font-weight:800;letter-spacing:-.02em;display:flex;gap:12px;align-items:center;flex-wrap:wrap}
.ph p{color:var(--mu);margin-top:6px;max-width:560px;line-height:1.6}
.ph-r{display:flex;gap:8px;flex-wrap:wrap;align-items:center;justify-content:flex-end;max-width:540px}
.sw select{padding:9px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font:600 12px Inter,sans-serif;color:var(--tx);max-width:230px}
.pc{display:inline-flex;gap:6px;align-items:center;padding:4px 11px;border-radius:99px;font-size:11px;font-weight:600;white-space:nowrap}
.pc.g{background:var(--mint);color:#0a5c3b}.pc.b{background:#e0e9fb;color:#2b4a8b}.pc.m{background:#eef2f7;color:var(--mu)}
.note{display:flex;justify-content:space-between;align-items:center;gap:12px;background:#e8f6ef;padding:12px 16px;border-radius:12px;margin-bottom:14px}
.alert{background:#fff1f1;border:1px solid #fbcaca;color:#b91c1c;border-radius:12px;padding:12px 16px;margin-bottom:14px}
.pf{display:grid;grid-template-columns:auto minmax(0,1fr) 360px;gap:24px;align-items:center;padding:22px}
.pfp{text-align:center;position:relative}
.pfp .ph0{width:112px;height:140px;border-radius:14px;object-fit:cover;display:grid;place-items:center;margin:0 auto;background:linear-gradient(135deg,var(--green),var(--navy2));color:#fff;font-size:44px;font-weight:800;box-shadow:0 18px 36px rgba(11,31,58,.22);animation:float 6s ease-in-out infinite}
@keyframes float{50%{transform:translateY(-5px)}}
.pfp .dt0{position:absolute;right:calc(50% - 64px);top:122px;width:16px;height:16px;border-radius:50%;background:#16a34a;border:3px solid #fff;animation:pulse 2s infinite}
.pfp small{display:block;margin-top:12px;font-size:10px;letter-spacing:.08em;color:var(--mu);font-weight:700}
.pf h2{font-size:30px;font-weight:800;letter-spacing:-.02em}.pf h2 small{font-size:14px;font-weight:500;color:var(--mu);letter-spacing:0}
.chips{display:flex;gap:8px;flex-wrap:wrap;margin:10px 0}
.meta{display:flex;gap:18px;flex-wrap:wrap;color:var(--mu);margin:6px 0}.meta b{color:var(--tx)}
.sk{padding:16px 18px;border-radius:14px;background:#f6f8fb;border:1px solid var(--line)}
.sk .r{display:flex;justify-content:space-between;gap:10px;margin:7px 0;font-size:12px}
.sk small{font-size:10.5px;letter-spacing:.06em;font-weight:700;color:var(--mu)}
.pb{height:8px;background:#e5eaf2;border-radius:9px;overflow:hidden;margin:8px 0}
.pb i{display:block;height:100%;border-radius:9px;background:linear-gradient(90deg,var(--green),#34d399);animation:grow 1.3s cubic-bezier(.2,.8,.2,1) .5s backwards}
@keyframes grow{from{width:0}}
.lnk{border:0;background:none;color:var(--green);font:700 12px Inter,sans-serif;cursor:pointer;padding:0}
.mp{display:inline-flex;gap:6px;align-items:center;padding:5px 10px;border-radius:8px;background:#fff;border:1px solid var(--line);font-size:11px;font-weight:600}
.sm{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin:18px 0}
.sc{padding:18px;position:relative;overflow:hidden;transition:transform .35s,box-shadow .35s}
.sc:hover{transform:translateY(-4px);box-shadow:0 18px 38px rgba(11,31,58,.1)}
.sc small.l{font-size:10.5px;letter-spacing:.06em;font-weight:700;color:var(--mu)}
.sc .ico{position:absolute;right:16px;top:14px;width:38px;height:38px;border-radius:50%;display:grid;place-items:center;background:var(--mint);color:#0a5c3b}
.sc .ico.b{background:#e0e9fb;color:#2b4a8b}.sc .ico.y{background:#fdf0cf;color:#a16207}
.sc h4{font-size:19px;font-weight:800;margin:14px 0 4px}.sc .big{font-size:34px;font-weight:800;margin:10px 0 2px}.sc .big small{font-size:14px;font-weight:600;color:var(--mu)}
.sc p{color:var(--mu);margin:0 0 12px}
.sc .ft{display:flex;justify-content:space-between;gap:8px;padding:9px 11px;border-radius:9px;background:#f6f8fb;font-size:11px;color:var(--mu)}.sc .ft b{color:var(--tx)}
.tabn{display:flex;gap:4px;overflow-x:auto;border-bottom:1px solid var(--line);padding:0 8px;background:#f8fafc;border-radius:14px 14px 0 0}
.tb{position:relative;padding:15px 16px;border:0;background:none;font:600 13px Inter,sans-serif;color:var(--mu);cursor:pointer;display:flex;gap:8px;align-items:center;white-space:nowrap;transition:color .25s}
.tb::after{content:"";position:absolute;left:12px;right:12px;bottom:-1px;height:2px;border-radius:2px;background:var(--green);transform:scaleX(0);transition:transform .4s cubic-bezier(.2,.8,.2,1)}
.tb.on{color:var(--tx)}.tb.on::after{transform:scaleX(1)}.tb:hover{color:var(--tx)}
.tb em{font-style:normal;background:#dbe7fb;color:#2b4a8b;border-radius:99px;padding:1px 8px;font-size:11px}
.tp{display:none;padding:20px}.tp.on{display:block;animation:tabIn .55s cubic-bezier(.2,.8,.2,1)}
@keyframes tabIn{from{opacity:0;transform:translateY(14px)}}
.st4{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;padding:16px 18px;border-radius:14px;background:#eef3fb;margin-bottom:16px}
.st4>div{display:flex;gap:12px;align-items:center}.st4 small{display:block;color:var(--mu);font-size:11px}.st4 b{font-size:16px}
.st4 .c{width:38px;height:38px;border-radius:11px;display:grid;place-items:center;background:#fff;color:var(--tx);flex:none}
.st4 .c.g{background:#bff0d5;color:#0a5c3b}.st4 .c.y{background:#fdf0cf;color:#a16207}.st4 .c.r{background:#fdd9d6;color:#b42318}
.tbar{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px}
.tbar input,.tbar select{padding:11px 12px;border:1px solid var(--line);border-radius:10px;background:#f6f8fb;font:inherit;color:var(--tx);outline:0}
.tbar input{flex:1;min-width:200px}.tbar input:focus,.tbar select:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
.tw{overflow-x:auto;border-radius:12px}
.dt{width:100%;border-collapse:collapse;min-width:900px}
.dt th{background:#eef3fb;font-size:10.5px;letter-spacing:.05em;color:var(--mu);text-align:left;padding:14px 16px}
.dt td{padding:14px 16px;border-top:1px solid var(--line);vertical-align:middle}
.dt tbody tr{animation:rise .6s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--i)*70ms + .35s);transition:background .25s}
.dt tbody tr:hover td{background:#f8fbff}.dt tr.rowbad td{background:#fff6f4}
.dt small{display:block;color:var(--mu);margin-top:2px}
.dn{display:flex;gap:12px;align-items:center}.dn b{display:block}
.di{width:38px;height:38px;border-radius:11px;display:grid;place-items:center;background:#dff4e8;color:#0a5c3b;flex:none}
.di.wait{background:#fdf0cf;color:#a16207}.di.bad{background:#fdd9d6;color:#b42318}
.fnm{display:block;word-break:break-all}
.sv,.sw2,.sn{display:inline-flex;gap:7px;align-items:center;padding:5px 12px;border-radius:99px;font-size:11px;font-weight:700}
.sv i,.sw2 i,.sn i{width:6px;height:6px;border-radius:50%;background:currentColor}
.sv{background:var(--mint);color:#0a5c3b}.sw2{background:#fdf0cf;color:#a16207}.sw2 i{animation:pulse 2s infinite}.sn{background:#fdd9d6;color:#b42318}
.aks{white-space:nowrap;text-align:right}
.ia{width:32px;height:32px;border-radius:9px;display:inline-grid;place-items:center;border:0;background:none;color:var(--mu);cursor:pointer;transition:background .25s,color .25s,transform .25s;text-decoration:none;vertical-align:middle}
.ia:hover{background:#eef2f7;color:var(--tx);transform:translateY(-2px)}.ia.dis{opacity:.3;pointer-events:none}.ia.ver{background:var(--mint);color:#0a5c3b}
.upb{border:0;background:#dbe7fb;color:#2b4a8b;border-radius:10px;padding:9px 12px;font:700 11.5px Inter,sans-serif;cursor:pointer;display:inline-flex;gap:6px;align-items:center;transition:transform .25s,background .25s}
.upb:hover{background:#c8daf8;transform:translateY(-2px)}
.empty{padding:26px;text-align:center;color:var(--mu)}
.kv{display:grid;grid-template-columns:190px 1fr;gap:12px 18px}.kv2{display:grid;grid-template-columns:1fr 1fr;gap:0 48px}
.kv dt{color:var(--mu)}.kv dd{font-weight:600;margin:0}
.tl{position:relative;padding-left:26px;margin:0;list-style:none}
.tl::before{content:"";position:absolute;left:6px;top:6px;bottom:6px;width:2px;background:var(--line)}
.tl li{position:relative;margin-bottom:18px;animation:rise .6s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--i)*80ms)}
.tl li::before{content:"";position:absolute;left:-26px;top:4px;width:12px;height:12px;border-radius:50%;background:var(--green);box-shadow:0 0 0 4px var(--mint)}
.tl small{color:var(--mu)}
dialog{border:0;border-radius:18px;padding:0;box-shadow:0 30px 80px rgba(11,31,58,.35);width:min(460px,92vw);color:var(--tx)}
dialog::backdrop{background:rgba(11,31,58,.45);backdrop-filter:blur(4px)}
dialog[open]{animation:dlg .4s cubic-bezier(.2,.8,.2,1)}
@keyframes dlg{from{opacity:0;transform:translateY(18px) scale(.97)}}
dialog form{padding:22px}dialog h3{font-size:18px;margin:0 0 4px}
dialog label{display:block;margin-top:14px;font-size:11.5px;font-weight:600}
dialog select,dialog input[type=file]{width:100%;margin-top:5px;padding:11px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font:inherit}
.dact{display:flex;justify-content:flex-end;gap:8px;margin-top:20px}
.toast{position:fixed;right:24px;bottom:24px;z-index:60;padding:14px 18px;border-radius:14px;background:var(--navy);color:#fff;box-shadow:0 18px 40px rgba(11,31,58,.35);transform:translateY(30px);opacity:0;pointer-events:none;transition:transform .5s cubic-bezier(.2,.8,.2,1),opacity .4s;max-width:340px}
.toast.show{transform:none;opacity:1}
@media(max-width:1250px){.pf{grid-template-columns:auto 1fr}.pf .sk{grid-column:1/-1}.sm{grid-template-columns:repeat(2,1fr)}.st4{grid-template-columns:repeat(2,1fr)}}
@media(max-width:700px){.pf{grid-template-columns:1fr;text-align:center}.chips,.meta{justify-content:center}.sm{grid-template-columns:1fr}.kv,.kv2{grid-template-columns:1fr}}
@media print{.side,.top,.noprint,.tabn,.toast{display:none!important}.main{margin-left:0!important}.tp{display:block!important;animation:none}.in,.dt tbody tr{animation:none!important}}

/* ===== Perbaikan fungsi & tampilan ===== */
.ph>div:first-child{flex:1 1 380px;min-width:0}
.tabn{overflow-y:hidden}
.qa{position:relative}
.qa-menu{position:absolute;right:0;top:calc(100% + 8px);min-width:250px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 20px 44px rgba(11,31,58,.18);padding:6px;z-index:40;animation:dlg .3s cubic-bezier(.2,.8,.2,1)}
.qa-menu a,.qa-menu button{display:block;width:100%;text-align:left;padding:10px 12px;border:0;background:none;border-radius:9px;color:var(--tx);text-decoration:none;font:600 12.5px Inter,sans-serif;cursor:pointer;transition:background .2s}
.qa-menu a:hover,.qa-menu button:hover{background:var(--bg)}
.qa-menu hr{border:0;border-top:1px solid var(--line);margin:5px 4px}
dialog#dlgEdit{width:min(780px,94vw)}
dialog form{max-height:88vh;overflow:auto}
dialog .g2{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px}
dialog .g2 label{margin-top:0}
dialog .full{grid-column:1/-1}
dialog input[type=text],dialog input[type=date],dialog input[type=number],dialog input[type=tel],dialog textarea{width:100%;margin-top:5px;padding:11px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font:inherit;color:var(--tx);outline:0}
dialog input:focus,dialog select:focus,dialog textarea:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
dialog textarea{resize:vertical;min-height:70px}
@media(max-width:700px){dialog .g2{grid-template-columns:1fr}}
</style>
</head>
<body>
@php
$ic = fn($n) => '<svg class="i"><use href="#'.$n.'"/></svg>';
$nama = auth()->user()->name ?? 'Admin';
$bln = fn($t) => $t ? $t->copy()->locale('id')->translatedFormat('d F Y') : '-';
@endphp

@include('partials.sidebar')
<svg width="0" height="0" style="position:absolute">
<symbol id="d-eye" viewBox="0 0 24 24"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></symbol>
<symbol id="d-swap" viewBox="0 0 24 24"><path d="M17 3l4 4-4 4M21 7H8a4 4 0 00-4 4M7 21l-4-4 4-4M3 17h13a4 4 0 004-4"/></symbol>
<symbol id="d-back" viewBox="0 0 24 24"><path d="M19 12H5M11 6l-6 6 6 6"/></symbol>
<symbol id="d-edit" viewBox="0 0 24 24"><path d="M4 20h4L19 9l-4-4L4 16zM13 7l4 4"/></symbol>
<symbol id="d-shield" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></symbol>
<symbol id="d-clock" viewBox="0 0 24 24"><path d="M6 3h12M6 21h12M7 3c0 5 5 5 5 9s-5 4-5 9M17 3c0 5-5 5-5 9s5 4 5 9"/></symbol>
<symbol id="d-warn" viewBox="0 0 24 24"><path d="M12 3l10 18H2zM12 10v5M12 18v.5"/></symbol>
<symbol id="d-cap" viewBox="0 0 24 24"><path d="M2 9l10-5 10 5-10 5zM6 11v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/></symbol>
<symbol id="d-box" viewBox="0 0 24 24"><path d="M3 7h18v4H3zM5 11v9h14v-9M10 15h4"/></symbol>
<symbol id="d-arrow" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
</svg>

<div class="main">
  <header class="top in" style="--d:1">
    <form method="GET" action="{{ route('siswa.aktif') }}" style="margin:0"><label class="search"><input type="search" name="q" placeholder="Cari siswa..."></label></form>
    <span class="pill">Sistem Aktif</span><small class="mu">TA 2026/2027 - Ganjil (Asia/Jakarta)</small>
    <span class="sp"></span>
    <div class="qa noprint">
      <button type="button" class="btn g" id="qaBtn" aria-haspopup="true" aria-expanded="false">+ Quick Action</button>
      <div class="qa-menu" id="qaMenu" hidden>
        @if($siswa)
        <button type="button" data-dlg="dlgEdit">Edit Profil Siswa</button>
        <button type="button" data-dlg="upDlg">Unggah Dokumen Baru</button>
        <a href="{{ route('siswa.aktif.buku', ['id' => $siswa->id, 'print' => 1]) }}" target="_blank" rel="noopener">Cetak Buku Induk</a>
        <hr>
        @endif
        <a href="{{ route('siswa.aktif') }}">Data Siswa Aktif</a>
        <a href="{{ route('siswa.baru') }}">Tambah Siswa Baru</a>
        <a href="{{ route('alumni') }}">Data Alumni</a>
      </div>
    </div>
    <div class="user">
      <div class="av">{{ strtoupper(substr($nama, 0, 1)) }}</div>
      <div><b>{{ $nama }}</b><small>Administrator • OP-10492</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
    </div>
  </header>

  <div class="wrap">
    <div class="crumb in" style="--d:1">Dashboard › Data Siswa › Data Siswa Aktif › <b>Detail Profil Siswa</b></div>

    @if(session('status'))<div class="note in" style="--d:1"><b>{{ session('status') }}</b></div>@endif
    @if($errors->any())<div class="alert in" style="--d:1"><b>Gagal diproses:</b><ul style="margin:6px 0 0 18px;line-height:1.6">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <div id="reopen" data-f="{{ $errors->any() ? old('_form') : '' }}" hidden></div>

@if(! $siswa)
    <section class="card in" style="--d:2"><div class="empty">Belum ada data siswa aktif. <a class="lnk" href="{{ route('siswa.baru') }}">Tambah siswa baru</a> terlebih dahulu.</div></section>
@else
@php
  $umur = $siswa->tanggal_lahir ? $siswa->tanggal_lahir->age : null;
  $ttl  = ($siswa->tempat_lahir ?: '-') . ', ' . $bln($siswa->tanggal_lahir);
  $agama = $siswa->getAttribute('agama') ?: 'Islam';
  $jalur = $siswa->getAttribute('jalur') ?: 'Reguler PPDB';
  $jk = $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
  $ini = strtoupper(substr($siswa->nama, 0, 1));
@endphp
    @if($alumniTerkait ?? null)<div class="note in" style="--d:2"><div><b>Siswa ini sudah lulus dan tercatat sebagai alumni (Angkatan {{ \App\Models\Alumni::romawi((int) $alumniTerkait->angkatan) }}).</b></div><a class="btn" href="{{ route('alumni', ['id' => $alumniTerkait->id]) }}">Lihat di Data Alumni</a></div>@endif
    <section class="ph in" style="--d:2">
      <div>
        <h1>Detail Profil Siswa — {{ $siswa->nama }} <span class="pc b">NIS: {{ $siswa->nis }}</span></h1>
        <p>Lihat identitas, informasi pendidikan, arsip digital, lokasi dokumen fisik, dan riwayat audit data siswa secara terpusat.</p>
      </div>
      <div class="ph-r noprint">
        <form class="sw" method="GET" action="{{ route('siswa.detail') }}"><select name="id" onchange="this.form.submit()" aria-label="Ganti siswa">@foreach($daftar as $s)<option value="{{ $s->id }}" @selected($s->id === $siswa->id)>{{ $s->nis }} — {{ $s->nama }}</option>@endforeach</select></form>
        <a class="btn" href="{{ route('siswa.aktif', ['id' => $siswa->id]) }}">{!! $ic('d-back') !!} Kembali</a>
        <button type="button" class="btn" onclick="window.print()">{!! $ic('print') !!} Cetak Profil</button>
        <button type="button" class="btn" id="bEdit" data-dlg="dlgEdit">{!! $ic('d-edit') !!} Edit Profil</button>
        <button type="button" class="btn g" data-up="">{!! $ic('upload') !!} Unggah Dokumen Baru</button>
        @if($alumniTerkait ?? null)<a class="btn" href="{{ route('alumni', ['id' => $alumniTerkait->id]) }}">{!! $ic('d-cap') !!} Lihat di Data Alumni</a>@endif
        @if($siswa->status === 'Aktif' && str_starts_with($siswa->kelas, 'XII-'))<form method="POST" action="{{ route('alumni.proses') }}" style="display:inline" onsubmit="return confirm('Luluskan siswa ini dan pindahkan ke Data Alumni?')">@csrf<input type="hidden" name="_form" value="proses"><input type="hidden" name="siswa_ids[]" value="{{ $siswa->id }}"><input type="hidden" name="tahun_lulus" value="{{ now()->year }}"><input type="hidden" name="tanggal_kelulusan" value="{{ now()->format('Y-m-d') }}"><button type="submit" class="btn">{!! $ic('d-cap') !!} Luluskan Siswa</button></form>@endif
      </div>
    </section>

    <section class="card pf in" style="--d:3">
      <div class="pfp">
        @if($siswa->foto)<img class="ph0" src="{{ asset('storage/' . $siswa->foto) }}" alt="{{ $siswa->nama }}">@else<div class="ph0">{{ $ini }}</div>@endif
        <span class="dt0"></span><small>BUKU INDUK</small>
      </div>
      <div>
        <h2>{{ $siswa->nama }} @if($siswa->panggilan)<small>(Panggilan: {{ $siswa->panggilan }})</small>@endif</h2>
        <div class="chips"><span class="pc g">● Siswa {{ $siswa->status }}</span><span class="pc b">Kelas {{ $siswa->kelas }}{{ $siswa->rombel ? ' (' . $siswa->rombel . ')' : '' }}</span><span class="pc m">TA {{ $siswa->tahun_ajaran }}</span><span class="pc m">{{ $jk }}</span></div>
        <div class="meta"><span>NIS: <b>{{ $siswa->nis }}</b></span><span>NISN: <b>{{ $siswa->nisn }}</b></span></div>
        <div class="meta"><span>Wali Kelas: <b>{{ $siswa->wali_kelas ?: '-' }}</b></span></div>
        <div class="meta" style="font-size:12px">Terdaftar sejak: {{ $bln($siswa->tanggal_masuk) }} • Kurikulum Merdeka Madrasah Aliyah • Akreditasi A</div>
      </div>
      <div class="sk">
        <div class="r"><small>STATUS KELENGKAPAN ARSIP</small><b><span data-count="{{ $ringkas['pct'] }}" data-dec="1">{{ $ringkas['pct'] }}</span>%</b></div>
        <div class="pb"><i style="width: {{ $ringkas['pct'] }}%"></i></div>
        <div class="r"><span>Berkas Wajib:</span><b>{{ $ringkas['kumpul'] }} dari {{ $ringkas['total'] }} Terkumpul</b></div>
        <div class="r" style="font-weight:600"><span>{{ $ringkas['ter'] }} Terverifikasi • <span style="color:#a16207">{{ $ringkas['menunggu'] }} Menunggu</span> • <span class="rd">{{ $ringkas['belum'] }} Belum Unggah</span></span></div>
        <div class="r" style="align-items:center;margin-top:12px"><button type="button" class="lnk" data-open-tab="arsip">Kelola Arsip {!! $ic('d-arrow') !!}</button><span class="mp">{!! $ic('folder') !!} {{ $siswa->kode_map ?: '-' }}</span></div>
      </div>
    </section>

    <section class="sm">
      <div class="card sc in" style="--d:4"><small class="l">IDENTITAS SISWA</small><span class="ico">{!! $ic('user') !!}</span><h4>{{ $siswa->nama }}</h4><p>{{ $jk }}{{ $umur !== null ? ' • ' . $umur . ' Tahun' : '' }}</p><div class="ft"><span>TTL: {{ $ttl }}</span><b>{{ $agama }}</b></div></div>
      <div class="card sc in" style="--d:5"><small class="l">AKADEMIK & ROMBEL</small><span class="ico b">{!! $ic('d-cap') !!}</span><h4>Kelas {{ $siswa->kelas }}{{ $siswa->rombel ? ' (' . $siswa->rombel . ')' : '' }}</h4><p>Asal: {{ $siswa->asal_sekolah ?: '-' }}</p><div class="ft"><span>Jalur: {{ $jalur }}</span><b>Siswa {{ $siswa->status }}</b></div></div>
      <div class="card sc in" style="--d:6"><small class="l">KELENGKAPAN BERKAS</small><span class="ico y">{!! $ic('file') !!}</span><div class="big"><span data-count="{{ $ringkas['kumpul'] }}">{{ $ringkas['kumpul'] }}</span> / {{ $ringkas['total'] }} <small>Berkas</small></div><p class="{{ $ringkas['belum'] ? 'rd' : 'okt' }}">{{ $ringkas['belum'] ? $ringkas['belum'] . ' Dokumen Belum Diunggah' : 'Seluruh berkas wajib terkumpul' }}</p><div class="ft"><span>{{ $ringkas['belum'] ? 'Kurang: ' . \Illuminate\Support\Str::limit($ringkas['kurang'], 26) : 'Tidak ada kekurangan' }}</span>@if($ringkas['belum'])<b class="rd">{!! $ic('d-warn') !!}</b>@endif</div></div>
      <div class="card sc in" style="--d:7"><small class="l">LOKASI MAP FISIK</small><span class="ico">{!! $ic('d-box') !!}</span><h4>{{ $siswa->lemari ?: '-' }} • {{ $siswa->rak ?: '-' }}</h4><p>Map Ordner: {{ $siswa->kode_map ?: '-' }}</p><div class="ft"><span>{{ \Illuminate\Support\Str::limit($siswa->ruang_arsip ?: 'Ruang arsip belum ditetapkan', 28) }}</span><b>QR Ready</b></div></div>
    </section>

    <section class="card in" style="--d:8;padding:0;overflow:hidden" id="tabs">
      <div class="tabn noprint">
        <button type="button" class="tb on" data-tab="arsip">{!! $ic('folder') !!} Arsip Dokumen <em>{{ $siswa->dokumen->count() }}</em></button>
        <button type="button" class="tb" data-tab="pribadi">{!! $ic('user') !!} Informasi Pribadi</button>
        <button type="button" class="tb" data-tab="ortu">{!! $ic('users') !!} Orang Tua / Wali</button>
        <button type="button" class="tb" data-tab="lokasi">{!! $ic('d-box') !!} Lokasi Arsip Fisik</button>
        <button type="button" class="tb" data-tab="riwayat">{!! $ic('chart') !!} Riwayat &amp; Log Audit</button>
      </div>

      <div class="tp on" id="tp-arsip">
        <div class="st4">
          <div><span class="c">{!! $ic('folder') !!}</span><span><small>Total Wajib</small><b>{{ $ringkas['total'] }} Berkas</b></span></div>
          <div><span class="c g">{!! $ic('d-shield') !!}</span><span><small>Terverifikasi</small><b>{{ $ringkas['ter'] }} Berkas</b></span></div>
          <div><span class="c y">{!! $ic('d-clock') !!}</span><span><small>Menunggu</small><b>{{ $ringkas['menunggu'] }} Berkas</b></span></div>
          <div><span class="c r">{!! $ic('d-warn') !!}</span><span><small>Belum Unggah</small><b>{{ $ringkas['belum'] }} Berkas</b></span></div>
        </div>
        <div class="tbar noprint">
          <input type="search" id="fq" placeholder="Cari nama dokumen atau nama file...">
          <select id="fk"><option value="">Semua Kategori</option><option>Identitas</option><option>Akademik</option><option>Foto</option><option>Pendukung</option></select>
          <select id="fs"><option value="">Semua Status</option><option value="terverifikasi">Terverifikasi</option><option value="menunggu">Menunggu Verifikasi</option><option value="belum">Belum Diunggah</option></select>
          <button type="button" class="btn g" data-up="">{!! $ic('plus') !!} Unggah</button>
        </div>
        <div class="tw">
        <table class="dt">
          <thead><tr><th>NAMA DOKUMEN</th><th>KATEGORI</th><th>INFORMASI FILE</th><th>TGL UNGGAH &amp; PETUGAS</th><th>STATUS VERIFIKASI</th><th style="text-align:right">AKSI</th></tr></thead>
          <tbody>
          @foreach($rows as $i => $r)
            @php $d = $r['dok']; $st = $r['status']; $url = $d && $d->path ? asset('storage/' . $d->path) : null; @endphp
            <tr class="{{ $st === 'belum' ? 'rowbad' : '' }}" style="--i:{{ $i }}" data-k="{{ $r['kategori'] }}" data-s="{{ $st }}" data-t="{{ strtolower($r['jenis'] . ' ' . ($d ? $d->nama_file : '')) }}">
              <td><div class="dn"><span class="di {{ $st === 'belum' ? 'bad' : ($st === 'menunggu' ? 'wait' : '') }}">{!! $ic($r['icon']) !!}</span><div><b>{{ $r['jenis'] }}</b><small class="{{ $st === 'belum' && $r['wajib'] ? 'rd' : '' }}">{{ $r['ket'] }}</small></div></div></td>
              <td><span class="pc m">{{ $r['kategori'] }}</span></td>
              <td>@if($d)<b class="fnm">{{ $d->nama_file }}</b><small>{{ $d->ukuran }} • {{ strtoupper(pathinfo($d->nama_file, PATHINFO_EXTENSION)) }}</small>@else<i class="mu">Belum Diunggah</i><small>–</small>@endif</td>
              <td>@if($d){{ $bln($d->tanggal_unggah) }}<small>{{ $d->diunggah_oleh ?: '-' }}</small>@else<span class="mu">–</span>@endif</td>
              <td>@if($st === 'terverifikasi')<span class="sv"><i></i>Terverifikasi</span>@elseif($st === 'menunggu')<span class="sw2"><i></i>Menunggu Verifikasi</span>@else<span class="sn"><i></i>Belum Diunggah</span>@endif</td>
              <td class="aks noprint">
                @if($d)
                  @if($url)
                    <a class="ia" href="{{ $url }}" target="_blank" rel="noopener" title="Pratinjau">{!! $ic('d-eye') !!}</a>
                    <a class="ia" href="{{ $url }}" download title="Unduh">{!! $ic('download') !!}</a>
                  @else
                    <button type="button" class="ia" data-toast="Berkas fisik belum tersedia untuk data contoh ini. Klik ikon ganti untuk mengunggah berkas asli." title="Pratinjau">{!! $ic('d-eye') !!}</button>
                    <button type="button" class="ia" data-toast="Berkas fisik belum tersedia untuk data contoh ini. Klik ikon ganti untuk mengunggah berkas asli." title="Unduh">{!! $ic('download') !!}</button>
                  @endif
                  <button type="button" class="ia" data-up="{{ $r['jenis'] }}" title="Ganti berkas">{!! $ic('d-swap') !!}</button>
                  @if($st === 'menunggu')<form method="POST" action="{{ route('siswa.dokumen.verifikasi', $d->id) }}" style="display:inline">@csrf<button type="submit" class="ia ver" title="Verifikasi">{!! $ic('d-shield') !!}</button></form>@endif
                @else
                  <button type="button" class="upb" data-up="{{ $r['jenis'] }}">{!! $ic('upload') !!} + Unggah Sekarang</button>
                @endif
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
        <div class="empty" id="fempty" hidden>Tidak ada dokumen yang cocok dengan pencarian.</div>
        </div>
      </div>

      <div class="tp" id="tp-pribadi">
        <div class="kv2">
          <dl class="kv"><dt>Nama Lengkap</dt><dd>{{ $siswa->nama }}</dd><dt>Panggilan</dt><dd>{{ $siswa->panggilan ?: '-' }}</dd><dt>Jenis Kelamin</dt><dd>{{ $jk }}</dd><dt>NISN</dt><dd>{{ $siswa->nisn }}</dd><dt>NIS</dt><dd>{{ $siswa->nis }}</dd></dl>
          <dl class="kv"><dt>NIK</dt><dd>{{ $siswa->nik ?: '-' }}</dd><dt>Tempat, Tgl Lahir</dt><dd>{{ $ttl }}</dd><dt>Agama</dt><dd>{{ $agama }}</dd><dt>Asal Sekolah</dt><dd>{{ $siswa->asal_sekolah ?: '-' }}</dd><dt>Alamat</dt><dd>{{ $siswa->alamat ?: '-' }}</dd></dl>
        </div>
      </div>

      <div class="tp" id="tp-ortu">
        <dl class="kv"><dt>Nama Ayah</dt><dd>{{ $siswa->nama_ayah ?: '-' }}</dd><dt>Nama Ibu</dt><dd>{{ $siswa->nama_ibu ?: '-' }}</dd><dt>Kontak Wali (HP/WA)</dt><dd>{{ $siswa->no_hp_wali ?: '-' }}</dd><dt>Wali Kelas</dt><dd>{{ $siswa->wali_kelas ?: '-' }}</dd></dl>
      </div>

      <div class="tp" id="tp-lokasi">
        <dl class="kv"><dt>Ruang Penyimpanan</dt><dd>{{ $siswa->ruang_arsip ?: '-' }}</dd><dt>Lemari Berkas</dt><dd>{{ $siswa->lemari ?: '-' }}</dd><dt>Nomor Rak</dt><dd>{{ $siswa->rak ?: '-' }}</dd><dt>Kode Label Map Ordner</dt><dd>{{ $siswa->kode_map ?: '-' }}</dd></dl>
      </div>

      <div class="tp" id="tp-riwayat">
        <ul class="tl">
          @foreach($log as $i => $l)
            <li style="--i:{{ $i }}"><b>{{ $l['judul'] }}</b><br><small>{{ $l['oleh'] }} • {{ $l['waktu'] ? $l['waktu']->copy()->locale('id')->translatedFormat('d F Y, H:i') : '-' }}</small></li>
          @endforeach
        </ul>
      </div>
    </section>

    <dialog id="upDlg">
      <form method="POST" action="{{ route('siswa.detail.unggah', $siswa->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_form" value="unggah">
        <h3>Unggah Dokumen</h3><p class="mu">Berkas baru akan berstatus menunggu verifikasi.</p>
        <label>Jenis Dokumen<select name="jenis" id="upJenis">@foreach($jenisUnggah as $j)<option value="{{ $j }}">{{ $j }}</option>@endforeach</select></label>
        <label>Berkas (PDF / JPG / PNG, maks. 5 MB)<input type="file" name="berkas" accept=".pdf,.jpg,.jpeg,.png" required></label>
        <div class="dact"><button type="button" class="btn" id="upTutup">Batal</button><button type="submit" class="btn g">Unggah</button></div>
      </form>
    </dialog>

    @php
      $opsiKelas = [];
      foreach (['X', 'XI', 'XII'] as $tk) { foreach (['A', 'B', 'C', 'D'] as $rk) { $opsiKelas[] = $tk . '-' . $rk; } }
      if (! in_array($siswa->kelas, $opsiKelas, true)) { $opsiKelas[] = $siswa->kelas; }
      $tg = fn ($f) => optional($siswa->{$f})->format('Y-m-d');
    @endphp
    <dialog id="dlgEdit">
      <form method="POST" action="{{ route('siswa.detail.update', $siswa->id) }}">
        @csrf @method('PUT')
        <input type="hidden" name="_form" value="edit">
        <h3>Edit Profil Siswa</h3><p class="mu">{{ $siswa->nama }} • perubahan langsung tersimpan ke database.</p>
        <div class="g2">
          <label class="full">Nama lengkap *<input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" required maxlength="100"></label>
          <label>Nama panggilan<input type="text" name="panggilan" value="{{ old('panggilan', $siswa->panggilan) }}" maxlength="50"></label>
          <label>Jenis kelamin *<select name="jenis_kelamin" required><option value="L" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'L')>Laki-laki</option><option value="P" @selected(old('jenis_kelamin', $siswa->jenis_kelamin) === 'P')>Perempuan</option></select></label>
          <label>NIS *<input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required maxlength="20"></label>
          <label>NISN * (10 digit)<input type="text" name="nisn" value="{{ old('nisn', $siswa->nisn) }}" required maxlength="10" inputmode="numeric"></label>
          <label>Kelas *<select name="kelas" required>@foreach($opsiKelas as $k)<option value="{{ $k }}" @selected(old('kelas', $siswa->kelas) === $k)>{{ $k }}</option>@endforeach</select></label>
          <label>Peminatan / Rombel<input type="text" name="rombel" value="{{ old('rombel', $siswa->rombel) }}" maxlength="80"></label>
          <label>Tahun masuk *<input type="number" name="tahun_masuk" value="{{ old('tahun_masuk', $siswa->tahun_masuk) }}" required min="2000" max="2100"></label>
          <label>Tanggal masuk<input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', $tg('tanggal_masuk')) }}"></label>
          <label>Wali kelas<input type="text" name="wali_kelas" value="{{ old('wali_kelas', $siswa->wali_kelas) }}" maxlength="100"></label>
          <label>Tempat lahir<input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" maxlength="60"></label>
          <label>Tanggal lahir<input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $tg('tanggal_lahir')) }}"></label>
          <label>NIK (16 digit)<input type="text" name="nik" value="{{ old('nik', $siswa->nik) }}" maxlength="16" inputmode="numeric"></label>
          <label>Asal sekolah<input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}" maxlength="150"></label>
          <label>Nama ayah<input type="text" name="nama_ayah" value="{{ old('nama_ayah', $siswa->nama_ayah) }}" maxlength="100"></label>
          <label>Nama ibu<input type="text" name="nama_ibu" value="{{ old('nama_ibu', $siswa->nama_ibu) }}" maxlength="100"></label>
          <label>No. HP wali<input type="tel" name="no_hp_wali" value="{{ old('no_hp_wali', $siswa->no_hp_wali) }}" maxlength="20"></label>
          <label>Ruang arsip<input type="text" name="ruang_arsip" value="{{ old('ruang_arsip', $siswa->ruang_arsip) }}" maxlength="100"></label>
          <label>Lemari berkas<input type="text" name="lemari" value="{{ old('lemari', $siswa->lemari) }}" maxlength="40"></label>
          <label>Nomor rak<input type="text" name="rak" value="{{ old('rak', $siswa->rak) }}" maxlength="20"></label>
          <label>Kode label map ordner<input type="text" name="kode_map" value="{{ old('kode_map', $siswa->kode_map) }}" maxlength="40"></label>
          <label class="full">Alamat<textarea name="alamat" maxlength="500">{{ old('alamat', $siswa->alamat) }}</textarea></label>
        </div>
        <div class="dact"><button type="button" class="btn" data-close>Batal</button><button type="submit" class="btn g">Simpan Perubahan</button></div>
      </form>
    </dialog>
@endif

    <footer class="foot in" style="--d:10"><span>Sistem Informasi Arsip Digital &amp; Data Siswa (SIADDS) • MAS YPI Sumber Harjo</span><span>Kemenag Kab. OKU Timur</span><span>NPSN: 10648892</span></footer>
  </div>
</div>

<div class="toast" id="toast"></div>

<script>
(function () {
  function $(s, c) { return (c || document).querySelector(s); }
  function $$(s, c) { return [].slice.call((c || document).querySelectorAll(s)); }
  var tabs = $$('.tb'), panels = $$('.tp');
  function openTab(id) {
    tabs.forEach(function (t) { t.classList.toggle('on', t.dataset.tab === id); });
    panels.forEach(function (p) { p.classList.toggle('on', p.id === 'tp-' + id); });
    if (history.replaceState) { history.replaceState(null, '', '#' + id); }
  }
  tabs.forEach(function (t) { t.addEventListener('click', function () { openTab(t.dataset.tab); }); });
  var h = location.hash.slice(1);
  if (h && $('#tp-' + h)) { openTab(h); }
  $$('[data-open-tab]').forEach(function (b) {
    b.addEventListener('click', function (e) { e.preventDefault(); openTab(b.dataset.openTab); var t = $('#tabs'); if (t) { t.scrollIntoView({ behavior: 'smooth' }); } });
  });

  var q = $('#fq'), fk = $('#fk'), fs = $('#fs'), rows = $$('.dt tbody tr');
  function filt() {
    var t = q.value.trim().toLowerCase(), n = 0;
    rows.forEach(function (r) {
      var ok = (!t || r.dataset.t.indexOf(t) > -1) && (!fk.value || r.dataset.k === fk.value) && (!fs.value || r.dataset.s === fs.value);
      r.hidden = !ok; if (ok) { n++; }
    });
    $('#fempty').hidden = n > 0;
  }
  if (q) { q.addEventListener('input', filt); fk.addEventListener('change', filt); fs.addEventListener('change', filt); }

  var dlg = $('#upDlg');
  if (dlg) {
    $$('[data-up]').forEach(function (b) {
      b.addEventListener('click', function () { if (b.dataset.up) { $('#upJenis').value = b.dataset.up; } dlg.showModal(); });
    });
    $('#upTutup').addEventListener('click', function () { dlg.close(); });
    dlg.addEventListener('click', function (e) { if (e.target === dlg) { dlg.close(); } });
  }

  var tst = $('#toast'), th;
  function toast(m) { tst.textContent = m; tst.classList.add('show'); clearTimeout(th); th = setTimeout(function () { tst.classList.remove('show'); }, 3500); }
  var be = $('#bEdit');
  if (be) { be.addEventListener('click', function () { var d = $('#dlgEdit'); if (d) { d.showModal(); } }); }

  $$('[data-toast]').forEach(function (b) { b.addEventListener('click', function () { toast(b.dataset.toast); }); });
  function bukaDialog(id) { var d = document.getElementById(id); if (d && !d.open) { d.showModal(); } }
  $$('[data-dlg]').forEach(function (b) {
    b.addEventListener('click', function () { var m = $('#qaMenu'); if (m) { m.hidden = true; } bukaDialog(b.dataset.dlg); });
  });
  $$('[data-close]').forEach(function (b) { b.addEventListener('click', function () { b.closest('dialog').close(); }); });
  $$('dialog').forEach(function (d) { d.addEventListener('click', function (e) { if (e.target === d) { d.close(); } }); });
  var qb = $('#qaBtn'), qm = $('#qaMenu');
  if (qb && qm) {
    qb.addEventListener('click', function (e) { e.stopPropagation(); qm.hidden = !qm.hidden; qb.setAttribute('aria-expanded', String(!qm.hidden)); });
    document.addEventListener('click', function (e) { if (!qm.hidden && !qm.contains(e.target)) { qm.hidden = true; qb.setAttribute('aria-expanded', 'false'); } });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { qm.hidden = true; } });
  }
  var ro = $('#reopen');
  if (ro && ro.dataset.f) { bukaDialog({ edit: 'dlgEdit', unggah: 'upDlg' }[ro.dataset.f]); }

  $$('[data-count]').forEach(function (el) {
    var to = parseFloat(el.dataset.count) || 0, dec = +el.dataset.dec || 0, t0 = null;
    function f(ts) {
      if (!t0) { t0 = ts; }
      var p = Math.min((ts - t0) / 1000, 1), e = 1 - Math.pow(1 - p, 3);
      el.textContent = (to * e).toFixed(dec);
      if (p < 1) { requestAnimationFrame(f); }
    }
    el.textContent = (0).toFixed(dec); requestAnimationFrame(f);
  });
})();
</script>
@include('partials.siswa-detail-tambahan')
</body>
</html>