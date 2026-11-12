<style>
/* ==========================================================================
   KELENGKAPAN DOKUMEN — Gaya halaman
   Daftar isi:
   1. Variabel          5. Kartu KPI            9. Panel detail siswa
   2. Dasar & tombol    6. Ringkasan arsip     10. Dialog, dropdown, toast
   3. Header            7. Filter              11. Animasi masuk
   4. Judul halaman     8. Tabel siswa         12. Responsif & cetak
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
.btn.off{opacity:.45;pointer-events:none}
.icobtn{width:38px;height:38px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--mu);display:grid;place-items:center;cursor:pointer;text-decoration:none;transition:.35s var(--ease)}
.icobtn:hover{background:var(--soft);color:var(--tx);transform:rotate(25deg)}
.mini{padding:7px 12px;border-radius:9px;border:1px solid var(--line);background:#fff;font:600 11.5px Inter,sans-serif;cursor:pointer;color:var(--tx);text-decoration:none}
.tag{display:inline-block;padding:4px 10px;border-radius:99px;font-size:10.5px;font-weight:700}
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
.head{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap;margin-bottom:18px}
.head h1{font-size:30px;font-weight:800;letter-spacing:-.025em;display:flex;align-items:center;gap:12px;flex-wrap:wrap;line-height:1.15}
.ttl{background:linear-gradient(100deg,var(--tx) 42%,#12935f 50%,var(--tx) 58%);background-size:260% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;animation:shine 2.6s .5s var(--ease) 1 both}
.head p{color:var(--mu);margin-top:9px;max-width:680px;line-height:1.65}
.head .ta{margin-top:10px}
.hact{display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap}
.flash{display:flex;gap:10px;align-items:center;padding:12px 16px;border-radius:12px;background:var(--mint);color:var(--dgreen);font-weight:600;margin-bottom:16px;border:1px solid rgba(15,122,79,.18)}
.flash.err{background:#fee2e2;color:#b91c1c;border-color:#fecaca}

/* 5. KARTU KPI ----------------------------------------------------------- */
.card{background:var(--card);border:1px solid var(--line);border-radius:var(--r);padding:20px;box-shadow:var(--shadow)}
.kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(185px,1fr));gap:14px;margin-bottom:12px}
.kpi{position:relative;overflow:hidden;padding:18px 20px;transition:transform .45s var(--ease),box-shadow .45s var(--ease)}
.kpi:hover{transform:translateY(-4px);box-shadow:var(--shadow-up)}
.kpi::after{content:"";position:absolute;right:-34px;bottom:-34px;width:130px;height:130px;border-radius:50%;background:var(--t);opacity:.09;transition:transform .8s var(--ease)}
.kpi:hover::after{transform:scale(1.35)}
.kpi .l{display:block;max-width:105px;font-size:11px;font-weight:700;letter-spacing:.04em;color:var(--t);line-height:1.35}
.kpi .ico{position:absolute;right:16px;top:16px;width:36px;height:36px;border-radius:50%;display:grid;place-items:center;background:var(--t2);color:var(--t)}
.kpi .ico svg{width:18px;height:18px}
.kpi strong{display:flex;align-items:baseline;gap:7px;font-size:34px;font-weight:800;letter-spacing:-.025em;margin:14px 0 2px;color:var(--tx);font-variant-numeric:tabular-nums}
.kpi strong small{font-size:13px;font-weight:600;color:var(--mu);letter-spacing:0}
.kpi strong em{font-style:normal;font-size:12.5px;font-weight:600;color:var(--t);letter-spacing:0}
.kpi .n{position:relative;z-index:1;font-size:11px;margin-top:10px;color:var(--mu);line-height:1.5}
.info{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;color:var(--mu);font-size:11px;margin-bottom:16px}
.info span{display:inline-flex;gap:6px;align-items:center}

