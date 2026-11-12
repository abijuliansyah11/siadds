<style>
/* ==========================================================================
   CETAK LABEL QR CODE — Gaya halaman
   Daftar isi:
   1. Variabel           6. Filter & chip            11. Riwayat
   2. Dasar & tombol     7. Bar pilihan              12. Dialog & toast
   3. Header             8. Tabel arsip              13. Animasi masuk
   4. Judul halaman      9. Panel pengaturan         14. Area cetak
   5. Kartu KPI         10. Stiker & lembar A4       15. Responsif & cetak
   ========================================================================== */

/* 1. VARIABEL ------------------------------------------------------------ */
:root{
  --navy:#0b1f3a;--navy2:#142d4e;--green:#0f7a4f;--green2:#12935f;--dgreen:#0a5c3b;--mint:#d9f5e8;
  --bg:#f3f5f9;--card:#fff;--line:#e5e9f0;--soft:#eef2fb;
  --tx:#0f1b2d;--mu:#64748b;--red:#dc2626;--amber:#d97706;--blue:#2563eb;
  --r:16px;
  --shadow:0 1px 2px rgba(11,31,58,.04),0 10px 28px rgba(11,31,58,.05);
  --shadow-up:0 2px 4px rgba(11,31,58,.05),0 22px 44px rgba(11,31,58,.11);
  --ease:cubic-bezier(.16,1,.3,1);
}

/* 2. DASAR & TOMBOL ------------------------------------------------------ */
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Inter,Arial,sans-serif;color:var(--tx);font-size:13px;
  background:
    radial-gradient(900px 380px at 82% -90px,rgba(15,122,79,.09),transparent 70%),
    radial-gradient(700px 320px at 6% -70px,rgba(37,99,235,.07),transparent 70%),
    var(--bg)}
a{color:inherit}
button{font-family:inherit}
svg.i{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex:none}
:focus-visible{outline:2px solid var(--green);outline-offset:2px}
.main{margin-left:248px}
.wrap{padding:18px 28px 44px;max-width:1420px}
.mu{color:var(--mu)}

