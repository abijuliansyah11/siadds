<style>
/* ==========================================================================
   LOKASI ARSIP FISIK — Gaya halaman
   Daftar isi:
   1. Variabel           6. Hierarki repositori     11. Dialog & toast
   2. Dasar & tombol     7. Filter                  12. Banner SOP
   3. Header             8. Tabel arsip             13. Animasi masuk
   4. Judul halaman      9. Panel detail            14. Label cetak
   5. Kartu KPI         10. Form panel              15. Responsif & cetak
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
.btn.bl{background:#e0e9ff;border-color:#c7d7fb;color:#1d4ed8}
.btn.sm{padding:8px 12px;font-size:11.5px}
.btn.full{width:100%}
.btn.off{opacity:.45;pointer-events:none}
.icobtn{width:38px;height:38px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--mu);display:grid;place-items:center;cursor:pointer;text-decoration:none;transition:.35s var(--ease)}
.icobtn:hover{background:var(--soft);color:var(--tx);transform:rotate(25deg)}
.tag{display:inline-flex;gap:6px;align-items:center;padding:4px 10px;border-radius:99px;font-size:10.5px;font-weight:700}
.tag.ok{background:var(--mint);color:var(--dgreen)}.tag.bl{background:#e8eefb;color:#334e8a}
.tag.tersimpan{background:var(--mint);color:var(--dgreen)}.tag.dipinjam{background:#dbeafe;color:#1d4ed8}
.tag.antrean,.tag.belum{background:#fef3c7;color:#b45309}

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
.crumb{display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;color:var(--mu);font-size:11.5px;margin-bottom:12px}
.crumb nav{display:flex;gap:8px}.crumb b{color:var(--tx);font-weight:600}
.head{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap;margin-bottom:20px;padding:20px;border-radius:var(--r);background:#fff;border:1px solid var(--line);box-shadow:var(--shadow)}
.head .ic{width:42px;height:42px;border-radius:12px;background:#e8eefb;color:#334e8a;display:grid;place-items:center;flex:none}
.head .ic svg{width:21px;height:21px}
.head .tl{display:flex;gap:14px}
.head h1{font-size:28px;font-weight:800;letter-spacing:-.025em;line-height:1.15}
.ttl{background:linear-gradient(100deg,var(--tx) 42%,#12935f 50%,var(--tx) 58%);background-size:260% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;animation:shine 2.6s .5s var(--ease) 1 both}
.head .sub{font-size:10.5px;font-weight:700;letter-spacing:.05em;color:var(--mu);margin-top:5px}
.head p{color:var(--mu);margin-top:10px;max-width:660px;line-height:1.65}
.hact{display:grid;grid-template-columns:1fr 1fr;gap:8px;align-content:start;min-width:290px}
.hact .btn{width:100%}
.flash{display:flex;gap:10px;align-items:center;padding:12px 16px;border-radius:12px;background:var(--mint);color:var(--dgreen);font-weight:600;margin-bottom:16px;border:1px solid rgba(15,122,79,.18)}
.flash.err{background:#fee2e2;color:#b91c1c;border-color:#fecaca}

/* 5. KARTU KPI ----------------------------------------------------------- */
.card{background:var(--card);border:1px solid var(--line);border-radius:var(--r);padding:20px;box-shadow:var(--shadow)}
.kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px;margin-bottom:18px}
.kpi{position:relative;overflow:hidden;padding:18px 20px;transition:transform .45s var(--ease),box-shadow .45s var(--ease)}
.kpi:hover{transform:translateY(-4px);box-shadow:var(--shadow-up)}
.kpi::after{content:"";position:absolute;right:-34px;bottom:-34px;width:130px;height:130px;border-radius:50%;background:var(--t);opacity:.09;transition:transform .8s var(--ease)}
.kpi:hover::after{transform:scale(1.35)}
.kpi .l{display:block;max-width:130px;font-size:11px;font-weight:600;color:var(--mu);line-height:1.4}
.kpi .ico{position:absolute;right:16px;top:16px;width:38px;height:38px;border-radius:11px;display:grid;place-items:center;background:var(--t2);color:var(--t)}
.kpi .ico svg{width:19px;height:19px}
.kpi strong{display:flex;align-items:baseline;gap:7px;font-size:34px;font-weight:800;letter-spacing:-.025em;margin:12px 0 6px;color:var(--tx);font-variant-numeric:tabular-nums}
.kpi strong small{font-size:13px;font-weight:600;color:var(--mu);letter-spacing:0}
.kpi .n{position:relative;z-index:1;display:flex;justify-content:space-between;gap:8px;flex-wrap:wrap;font-size:11px;color:var(--mu);margin-top:10px}
.kpi .n span{display:inline-flex;gap:6px;align-items:center}
.kpi .n a{color:var(--blue);font-weight:600;text-decoration:none}.kpi .n a:hover{text-decoration:underline}
.kpi .n .al{padding:3px 8px;border-radius:7px;background:#fee2e2;color:#b91c1c;font-weight:600}
.kpi .n .ok{color:var(--dgreen);font-weight:600}.kpi .n .wr{color:var(--amber);font-weight:600}
.track{height:7px;background:#e3e9f2;border-radius:9px;overflow:hidden}
.track i{display:block;height:100%;width:var(--w);border-radius:9px;transition:width 1.4s var(--ease) .4s}
.track .stabil{background:var(--green)}.track .padat{background:var(--amber)}.track .kritis{background:var(--red)}

/* 6. HIERARKI REPOSITORI ------------------------------------------------- */
.hr{margin-bottom:18px}
.hr-h{display:flex;justify-content:space-between;gap:16px;flex-wrap:wrap;align-items:flex-start;margin-bottom:16px}
.hr-h h2{display:flex;gap:9px;align-items:center;font-size:16px;font-weight:700}.hr-h h2 svg{color:#334e8a}
.hr-h p{color:var(--mu);margin-top:6px;max-width:540px;line-height:1.6;font-size:12px}
.kep{display:flex;gap:16px;align-items:center;font-size:11px;color:var(--mu);flex-wrap:wrap}
.kep span{display:inline-flex;gap:6px;align-items:center}.kep i{width:8px;height:8px;border-radius:50%}
.rooms{display:grid;grid-template-columns:repeat(auto-fit,minmax(380px,1fr));gap:16px}
.room{padding:18px;border-radius:15px;background:#eef3fc;border:1px solid #e0e8f6}
.room-h{display:flex;justify-content:space-between;gap:10px;align-items:flex-start;margin-bottom:14px}
.room-h h3{display:flex;gap:9px;align-items:flex-start;font-size:15px;font-weight:700;line-height:1.35}.room-h h3 svg{color:#334e8a;margin-top:2px}
.room-h small{display:block;color:var(--mu);font-size:11px;font-weight:500;margin-top:3px;line-height:1.5}
.room-h .tag{background:#dbe5f7;color:#334e8a;white-space:nowrap}
.lm{padding:14px;border-radius:12px;background:#fff;border:1px solid var(--line);margin-bottom:10px;transition:transform .4s var(--ease),box-shadow .4s var(--ease)}
.lm:last-child{margin-bottom:0}
.lm:hover{transform:translateY(-3px);box-shadow:0 12px 24px rgba(11,31,58,.09)}
.lm-h{display:flex;justify-content:space-between;gap:10px;align-items:flex-start;margin-bottom:9px}
.lm-h b{display:flex;gap:7px;align-items:center;font-size:13px}.lm-h b::before{content:"";width:8px;height:8px;border-radius:50%;background:var(--c)}
.lm-h small{display:block;color:var(--mu);font-size:10.5px;margin-top:3px;font-weight:500;line-height:1.4}
.lm-h em{font-style:normal;font-weight:700;font-size:11px;color:var(--c);white-space:nowrap}
.lm .stabil,.lm.stabil{--c:var(--green)}.lm.padat{--c:var(--amber)}.lm.kritis{--c:var(--red)}
.raks{display:grid;grid-template-columns:repeat(4,1fr);gap:7px;margin-top:11px}
.rk{padding:7px 4px;border-radius:8px;background:#f1f5fb;font-size:10px;font-weight:600;color:var(--mu);text-align:center;transition:transform .3s var(--ease),background .25s}
.rk:hover{transform:translateY(-2px);background:#e4ecf8}
.rk.padat{background:#fff4e0;color:#b45309}.rk.kritis{background:#fde8e8;color:#b91c1c}
.hr-empty{padding:34px 12px;text-align:center;color:var(--mu);line-height:1.7;border-radius:14px;border:1.5px dashed #cdd8ea;background:#f8fafd}
.hr-empty b{display:block;color:var(--tx);font-size:14px;margin-bottom:4px}
.hr-empty .btn{margin:14px 5px 0}

/* 7. FILTER -------------------------------------------------------------- */
.flt{margin-bottom:18px}
.quick{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:14px;font-size:11px;color:var(--mu)}
.chip{display:inline-block;padding:5px 12px;border-radius:99px;border:1px solid var(--line);background:#fff;font-size:11px;font-weight:600;text-decoration:none;color:var(--mu);white-space:nowrap;transition:transform .3s var(--ease),box-shadow .3s}
.chip:hover{transform:translateY(-2px);box-shadow:0 6px 14px rgba(11,31,58,.1)}
.chip.on{background:var(--navy);border-color:var(--navy);color:#fff}
.chip.rd{background:#fee2e2;border-color:#fecaca;color:#b91c1c}.chip.bl{background:#e0e9ff;border-color:#c7d7fb;color:#1d4ed8}
.chip.rd.on,.chip.bl.on{background:var(--navy);border-color:var(--navy);color:#fff}
.frow{display:flex;gap:10px;flex-wrap:wrap;align-items:center;margin-bottom:12px}
.fsearch{flex:1;min-width:260px;display:flex;align-items:center;gap:9px;padding:11px 14px;border-radius:11px;background:var(--soft);border:1px solid transparent;color:var(--mu);transition:.3s var(--ease)}
.fsearch:focus-within{background:#fff;border-color:var(--green);box-shadow:0 0 0 4px rgba(15,122,79,.1)}
.fsearch input{flex:1;border:0;outline:0;background:none;font:inherit;color:var(--tx);min-width:0}
.fsearch kbd{font:600 10px Inter,sans-serif;background:#dfe6f2;color:var(--mu);border-radius:5px;padding:2px 6px}
.sels{display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:10px}
.sels label{display:block;font-size:10.5px;font-weight:600;color:var(--mu)}
.sels select{width:100%;margin-top:5px;padding:10px 11px;border:1px solid var(--line);border-radius:10px;background:#fff;font:500 12px Inter,sans-serif;color:var(--tx)}
.bulk{display:flex;gap:10px;flex-wrap:wrap;align-items:center;margin-top:14px;font-size:11.5px;color:var(--mu)}
.bulk b{color:var(--tx)}.bulk .sp{flex:1}

/* 8. TABEL ARSIP --------------------------------------------------------- */
.layout{display:grid;grid-template-columns:minmax(0,1fr) 350px;gap:18px;align-items:start}
.tb{padding:0;overflow:hidden}
.tb-h{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:18px 20px}
.tb-h h2{font-size:16px;font-weight:700;display:flex;gap:10px;align-items:center;flex-wrap:wrap}.tb-h h2 svg{color:#334e8a}
.dens{display:inline-flex;gap:7px;align-items:center;padding:7px 11px;border-radius:9px;border:1px solid var(--line);background:#fff;font:600 11px Inter,sans-serif;color:var(--mu);cursor:pointer;transition:.3s}
.dens:hover{background:var(--soft);color:var(--tx)}
.scroll{overflow-x:auto}
.tbl{width:100%;border-collapse:collapse;min-width:800px}
.tbl th{text-align:left;font-size:10.5px;letter-spacing:.04em;color:var(--mu);padding:12px 10px;background:#f7f9fc;border-bottom:1px solid var(--line);white-space:nowrap}
.tbl td{padding:14px 10px;border-bottom:1px solid var(--line);vertical-align:middle;font-size:12px}
.tbl.rapat td{padding:8px 10px}.tbl.rapat .sub{display:none}
.tbl tbody tr{cursor:pointer;transition:background .2s}
.tbl tbody tr:hover{background:#f8fafc}.tbl tbody tr.act{background:#ecfaf3;box-shadow:inset 3px 0 0 var(--green)}
.kd{font-weight:700;font-size:11.5px;line-height:1.4;max-width:80px;word-break:break-all}
.sw{display:flex;align-items:center;gap:10px;min-width:170px}
.ini{width:34px;height:34px;border-radius:50%;display:grid;place-items:center;font-size:11px;font-weight:800;flex:none;background:#dcefe6;color:var(--dgreen)}
.ini.c1{background:#e0e7ff;color:#3730a3}.ini.c2{background:#fee2e2;color:#b91c1c}.ini.c3{background:#fef3c7;color:#b45309}
.sw b{display:block;font-size:12.5px}.sw small{color:var(--mu);font-size:11px}
.dk b{display:block;font-size:12.5px;line-height:1.35}.dk small{display:block;color:var(--mu);font-size:10.5px;margin-top:2px}.dk .kat{color:var(--amber);font-weight:600}
.lk b{display:block;font-size:11.5px}.lk small{display:block;color:var(--mu);font-size:10.5px;margin-top:3px;line-height:1.4}.lk .no{color:var(--amber);font-weight:600}
.kn{display:inline-flex;gap:6px;align-items:center;padding:4px 10px;border-radius:99px;font-size:10.8px;font-weight:700;white-space:nowrap}
.kn::before{content:"";width:6px;height:6px;border-radius:50%;background:currentColor}
.kn.baik{background:var(--mint);color:var(--dgreen)}.kn.perhatian{background:#fef3c7;color:#b45309}
.kn.rusak{background:#fee2e2;color:#b91c1c}.kn.belum{background:#e8eefb;color:#334e8a}
.empty{text-align:center;padding:50px 12px;color:var(--mu);line-height:1.7}.empty b{display:block;color:var(--tx);font-size:14px;margin-bottom:4px}
.pg{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;padding:14px 20px;color:var(--mu);font-size:11.5px;border-top:1px solid var(--line)}
.pg select{padding:6px 8px;border:1px solid var(--line);border-radius:8px;font:inherit;margin-left:6px;color:var(--tx)}
.pgn{display:flex;gap:6px;align-items:center}
.pgn a,.pgn span{min-width:30px;height:30px;border-radius:8px;display:grid;place-items:center;text-decoration:none;font-weight:600;color:var(--mu);border:1px solid var(--line);padding:0 9px;transition:.3s var(--ease)}
.pgn a:hover{background:var(--soft)}.pgn a.on{background:var(--green);border-color:var(--green);color:#fff}.pgn span{border:0}.pgn .dis{opacity:.4;pointer-events:none}

/* 9. PANEL DETAIL -------------------------------------------------------- */
.dp{padding:18px}
.dp.swap>*{animation:panelIn .55s var(--ease) both}
.dp.swap>*:nth-child(2){animation-delay:.05s}.dp.swap>*:nth-child(3){animation-delay:.1s}
.dp.swap>*:nth-child(4){animation-delay:.15s}.dp.swap>*:nth-child(5){animation-delay:.2s}
.dh{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:10px}
.dh .t{font-size:10.5px;font-weight:700;letter-spacing:.04em;color:#334e8a}
.kode{font-size:22px;font-weight:800;letter-spacing:-.02em;margin-bottom:12px}
.sc{display:flex;gap:12px;align-items:center;padding:13px;border-radius:13px;background:#f6f8fc;margin-bottom:14px}
.sc .ini{width:42px;height:42px;font-size:13px;background:var(--green);color:#fff}
.sc b{font-size:13.5px}.sc small{display:block;color:var(--mu);font-size:11px;margin-top:3px}.sc .dok{color:var(--tx);font-weight:600}
.dl{font-size:10.5px;font-weight:700;letter-spacing:.04em;color:var(--mu);margin:14px 0 8px}
.lbl{display:flex;gap:12px;align-items:center;padding:12px;border-radius:12px;border:1.5px dashed #c5d2e8;background:#fafcff}
.lbl .qr{width:76px;height:76px;flex:none;display:grid;place-items:center;background:#fff;border-radius:8px;padding:3px;font-size:9px;color:var(--mu);text-align:center}
.lbl .qr img,.lbl .qr canvas{width:100%!important;height:100%!important}
.lbl .lt b{display:block;font-size:10.5px}.lbl .lt small{display:block;color:var(--mu);font-size:9.5px;margin-top:2px;line-height:1.4}.lbl .lt strong{display:block;font-size:11.5px;margin:4px 0}
.addr{list-style:none;display:grid;gap:6px;margin-bottom:14px}
.addr li{display:flex;gap:10px;align-items:flex-start;padding:10px 11px;border-radius:10px;background:#f6f8fc;font-size:11.5px}
.addr li svg{color:var(--mu);margin-top:1px}
.addr li span{color:var(--mu);min-width:92px;font-size:11px}.addr li b{font-weight:600;line-height:1.4}.addr li b small{display:block;color:var(--mu);font-weight:500;font-size:10px;margin-top:2px}
.addr .no{color:var(--amber)}
.loan{padding:12px;border-radius:12px;background:#e8f0ff;color:#1e3a8a;font-size:11.5px;line-height:1.6;margin-bottom:12px}
.loan.lewat{background:#fdecec;color:#b91c1c}
.loan b{display:block}.loan .btn{margin-top:9px}
.log{list-style:none;display:grid;gap:7px;margin-bottom:14px}
.log li{padding:9px 11px;border-radius:10px;background:#f6f8fc;font-size:10.8px;line-height:1.5;color:var(--mu)}
.log li b{color:var(--tx);font-size:11px;text-transform:capitalize}.log li small{display:block;font-size:10px;margin-top:2px}
.plinks{display:grid;gap:2px;margin-top:6px}
.plinks a{display:flex;justify-content:space-between;align-items:center;gap:8px;padding:10px 4px;border-bottom:1px solid var(--line);font-size:11.5px;font-weight:600;color:var(--mu);text-decoration:none;transition:.25s}
.plinks a:last-child{border:0}.plinks a:hover{color:var(--tx);padding-left:8px}

/* 10. FORM PANEL --------------------------------------------------------- */
.ptabs{display:flex;gap:4px;padding:4px;border-radius:11px;background:var(--soft);margin-bottom:12px}
.ptabs button{flex:1;padding:8px 6px;border:0;border-radius:8px;background:transparent;font:600 11px Inter,sans-serif;color:var(--mu);cursor:pointer;transition:.3s var(--ease)}
.ptabs button.on{background:#fff;color:var(--tx);box-shadow:0 2px 8px rgba(11,31,58,.1)}
.pform{display:none;margin-bottom:6px}.pform.on{display:block;animation:pop .4s var(--ease)}
.fld{margin-bottom:10px}
.fld label{display:block;font-size:10.5px;font-weight:600;color:var(--mu);margin-bottom:5px}
.fld input,.fld select,.fld textarea{width:100%;padding:10px 11px;border-radius:9px;border:1px solid var(--line);background:#f8fafc;font:12px Inter,sans-serif;color:var(--tx);transition:.25s}
.fld input:focus,.fld select:focus,.fld textarea:focus{outline:0;border-color:var(--green);background:#fff;box-shadow:0 0 0 3px rgba(15,122,79,.1)}
.fld textarea{min-height:58px;resize:vertical}
.two{display:grid;grid-template-columns:1fr 1fr;gap:9px}

/* 11. DIALOG, DROPDOWN, TOAST -------------------------------------------- */
dialog{margin:auto;border:0;border-radius:18px;padding:26px;width:min(560px,92vw);max-height:88vh;overflow:auto;box-shadow:0 30px 80px rgba(11,31,58,.3);color:var(--tx)}
dialog[open]{animation:pop .5s var(--ease)}
dialog::backdrop{background:rgba(11,31,58,.5);backdrop-filter:blur(5px)}
dialog h3{font-size:18px;margin-bottom:6px}dialog>p,dialog form>p{color:var(--mu);line-height:1.6;margin-bottom:14px}
dialog ul.pl{padding-left:18px;display:grid;gap:8px;line-height:1.6;margin-bottom:16px}
dialog .end{display:flex;justify-content:flex-end;gap:8px;margin-top:6px}
.finder{position:relative}
.res{position:absolute;left:0;right:0;top:calc(100% + 6px);z-index:5;list-style:none;background:#fff;border:1px solid var(--line);border-radius:12px;box-shadow:var(--shadow-up);max-height:230px;overflow:auto;padding:6px;animation:drop .35s var(--ease)}
.res li{display:flex;justify-content:space-between;gap:10px;align-items:center;padding:9px 11px;border-radius:9px;cursor:pointer}
.res li:hover{background:var(--soft)}.res li b{display:block;font-size:12.5px}.res li small{color:var(--mu);font-size:11px}
.res li em{font-style:normal;font-size:10.5px;font-weight:700;background:#e8eefb;color:#334e8a;border-radius:6px;padding:3px 8px}
.res .none{justify-content:center;color:var(--mu);cursor:default}
.chosen{padding:11px 13px;border-radius:11px;background:var(--mint);color:var(--dgreen);font-weight:600;font-size:12px;margin-top:8px}
.chk{display:grid;gap:6px;margin:6px 0 12px}
.chk label{display:flex;gap:9px;align-items:center;padding:9px 11px;border-radius:9px;background:#f6f8fc;font-size:12px;font-weight:500;cursor:pointer}
.chk label small{margin-left:auto;color:var(--mu);font-size:10.5px}
.toast{position:fixed;right:24px;bottom:24px;z-index:50;max-width:340px;padding:13px 16px;border-radius:13px;background:var(--navy);color:#fff;font-weight:500;line-height:1.5;box-shadow:var(--shadow-up);transform:translateY(30px);opacity:0;pointer-events:none;transition:.5s var(--ease)}
.toast.show{transform:none;opacity:1}

/* 12. BANNER SOP --------------------------------------------------------- */
.sop{display:flex;justify-content:space-between;align-items:center;gap:18px;flex-wrap:wrap;margin-top:22px;padding:20px 24px;border-radius:var(--r);background:linear-gradient(135deg,#0b1f3a,#10294a 60%,#0e3a37);color:#d6e2f2;position:relative;overflow:hidden}
.sop::before{content:"";position:absolute;right:-60px;top:-80px;width:260px;height:260px;border-radius:50%;background:radial-gradient(circle,rgba(52,211,153,.22),transparent 70%)}
.sop .si{display:flex;gap:16px;align-items:center;position:relative;max-width:640px}
.sop .si>svg{width:44px;height:44px;padding:10px;border-radius:12px;background:rgba(52,211,153,.16);color:#34d399;flex:none}
.sop b{display:block;color:#fff;font-size:15px;margin-bottom:5px}.sop p{font-size:11.5px;line-height:1.65;color:#aebfd6}
.sop .sa{display:flex;gap:10px;align-items:center;flex-wrap:wrap;position:relative}
.sop .sa span{padding:8px 12px;border-radius:9px;background:rgba(255,255,255,.08);font-size:10.5px;color:#c4d3e6}

/* 13. ANIMASI MASUK ------------------------------------------------------ */
.js .rv{opacity:0;transform:translateY(24px) scale(.985);filter:blur(5px)}
.js .rv.in{opacity:1;transform:none;filter:none;transition:opacity 1s var(--ease),transform 1s var(--ease),filter 1s var(--ease);transition-delay:var(--d,0ms)}
.js .track i,.js .lm .track i{width:0}
.js .in .track i{width:var(--w)}
.js .tb tbody tr{opacity:0;transform:translateX(-14px)}
.js .tb.in tbody tr{opacity:1;transform:none;transition:opacity .7s var(--ease),transform .7s var(--ease);transition-delay:calc(400ms + var(--i,0)*70ms)}
.js .room .lm,.js .room .rk{opacity:0;transform:translateY(10px)}
.js .room.in .lm,.js .room.in .rk{opacity:1;transform:none;transition:opacity .7s var(--ease),transform .7s var(--ease);transition-delay:calc(300ms + var(--i,0)*90ms)}
@keyframes shine{from{background-position:100% 0}to{background-position:0 0}}
@keyframes pop{from{opacity:0;transform:translateY(12px) scale(.96)}}
@keyframes drop{from{opacity:0;transform:translateY(-8px) scaleY(.92)}}
@keyframes panelIn{from{opacity:0;transform:translateX(18px)}}

/* 14. LABEL CETAK (sticker 50 x 30 mm) ----------------------------------- */
#areaCetak{display:none}
.stk{width:50mm;height:30mm;display:flex;gap:2.5mm;align-items:center;padding:2mm;border:.2mm solid #000;border-radius:1.5mm;background:#fff;color:#000;page-break-inside:avoid;break-inside:avoid;overflow:hidden}
.stk .q{width:22mm;height:22mm;flex:none}.stk .q img,.stk .q canvas{width:100%!important;height:100%!important}
.stk .tx{font-size:6.5pt;line-height:1.3;min-width:0}
.stk .tx b{display:block;font-size:6.8pt}.stk .tx strong{display:block;font-size:8pt;margin:.6mm 0}
.stk .tx small{display:block;font-size:5.8pt;color:#333}

/* 15. RESPONSIF & CETAK -------------------------------------------------- */
@media(max-width:1200px){.layout{grid-template-columns:1fr}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.search,.pill{display:none}.hact{min-width:0;width:100%}}
@media(max-width:640px){.wrap{padding:14px}.head h1{font-size:23px}.raks{grid-template-columns:repeat(2,1fr)}.rooms{grid-template-columns:1fr}}
@media(prefers-reduced-motion:reduce){
  *,*::before,*::after{animation:none!important;transition:none!important}
  .js .rv,.js .tb tbody tr,.js .room .lm,.js .room .rk{opacity:1;transform:none;filter:none}
  .js .track i{width:var(--w)}
}
@page{margin:8mm}
@media print{
  .side,.top,.hact,.flt,.dp,.pg,.sop,.toast,.dens,.icobtn,.bulk{display:none!important}
  .main{margin:0}.layout{display:block}body{background:#fff}.card,.head{box-shadow:none}
  .js .rv,.js .tb tbody tr,.js .room .lm,.js .room .rk{opacity:1!important;transform:none!important;filter:none!important}
  .js .track i{width:var(--w)!important}
  body.cetak-label .main,body.cetak-label dialog,body.cetak-label .side{display:none!important}
  body.cetak-label #areaCetak{display:flex;flex-wrap:wrap;gap:3mm}
}
</style>