/* 6. RINGKASAN ARSIP ----------------------------------------------------- */
.rk{margin-bottom:18px}
.rk-h{display:flex;justify-content:space-between;gap:20px;align-items:flex-start;flex-wrap:wrap;margin-bottom:18px}
.rk-h h2{display:flex;gap:9px;align-items:center;font-size:17px;font-weight:700}
.rk-h h2 svg{color:var(--green)}
.rk-h p{color:var(--mu);margin-top:8px;max-width:620px;line-height:1.65}
.rk-h p b{color:var(--tx)}
.rk-big{display:flex;align-items:center;gap:12px;padding:12px 18px;border-radius:14px;background:var(--soft)}
.rk-big strong{font-size:38px;font-weight:800;color:var(--green);letter-spacing:-.03em;font-variant-numeric:tabular-nums}
.rk-big span{font-size:11px;color:var(--mu);font-weight:600;line-height:1.4;max-width:90px}
.seg{display:flex;height:13px;border-radius:99px;overflow:hidden;background:#eef2f7}
.seg i{display:block;height:100%;width:var(--w);transition:width 1.5s var(--ease) .35s}
.seg .c-lengkap{background:#0a6b45}.seg .c-menunggu{background:#2563eb}.seg .c-belum{background:#d97706}.seg .c-revisi{background:#dc2626}
.lg{display:flex;gap:20px;flex-wrap:wrap;margin:12px 0 18px;font-size:11px;color:var(--mu)}
.lg span{display:inline-flex;align-items:center;gap:6px}.lg i{width:9px;height:9px;border-radius:50%}
.minis{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px}
.mi{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:14px 16px;border-radius:13px;border:1px solid transparent;transition:transform .4s var(--ease),box-shadow .4s var(--ease)}
.mi:hover{transform:translateY(-3px);box-shadow:0 12px 24px rgba(11,31,58,.09)}
.mi small{display:block;font-size:11px;font-weight:600;margin-bottom:4px}.mi b{font-size:18px;font-weight:800}
.mi svg{width:22px;height:22px}
.mi.k1{background:#eef2fb;color:#1e3a8a}.mi.k2{background:#fff7e6;color:#b45309;border-color:#fde9c3}
.mi.k3{background:#e8f0ff;color:#1d4ed8}.mi.k4{background:#fdecec;color:#b91c1c}

/* 7. FILTER -------------------------------------------------------------- */
.flt{margin-bottom:18px}
.tabs{display:inline-flex;gap:4px;padding:4px;border-radius:12px;background:var(--soft);margin-bottom:14px;flex-wrap:wrap}
.tabs a{padding:9px 16px;border-radius:9px;font-size:11.5px;font-weight:600;color:var(--mu);text-decoration:none;white-space:nowrap;transition:.3s var(--ease)}
.tabs a:hover{color:var(--tx)}.tabs a.on{background:var(--navy);color:#fff;box-shadow:0 4px 12px rgba(11,31,58,.25)}
.quick{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:14px;font-size:11px;color:var(--mu)}
.chip{display:inline-block;padding:5px 12px;border-radius:99px;border:1px solid var(--line);background:#fff;font-size:11px;font-weight:600;text-decoration:none;color:var(--mu);white-space:nowrap;transition:transform .3s var(--ease),box-shadow .3s}
.chip:hover{transform:translateY(-2px);box-shadow:0 6px 14px rgba(11,31,58,.1)}
.chip.amb{background:#fef3c7;border-color:#fde68a;color:#b45309}.chip.bl{background:#e0e9ff;border-color:#c7d7fb;color:#1d4ed8}
.chip.on{background:var(--navy);border-color:var(--navy);color:#fff}
.frow{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
.fsearch{flex:1;min-width:230px;display:flex;align-items:center;gap:9px;padding:11px 14px;border-radius:11px;background:var(--soft);border:1px solid transparent;color:var(--mu);transition:.3s var(--ease)}
.fsearch:focus-within{background:#fff;border-color:var(--green);box-shadow:0 0 0 4px rgba(15,122,79,.1)}
.fsearch input{flex:1;border:0;outline:0;background:none;font:inherit;color:var(--tx);min-width:0}
.fsearch kbd{font:600 10px Inter,sans-serif;background:#dfe6f2;color:var(--mu);border-radius:5px;padding:2px 6px}
.frow select{padding:11px 12px;border:1px solid var(--line);border-radius:10px;background:#fff;font:500 12px Inter,sans-serif;color:var(--tx);min-width:150px}

/* 8. TABEL SISWA --------------------------------------------------------- */
.layout{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:18px;align-items:start}
.tb{padding:0;overflow:hidden}
.tb-h{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:18px 20px}
.tb-h h2{font-size:16px;font-weight:700;display:flex;gap:10px;align-items:center;flex-wrap:wrap}
.scroll{overflow-x:auto}
.tbl{width:100%;border-collapse:collapse;min-width:880px}
.tbl th{text-align:left;font-size:10.5px;letter-spacing:.04em;color:var(--mu);padding:12px 10px;background:#f7f9fc;border-bottom:1px solid var(--line);white-space:nowrap}
.tbl th.c,.tbl td.c{text-align:center}
.tbl td{padding:13px 10px;border-bottom:1px solid var(--line);vertical-align:middle;font-size:12px}
.tbl tbody tr{cursor:pointer;transition:background .2s}
.tbl tbody tr:hover{background:#f8fafc}.tbl tbody tr.act{background:#f0f6ff;box-shadow:inset 3px 0 0 var(--green)}
.tbl .no{color:var(--mu);width:38px}
.idn{display:flex;align-items:center;gap:11px;min-width:190px}
.idn img{width:38px;height:38px;border-radius:50%;object-fit:cover;background:#dbe4f3;flex:none}
.idn b{display:block;font-size:12.5px}.idn small{color:var(--mu);font-size:11px;margin-right:6px}
.idn em{font-style:normal;font-size:10px;font-weight:700;background:#e8eefb;color:#334e8a;border-radius:6px;padding:2px 7px}
.mp{min-width:110px}.mp b{display:block;font-size:11.5px;margin-bottom:6px}
.track{height:6px;background:#e3e9f2;border-radius:9px;overflow:hidden}
.track i{display:block;height:100%;width:var(--w);border-radius:9px;transition:width 1.3s var(--ease) .4s}
.track .lengkap{background:var(--green)}.track .menunggu{background:var(--blue)}.track .belum{background:var(--amber)}.track .revisi{background:var(--red)}
.mk{display:inline-grid;place-items:center;width:24px;height:24px}
.mk svg{width:20px;height:20px}
.mk.sah{color:#16a34a}.mk.menunggu{color:var(--blue)}.mk.revisi{color:var(--red)}.mk.kosong{color:#c4cbd6}
.st{display:inline-flex;align-items:center;gap:6px;padding:5px 11px;border-radius:99px;font-size:10.8px;font-weight:700;white-space:nowrap}
.st::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor}
.st.lengkap{background:var(--mint);color:var(--dgreen)}.st.menunggu{background:#dbeafe;color:#1d4ed8}
.st.belum{background:#fef3c7;color:#b45309}.st.revisi{background:#fee2e2;color:#b91c1c}
.aks{display:flex;gap:4px}
.aks a{width:30px;height:30px;border-radius:8px;display:grid;place-items:center;color:var(--mu);text-decoration:none;transition:.3s var(--ease)}
.aks a:hover{background:var(--soft);color:var(--tx);transform:translateY(-2px)}
.empty{text-align:center;padding:50px 12px;color:var(--mu);line-height:1.7}.empty b{display:block;color:var(--tx);font-size:14px;margin-bottom:4px}
.pg{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;padding:14px 20px;color:var(--mu);font-size:11.5px;border-top:1px solid var(--line)}
.pg select{padding:6px 8px;border:1px solid var(--line);border-radius:8px;font:inherit;margin-left:6px;color:var(--tx)}
.pgn{display:flex;gap:6px;align-items:center}
.pgn a,.pgn span{min-width:30px;height:30px;border-radius:8px;display:grid;place-items:center;text-decoration:none;font-weight:600;color:var(--mu);border:1px solid var(--line);padding:0 9px;transition:.3s var(--ease)}
.pgn a:hover{background:var(--soft)}.pgn a.on{background:var(--navy);border-color:var(--navy);color:#fff}.pgn span{border:0}.pgn .dis{opacity:.4;pointer-events:none}

/* 9. PANEL DETAIL SISWA -------------------------------------------------- */
.dp{padding:18px}
.dp.swap>*{animation:panelIn .55s var(--ease) both}
.dp.swap>*:nth-child(2){animation-delay:.05s}.dp.swap>*:nth-child(3){animation-delay:.1s}
.dp.swap>*:nth-child(4){animation-delay:.15s}.dp.swap>*:nth-child(5){animation-delay:.2s}
.dh{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:14px}
.dh .t{display:flex;gap:8px;align-items:center;font-size:10.5px;font-weight:700;letter-spacing:.04em;color:#334e8a;line-height:1.3}
.dh .tag.lengkap{background:var(--mint);color:var(--dgreen)}.dh .tag.menunggu{background:#dbeafe;color:#1d4ed8}
.dh .tag.belum{background:#fef3c7;color:#b45309}.dh .tag.revisi{background:#fee2e2;color:#b91c1c}
.dc{display:flex;gap:14px;align-items:center;padding:14px;border-radius:13px;background:#f6f8fc;margin-bottom:14px}
.dc img{width:60px;height:60px;border-radius:14px;object-fit:cover;background:#dbe4f3;box-shadow:0 6px 16px rgba(11,31,58,.15);flex:none}
.dc b{font-size:15px}.dc em{font-style:normal;font-size:10px;font-weight:700;background:#e8eefb;color:#334e8a;border-radius:6px;padding:3px 8px;float:right}
.dc small{display:block;color:var(--mu);font-size:11.5px;margin-top:4px;line-height:1.5}.dc small b{color:var(--tx);font-size:11.5px}
.dc .ak{color:var(--dgreen);font-weight:600}
.dpct{display:flex;justify-content:space-between;align-items:baseline;margin:6px 0 8px;font-size:11.5px;color:var(--mu)}.dpct b{font-size:15px;color:var(--green)}
.dcnt{display:flex;gap:12px;flex-wrap:wrap;margin:9px 0 16px;font-size:11px;font-weight:700}
.dcnt .a{color:#16a34a}.dcnt .b{color:var(--blue)}.dcnt .c{color:var(--amber)}.dcnt .d{color:var(--red)}
.dl{font-size:10.5px;font-weight:700;letter-spacing:.04em;color:var(--mu);margin-bottom:8px}
.cls{list-style:none;display:grid;gap:7px;margin-bottom:14px}
.cl{display:flex;align-items:center;gap:11px;padding:11px 12px;border-radius:12px;background:#f6f8fc;transition:transform .35s var(--ease),background .25s}
.cl:hover{transform:translateX(3px)}
.cl.menunggu{background:#e8f0ff}
.cli{flex:none;width:22px;height:22px;display:grid;place-items:center}.cli svg{width:21px;height:21px}
.cl.sah .cli{color:#16a34a}.cl.menunggu .cli{color:var(--blue)}.cl.revisi .cli{color:var(--red)}.cl.kosong .cli{color:#b6bfcc}
.cl .tx{flex:1;min-width:0}.cl .tx b{display:block;font-size:12px}.cl .tx small{display:block;color:var(--mu);font-size:10.5px;margin-top:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.cl.kosong .tx small{color:var(--amber)}.cl.revisi .tx small{color:var(--red)}
.cl .ac{flex:none}
.cl .ac a,.cl .ac button{display:inline-block;padding:5px 10px;border-radius:8px;border:0;font:600 11px Inter,sans-serif;text-decoration:none;cursor:pointer;color:var(--green);background:transparent;transition:.3s}
.cl .ac a:hover{background:#e3efe8}
.cl .ac .pk{background:var(--navy);color:#fff}.cl .ac .pk:hover{background:var(--green)}
.cl .ac .up{background:#e8eefb;color:#334e8a}.cl .ac .up:hover{background:#d6e0f7}
.rv-box{padding:14px;border-radius:13px;border:1px solid var(--line);background:#fff;margin-bottom:12px}
.rv-box h4{display:flex;justify-content:space-between;gap:8px;font-size:12.5px;margin-bottom:10px}.rv-box h4 small{color:var(--mu);font-weight:500;font-size:10.5px;text-align:right}
.rv-file{display:flex;justify-content:space-between;align-items:center;gap:8px;padding:9px 11px;border-radius:9px;background:var(--soft);font-size:11px;margin-bottom:10px}
.rv-file span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:flex;gap:7px;align-items:center}
.rv-file a{font-weight:700;color:var(--green);text-decoration:none;flex:none}
.rd2{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin-bottom:10px}
.rd2 label{display:flex;align-items:center;gap:7px;padding:9px 10px;border-radius:9px;border:1px solid var(--line);font-size:11.5px;font-weight:600;cursor:pointer;transition:.25s}
.rd2 label:has(input:checked){border-color:var(--green);background:#ecfaf3;color:var(--dgreen)}
.rd2 label.no:has(input:checked){border-color:var(--red);background:#fdecec;color:#b91c1c}
.rv-box textarea{width:100%;min-height:62px;padding:10px;border-radius:9px;border:1px solid var(--line);background:#f8fafc;font:11.5px Inter,sans-serif;resize:vertical;margin-bottom:10px;color:var(--tx)}
.rv-box textarea:focus{outline:0;border-color:var(--green);background:#fff}
.rv-box .btn{width:100%}
.rv-none{padding:14px;border-radius:12px;background:#f6f8fc;color:var(--mu);font-size:11.5px;line-height:1.6;margin-bottom:12px;text-align:center}
.dact{display:grid;gap:9px}
.dact .btn{width:100%}
.dlink{display:flex;justify-content:space-between;gap:10px;margin-top:6px;font-size:11px;font-weight:600}
.dlink a{display:inline-flex;gap:6px;align-items:center;text-decoration:none;color:var(--mu);transition:.25s}.dlink a:hover{color:var(--tx)}
.dlink a.wa{color:#b45309}.dlink a.off{opacity:.4;pointer-events:none}

/* 10. DIALOG, DROPDOWN, TOAST -------------------------------------------- */
.dd{position:relative}
.dd summary{list-style:none}.dd summary::-webkit-details-marker{display:none}
.dd .menu{position:absolute;right:0;top:calc(100% + 8px);z-index:20;min-width:210px;background:#fff;border:1px solid var(--line);border-radius:13px;box-shadow:var(--shadow-up);padding:6px;animation:drop .35s var(--ease)}
.dd .menu a,.dd .menu button{display:flex;gap:9px;align-items:center;width:100%;padding:10px 12px;border:0;background:none;border-radius:9px;font:600 12px Inter,sans-serif;color:var(--tx);text-decoration:none;cursor:pointer;text-align:left}
.dd .menu a:hover,.dd .menu button:hover{background:var(--soft)}
dialog{margin:auto;border:0;border-radius:18px;padding:26px;width:min(560px,92vw);max-height:86vh;overflow:auto;box-shadow:0 30px 80px rgba(11,31,58,.3);color:var(--tx)}
dialog[open]{animation:pop .5s var(--ease)}
dialog::backdrop{background:rgba(11,31,58,.5);backdrop-filter:blur(5px)}
dialog h3{font-size:18px;margin-bottom:6px}dialog>p{color:var(--mu);line-height:1.6;margin-bottom:12px}
dialog ul.pl{padding-left:18px;display:grid;gap:8px;line-height:1.6;margin-bottom:18px}
dialog .end{display:flex;justify-content:flex-end}
.pgl{list-style:none;display:grid;gap:8px;margin:14px 0 18px}
.pgl li{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:10px 12px;border-radius:11px;background:#f6f8fc}
.pgl b{display:block;font-size:12.5px}.pgl small{color:var(--mu);font-size:11px}
.toast{position:fixed;right:24px;bottom:24px;z-index:50;max-width:340px;padding:13px 16px;border-radius:13px;background:var(--navy);color:#fff;font-weight:500;line-height:1.5;box-shadow:var(--shadow-up);transform:translateY(30px);opacity:0;pointer-events:none;transition:.5s var(--ease)}
.toast.show{transform:none;opacity:1}
.foot{display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;align-items:center;margin-top:22px;padding:14px 18px;border-radius:var(--r);background:#ecfaf3;color:var(--dgreen);font-size:11.5px;line-height:1.6}
.foot span:first-child{display:flex;gap:10px;align-items:center}.foot svg{width:20px;height:20px}.foot span:last-child{color:var(--mu);max-width:520px;text-align:right}

/* 11. ANIMASI MASUK ------------------------------------------------------ */
.js .rv{opacity:0;transform:translateY(24px) scale(.985);filter:blur(5px)}
.js .rv.in{opacity:1;transform:none;filter:none;transition:opacity 1s var(--ease),transform 1s var(--ease),filter 1s var(--ease);transition-delay:var(--d,0ms)}
.js .seg i,.js .tb .track i{width:0}
.js .rk.in .seg i,.js .tb.in .track i{width:var(--w)}
.js .tb tbody tr{opacity:0;transform:translateX(-14px)}
.js .tb.in tbody tr{opacity:1;transform:none;transition:opacity .7s var(--ease),transform .7s var(--ease);transition-delay:calc(400ms + var(--i,0)*70ms)}
.js .tb .mk{opacity:0;transform:scale(.3) rotate(-30deg)}
.js .tb.in .mk{opacity:1;transform:none;transition:opacity .6s var(--ease),transform .7s cubic-bezier(.34,1.56,.64,1);transition-delay:calc(650ms + var(--i,0)*70ms + var(--c,0)*55ms)}
@keyframes shine{from{background-position:100% 0}to{background-position:0 0}}
@keyframes pop{from{opacity:0;transform:translateY(12px) scale(.96)}}
@keyframes drop{from{opacity:0;transform:translateY(-8px) scaleY(.92)}}
@keyframes panelIn{from{opacity:0;transform:translateX(18px)}}

/* 12. RESPONSIF & CETAK -------------------------------------------------- */
@media(max-width:1200px){.layout{grid-template-columns:1fr}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.search,.pill{display:none}}
@media(max-width:640px){.wrap{padding:14px}.head h1{font-size:23px}.rk-big strong{font-size:30px}}
@media(prefers-reduced-motion:reduce){
  *,*::before,*::after{animation:none!important;transition:none!important}
  .js .rv,.js .tb tbody tr,.js .tb .mk{opacity:1;transform:none;filter:none}
  .js .seg i,.js .tb .track i{width:var(--w)}
}
@media print{
  .side,.top,.hact,.flt,.dp,.pg,.foot,.aks,.toast{display:none!important}
  .main{margin:0}.layout{display:block}.js .rv,.js .tb tbody tr,.js .tb .mk{opacity:1!important;transform:none!important;filter:none!important}
  .js .seg i,.js .tb .track i{width:var(--w)!important}
  body{background:#fff}.card{box-shadow:none}
}
</style>