.btn{position:relative;overflow:hidden;display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 16px;border-radius:11px;border:1px solid var(--line);background:#fff;color:var(--tx);font:600 12.5px Inter,sans-serif;cursor:pointer;text-decoration:none;transition:transform .35s var(--ease),box-shadow .35s var(--ease),background .25s}
.btn:hover{transform:translateY(-2px);box-shadow:0 10px 22px rgba(11,31,58,.12)}
.btn:active{transform:translateY(0) scale(.98)}
.btn.g{background:linear-gradient(135deg,var(--green2),var(--green));border-color:var(--green);color:#fff}
.btn.g::after{content:"";position:absolute;inset:0;background:linear-gradient(110deg,transparent 30%,rgba(255,255,255,.35) 50%,transparent 70%);transform:translateX(-120%);transition:transform .8s var(--ease)}
.btn.g:hover::after{transform:translateX(120%)}
.btn.sm{padding:8px 12px;font-size:11.5px}
.btn.full{width:100%}
.btn[disabled]{opacity:.45;pointer-events:none}
.btn.dk{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.16);color:#e6eefb}
.btn.dk:hover{background:rgba(255,255,255,.14)}
.icobtn{width:38px;height:38px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--mu);display:grid;place-items:center;cursor:pointer;text-decoration:none;transition:.35s var(--ease)}
.icobtn:hover{background:var(--soft);color:var(--tx);transform:rotate(25deg)}
.tag{display:inline-flex;gap:6px;align-items:center;padding:4px 10px;border-radius:99px;font-size:10.5px;font-weight:700}
.tag.ok{background:var(--mint);color:var(--dgreen)}.tag.bl{background:#e8eefb;color:#334e8a}

/* 3. HEADER -------------------------------------------------------------- */
.top{position:sticky;top:0;z-index:10;display:flex;align-items:center;gap:12px;padding:12px 28px;background:rgba(255,255,255,.82);backdrop-filter:blur(14px) saturate(1.4);border-bottom:1px solid var(--line)}
.search{display:flex;align-items:center;gap:8px;padding:9px 12px;border:1px solid var(--line);border-radius:10px;width:250px;color:var(--mu);background:#fff;transition:.3s var(--ease)}
.search:focus-within{width:290px;border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
.search input{border:0;outline:0;background:none;width:100%;font:inherit;color:var(--tx)}
.pill{padding:6px 11px;border-radius:99px;background:var(--mint);color:var(--dgreen);font-weight:600;font-size:11.5px}
.pill.bl{background:#e8eefb;color:#334e8a}
.sp{flex:1}
.bell{position:relative;display:grid;place-items:center;width:36px;height:36px;border-radius:50%;color:var(--mu);text-decoration:none;transition:background .25s}
.bell:hover{background:var(--soft)}
.bell b{position:absolute;top:0;right:0;min-width:17px;height:17px;border-radius:99px;background:var(--red);color:#fff;font-size:10px;display:grid;place-items:center;padding:0 4px}
.user{display:flex;align-items:center;gap:10px}
.av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--green),var(--navy2));color:#fff;display:grid;place-items:center;font-weight:700}
.user small{display:block;color:var(--mu);font-size:11px}
.user form button{border:0;background:none;color:var(--red);font:600 12px Inter;cursor:pointer;padding:6px}

/* 4. JUDUL HALAMAN ------------------------------------------------------- */
.crumb{display:flex;gap:8px;color:var(--mu);font-size:11.5px;margin-bottom:10px}.crumb b{color:var(--tx);font-weight:600}
.head{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap;margin-bottom:20px}
.head h1{font-size:30px;font-weight:800;letter-spacing:-.025em;line-height:1.15;margin-bottom:10px}
.ttl{background:linear-gradient(100deg,var(--tx) 42%,#12935f 50%,var(--tx) 58%);background-size:260% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;animation:shine 2.6s .5s var(--ease) 1 both}
.head p{color:var(--mu);margin-top:11px;max-width:620px;line-height:1.65}
.hact{display:grid;grid-template-columns:1fr 1fr;gap:8px;align-content:start;min-width:330px}
.hact .btn:last-child{grid-column:1/-1}
.flash{display:flex;gap:10px;align-items:center;padding:12px 16px;border-radius:12px;background:var(--mint);color:var(--dgreen);font-weight:600;margin-bottom:16px;border:1px solid rgba(15,122,79,.18)}
.flash.err{background:#fee2e2;color:#b91c1c;border-color:#fecaca}

/* 5. KARTU KPI ----------------------------------------------------------- */
.card{background:var(--card);border:1px solid var(--line);border-radius:var(--r);padding:20px;box-shadow:var(--shadow)}
.kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px;margin-bottom:18px}
.kpi{position:relative;overflow:hidden;padding:18px 20px;transition:transform .45s var(--ease),box-shadow .45s var(--ease)}
.kpi:hover{transform:translateY(-4px);box-shadow:var(--shadow-up)}
.kpi::after{content:"";position:absolute;right:-34px;bottom:-34px;width:130px;height:130px;border-radius:50%;background:var(--t);opacity:.09;transition:transform .8s var(--ease)}
.kpi:hover::after{transform:scale(1.35)}
.kpi .l{display:block;max-width:130px;font-size:10.5px;font-weight:700;letter-spacing:.04em;color:var(--mu);line-height:1.4}
.kpi .ico{position:absolute;right:16px;top:16px;width:38px;height:38px;border-radius:11px;display:grid;place-items:center;background:var(--t2);color:var(--t)}
.kpi .ico svg{width:19px;height:19px}
.kpi strong{display:block;font-size:34px;font-weight:800;letter-spacing:-.025em;margin:12px 0 8px;color:var(--t);font-variant-numeric:tabular-nums}
.kpi .n{position:relative;z-index:1;display:flex;justify-content:space-between;gap:8px;flex-wrap:wrap;font-size:11px;color:var(--mu)}
.kpi .n span{display:inline-flex;gap:6px;align-items:center}
.kpi .n .al{color:var(--red);font-weight:600}.kpi .n .ok{color:var(--dgreen);font-weight:600}

/* 6. FILTER & CHIP ------------------------------------------------------- */
.work{display:grid;grid-template-columns:minmax(0,1fr) 400px;gap:18px;align-items:start;margin-bottom:18px}
.col{display:grid;gap:16px;min-width:0}
.frow{display:flex;gap:10px;align-items:center;margin-bottom:12px}
.fsearch{flex:1;display:flex;align-items:center;gap:9px;padding:11px 14px;border-radius:11px;background:var(--soft);border:1px solid transparent;color:var(--mu);transition:.3s var(--ease)}
.fsearch:focus-within{background:#fff;border-color:var(--green);box-shadow:0 0 0 4px rgba(15,122,79,.1)}
.fsearch input{flex:1;border:0;outline:0;background:none;font:inherit;color:var(--tx);min-width:0}
.fsearch kbd{font:600 10px Inter,sans-serif;background:#dfe6f2;color:var(--mu);border-radius:5px;padding:2px 6px}
.sels{display:grid;grid-template-columns:repeat(auto-fit,minmax(130px,1fr));gap:10px;margin-bottom:12px}
.sels label{display:block;font-size:10.5px;font-weight:600;color:var(--mu)}
.sels select{width:100%;margin-top:5px;padding:10px 11px;border:1px solid var(--line);border-radius:10px;background:#fff;font:500 12px Inter,sans-serif;color:var(--tx)}
.quick{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
.chip{display:inline-block;padding:5px 12px;border-radius:99px;border:1px solid var(--line);background:#fff;font-size:11px;font-weight:600;text-decoration:none;color:var(--mu);white-space:nowrap;transition:transform .3s var(--ease),box-shadow .3s}
.chip:hover{transform:translateY(-2px);box-shadow:0 6px 14px rgba(11,31,58,.1)}
.chip.on{background:var(--navy);border-color:var(--navy);color:#fff}
.chip.bl{background:#e0e9ff;border-color:#c7d7fb;color:#1d4ed8}.chip.rd{background:#fee2e2;border-color:#fecaca;color:#b91c1c}
.chip.on.bl,.chip.on.rd{background:var(--navy);border-color:var(--navy);color:#fff}
.chip.ghost{border-color:transparent;background:none}

/* 7. BAR PILIHAN --------------------------------------------------------- */
.pick{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;padding:16px 20px;border-radius:var(--r);background:linear-gradient(135deg,#0b1f3a,#10294a 65%,#0e3a37);color:#d6e2f2;box-shadow:var(--shadow-up);animation:slideDown .6s var(--ease)}
.pick[hidden]{display:none}
.pick .pt{display:flex;gap:12px;align-items:center}
.pick .nb{width:30px;height:30px;border-radius:9px;background:var(--green);color:#fff;display:grid;place-items:center;font-weight:800}
.pick b{color:#fff;font-size:14px}.pick small{color:#9fb4cf;margin-left:6px}
.pick .ac{display:flex;gap:8px;flex-wrap:wrap}
.pick .link{background:none;border:0;color:#9fb4cf;font:600 12px Inter,sans-serif;cursor:pointer;padding:10px 8px}
.pick .link:hover{color:#fff}

/* 8. TABEL ARSIP --------------------------------------------------------- */
.tb{padding:0;overflow:hidden}
.scroll{overflow-x:auto}
.tbl{width:100%;border-collapse:collapse;min-width:640px}
.tbl th{text-align:left;font-size:10.5px;letter-spacing:.04em;color:var(--mu);padding:12px 10px;background:#f7f9fc;border-bottom:1px solid var(--line);white-space:nowrap}
.tbl td{padding:14px 10px;border-bottom:1px solid var(--line);vertical-align:middle;font-size:12px}
.tbl tbody tr{cursor:pointer;transition:background .2s}
.tbl tbody tr:hover{background:#f8fafc}.tbl tbody tr.sel{background:#ecfaf3}
.kd{font-weight:700;font-size:12px;white-space:nowrap}
.sw b{display:block;font-size:12.5px}.sw small{color:var(--mu);font-size:11px;line-height:1.5}
.kat{display:inline-block;padding:4px 9px;border-radius:7px;background:#e8eefb;color:#334e8a;font-size:10.5px;font-weight:600;line-height:1.35}
.lk{font-size:11px;line-height:1.5;color:#334155;min-width:130px}
.lk.no{color:var(--amber);font-weight:600}
.stl{display:inline-flex;gap:6px;align-items:center;padding:4px 10px;border-radius:99px;font-size:10.8px;font-weight:700;white-space:nowrap}
.stl::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor}
.stl.dibuat,.stl.selesai{background:var(--mint);color:var(--dgreen)}.stl.belum{background:#fef3c7;color:#b45309}.stl.siap{background:#dbeafe;color:#1d4ed8}
.empty{text-align:center;padding:50px 12px;color:var(--mu);line-height:1.7}.empty b{display:block;color:var(--tx);font-size:14px;margin-bottom:4px}
.pg{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;padding:14px 20px;color:var(--mu);font-size:11.5px;border-top:1px solid var(--line)}
.pg select{padding:6px 8px;border:1px solid var(--line);border-radius:8px;font:inherit;margin-left:6px;color:var(--tx)}
.pgn{display:flex;gap:6px;align-items:center}
.pgn a,.pgn span{min-width:30px;height:30px;border-radius:8px;display:grid;place-items:center;text-decoration:none;font-weight:600;color:var(--mu);border:1px solid var(--line);padding:0 9px;transition:.3s var(--ease)}
.pgn a:hover{background:var(--soft)}.pgn a.on{background:var(--green);border-color:var(--green);color:#fff}.pgn span{border:0}.pgn .dis{opacity:.4;pointer-events:none}

/* 9. PANEL PENGATURAN & PRATINJAU ---------------------------------------- */
.cfg{padding:18px}
.vt{display:flex;gap:4px;padding:4px;border-radius:12px;background:var(--soft);margin-bottom:16px}
.vt button{flex:1;display:flex;gap:7px;align-items:center;justify-content:center;padding:9px 6px;border:0;border-radius:9px;background:transparent;font:600 11px Inter,sans-serif;color:var(--mu);cursor:pointer;transition:.3s var(--ease)}
.vt button.on{background:#fff;color:var(--tx);box-shadow:0 2px 8px rgba(11,31,58,.1)}
.st-t{display:flex;justify-content:space-between;align-items:center;font-size:10.5px;font-weight:700;letter-spacing:.04em;color:var(--mu);margin:16px 0 9px}
.st-t:first-of-type{margin-top:0}.st-t em{font-style:normal;color:var(--dgreen);letter-spacing:0}
.tpl{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.tpl label{position:relative;display:block;padding:12px;border-radius:12px;border:1.5px solid var(--line);background:#fff;cursor:pointer;transition:.3s var(--ease)}
.tpl label:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(11,31,58,.08)}
.tpl input{position:absolute;opacity:0}
.tpl label:has(input:checked){border-color:var(--green);background:#ecfaf3}
.tpl b{display:flex;gap:6px;align-items:center;font-size:12px}.tpl small{display:block;margin-top:4px;color:var(--mu);font-size:10.5px;line-height:1.45}
.tpl label:has(input:checked) b svg{color:var(--green)}
.uk{display:flex;gap:7px;flex-wrap:wrap}
.uk label{padding:7px 12px;border-radius:99px;border:1px solid var(--line);background:#fff;font-size:11px;font-weight:600;color:var(--mu);cursor:pointer;transition:.3s var(--ease)}
.uk input{position:absolute;opacity:0}
.uk label:has(input:checked){background:var(--navy);border-color:var(--navy);color:#fff}
.kus{display:none;gap:8px;margin-top:9px;align-items:center;font-size:11px;color:var(--mu)}
.kus.on{display:flex;animation:pop .4s var(--ease)}
.kus input{width:70px;padding:8px;border:1px solid var(--line);border-radius:8px;font:12px Inter,sans-serif}
.kmp{display:grid;grid-template-columns:1fr 1fr;gap:8px;padding:12px;border-radius:12px;background:#f6f8fc}
.kmp label{display:flex;gap:8px;align-items:flex-start;font-size:11px;line-height:1.4;cursor:pointer}
.kmp input{accent-color:var(--green);margin-top:1px}
.pvh{display:flex;justify-content:space-between;align-items:center;margin:16px 0 9px}
.pvh .st-t{margin:0}
.zm{display:flex;gap:4px;align-items:center;font-size:11px;color:var(--mu)}
.zm button{width:26px;height:26px;border:1px solid var(--line);border-radius:7px;background:#fff;color:var(--mu);cursor:pointer;display:grid;place-items:center;transition:.25s}
.zm button:hover{background:var(--soft);color:var(--tx)}
.stage{position:relative;display:grid;place-items:center;min-height:230px;padding:22px 14px;border-radius:14px;background:radial-gradient(circle at 30% 20%,#e6eefb,#d9e5f6);overflow:hidden}
.stage .wrap-lb{transform-origin:center;transition:transform .5s var(--ease)}
.stage .badge{position:absolute;top:10px;left:50%;transform:translateX(-50%);padding:3px 10px;border-radius:99px;background:var(--navy);color:#fff;font-size:9.5px;font-weight:700;white-space:nowrap}
.stage.a4{place-items:start center;padding:14px;min-height:0}
.stage.a4 .badge{display:none}
.nav2{display:flex;justify-content:space-between;align-items:center;margin-top:9px;font-size:11px;color:var(--mu)}
.nav2 div{display:flex;gap:6px}
.nav2 button{padding:5px 11px;border-radius:8px;border:1px solid var(--line);background:#fff;font:600 11px Inter,sans-serif;color:var(--mu);cursor:pointer}
.nav2 button:hover{background:var(--soft)}.nav2 button:disabled{opacity:.4;cursor:default}
.fmt{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:16px}
.fmt label,.fld label{display:block;font-size:10.5px;font-weight:600;color:var(--mu)}
.fmt select,.fmt input{width:100%;margin-top:5px;padding:10px 11px;border:1px solid var(--line);border-radius:10px;background:#fff;font:500 12px Inter,sans-serif;color:var(--tx)}
.acts{display:grid;gap:8px;margin-top:16px}
.acts .two{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.acts .btn.big{padding:13px 16px;font-size:13px}
.catat{margin-top:10px;font-size:10.5px;line-height:1.55;color:var(--mu)}

/* 10. STIKER & LEMBAR A4 -------------------------------------------------
   Ukuran memakai milimeter lewat variabel --w dan --h (satuan mm).
   Semua huruf & QR ikut membesar/mengecil mengikuti tinggi stiker (--u). */
.lb{--u:calc(var(--h)*.1mm);position:relative;box-sizing:border-box;flex:none;width:calc(var(--w)*1mm);height:calc(var(--h)*1mm);padding:calc(var(--u)*.55);display:flex;gap:calc(var(--u)*.6);align-items:center;background:#fff;color:#000;overflow:hidden;font-family:Inter,Arial,sans-serif;line-height:1.25}
.lb.cut{outline:.25mm dashed #555;outline-offset:-.25mm}
.lb.kosong{visibility:hidden}
.lb .q{flex:none;width:calc(var(--h)*.72mm);height:calc(var(--h)*.72mm);background:#fff}
.lb .q img,.lb .q canvas{width:100%!important;height:100%!important;display:block}
.lb .tx{flex:1;min-width:0}
.lb .hd{display:flex;gap:calc(var(--u)*.4);align-items:center;margin-bottom:calc(var(--u)*.3)}
.lb .hd img{height:calc(var(--u)*1.5);width:auto;flex:none}
.lb .hd b{display:block;font-size:calc(var(--u)*.6);line-height:1.15}.lb .hd small{display:block;font-size:calc(var(--u)*.46);color:#444}
.lb .kd{display:block;font-size:calc(var(--u)*.95);font-weight:800;margin:calc(var(--u)*.15) 0}
.lb .dk{display:block;font-size:calc(var(--u)*.68);font-weight:600}
.lb .ln{display:block;font-size:calc(var(--u)*.55);color:#333;margin-top:calc(var(--u)*.2)}
.lb.t-vertikal{flex-direction:column;justify-content:center;text-align:center;gap:calc(var(--u)*.35)}
.lb.t-vertikal .q{width:calc(var(--h)*.5mm);height:calc(var(--h)*.5mm)}
.lb.t-vertikal .hd{justify-content:center}
.lb.t-map .q{width:calc(var(--h)*.64mm);height:calc(var(--h)*.64mm)}
.lb.t-map .kd{font-size:calc(var(--u)*1.05)}
.lb.t-kop{flex-direction:column;align-items:stretch;justify-content:flex-start;gap:calc(var(--u)*.4)}
.lb.t-kop .hd{padding-bottom:calc(var(--u)*.35);border-bottom:.2mm solid #000;margin:0}
.lb.t-kop .hd b{font-size:calc(var(--u)*.66)}
.lb.t-kop .row{display:flex;gap:calc(var(--u)*.6);align-items:center;flex:1;min-height:0}
.lb.t-kop .q{width:calc(var(--h)*.5mm);height:calc(var(--h)*.5mm)}
.pv-mini{display:flex;flex-wrap:wrap;gap:0}
.lembar{position:relative;box-sizing:border-box;background:#fff;box-shadow:0 8px 30px rgba(11,31,58,.18);width:210mm;height:297mm;padding:8mm;display:grid;align-content:start;justify-content:start}
.lembar.penuh .lb.kosong{visibility:visible;outline:.25mm dashed #b8c4d8;outline-offset:-.25mm;background:#f6f8fc}

/* 11. RIWAYAT ------------------------------------------------------------ */
.riw{padding:0;overflow:hidden}
.riw-h{display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;padding:20px}
.riw-h h2{display:flex;gap:10px;align-items:center;font-size:17px;font-weight:700}.riw-h h2 svg{color:var(--green);width:20px;height:20px}
.riw-h .ra{display:flex;gap:8px}
.dd{position:relative}
.dd summary{list-style:none}.dd summary::-webkit-details-marker{display:none}
.dd .menu{position:absolute;right:0;top:calc(100% + 8px);z-index:20;min-width:190px;background:#fff;border:1px solid var(--line);border-radius:13px;box-shadow:var(--shadow-up);padding:6px;animation:drop .35s var(--ease)}
.dd .menu a{display:block;padding:10px 12px;border-radius:9px;font:600 12px Inter,sans-serif;color:var(--tx);text-decoration:none}
.dd .menu a:hover,.dd .menu a.on{background:var(--soft)}
.tbl.riwayat{min-width:900px}
.op{display:inline-flex;gap:8px;align-items:center}
.op i{width:24px;height:24px;border-radius:50%;background:#dcefe6;color:var(--dgreen);display:grid;place-items:center;font:800 9px Inter,sans-serif;font-style:normal}
.tbl .kode a{color:var(--dgreen);font-weight:700;text-decoration:none}.tbl .kode a:hover{text-decoration:underline}
.tbl .wk{color:var(--mu);line-height:1.5}
.sr{display:inline-flex;gap:6px;align-items:center;padding:4px 10px;border-radius:99px;font-size:10.8px;font-weight:700;white-space:nowrap}
.sr::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor}
.sr.selesai{background:var(--mint);color:var(--dgreen)}.sr.siap{background:#dbeafe;color:#1d4ed8}.sr.dibuat{background:#e8eefb;color:#334e8a}
.aman{display:flex;gap:16px;align-items:flex-start;margin-top:22px;padding:20px 22px;border-radius:var(--r);background:#eaf1fc;color:#334e8a;line-height:1.7;font-size:12px}
.aman>svg{width:38px;height:38px;padding:9px;border-radius:11px;background:#dbe6f8;flex:none}
.aman b{display:block;color:var(--tx);font-size:14px;margin-bottom:5px}.aman strong{color:var(--tx)}

/* 12. DIALOG & TOAST ----------------------------------------------------- */
dialog{margin:auto;border:0;border-radius:18px;padding:26px;width:min(560px,92vw);max-height:88vh;overflow:auto;box-shadow:0 30px 80px rgba(11,31,58,.3);color:var(--tx)}
dialog[open]{animation:pop .5s var(--ease)}
dialog::backdrop{background:rgba(11,31,58,.5);backdrop-filter:blur(5px)}
dialog h3{font-size:18px;margin-bottom:6px}dialog>p{color:var(--mu);line-height:1.6;margin-bottom:12px}
dialog ul.pl{padding-left:18px;display:grid;gap:8px;line-height:1.6;margin-bottom:16px}
dialog .end{display:flex;justify-content:flex-end;gap:8px}
.toast{position:fixed;right:24px;bottom:24px;z-index:50;max-width:340px;padding:13px 16px;border-radius:13px;background:var(--navy);color:#fff;font-weight:500;line-height:1.5;box-shadow:var(--shadow-up);transform:translateY(30px);opacity:0;pointer-events:none;transition:.5s var(--ease)}
.toast.show{transform:none;opacity:1}

/* 13. ANIMASI MASUK ------------------------------------------------------ */
.js .rv{opacity:0;transform:translateY(24px) scale(.985);filter:blur(5px)}
.js .rv.in{opacity:1;transform:none;filter:none;transition:opacity 1s var(--ease),transform 1s var(--ease),filter 1s var(--ease);transition-delay:var(--d,0ms)}
.js .tb tbody tr,.js .riw tbody tr{opacity:0;transform:translateX(-14px)}
.js .tb.in tbody tr,.js .riw.in tbody tr{opacity:1;transform:none;transition:opacity .7s var(--ease),transform .7s var(--ease);transition-delay:calc(400ms + var(--i,0)*70ms)}
.js .tpl label,.js .uk label{opacity:0;transform:translateY(8px)}
.js .cfg.in .tpl label,.js .cfg.in .uk label{opacity:1;transform:none;transition:opacity .6s var(--ease),transform .6s var(--ease);transition-delay:calc(350ms + var(--i,0)*70ms)}
@keyframes shine{from{background-position:100% 0}to{background-position:0 0}}
@keyframes pop{from{opacity:0;transform:translateY(12px) scale(.96)}}
@keyframes drop{from{opacity:0;transform:translateY(-8px) scaleY(.92)}}
@keyframes slideDown{from{opacity:0;transform:translateY(-16px) scale(.98)}}
@keyframes swapLb{from{opacity:0;transform:scale(.94) rotate(-1deg)}}
.swaplb{animation:swapLb .5s var(--ease)}

/* 14. AREA CETAK --------------------------------------------------------- */
#areaCetak{display:none}
#areaCetak .lembar{box-shadow:none;page-break-after:always;break-after:page}
#areaCetak .lembar:last-child{page-break-after:auto;break-after:auto}
#areaCetak .roll{page-break-after:always;break-after:page}#areaCetak .roll:last-child{page-break-after:auto;break-after:auto}

/* 15. RESPONSIF & CETAK -------------------------------------------------- */
@media(max-width:1280px){.work{grid-template-columns:1fr}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.search,.pill{display:none}.hact{min-width:0;width:100%}}
@media(max-width:640px){.wrap{padding:14px}.head h1{font-size:23px}.tpl,.kmp,.fmt{grid-template-columns:1fr}}
@media(prefers-reduced-motion:reduce){
  *,*::before,*::after{animation:none!important;transition:none!important}
  .js .rv,.js .tb tbody tr,.js .riw tbody tr,.js .tpl label,.js .uk label{opacity:1;transform:none;filter:none}
}
@media print{
  body.cetak-label{background:#fff}
  body.cetak-label>*:not(#areaCetak){display:none!important}
  body.cetak-label #areaCetak{display:block!important}
}
</style>