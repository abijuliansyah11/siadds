<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Alumni | MAS YPI SUMBER HARJO</title>
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

/* ===== Data Alumni ===== */
[hidden]{display:none!important}
.crumb{color:var(--mu);font-size:12px;margin-bottom:10px}
.hd{display:flex;justify-content:space-between;align-items:flex-start;gap:18px;flex-wrap:wrap;margin-bottom:18px}
.hd h1{font-size:28px;font-weight:800;letter-spacing:-.02em;line-height:1.2;max-width:520px}
.hd p{color:var(--mu);margin-top:8px;max-width:520px;line-height:1.6}
.hb{display:grid;grid-template-columns:repeat(2,auto);gap:8px;justify-content:end}
.hb .btn{justify-content:center}
.note{display:flex;justify-content:space-between;align-items:center;gap:12px;background:#e8f6ef;padding:12px 16px;border-radius:12px;margin-bottom:14px}
.alert{background:#fff1f1;border:1px solid #fbcaca;color:#b91c1c;border-radius:12px;padding:12px 16px;margin-bottom:14px}
.bn{display:flex;gap:16px;align-items:center;flex-wrap:wrap;padding:18px 22px;background:linear-gradient(110deg,#eaf1fd,#f4f8ff);border:1px solid #dbe7fb;border-radius:16px;margin-bottom:18px;position:relative;overflow:hidden}
.bn::after{content:"";position:absolute;inset:0;background:linear-gradient(105deg,transparent 35%,rgba(255,255,255,.7) 50%,transparent 65%);transform:translateX(-120%);animation:shine 6s ease-in-out 1.6s infinite;pointer-events:none}
@keyframes shine{to{transform:translateX(120%)}}
.bn .bi{width:42px;height:42px;border-radius:12px;background:var(--green);color:#fff;display:grid;place-items:center;flex:none}
.bn b{font-size:15px}.bn p{color:var(--mu);margin:3px 0 0;line-height:1.5;max-width:620px;font-size:12px}
.bn .bx{margin-left:auto;display:flex;gap:14px;align-items:center;flex-wrap:wrap}
.lnk{border:0;background:none;color:#2b4a8b;font:700 12px Inter,sans-serif;cursor:pointer;padding:0}
.pc{display:inline-flex;gap:6px;align-items:center;padding:4px 11px;border-radius:99px;font-size:11px;font-weight:600;white-space:nowrap}
.pc.g{background:var(--mint);color:#0a5c3b}.pc.b{background:#e0e9fb;color:#2b4a8b}.pc.m{background:#eef2f7;color:var(--mu)}.pc.w{background:#fff;border:1px solid var(--line);color:var(--tx)}
.sm4{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:18px}
.sc{padding:18px;position:relative;overflow:hidden;transition:transform .35s,box-shadow .35s}
.sc:hover{transform:translateY(-4px);box-shadow:0 18px 38px rgba(11,31,58,.1)}
.sc small.l{font-size:10.5px;letter-spacing:.06em;font-weight:700;color:var(--mu)}
.sc .ico{position:absolute;right:16px;top:14px;width:36px;height:36px;border-radius:50%;display:grid;place-items:center;background:#dbe7fb;color:#2b4a8b}
.sc .ico.g{background:var(--mint);color:#0a5c3b}
.sc .big{font-size:36px;font-weight:800;margin:12px 0 4px;letter-spacing:-.02em}.sc .big small{font-size:12px;font-weight:600;color:var(--mu);letter-spacing:0}
.sc .ft{display:flex;justify-content:space-between;gap:8px;align-items:center;color:var(--mu);font-size:11px}
.fc{padding:20px}
.sbox{width:100%;padding:12px 14px;border:1px solid var(--line);border-radius:10px;background:var(--bg);font:inherit;color:var(--tx);outline:0}
.sbox:focus,.fil select:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
.srow{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px}.srow .sbox{flex:1;min-width:220px}
.fil{display:grid;grid-template-columns:repeat(5,1fr);gap:12px}
.fil label{display:block;font-size:11px;color:var(--mu);font-weight:600;margin-bottom:4px}
.fil select{width:100%;padding:10px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font:inherit;color:var(--tx)}
.tags{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-top:14px;color:var(--mu);font-size:12px}
.tg{padding:3px 10px;border-radius:99px;font-size:11px;background:#e0e9fb;color:#2b4a8b;font-weight:600}
.lg{margin-left:auto;display:flex;gap:14px;font-size:11px}.lg i{display:inline-block;width:7px;height:7px;border-radius:50%;margin-right:5px}
.tw{overflow-x:auto}
.dt{width:100%;border-collapse:collapse;min-width:980px}
.dt th{background:#f4f7fb;font-size:10.5px;letter-spacing:.05em;color:var(--mu);text-align:left;padding:14px 12px}
.dt td{padding:13px 12px;border-top:1px solid var(--line);vertical-align:middle}
.dt tbody tr{cursor:pointer;animation:rise .6s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--i)*70ms + .3s);transition:background .25s}
.dt tbody tr:hover td{background:#f8fbff}.dt tr.sel td{background:#eefaf3}
.dt small{display:block;color:var(--mu);margin-top:2px}
.al{display:flex;gap:12px;align-items:center}.al b{display:block}
.avt{width:38px;height:38px;border-radius:50%;object-fit:cover;display:grid;place-items:center;background:#dbe7fb;color:#2b4a8b;font-weight:700;font-size:12px;flex:none}
.lp{display:inline-grid;place-items:center;width:24px;height:24px;border-radius:50%;font-weight:700;font-size:11px}
.lp.L{background:#dbeafe;color:#1d4ed8}.lp.P{background:#f3e8ff;color:#7e22ce}
.kp{display:inline-block;padding:4px 10px;border-radius:8px;font-size:10.5px;font-weight:700;line-height:1.3}
.kp.g{background:#d9f3e4;color:#0a5c3b}.kp.y{background:#fdf0cf;color:#a16207}
.kpw{display:flex;justify-content:space-between;align-items:flex-start;gap:8px;min-width:150px;font-size:11px;font-weight:700}
.pb{height:5px;background:#e5eaf2;border-radius:9px;overflow:hidden;margin-top:6px}
.pb i{display:block;height:100%;border-radius:9px;background:var(--green);animation:grow 1.2s cubic-bezier(.2,.8,.2,1) .5s backwards}.pb.y i{background:#f59e0b}
@keyframes grow{from{width:0}}
.si{display:inline-flex;gap:6px;align-items:center;padding:5px 11px;border-radius:99px;font-size:10.5px;font-weight:700;line-height:1.25}
.si::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor;flex:none}
.si.g{background:var(--mint);color:#0a5c3b}.si.b{background:#dbe7fb;color:#2b4a8b}.si.y{background:#fdf0cf;color:#a16207}
.ia{width:30px;height:30px;border-radius:8px;display:inline-grid;place-items:center;border:0;background:none;color:var(--mu);cursor:pointer;text-decoration:none;transition:background .25s,color .25s,transform .25s}
.ia:hover{background:#e3f6ec;color:#0a5c3b;transform:translateY(-2px)}
.pgr{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;padding:14px 4px 0;color:var(--mu);font-size:12px}
.pgn{display:flex;gap:6px;align-items:center}
.pgn a,.pgn span{min-width:30px;height:30px;line-height:30px;text-align:center;border-radius:8px;padding:0 8px;text-decoration:none;color:var(--tx)}
.pgn .on{background:var(--green);color:#fff;font-weight:700}.pgn .off{color:#b8c1cc}.pgn a:hover{background:var(--bg)}
.empty{padding:28px;text-align:center;color:var(--mu)}
.dh{display:flex;gap:20px;align-items:center;flex-wrap:wrap;padding:22px 26px;background:linear-gradient(120deg,#0b1f3a,#12396a);color:#a9bbd4;position:relative;overflow:hidden}
.dh::after{content:"";position:absolute;inset:0;background:linear-gradient(105deg,transparent 35%,rgba(255,255,255,.08) 50%,transparent 65%);transform:translateX(-120%);animation:shine 7s ease-in-out 2s infinite;pointer-events:none}
.dh .ph0{width:72px;height:88px;border-radius:12px;object-fit:cover;display:grid;place-items:center;background:linear-gradient(135deg,var(--green),#12396a);color:#fff;font-size:28px;font-weight:800;border:2px solid rgba(255,255,255,.25);animation:float 6s ease-in-out infinite;flex:none}
@keyframes float{50%{transform:translateY(-4px)}}
.dh h2{color:#fff;font-size:20px;display:flex;gap:10px;align-items:center;flex-wrap:wrap}
.dh .m{margin-top:6px;line-height:1.7;font-size:12px}.dh .m b{color:#fff}
.dh .ac{margin-left:auto;display:flex;gap:8px;flex-wrap:wrap}
.dh .btn{background:rgba(255,255,255,.1);border-color:rgba(255,255,255,.18);color:#fff}.dh .btn.g{background:var(--green);border-color:var(--green)}
.tabn{display:flex;gap:4px;overflow-x:auto;border-bottom:1px solid var(--line);padding:0 14px}
.tb{position:relative;padding:15px 14px;border:0;background:none;font:600 12.5px Inter,sans-serif;color:var(--mu);cursor:pointer;display:flex;gap:8px;align-items:center;white-space:nowrap;transition:color .25s}
.tb::after{content:"";position:absolute;left:10px;right:10px;bottom:-1px;height:2px;border-radius:2px;background:var(--green);transform:scaleX(0);transition:transform .4s cubic-bezier(.2,.8,.2,1)}
.tb.on{color:var(--tx)}.tb.on::after{transform:scaleX(1)}.tb:hover{color:var(--tx)}
.tp{display:none;padding:22px 26px}.tp.on{display:block;animation:tabIn .55s cubic-bezier(.2,.8,.2,1)}
@keyframes tabIn{from{opacity:0;transform:translateY(14px)}}
.th{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:16px}
.th h3{font-size:16px;display:flex;gap:10px;align-items:center;flex-wrap:wrap}
.docs{display:grid;grid-template-columns:repeat(3,1fr);gap:14px}
.dc{border:1px solid var(--line);border-radius:14px;padding:16px;background:#f7faff;display:flex;flex-direction:column;gap:12px;transition:transform .3s,box-shadow .3s;animation:rise .7s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--i)*80ms)}
.dc:hover{transform:translateY(-4px);box-shadow:0 16px 34px rgba(11,31,58,.1)}
.dc .r{display:flex;gap:12px;align-items:flex-start}.dc .r>div{flex:1;min-width:0}
.dc .di{width:42px;height:42px;border-radius:11px;display:grid;place-items:center;background:var(--green);color:#fff;flex:none}
.dc .di.n{background:#e0e9fb;color:#2b4a8b}
.dc b{font-size:13px;display:block}.dc small{color:var(--mu);word-break:break-all}
.dc .bg{padding:2px 9px;border-radius:99px;background:#d9f3e4;color:#0a5c3b;font-size:10px;font-weight:700;white-space:nowrap}
.dc .f{display:flex;justify-content:space-between;align-items:center;gap:8px;margin-top:auto;font-size:11px;color:var(--mu)}
.dc.kosong{border-style:dashed;background:#fffbf2}.dc.kosong .bg{background:#fdf0cf;color:#a16207}
.upb{border:0;background:#dbe7fb;color:#2b4a8b;border-radius:9px;padding:6px 10px;font:700 11px Inter,sans-serif;cursor:pointer}
.kv{display:grid;grid-template-columns:200px 1fr;gap:12px 18px;margin:0}.kv dt{color:var(--mu)}.kv dd{font-weight:600;margin:0}
.tl{position:relative;padding-left:26px;margin:0;list-style:none}
.tl::before{content:"";position:absolute;left:6px;top:6px;bottom:6px;width:2px;background:var(--line)}
.tl li{position:relative;margin-bottom:18px;animation:rise .6s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--i)*80ms)}
.tl li::before{content:"";position:absolute;left:-26px;top:4px;width:12px;height:12px;border-radius:50%;background:var(--green);box-shadow:0 0 0 4px var(--mint)}
.tl small{color:var(--mu)}
.fl{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;position:relative}
.fs{padding:16px;border-radius:14px;background:#eef3fb;transition:transform .3s,box-shadow .3s;animation:rise .7s cubic-bezier(.2,.8,.2,1) backwards;animation-delay:calc(var(--i)*110ms + .2s)}
.fs:hover{transform:translateY(-5px);box-shadow:0 16px 34px rgba(11,31,58,.1)}
.fs.last{background:#e3f6ec}
.fs .t{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;color:var(--mu)}
.fs .n{width:26px;height:26px;border-radius:50%;background:var(--green);color:#fff;display:grid;place-items:center;font-weight:700;font-size:12px}
.fs b{display:block;margin-bottom:6px}.fs p{margin:0;color:var(--mu);font-size:11.5px;line-height:1.55}
dialog{border:0;border-radius:18px;padding:0;box-shadow:0 30px 80px rgba(11,31,58,.35);width:min(520px,92vw);color:var(--tx)}
dialog::backdrop{background:rgba(11,31,58,.45);backdrop-filter:blur(4px)}
dialog[open]{animation:dlg .4s cubic-bezier(.2,.8,.2,1)}
@keyframes dlg{from{opacity:0;transform:translateY(18px) scale(.97)}}
dialog form{padding:22px}dialog h3{font-size:18px;margin:0 0 4px}
dialog label.f{display:block;margin-top:14px;font-size:11.5px;font-weight:600}
dialog select,dialog input[type=file],dialog input[type=text],dialog input[type=date],dialog input[type=number]{width:100%;margin-top:5px;padding:11px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font:inherit}
.kl{max-height:210px;overflow:auto;border:1px solid var(--line);border-radius:10px;margin-top:6px}
.kl label{display:flex;gap:10px;align-items:center;padding:9px 12px;border-bottom:1px solid var(--line);font-weight:500;cursor:pointer}.kl label:hover{background:#f6f8fb}
.dact{display:flex;justify-content:flex-end;gap:8px;margin-top:20px}
.toast{position:fixed;right:24px;bottom:24px;z-index:60;padding:14px 18px;border-radius:14px;background:var(--navy);color:#fff;box-shadow:0 18px 40px rgba(11,31,58,.35);transform:translateY(30px);opacity:0;pointer-events:none;transition:transform .5s cubic-bezier(.2,.8,.2,1),opacity .4s;max-width:340px}
.toast.show{transform:none;opacity:1}
@media(max-width:1250px){.sm4{grid-template-columns:repeat(2,1fr)}.fil{grid-template-columns:repeat(3,1fr)}.docs{grid-template-columns:repeat(2,1fr)}.fl{grid-template-columns:repeat(3,1fr)}}
@media(max-width:700px){.sm4,.docs,.fl,.fil{grid-template-columns:1fr}.kv{grid-template-columns:1fr}.hb{grid-template-columns:1fr}}
@media print{.side,.top,.noprint,.tabn,.toast{display:none!important}.main{margin-left:0!important}.tp{display:block!important;animation:none}.in,.dt tbody tr{animation:none!important}}

/* ===== Perbaikan fungsi & tampilan ===== */
.tabn{overflow-y:hidden}
.dt{min-width:900px}
.dt th,.dt td{padding:12px 8px}
.kpw{min-width:130px}
.dc .f{flex-wrap:wrap}
.dc .f>span:first-child{flex:1 1 150px;min-width:0;overflow-wrap:anywhere}
.dc .f .ic{display:flex;gap:2px;flex:none}
.qa{position:relative}
.qa-menu{position:absolute;right:0;top:calc(100% + 8px);min-width:260px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 20px 44px rgba(11,31,58,.18);padding:6px;z-index:40;animation:dlg .3s cubic-bezier(.2,.8,.2,1)}
.qa-menu a,.qa-menu button{display:block;width:100%;text-align:left;padding:10px 12px;border:0;background:none;border-radius:9px;color:var(--tx);text-decoration:none;font:600 12.5px Inter,sans-serif;cursor:pointer;transition:background .2s}
.qa-menu a:hover,.qa-menu button:hover{background:var(--bg)}
.qa-menu hr{border:0;border-top:1px solid var(--line);margin:5px 4px}
dialog#dlgEdit{width:min(780px,94vw)}
dialog form{max-height:88vh;overflow:auto}
dialog .g2{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:14px}
dialog .g2 label.f{margin-top:0}
dialog .full{grid-column:1/-1}
dialog input[type=tel],dialog textarea{width:100%;margin-top:5px;padding:11px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font:inherit;color:var(--tx);outline:0}
dialog input:focus,dialog select:focus,dialog textarea:focus{border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
dialog textarea{resize:vertical;min-height:70px}
.kb{line-height:1.7;color:var(--tx)}.kb li{margin:6px 0}
.qrw{display:grid;place-items:center;padding:14px;margin-top:14px;border:1px dashed var(--line);border-radius:14px;background:#f8fafc}
.qrw #qrBox{padding:10px;background:#fff;border-radius:10px;min-height:60px}
.qrl{word-break:break-all;font-size:11.5px;color:var(--mu);margin-top:10px;text-align:center}
@media(max-width:700px){dialog .g2{grid-template-columns:1fr}}
</style>
</head>
<body>
@php
use App\Models\Alumni;
$ic = fn($n) => '<svg class="i"><use href="#'.$n.'"/></svg>';
$nama = auth()->user()->name ?? 'Admin';
$bln = fn($t) => $t ? $t->copy()->locale('id')->translatedFormat('d F Y') : '-';
$wajib = count(Alumni::DOKUMEN);
$statusLabel = ['diambil' => ['g', 'Sudah Diambil'], 'tersimpan' => ['b', 'Tersimpan di TU'], 'menunggu' => ['y', 'Menunggu Ambil']];
@endphp

@include('partials.sidebar')
<svg width="0" height="0" style="position:absolute">
<symbol id="a-eye" viewBox="0 0 24 24"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></symbol>
<symbol id="a-shield" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></symbol>
<symbol id="a-cap" viewBox="0 0 24 24"><path d="M2 9l10-5 10 5-10 5zM6 11v5c0 1.5 3 3 6 3s6-1.5 6-3v-5"/></symbol>
<symbol id="a-pin" viewBox="0 0 24 24"><path d="M12 21s7-6 7-11a7 7 0 10-14 0c0 5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></symbol>
<symbol id="a-arrow" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></symbol>
<symbol id="a-flow" viewBox="0 0 24 24"><circle cx="6" cy="6" r="2.5"/><circle cx="18" cy="18" r="2.5"/><path d="M6 8.5V12a4 4 0 004 4h5.5"/></symbol>
</svg>

<div class="main">
  <header class="top in" style="--d:1">
    <form method="GET" action="{{ route('alumni') }}" style="margin:0"><label class="search"><input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama, NISN, atau menu..."></label></form>
    <span class="pill">Sistem Aktif</span><small class="mu">TA 2026/2027 - Ganjil (Asia/Jakarta)</small>
    <span class="sp"></span>
    <div class="qa noprint">
      <button type="button" class="btn g" id="qaBtn" aria-haspopup="true" aria-expanded="false">+ Quick Action</button>
      <div class="qa-menu" id="qaMenu" hidden>
        <button type="button" data-dlg="dlgProses">Proses Kelulusan Siswa</button>
        <button type="button" data-dlg="dlgImpor">Impor Data Alumni</button>
        <a href="{{ route('alumni.ekspor', request()->query()) }}">Ekspor Excel</a>
        @if($terpilih)
        <hr>
        <button type="button" data-dlg="dlgEdit">Edit Data Alumni</button>
        <button type="button" data-dlg="dlgUnggah">Unggah Dokumen Kelulusan</button>
        <a href="{{ route('alumni.cetak', ['id' => $terpilih->id, 'print' => 1]) }}" target="_blank" rel="noopener">Cetak Transkrip &amp; SKL</a>
        @endif
        <hr>
        <a href="{{ route('siswa.aktif') }}">Data Siswa Aktif</a>
        <a href="{{ route('siswa.baru') }}">Tambah Siswa Baru</a>
        <a href="{{ route('siswa.detail') }}">Detail Profil Siswa</a>
      </div>
    </div>
    <div class="user">
      <div class="av">{{ strtoupper(substr($nama, 0, 1)) }}</div>
      <div><b>{{ $nama }}</b><small>Administrator • OP-10492</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
    </div>
  </header>

  <div class="wrap">
    <div class="crumb in" style="--d:1">Dashboard › Data Siswa › <b>Data Alumni</b></div>
    @if(session('status'))<div class="note in" style="--d:1"><b>{{ session('status') }}</b></div>@endif
    @if(session('peringatan'))<div class="alert in" style="--d:1"><b>Perhatian:</b> {{ session('peringatan') }}</div>@endif
    @if($errors->any())<div class="alert in" style="--d:1"><b>Gagal diproses:</b><ul style="margin:6px 0 0 18px;line-height:1.6">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
    <div id="reopen" data-f="{{ $errors->any() ? old('_form') : '' }}" hidden></div>

    <section class="hd in" style="--d:2">
      <div>
        <h1>Data Alumni MAS YPI SUMBER HARJO</h1>
        <p>Kelola data siswa yang telah lulus, pantau kelengkapan arsip kelulusan (ijazah, SKL, buku induk), dan temukan kembali lokasi berkas fisik dengan cepat.</p>
      </div>
      <div class="hb noprint">
        <button type="button" class="btn" id="bImpor">{!! $ic('upload') !!} Impor Data Alumni</button>
        <a class="btn" id="bEks" href="{{ route('alumni.ekspor', request()->query()) }}" data-base="{{ route('alumni.ekspor', request()->query()) }}">{!! $ic('download') !!} Ekspor Excel</a>
        <button type="button" class="btn" onclick="window.print()">{!! $ic('print') !!} Cetak Laporan</button>
        <button type="button" class="btn g" data-dlg="dlgProses">{!! $ic('a-cap') !!} + Proses Kelulusan Siswa</button>
      </div>
    </section>

    <section class="bn in" style="--d:3">
      <span class="bi">{!! $ic('a-shield') !!}</span>
      <div><b>Integrasi Sistem Buku Induk &amp; Retensi Permanen SIADDS</b><p>Data alumni otomatis terintegrasi langsung dari buku induk siswa aktif tanpa risiko duplikasi identitas NISN. Seluruh arsip digital dikunci secara permanen untuk kebutuhan legalisir ijazah online kapan saja.</p></div>
      <div class="bx"><span class="pc w">{{ $pctArsip }}% Berkas Terpenuhi</span><button type="button" class="lnk" data-dlg="dlgKebijakan">Kebijakan Arsip {!! $ic('a-arrow') !!}</button></div>
    </section>

    <section class="sm4">
      <div class="card sc in" style="--d:4"><small class="l">TOTAL ALUMNI TERDATA</small><span class="ico">{!! $ic('users') !!}</span><div class="big"><span data-count="{{ $total }}">{{ $total }}</span> <small>alumni</small></div><div class="ft"><span>Tercatat dari {{ $jumlahAngkatan }} angkatan</span><span class="pc b">{{ $jumlahAngkatan }} Thn</span></div></div>
      <div class="card sc in" style="--d:5"><small class="l">LULUSAN TA {{ $tahunTerbaru ? ($tahunTerbaru - 1) . '/' . $tahunTerbaru : '-' }}</small><span class="ico g">{!! $ic('a-cap') !!}</span><div class="big"><span data-count="{{ $lulusTerbaru }}">{{ $lulusTerbaru }}</span> <small>Angkatan {{ Alumni::romawi((int) $angkatanBaru) }}</small></div><div class="ft"><span>Penetapan: {{ $bln($tglTerbaru) }}</span></div></div>
      <div class="card sc in" style="--d:6"><small class="l">ALUMNI LAKI-LAKI</small><span class="ico">{!! $ic('user') !!}</span><div class="big"><span data-count="{{ $laki }}">{{ $laki }}</span> <small>jiwa ({{ $persen($laki) }}%)</small></div><div class="ft"><span>Peminatan terbanyak: {{ $topL ?: '-' }}</span></div></div>
      <div class="card sc in" style="--d:7"><small class="l">ALUMNI PEREMPUAN</small><span class="ico">{!! $ic('user') !!}</span><div class="big"><span data-count="{{ $perempuan }}">{{ $perempuan }}</span> <small>jiwa ({{ $persen($perempuan) }}%)</small></div><div class="ft"><span>Peminatan terbanyak: {{ $topP ?: '-' }}</span></div></div>
    </section>

    <section class="card fc in" style="--d:8">
      <form method="GET" action="{{ route('alumni') }}">
        <div class="srow">
          <input class="sbox" type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama alumni, NIS, NISN, nomor seri ijazah, atau tahun kelulusan...">
          <button class="btn g" type="submit">{!! $ic('search') !!} Terapkan Filter</button>
          <a class="btn" href="{{ route('alumni') }}">↻ Reset</a>
        </div>
        <div class="fil">
          <div><label>Tahun Kelulusan</label><select name="tahun"><option value="">Semua Tahun</option>@foreach($daftarTahun as $t)<option value="{{ $t->tahun_lulus }}" @selected((string) request('tahun') === (string) $t->tahun_lulus)>{{ $t->tahun_lulus }} (Angkatan {{ Alumni::romawi((int) $t->angkatan) }})</option>@endforeach</select></div>
          <div><label>Kelas Terakhir</label><select name="kelas"><option value="">Semua Kelas</option>@foreach($daftarKelas as $k)<option value="{{ $k }}" @selected(request('kelas') === $k)>{{ $k }}</option>@endforeach</select></div>
          <div><label>Jenis Kelamin</label><select name="jk"><option value="">Semua Gender</option><option value="L" @selected(request('jk') === 'L')>Laki-laki</option><option value="P" @selected(request('jk') === 'P')>Perempuan</option></select></div>
          <div><label>Status Arsip Digital</label><select name="arsip"><option value="">Semua Status Arsip</option><option value="lengkap" @selected(request('arsip') === 'lengkap')>Lengkap (6/6)</option><option value="belum" @selected(request('arsip') === 'belum')>Belum Lengkap</option></select></div>
          <div><label>Status Pengambilan Berkas</label><select name="ambil"><option value="">Semua Distribusi</option>@foreach($statusLabel as $kode => $sl)<option value="{{ $kode }}" @selected(request('ambil') === $kode)>{{ $sl[1] }}</option>@endforeach</select></div>
        </div>
        <input type="hidden" name="per_page" value="{{ $perPage }}">
      </form>
      <div class="tags">
        <span>Menampilkan {{ $alumni->count() }} dari {{ number_format($alumni->total()) }} data alumni</span>
        @if(request('tahun'))<span class="tg">Angkatan: {{ request('tahun') }}</span>@endif
        @if(request('kelas'))<span class="tg">Kelas: {{ request('kelas') }}</span>@endif
        @if(request('ambil'))<span class="tg">Ijazah: {{ $statusLabel[request('ambil')][1] ?? request('ambil') }}</span>@endif
        @if(request('q'))<span class="tg">Cari: {{ request('q') }}</span>@endif
        <span id="nSel" class="tg" hidden></span>
        <span class="lg"><span><i style="background:#16a34a"></i>Arsip 100%</span><span><i style="background:#f59e0b"></i>Dokumen Menunggu Verifikasi</span></span>
      </div>

      <div class="tw" style="margin-top:14px">
      <table class="dt">
        <thead><tr><th><input type="checkbox" id="ckAll" aria-label="Pilih semua"></th><th>ALUMNI</th><th>NIS / NISN</th><th>L/P</th><th>KELAS TERAKHIR / JURUSAN</th><th>TAHUN MASUK / LULUS</th><th>KELENGKAPAN ARSIP DIGITAL</th><th>STATUS IJAZAH FISIK</th><th style="text-align:right">AKSI DOKUMEN</th></tr></thead>
        <tbody>
        @forelse($alumni as $i => $a)
          @php
            $ada = $a->dokumen->pluck('jenis');
            $n = min($ada->count(), $wajib);
            $pct = round($n / $wajib * 100);
            $lengkap = $n >= $wajib;
            $kurang = collect(Alumni::DOKUMEN)->first(fn($d) => ! $ada->contains($d['label']));
            $sl = $statusLabel[$a->status_ijazah] ?? ['b', ucfirst($a->status_ijazah)];
            $href = request()->fullUrlWithQuery(['id' => $a->id]);
          @endphp
          <tr class="{{ $terpilih && $terpilih->id === $a->id ? 'sel' : '' }}" style="--i:{{ $i }}" data-href="{{ $href }}#arsip">
            <td><input type="checkbox" class="rk" value="{{ $a->id }}" aria-label="Pilih {{ $a->nama }}"></td>
            <td><div class="al">@if($a->foto)<img class="avt" src="{{ asset('storage/' . $a->foto) }}" alt="{{ $a->nama }}">@else<span class="avt">{{ strtoupper(substr($a->nama, 0, 1)) }}</span>@endif<div><b>{{ $a->nama }}</b><small>Panggilan: {{ $a->panggilan ?: '-' }}</small></div></div></td>
            <td><b>{{ $a->nis }}</b><small>{{ $a->nisn }}</small></td>
            <td><span class="lp {{ $a->jenis_kelamin }}">{{ $a->jenis_kelamin }}</span></td>
            <td><b>{{ $a->kelas_terakhir }}</b><small>{{ $a->jurusan ? '(' . $a->jurusan . ')' : '' }}</small></td>
            <td>{{ $a->tahun_masuk }} / <b>{{ $a->tahun_lulus }}</b></td>
            <td><div class="kpw"><span class="kp {{ $lengkap ? 'g' : 'y' }}">{{ $lengkap ? 'Lengkap (' . $n . '/' . $wajib . ')' : 'Kurang ' . ($kurang['short'] ?? '') . ' (' . $n . '/' . $wajib . ')' }}</span><span>{{ $pct }}%</span></div><div class="pb {{ $lengkap ? '' : 'y' }}"><i style="width: {{ $pct }}%"></i></div></td>
            <td><span class="si {{ $sl[0] }}">{{ $sl[1] }}</span></td>
            <td style="text-align:right;white-space:nowrap" class="noprint"><a class="ia" href="{{ $href }}#arsip" title="Arsip dokumen">{!! $ic('file') !!}</a><a class="ia" href="{{ $href }}#lokasi" title="Lokasi map fisik">{!! $ic('folder') !!}</a><a class="ia" href="{{ route('alumni.cetak', ['id' => $a->id, 'print' => 1]) }}" target="_blank" rel="noopener" title="Cetak SKL">{!! $ic('print') !!}</a></td>
          </tr>
        @empty
          <tr><td colspan="9" class="empty">Belum ada data alumni yang cocok. Gunakan <b>Proses Kelulusan Siswa</b> untuk memindahkan siswa kelas XII menjadi alumni.</td></tr>
        @endforelse
        </tbody>
      </table>
      </div>

      @if($alumni->total() > 0)
      <div class="pgr">
        <span>Menampilkan <b>{{ $alumni->firstItem() }}–{{ $alumni->lastItem() }}</b> dari <b>{{ number_format($alumni->total()) }}</b> alumni</span>
        <div class="pgn">
          @if($alumni->onFirstPage())<span class="off">‹</span>@else<a href="{{ $alumni->previousPageUrl() }}">‹</a>@endif
          @if($alumni->currentPage() > 2)<a href="{{ $alumni->url(1) }}">1</a><span>…</span>@endif
          @foreach(range(max(1, $alumni->currentPage() - 1), min($alumni->lastPage(), $alumni->currentPage() + 1)) as $p)
            @if($p === $alumni->currentPage())<span class="on">{{ $p }}</span>@else<a href="{{ $alumni->url($p) }}">{{ $p }}</a>@endif
          @endforeach
          @if($alumni->currentPage() < $alumni->lastPage() - 1)<span>…</span><a href="{{ $alumni->url($alumni->lastPage()) }}">{{ $alumni->lastPage() }}</a>@endif
          @if($alumni->hasMorePages())<a href="{{ $alumni->nextPageUrl() }}">›</a>@else<span class="off">›</span>@endif
        </div>
      </div>
      @endif
    </section>

    @if($terpilih)
    @php
      $docT = $terpilih->dokumen->keyBy('jenis');
      $nT = min($docT->count(), $wajib);
      $slT = $statusLabel[$terpilih->status_ijazah] ?? ['b', ucfirst($terpilih->status_ijazah)];
    @endphp
    <section class="card in" style="--d:9;padding:0;overflow:hidden;margin:22px 0" id="detail">
      <div class="dh">
        @if($terpilih->foto)<img class="ph0" src="{{ asset('storage/' . $terpilih->foto) }}" alt="{{ $terpilih->nama }}">@else<div class="ph0">{{ strtoupper(substr($terpilih->nama, 0, 1)) }}</div>@endif
        <div>
          <h2>{{ $terpilih->nama }} <span class="pc g">Alumni Resmi • Angkatan {{ Alumni::romawi((int) $terpilih->angkatan) }}</span></h2>
          <div class="m">Nomor Ijazah: <b>{{ $terpilih->nomor_ijazah ?: '-' }}</b> &nbsp;•&nbsp; NIS: <b>{{ $terpilih->nis }}</b><br>NISN: <b>{{ $terpilih->nisn }}</b><br>Lulusan Kelas {{ $terpilih->kelas_terakhir }}{{ $terpilih->jurusan ? ' (' . $terpilih->jurusan . ')' : '' }} — Tanggal Penetapan Kelulusan: {{ $bln($terpilih->tanggal_kelulusan) }}</div>
        </div>
        <div class="ac noprint">
          <button type="button" class="btn" data-dlg="dlgQr">{!! $ic('qr') !!} QR Verifikasi Digital</button>
          <a class="btn" href="{{ route('alumni.cetak', ['id' => $terpilih->id, 'print' => 1]) }}" target="_blank" rel="noopener">{!! $ic('print') !!} Cetak Transkrip &amp; SKL</a>
          @if($siswaAsal ?? null)
          <a class="btn" href="{{ route('siswa.detail', ['id' => $siswaAsal->id]) }}">Profil Siswa</a>
          <a class="btn" href="{{ route('siswa.aktif.buku', ['id' => $siswaAsal->id]) }}" target="_blank" rel="noopener">Buku Induk</a>
          <form method="POST" action="{{ route('alumni.batal', $terpilih->id) }}" style="display:inline" onsubmit="return confirm('Batalkan kelulusan dan kembalikan siswa ke Data Siswa Aktif? Data alumni beserta dokumen alumni akan dihapus.')">@csrf<button type="submit" class="btn">Batalkan Kelulusan</button></form>
          @endif
          <button type="button" class="btn g" data-dlg="dlgEdit">Edit Data Alumni</button>
        </div>
      </div>

      <div class="tabn noprint" id="tabs">
        <button type="button" class="tb on" data-tab="arsip">{!! $ic('folder') !!} Arsip Kelulusan &amp; Dokumen ({{ $docT->count() }} Berkas)</button>
        <button type="button" class="tb" data-tab="akademik">{!! $ic('chart') !!} Riwayat Akademik &amp; Prestasi</button>
        <button type="button" class="tb" data-tab="lokasi">{!! $ic('a-pin') !!} Lokasi Map Fisik Arsip</button>
        <button type="button" class="tb" data-tab="log">{!! $ic('check') !!} Log Penyerahan Ijazah</button>
      </div>

      <div class="tp on" id="tp-arsip">
        <div class="th"><h3>Direktori Dokumen Ijazah &amp; Kelulusan <span class="pc g">Terverifikasi {{ $nT }}/{{ $wajib }}</span></h3><span class="pc b">{!! $ic('a-pin') !!} Fisik: {{ $terpilih->lemari ?: '-' }} / {{ $terpilih->rak ?: '-' }} / Map {{ $terpilih->kode_map ?: '-' }} ({{ $terpilih->ruang_arsip ?: '-' }})</span></div>
        <div class="docs">
          @foreach(Alumni::DOKUMEN as $i => $k)
            @php
              $d = $docT->get($k['label']);
              $url = $d && $d->path ? asset('storage/' . $d->path) : null;
              $foot = match($k['key']) {
                'ijazah' => 'Nomor: ' . ($terpilih->nomor_ijazah ?: '-'),
                'skl' => 'No: ' . ($terpilih->nomor_skl ?: '-'),
                'transkrip' => 'Rata-rata Kelulusan: ' . ($terpilih->rata_rata !== null ? number_format($terpilih->rata_rata, 2) : '-'),
                'akta' => 'NIK: ' . ($terpilih->nik ?: '-'),
                'foto' => 'Fisik: ' . ($terpilih->lemari ?: '-'),
                default => 'Diserahkan: ' . $bln($terpilih->tanggal_pengambilan),
              };
            @endphp
            @if($d)
            <div class="dc" style="--i:{{ $i }}">
              <div class="r"><span class="di">{!! $ic($k['icon']) !!}</span><div><b>{{ $k['label'] }}</b><small>{{ $d->nama_file }} • {{ $d->ukuran }}</small></div><span class="bg">{{ $k['badge'] }}</span></div>
              <div class="f"><span>{{ $foot }}</span><span class="noprint ic">@if($url)<a class="ia" href="{{ $url }}" target="_blank" rel="noopener" title="Pratinjau">{!! $ic('a-eye') !!}</a><a class="ia" href="{{ $url }}" download title="Unduh">{!! $ic('download') !!}</a>@else<button type="button" class="ia" data-toast="Berkas fisik belum tersedia untuk data contoh ini. Klik ikon unggah untuk menambahkan berkas asli." title="Pratinjau">{!! $ic('a-eye') !!}</button><button type="button" class="ia" data-toast="Berkas fisik belum tersedia untuk data contoh ini. Klik ikon unggah untuk menambahkan berkas asli." title="Unduh">{!! $ic('download') !!}</button>@endif<button type="button" class="ia" data-up="{{ $k['label'] }}" title="Ganti / unggah berkas">{!! $ic('upload') !!}</button></span></div>
            </div>
            @else
            <div class="dc kosong" style="--i:{{ $i }}">
              <div class="r"><span class="di n">{!! $ic($k['icon']) !!}</span><div><b>{{ $k['label'] }}</b><small>Belum diunggah</small></div><span class="bg">Belum Ada</span></div>
              <div class="f"><span>{{ $foot }}</span><button type="button" class="upb noprint" data-up="{{ $k['label'] }}">+ Unggah</button></div>
            </div>
            @endif
          @endforeach
        </div>
      </div>

      <div class="tp" id="tp-akademik">
        <dl class="kv"><dt>Kelas Terakhir</dt><dd>{{ $terpilih->kelas_terakhir }}</dd><dt>Jurusan / Peminatan</dt><dd>{{ $terpilih->jurusan ?: '-' }}</dd><dt>Tahun Masuk / Lulus</dt><dd>{{ $terpilih->tahun_masuk }} / {{ $terpilih->tahun_lulus }}</dd><dt>Rata-rata Kelulusan</dt><dd>{{ $terpilih->rata_rata !== null ? number_format($terpilih->rata_rata, 2) : '-' }}</dd><dt>Prestasi</dt><dd>@if($terpilih->prestasi)@foreach(preg_split('/\r\n|\r|\n/', $terpilih->prestasi) as $pr)<div>• {{ $pr }}</div>@endforeach @else - @endif</dd></dl>
      </div>

      <div class="tp" id="tp-lokasi">
        <dl class="kv"><dt>Ruang Penyimpanan</dt><dd>{{ $terpilih->ruang_arsip ?: '-' }}</dd><dt>Lemari Berkas</dt><dd>{{ $terpilih->lemari ?: '-' }}</dd><dt>Nomor Rak</dt><dd>{{ $terpilih->rak ?: '-' }}</dd><dt>Kode Label Map Ordner</dt><dd>{{ $terpilih->kode_map ?: '-' }}</dd></dl>
      </div>

      <div class="tp" id="tp-log">
        <div class="th"><h3>Status Ijazah Fisik: <span class="si {{ $slT[0] }}">{{ $slT[1] }}</span></h3><button type="button" class="btn noprint" data-dlg="dlgIjazah">Ubah Status Ijazah</button></div>
        <ul class="tl">
          @foreach($log as $i => $l)
            <li style="--i:{{ $i }}"><b>{{ $l['judul'] }}</b><br><small>{{ $l['oleh'] }} • {{ $l['waktu'] ? $l['waktu']->copy()->locale('id')->translatedFormat('d F Y') : '-' }}</small></li>
          @endforeach
        </ul>
      </div>
    </section>
    @endif

    <section class="card fc in" style="--d:10;margin-bottom:22px">
      <div class="th" style="margin-bottom:18px"><h3><span class="bn" style="padding:0;border:0;background:none;display:inline-flex"><span class="bi" style="width:38px;height:38px;background:#e3f6ec;color:#0a5c3b">{!! $ic('a-flow') !!}</span></span> Alur Mutasi Kelulusan Siswa (Buku Induk → Arsip Alumni)</h3><span class="pc b">SOP-ARSIP-04/PPDB</span></div>
      <div class="fl">
        <div class="fs" style="--i:0"><div class="t"><span class="n">1</span>{!! $ic('users') !!}</div><b>Data Siswa Kelas XII</b><p>Seleksi rombel kelas XII aktif yang telah menempuh semester 6 tanpa tunggakan nilai.</p></div>
        <div class="fs" style="--i:1"><div class="t"><span class="n">2</span>{!! $ic('check') !!}</div><b>Verifikasi Nilai Ujian</b><p>Sinkronisasi nilai asesmen madrasah, ujian praktik, dan rapor buku induk resmi.</p></div>
        <div class="fs" style="--i:2"><div class="t"><span class="n">3</span>{!! $ic('chart') !!}</div><b>Konfirmasi Pleno</b><p>Rapat dewan guru dan penerbitan SK Kepala Madrasah terkait penetapan kelulusan resmi.</p></div>
        <div class="fs" style="--i:3"><div class="t"><span class="n">4</span>{!! $ic('file') !!}</div><b>Penetapan Nomor Ijazah</b><p>Perekaman nomor seri blangko ijazah Kemenag &amp; penempatan lokasi map fisik arsip.</p></div>
        <div class="fs last" style="--i:4"><div class="t"><span class="n">5</span>{!! $ic('a-cap') !!}</div><b>Terbit di Direktori</b><p>Status bermutasi ke Alumni. Riwayat buku induk terkunci permanen untuk arsip selamanya.</p></div>
      </div>
    </section>

    <dialog id="dlgImpor">
      <form method="POST" action="{{ route('alumni.impor') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_form" value="impor">
        <h3>Impor Data Alumni</h3>
        <p class="mu" style="line-height:1.6">Unggah berkas CSV (bisa dibuat dari Excel dengan Save As → CSV). Kolom wajib: nis, nisn, nama, jenis_kelamin, kelas_terakhir, tahun_masuk, tahun_lulus.</p>
        <p style="margin-top:8px"><a class="lnk" style="color:var(--green);font-weight:700" href="{{ route('alumni.template') }}">⬇ Unduh template CSV</a></p>
        <label class="f">Berkas CSV (maks. 2 MB)<input type="file" name="berkas" accept=".csv,.txt" required></label>
        <div class="dact"><button type="button" class="btn" data-close>Batal</button><button type="submit" class="btn g">Impor Sekarang</button></div>
      </form>
    </dialog>

    <dialog id="dlgKebijakan">
      <form method="dialog">
        <h3>Kebijakan Arsip &amp; Retensi Permanen</h3><p class="mu">SOP-ARSIP-04/PPDB • MAS YPI Sumber Harjo</p>
        <ul class="kb">
          <li>Data alumni dipindahkan dari buku induk siswa aktif dan <b>tidak dihapus</b>; arsip dikunci permanen.</li>
          <li>Enam dokumen kelulusan wajib diarsipkan: ijazah, SKL, transkrip nilai, akta &amp; KK, pasfoto cap 3 jari, serta berita acara penyerahan.</li>
          <li>Nomor ijazah bersifat unik dan menjadi dasar QR verifikasi publik untuk legalisir online.</li>
          <li>Ijazah asli dicatat statusnya: tersimpan di TU, menunggu diambil, atau sudah diambil beserta nama dan tanggal penyerahan.</li>
          <li>Perubahan data alumni hanya dilakukan oleh operator berwenang dan tercatat pada riwayat arsip.</li>
        </ul>
        <div class="dact"><button type="submit" class="btn g">Mengerti</button></div>
      </form>
    </dialog>

    <dialog id="dlgProses">
      <form method="POST" action="{{ route('alumni.proses') }}">
        @csrf
        <input type="hidden" name="_form" value="proses">
        <h3>Proses Kelulusan Siswa</h3><p class="mu">Siswa aktif kelas XII yang dipilih dipindahkan menjadi alumni dan tidak lagi tampil di Data Siswa Aktif.</p>
        @if($kandidat->isEmpty())
          <div class="empty">Tidak ada siswa aktif kelas XII.</div>
        @else
          <label class="f">Pilih siswa <button type="button" class="lnk" id="pAll" style="float:right">Pilih semua</button></label>
          <div class="kl">@foreach($kandidat as $s)<label><input type="checkbox" name="siswa_ids[]" value="{{ $s->id }}" class="pk"> <span><b>{{ $s->nama }}</b> <small class="mu">{{ $s->nis }} • {{ $s->kelas }}</small></span></label>@endforeach</div>
          <label class="f">Tahun lulus<input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', now()->year) }}" min="2000" max="2100" required></label>
          <label class="f">Tanggal penetapan kelulusan<input type="date" name="tanggal_kelulusan" value="{{ old('tanggal_kelulusan', now()->format('Y-m-d')) }}" required></label>
        @endif
        <div class="dact"><button type="button" class="btn" data-close>Batal</button><button type="submit" class="btn g" {{ $kandidat->isEmpty() ? 'disabled' : '' }}>Proses Kelulusan</button></div>
      </form>
    </dialog>

    @if($terpilih)
    <dialog id="dlgUnggah">
      <form method="POST" action="{{ route('alumni.unggah', $terpilih->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="_form" value="unggah">
        <h3>Unggah Dokumen Kelulusan</h3><p class="mu">{{ $terpilih->nama }} • PDF / JPG / PNG, maks. 5 MB.</p>
        <label class="f">Jenis dokumen<select name="jenis" id="upJenis">@foreach(Alumni::DOKUMEN as $k)<option value="{{ $k['label'] }}">{{ $k['label'] }}</option>@endforeach</select></label>
        <label class="f">Berkas<input type="file" name="berkas" accept=".pdf,.jpg,.jpeg,.png" required></label>
        <div class="dact"><button type="button" class="btn" data-close>Batal</button><button type="submit" class="btn g">Unggah</button></div>
      </form>
    </dialog>
    <dialog id="dlgIjazah">
      <form method="POST" action="{{ route('alumni.ijazah', $terpilih->id) }}">
        @csrf
        <input type="hidden" name="_form" value="ijazah">
        <h3>Ubah Status Ijazah Fisik</h3><p class="mu">{{ $terpilih->nama }} • {{ $terpilih->nomor_ijazah ?: '-' }}</p>
        <label class="f">Status<select name="status_ijazah">@foreach($statusLabel as $kode => $sl)<option value="{{ $kode }}" @selected($terpilih->status_ijazah === $kode)>{{ $sl[1] }}</option>@endforeach</select></label>
        <label class="f">Diambil oleh<input type="text" name="diambil_oleh" value="{{ $terpilih->diambil_oleh }}" maxlength="100" placeholder="Nama pengambil (jika sudah diambil)"></label>
        <label class="f">Tanggal pengambilan<input type="date" name="tanggal_pengambilan" value="{{ optional($terpilih->tanggal_pengambilan)->format('Y-m-d') }}"></label>
        <div class="dact"><button type="button" class="btn" data-close>Batal</button><button type="submit" class="btn g">Simpan</button></div>
      </form>
    </dialog>

    @php
      $opsiKelas = [];
      foreach (['X', 'XI', 'XII'] as $tk) { foreach (['A', 'B', 'C', 'D'] as $rk) { $opsiKelas[] = $tk . '-' . $rk; } }
      if (! in_array($terpilih->kelas_terakhir, $opsiKelas, true)) { $opsiKelas[] = $terpilih->kelas_terakhir; }
      $tg = fn ($f) => optional($terpilih->{$f})->format('Y-m-d');
    @endphp
    <dialog id="dlgEdit">
      <form method="POST" action="{{ route('alumni.update', $terpilih->id) }}">
        @csrf @method('PUT')
        <input type="hidden" name="_form" value="edit">
        <h3>Edit Data Alumni</h3><p class="mu">{{ $terpilih->nama }} • perubahan langsung tersimpan ke database.</p>
        <div class="g2">
          <label class="f full">Nama lengkap *<input type="text" name="nama" value="{{ old('nama', $terpilih->nama) }}" required maxlength="100"></label>
          <label class="f">Nama panggilan<input type="text" name="panggilan" value="{{ old('panggilan', $terpilih->panggilan) }}" maxlength="50"></label>
          <label class="f">Jenis kelamin *<select name="jenis_kelamin" required><option value="L" @selected(old('jenis_kelamin', $terpilih->jenis_kelamin) === 'L')>Laki-laki</option><option value="P" @selected(old('jenis_kelamin', $terpilih->jenis_kelamin) === 'P')>Perempuan</option></select></label>
          <label class="f">NIS *<input type="text" name="nis" value="{{ old('nis', $terpilih->nis) }}" required maxlength="20"></label>
          <label class="f">NISN * (10 digit)<input type="text" name="nisn" value="{{ old('nisn', $terpilih->nisn) }}" required maxlength="10" inputmode="numeric"></label>
          <label class="f">NIK (16 digit)<input type="text" name="nik" value="{{ old('nik', $terpilih->nik) }}" maxlength="16" inputmode="numeric"></label>
          <label class="f">Kelas terakhir *<select name="kelas_terakhir" required>@foreach($opsiKelas as $k)<option value="{{ $k }}" @selected(old('kelas_terakhir', $terpilih->kelas_terakhir) === $k)>{{ $k }}</option>@endforeach</select></label>
          <label class="f">Jurusan / peminatan<input type="text" name="jurusan" value="{{ old('jurusan', $terpilih->jurusan) }}" maxlength="80"></label>
          <label class="f">Tahun masuk *<input type="number" name="tahun_masuk" value="{{ old('tahun_masuk', $terpilih->tahun_masuk) }}" required min="2000" max="2100"></label>
          <label class="f">Tahun lulus *<input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', $terpilih->tahun_lulus) }}" required min="2000" max="2100"></label>
          <label class="f">Tanggal penetapan kelulusan<input type="date" name="tanggal_kelulusan" value="{{ old('tanggal_kelulusan', $tg('tanggal_kelulusan')) }}"></label>
          <label class="f">Rata-rata kelulusan<input type="number" name="rata_rata" value="{{ old('rata_rata', $terpilih->rata_rata) }}" step="0.01" min="0" max="100"></label>
          <label class="f">Nomor ijazah<input type="text" name="nomor_ijazah" value="{{ old('nomor_ijazah', $terpilih->nomor_ijazah) }}" maxlength="40"></label>
          <label class="f">Nomor SKL<input type="text" name="nomor_skl" value="{{ old('nomor_skl', $terpilih->nomor_skl) }}" maxlength="60"></label>
          <label class="f">Ruang arsip<input type="text" name="ruang_arsip" value="{{ old('ruang_arsip', $terpilih->ruang_arsip) }}" maxlength="100"></label>
          <label class="f">Lemari berkas<input type="text" name="lemari" value="{{ old('lemari', $terpilih->lemari) }}" maxlength="40"></label>
          <label class="f">Nomor rak<input type="text" name="rak" value="{{ old('rak', $terpilih->rak) }}" maxlength="20"></label>
          <label class="f">Kode label map ordner<input type="text" name="kode_map" value="{{ old('kode_map', $terpilih->kode_map) }}" maxlength="40"></label>
          <label class="f full">Prestasi (satu baris per prestasi)<textarea name="prestasi" maxlength="1000">{{ old('prestasi', $terpilih->prestasi) }}</textarea></label>
        </div>
        <div class="dact"><button type="button" class="btn" data-close>Batal</button><button type="submit" class="btn g">Simpan Perubahan</button></div>
      </form>
    </dialog>

    <dialog id="dlgQr">
      <form method="dialog">
        <h3>QR Verifikasi Digital</h3><p class="mu">{{ $terpilih->nama }} • pindai untuk memeriksa keaslian ijazah secara online.</p>
        @if($terpilih->nomor_ijazah)
          @php $urlVerif = route('alumni.verifikasi', ['nomor' => $terpilih->nomor_ijazah]); @endphp
          <div class="qrw"><div id="qrBox"></div><div class="qrl" id="qrUrl" data-url="{{ $urlVerif }}" data-nama="{{ $terpilih->nama }}" data-nomor="{{ $terpilih->nomor_ijazah }}">{{ $urlVerif }}</div></div>
          <div class="dact" style="flex-wrap:wrap">
            <button type="button" class="btn" id="qrSalin">Salin Tautan</button>
            <a class="btn" href="{{ $urlVerif }}" target="_blank" rel="noopener">Buka Halaman Verifikasi</a>
            <button type="button" class="btn" id="qrCetak">Cetak Label QR</button>
            <button type="submit" class="btn g">Tutup</button>
          </div>
        @else
          <div class="empty">Nomor ijazah belum ada. Isi nomor ijazah melalui Edit Data Alumni terlebih dahulu.</div>
          <div class="dact"><button type="submit" class="btn g">Tutup</button></div>
        @endif
      </form>
    </dialog>
    @endif

    <footer class="foot in" style="--d:11"><span>Sistem Informasi Arsip Digital &amp; Data Siswa (SIADDS) • MAS YPI Sumber Harjo</span><span>Kemenag Kab. OKU Timur</span><span>NPSN: 10648892</span></footer>
  </div>
</div>

<div class="toast" id="toast"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
(function () {
  function $(s, c) { return (c || document).querySelector(s); }
  function $$(s, c) { return [].slice.call((c || document).querySelectorAll(s)); }

  var tst = $('#toast'), th;
  function toast(m) { tst.textContent = m; tst.classList.add('show'); clearTimeout(th); th = setTimeout(function () { tst.classList.remove('show'); }, 3600); }
  $$('[data-toast]').forEach(function (b) { b.addEventListener('click', function () { toast(b.dataset.toast); }); });
  var im = $('#bImpor'); if (im) { im.addEventListener('click', function () { var d = $('#dlgImpor'); if (d && !d.open) { d.showModal(); } }); }

  var tabs = $$('.tb'), panels = $$('.tp');
  function openTab(id) {
    tabs.forEach(function (t) { t.classList.toggle('on', t.dataset.tab === id); });
    panels.forEach(function (p) { p.classList.toggle('on', p.id === 'tp-' + id); });
  }
  tabs.forEach(function (t) { t.addEventListener('click', function () { openTab(t.dataset.tab); }); });
  var h = location.hash.slice(1);
  if (h && $('#tp-' + h)) { openTab(h); var d = $('#detail'); if (d) { setTimeout(function () { d.scrollIntoView({ behavior: 'smooth' }); }, 500); } }

  $$('[data-dlg]').forEach(function (b) { b.addEventListener('click', function () { var d = document.getElementById(b.dataset.dlg); if (d) { d.showModal(); } }); });
  $$('[data-close]').forEach(function (b) { b.addEventListener('click', function () { b.closest('dialog').close(); }); });
  $$('dialog').forEach(function (d) { d.addEventListener('click', function (e) { if (e.target === d) { d.close(); } }); });
  $$('[data-up]').forEach(function (b) { b.addEventListener('click', function () { var s = $('#upJenis'), d = $('#dlgUnggah'); if (s && d) { s.value = b.dataset.up; d.showModal(); } }); });
  var pAll = $('#pAll'); if (pAll) { pAll.addEventListener('click', function () { $$('.pk').forEach(function (c) { c.checked = true; }); }); }

  var cks = $$('.rk'), all = $('#ckAll'), eks = $('#bEks');
  function upd() {
    var ids = cks.filter(function (c) { return c.checked; }).map(function (c) { return c.value; });
    var s = $('#nSel'); s.hidden = !ids.length; s.textContent = ids.length + ' dipilih';
    var u = new URL(eks.dataset.base, location.href);
    if (ids.length) { u.searchParams.set('ids', ids.join(',')); }
    eks.href = u.toString();
  }
  cks.forEach(function (c) { c.addEventListener('change', upd); c.addEventListener('click', function (e) { e.stopPropagation(); }); });
  if (all) { all.addEventListener('change', function () { cks.forEach(function (c) { c.checked = all.checked; }); upd(); }); }
  $$('.dt tbody tr[data-href]').forEach(function (r) {
    r.addEventListener('click', function (e) { if (e.target.closest('input,a,button')) { return; } location.href = r.dataset.href; });
  });

  var qb = $('#qaBtn'), qm = $('#qaMenu');
  if (qb && qm) {
    qb.addEventListener('click', function (e) { e.stopPropagation(); qm.hidden = !qm.hidden; qb.setAttribute('aria-expanded', String(!qm.hidden)); });
    qm.addEventListener('click', function (e) { if (e.target.closest('button,a')) { qm.hidden = true; } });
    document.addEventListener('click', function (e) { if (!qm.hidden && !qm.contains(e.target)) { qm.hidden = true; qb.setAttribute('aria-expanded', 'false'); } });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { qm.hidden = true; } });
  }

  var qrBox = $('#qrBox'), qrInfo = $('#qrUrl');
  if (qrBox && qrInfo) {
    var tautan = qrInfo.dataset.url;
    if (typeof QRCode !== 'undefined') { new QRCode(qrBox, { text: tautan, width: 200, height: 200, correctLevel: QRCode.CorrectLevel.M }); }
    else { qrBox.innerHTML = '<p class="mu" style="max-width:240px;text-align:center;line-height:1.5">Pustaka QR tidak dapat dimuat (periksa koneksi internet). Gunakan tautan verifikasi di bawah.</p>'; }
    $('#qrSalin').addEventListener('click', function () {
      function ok() { toast('Tautan verifikasi berhasil disalin.'); }
      if (navigator.clipboard && window.isSecureContext) { navigator.clipboard.writeText(tautan).then(ok, ok); return; }
      var t = document.createElement('textarea'); t.value = tautan; document.body.appendChild(t); t.select();
      try { document.execCommand('copy'); } catch (e) { } document.body.removeChild(t); ok();
    });
    $('#qrCetak').addEventListener('click', function () {
      var cv = qrBox.querySelector('canvas'), im = qrBox.querySelector('img'), src = cv ? cv.toDataURL('image/png') : (im ? im.src : '');
      if (!src) { toast('QR belum tersedia. Periksa koneksi internet lalu muat ulang halaman.'); return; }
      var w = window.open('', '_blank');
      if (!w) { toast('Izinkan pop-up pada peramban untuk mencetak label QR.'); return; }
      function esc(x) { return String(x).replace(/[&<>"]/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]; }); }
      w.document.write('<html><head><title>Label QR</title><style>body{font-family:Arial,sans-serif;text-align:center;padding:30px}img{width:230px;height:230px}h3{margin:0 0 6px}p{margin:4px 0}</style></head><body><h3>MAS YPI SUMBER HARJO</h3><p><b>' + esc(qrInfo.dataset.nama) + '</b></p><p>' + esc(qrInfo.dataset.nomor) + '</p><img src="' + src + '" alt="QR"><p style="font-size:12px">Pindai untuk verifikasi keaslian dokumen</p></body></html>');
      w.document.close(); setTimeout(function () { w.focus(); w.print(); }, 400);
    });
  }

  var ro = $('#reopen');
  if (ro && ro.dataset.f) {
    var dr = document.getElementById({ proses: 'dlgProses', unggah: 'dlgUnggah', ijazah: 'dlgIjazah', edit: 'dlgEdit', impor: 'dlgImpor' }[ro.dataset.f]);
    if (dr && !dr.open) { dr.showModal(); }
  }

  $$('[data-count]').forEach(function (el) {
    var to = parseFloat(el.dataset.count) || 0, t0 = null;
    function f(ts) { if (!t0) { t0 = ts; } var p = Math.min((ts - t0) / 1000, 1), e = 1 - Math.pow(1 - p, 3); el.textContent = Math.round(to * e); if (p < 1) { requestAnimationFrame(f); } }
    el.textContent = '0'; requestAnimationFrame(f);
  });
})();
</script>
@include('partials.alumni-tambahan')
@includeIf('partials.alumni-lama')
@includeIf('partials.alumni-skl')
</body>
</html>