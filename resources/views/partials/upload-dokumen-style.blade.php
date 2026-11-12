<style>
/* ==========================================================================
   UPLOAD DOKUMEN — Gaya halaman
   Daftar isi:
   1. Variabel        6. Kartu & judul langkah   11. Panel kanan
   2. Dasar           7. Langkah 1 (siswa)       12. Riwayat upload
   3. Header          8. Langkah 2 (kategori)    13. Dialog & toast
   4. Judul halaman   9. Langkah 3 (unggah)      14. Animasi masuk
   5. Kartu KPI      10. Bar aksi                15. Responsif
   ========================================================================== */

/* 1. VARIABEL ------------------------------------------------------------ */
:root{
  --navy:#0b1f3a;--navy2:#142d4e;--green:#0f7a4f;--green2:#12935f;--mint:#d9f5e8;
  --bg:#f3f5f9;--card:#fff;--line:#e5e9f0;--soft:#eef2fb;
  --tx:#0f1b2d;--mu:#64748b;--red:#dc2626;--amber:#b45309;--blue:#2563eb;
  --r:16px;
  --shadow:0 1px 2px rgba(11,31,58,.04),0 10px 28px rgba(11,31,58,.05);
  --shadow-up:0 2px 4px rgba(11,31,58,.05),0 22px 44px rgba(11,31,58,.11);
  --ease:cubic-bezier(.16,1,.3,1);
}

/* 2. DASAR --------------------------------------------------------------- */
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Inter,Arial,sans-serif;color:var(--tx);font-size:13px;
  background:
    radial-gradient(900px 380px at 80% -90px,rgba(15,122,79,.09),transparent 70%),
    radial-gradient(700px 320px at 8% -70px,rgba(37,99,235,.07),transparent 70%),
    var(--bg)}
a{color:inherit}
button{font-family:inherit}
svg.i{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex:none}
:focus-visible{outline:2px solid var(--green);outline-offset:2px}
.main{margin-left:248px}
.wrap{padding:18px 28px 44px;max-width:1380px}
.mu{color:var(--mu)}

/* Tombol */
.btn{position:relative;overflow:hidden;display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 16px;border-radius:11px;border:1px solid var(--line);background:#fff;color:var(--tx);font:600 12.5px Inter,sans-serif;cursor:pointer;text-decoration:none;transition:transform .35s var(--ease),box-shadow .35s var(--ease),background .25s}
.btn:hover{transform:translateY(-2px);box-shadow:0 10px 22px rgba(11,31,58,.12)}
.btn:active{transform:translateY(0) scale(.98)}
.btn.g{background:linear-gradient(135deg,var(--green2),var(--green));border-color:var(--green);color:#fff}
.btn.g::after{content:"";position:absolute;inset:0;background:linear-gradient(110deg,transparent 30%,rgba(255,255,255,.35) 50%,transparent 70%);transform:translateX(-120%);transition:transform .8s var(--ease)}
.btn.g:hover::after{transform:translateX(120%)}
.btn[disabled]{opacity:.45;pointer-events:none;filter:saturate(.6)}
.btn .arr{transition:transform .35s var(--ease)}.btn:hover .arr{transform:translateX(4px)}
.mini{padding:7px 12px;border-radius:9px;border:1px solid var(--line);background:#fff;font:600 11.5px Inter,sans-serif;cursor:pointer;color:var(--tx);text-decoration:none;transition:background .2s,transform .3s var(--ease)}
.mini:hover{background:var(--soft);transform:translateY(-1px)}
.badge{display:inline-block;padding:3px 9px;border-radius:99px;font-size:10.5px;font-weight:700}
.badge.ok{background:var(--mint);color:#0a5c3b}

/* 3. HEADER -------------------------------------------------------------- */
.top{position:sticky;top:0;z-index:10;display:flex;align-items:center;gap:12px;padding:12px 28px;background:rgba(255,255,255,.82);backdrop-filter:blur(14px) saturate(1.4);border-bottom:1px solid var(--line)}
.search{display:flex;align-items:center;gap:8px;padding:9px 12px;border:1px solid var(--line);border-radius:10px;width:250px;color:var(--mu);background:#fff;transition:.3s var(--ease)}
.search:focus-within{width:290px;border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
.search input{border:0;outline:0;background:none;width:100%;font:inherit;color:var(--tx)}
.pill{padding:6px 11px;border-radius:99px;background:var(--mint);color:#0a5c3b;font-weight:600;font-size:11.5px}
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
.head h1{font-size:30px;font-weight:800;letter-spacing:-.025em;display:flex;align-items:center;gap:12px;flex-wrap:wrap;line-height:1.15}
.ttl{background:linear-gradient(100deg,var(--tx) 42%,#12935f 50%,var(--tx) 58%);background-size:260% 100%;-webkit-background-clip:text;background-clip:text;color:transparent;animation:shine 2.6s .5s var(--ease) 1 both}
.head p{color:var(--mu);margin-top:9px;max-width:660px;line-height:1.65}
.hact{display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap}
.flash{display:flex;gap:10px;align-items:center;padding:12px 16px;border-radius:12px;background:var(--mint);color:#0a5c3b;font-weight:600;margin-bottom:16px;border:1px solid rgba(15,122,79,.18)}
.flash.err{background:#fee2e2;color:#b91c1c;border-color:#fecaca}

/* 5. KARTU KPI ----------------------------------------------------------- */
.kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:14px;margin-bottom:22px}
.kpi{position:relative;overflow:hidden;padding:18px 20px;transition:transform .45s var(--ease),box-shadow .45s var(--ease)}
.kpi:hover{transform:translateY(-4px);box-shadow:var(--shadow-up)}
.kpi::after{content:"";position:absolute;right:-34px;bottom:-34px;width:140px;height:140px;border-radius:50%;background:var(--t);opacity:.1;transition:transform .8s var(--ease)}
.kpi:hover::after{transform:scale(1.35)}
.kpi .l{font-size:11px;font-weight:600;letter-spacing:.04em;color:var(--mu)}
.kpi .ico{position:absolute;right:18px;top:16px;width:40px;height:40px;border-radius:12px;display:grid;place-items:center;background:var(--t2);color:var(--t)}
.kpi .ico svg{width:20px;height:20px}
.kpi strong{display:block;font-size:34px;font-weight:800;letter-spacing:-.025em;margin:10px 0 2px;color:var(--tx);font-variant-numeric:tabular-nums}
.kpi strong small{font-size:14px;font-weight:600;color:var(--mu);margin-left:6px;letter-spacing:0}
.kpi .n{position:relative;z-index:1;display:flex;align-items:center;gap:7px;font-size:11px;margin-top:14px;color:var(--mu)}
.kpi .n.up{color:#0a5c3b;font-weight:600}.kpi .n.dn{color:var(--red);font-weight:600}

/* 6. KARTU & JUDUL LANGKAH ----------------------------------------------- */
.card{background:var(--card);border:1px solid var(--line);border-radius:var(--r);padding:20px;box-shadow:var(--shadow);transition:box-shadow .45s var(--ease)}
.layout{display:grid;grid-template-columns:minmax(0,1fr) 350px;gap:18px;align-items:start}
.col{display:grid;gap:18px}
.sh{display:flex;align-items:center;gap:12px;margin-bottom:16px}
.sh .ico{width:34px;height:34px;border-radius:10px;background:#e8eefb;color:#334e8a;display:grid;place-items:center;flex:none}
.sh h2{font-size:16px;font-weight:700;letter-spacing:-.01em}
.sh p{color:var(--mu);font-size:11.5px;margin-top:2px}
.sh .end{margin-left:auto;font-size:10.5px;font-weight:700;color:var(--mu)}
.req{margin-left:auto;padding:4px 10px;border-radius:99px;background:var(--mint);color:#0a5c3b;font-size:10.5px;font-weight:700}

/* 7. LANGKAH 1 — SISWA --------------------------------------------------- */
.finder{position:relative;margin-bottom:14px}
.fsearch{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:12px;background:var(--soft);border:1px solid transparent;color:var(--mu);transition:.3s var(--ease)}
.fsearch:focus-within{background:#fff;border-color:var(--green);box-shadow:0 0 0 4px rgba(15,122,79,.1)}
.fsearch input{flex:1;border:0;outline:0;background:none;font:inherit;color:var(--tx)}
.res{position:absolute;left:0;right:0;top:calc(100% + 6px);z-index:5;list-style:none;background:#fff;border:1px solid var(--line);border-radius:12px;box-shadow:var(--shadow-up);max-height:290px;overflow:auto;padding:6px;transform-origin:top;animation:drop .35s var(--ease)}
.res li{display:flex;justify-content:space-between;gap:10px;align-items:center;padding:10px 12px;border-radius:9px;cursor:pointer;transition:background .2s}
.res li:hover,.res li.act{background:var(--soft)}
.res li b{display:block;font-size:12.5px}.res li small{color:var(--mu);font-size:11px}
.res li em{font-style:normal;font-size:10.5px;font-weight:700;background:#e8eefb;color:#334e8a;border-radius:6px;padding:3px 8px}
.res .none{cursor:default;color:var(--mu);justify-content:center}
.scard{display:flex;align-items:center;gap:16px;padding:16px;border-radius:14px;background:linear-gradient(135deg,#f7faff,#eef6f2);border:1px solid var(--line);animation:pop .6s var(--ease)}
.scard.empty{background:#fafbfd;border-style:dashed}
.scard .se-ic{width:48px;height:48px;border-radius:14px;background:var(--soft);color:var(--mu);display:grid;place-items:center}
.scard.empty small{display:block;color:var(--mu);margin-top:3px}
.foto{position:relative;flex:none}
.foto img{width:62px;height:62px;border-radius:14px;object-fit:cover;background:#dbe4f3;box-shadow:0 6px 16px rgba(11,31,58,.15)}
.foto .ck{position:absolute;right:-6px;bottom:-6px;width:22px;height:22px;border-radius:50%;background:var(--green);color:#fff;display:grid;place-items:center;font-size:12px;font-style:normal;border:2px solid #fff}
.sinfo{flex:1;min-width:0}
.snm{display:flex;gap:10px;align-items:center;flex-wrap:wrap}.snm b{font-size:16px;letter-spacing:-.01em}
.smeta{display:flex;gap:18px;flex-wrap:wrap;margin:7px 0;color:var(--mu);font-size:11.5px}.smeta b{color:var(--tx)}
.sprog{display:flex;align-items:center;gap:10px;font-size:11.5px;color:var(--mu);flex-wrap:wrap}.sprog b{color:var(--green)}
.track{flex:1;min-width:120px;max-width:220px;height:7px;background:#dfe6f0;border-radius:9px;overflow:hidden}
.track i{display:block;width:0;height:100%;border-radius:9px;background:linear-gradient(90deg,var(--green),#34d399);transition:width 1.4s var(--ease) .3s}
.sact{display:grid;gap:8px;justify-items:end}
.lnk{display:inline-flex;align-items:center;gap:5px;color:var(--green);font-weight:600;font-size:11.5px;text-decoration:none}

/* 8. LANGKAH 2 — KATEGORI & METADATA ------------------------------------- */
.lbl{display:block;font-size:11.5px;font-weight:600;margin-bottom:9px}
.tiles{display:grid;grid-template-columns:repeat(auto-fill,minmax(190px,1fr));gap:10px;margin-bottom:18px}
.tile{display:flex;gap:11px;align-items:center;text-align:left;padding:12px;border-radius:12px;border:1px solid transparent;background:var(--soft);cursor:pointer;color:var(--tx);transition:transform .4s var(--ease),box-shadow .4s var(--ease),background .3s}
.tile:hover{transform:translateY(-3px);box-shadow:0 12px 24px rgba(11,31,58,.1)}
.tile .ti{width:34px;height:34px;border-radius:10px;background:#fff;color:#334e8a;display:grid;place-items:center;flex:none;transition:.3s}
.tile b{display:block;font-size:12.5px}
.tile small{display:block;font-size:10.5px;margin-top:2px;color:var(--mu)}
.tile small[data-st=sah]{color:#0a5c3b}.tile small[data-st=menunggu]{color:var(--blue)}.tile small[data-st=revisi]{color:var(--red)}.tile small[data-st=kosong]{color:var(--amber)}
.tile.pick{background:linear-gradient(135deg,var(--green2),var(--green));color:#fff;animation:ring .9s var(--ease)}
.tile.pick .ti{background:rgba(255,255,255,.18);color:#fff}
.tile.pick small{color:rgba(255,255,255,.85)!important}
.fields{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.fields .full{grid-column:1/-1}
.field label{display:block;font-size:11.5px;font-weight:600;margin-bottom:7px}
.field input,.field textarea{width:100%;padding:11px 12px;border-radius:10px;border:1px solid transparent;background:var(--soft);font:12.5px Inter,sans-serif;color:var(--tx);transition:.3s var(--ease)}
.field input:focus,.field textarea:focus{outline:0;background:#fff;border-color:var(--green);box-shadow:0 0 0 4px rgba(15,122,79,.1)}
.field input[readonly]{color:var(--mu)}
.field textarea{min-height:76px;resize:vertical;line-height:1.5}

/* 9. LANGKAH 3 — UNGGAH BERKAS ------------------------------------------- */
.drop{position:relative;overflow:hidden;display:grid;justify-items:center;gap:6px;text-align:center;padding:30px 18px;border-radius:14px;border:1.5px dashed #b9c6da;background:linear-gradient(180deg,#fafcff,#f1f6fb);transition:transform .45s var(--ease),border-color .3s,box-shadow .45s var(--ease),background .3s}
.drop::before{content:"";position:absolute;inset:0;background:linear-gradient(110deg,transparent 35%,rgba(15,122,79,.08) 50%,transparent 65%);transform:translateX(-100%);animation:sweep 5s 1.2s ease-in-out infinite}
.drop.over{transform:scale(1.015);border-color:var(--green);border-style:solid;background:#f0fbf6;box-shadow:0 0 0 5px rgba(15,122,79,.12),0 18px 40px rgba(15,122,79,.15)}
.drop .cloud{width:58px;height:58px;border-radius:50%;background:var(--mint);color:var(--green);display:grid;place-items:center;animation:float 3.4s ease-in-out infinite}
.drop.over .cloud{animation:bounce .6s var(--ease) infinite alternate}
.drop .cloud svg{width:28px;height:28px}
.drop b{font-size:14.5px;margin-top:4px}.drop p{color:var(--mu);font-size:12px;max-width:430px;line-height:1.55}
.drop .fmt{display:flex;gap:16px;flex-wrap:wrap;justify-content:center;color:var(--mu);font-size:11px;margin-top:6px}
.drop-err{margin-top:10px;color:var(--red);font-weight:600;font-size:12px;min-height:0}
.fileitem{display:flex;align-items:center;gap:13px;margin-top:14px;padding:13px 14px;border-radius:13px;border:1px solid var(--line);background:#fff;animation:pop .6s var(--ease)}
.fileitem[hidden]{display:none}
.fileitem .fi{width:44px;height:44px;border-radius:11px;background:#fee2e2;color:#b91c1c;display:grid;place-items:center;font-size:10px;font-weight:800;flex:none}
.fileitem .fi.im{background:#e0e7ff;color:#3730a3}
.fileitem .fn{flex:1;min-width:0}
.fileitem .fn b{display:flex;gap:8px;align-items:center;flex-wrap:wrap;font-size:12.5px;word-break:break-all}
.fileitem .fn small{display:block;color:var(--mu);font-size:11px;margin-top:3px}
.ib{width:34px;height:34px;border-radius:9px;border:1px solid var(--line);background:#fff;color:var(--mu);display:grid;place-items:center;cursor:pointer;transition:.3s var(--ease)}
.ib:hover{background:var(--soft);color:var(--tx);transform:translateY(-2px)}.ib.rd:hover{background:#fee2e2;color:var(--red)}
.fileitem .acts{display:flex;gap:7px}

/* 10. BAR AKSI ----------------------------------------------------------- */
.bar{display:flex;align-items:center;gap:14px;flex-wrap:wrap;transition:border-color .4s,background .4s}
.bar .ck{width:34px;height:34px;border-radius:50%;background:#fef3c7;color:var(--amber);display:grid;place-items:center;flex:none;transition:.4s var(--ease)}
.bar.ok{border-color:rgba(15,122,79,.3);background:linear-gradient(135deg,#fff,#f2fbf6)}
.bar.ok .ck{background:var(--mint);color:var(--green);transform:rotate(360deg)}
.bar .tx{flex:1;min-width:210px}.bar .tx b{display:block;font-size:12.5px}.bar .tx small{color:var(--mu);font-size:11px}
.bar .acts{display:flex;gap:9px;flex-wrap:wrap}
.spin{width:14px;height:14px;border-radius:50%;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;animation:rot .7s linear infinite}

/* 11. PANEL KANAN -------------------------------------------------------- */
.rail{display:grid;gap:18px}
.pv-top{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.pv-top h3{font-size:15px;font-weight:700}.pv-top .ico{width:30px;height:30px;border-radius:9px;background:#e8eefb;color:#334e8a;display:grid;place-items:center}
.pv-top .badge{margin-left:auto;background:#e8eefb;color:#334e8a}
.pv{position:relative;height:290px;border-radius:13px;background:#eef2f7;border:1px solid var(--line);overflow:hidden;display:grid;place-items:center}
.pv-inner{width:100%;height:100%;display:grid;place-items:center;transition:transform .5s var(--ease);transform-origin:center}
.pv-inner img,.pv-inner iframe{width:100%;height:100%;border:0;object-fit:contain;background:#fff}
.pv-empty{display:grid;justify-items:center;gap:8px;color:var(--mu);text-align:center;padding:20px;font-size:12px;line-height:1.55}
.pv-empty svg{width:34px;height:34px;opacity:.55}
.pv.has{animation:pop .6s var(--ease)}
.pv-tools{display:flex;justify-content:center;gap:8px;margin-top:12px}
.pv-tools .ib{width:32px;height:32px}
.hashbox{display:flex;justify-content:space-between;gap:10px;align-items:center;margin-top:14px;padding:10px 12px;border-radius:10px;background:var(--soft);font-size:11px;color:var(--mu)}
.hashbox code{font:600 11px ui-monospace,Consolas,monospace;color:var(--tx);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:170px}
.stor h3,.rules h3{font-size:14.5px;font-weight:700;display:flex;gap:8px;align-items:center;margin-bottom:10px}
.stor h3 i{width:8px;height:8px;border-radius:50%;background:var(--green);animation:pulse 2s infinite}
.stor p,.rules li{color:var(--mu);line-height:1.65;font-size:12px}
.stor code{font:600 11px ui-monospace,Consolas,monospace;color:var(--tx);background:var(--soft);padding:2px 6px;border-radius:6px;word-break:break-all}
.cap{display:flex;justify-content:space-between;font-size:11.5px;margin:14px 0 7px}.cap b{color:var(--green)}
.rules ol{padding-left:18px;display:grid;gap:9px}
.rules .ln{display:inline-flex;gap:6px;align-items:center;margin-top:14px;font-size:11.5px;font-weight:600;color:var(--green);text-decoration:none}
.rules .ln.off{color:var(--mu);opacity:.6;pointer-events:none}

/* 12. RIWAYAT UPLOAD ----------------------------------------------------- */
.riw{margin-top:18px;padding:0;overflow:hidden}
.riw-h{display:flex;justify-content:space-between;align-items:flex-end;gap:16px;flex-wrap:wrap;padding:20px 20px 14px}
.riw-h h2{font-size:17px;font-weight:700}.riw-h p{color:var(--mu);margin-top:3px;font-size:11.5px}
.tabs{display:flex;gap:4px;padding:4px;border-radius:12px;background:var(--soft);flex-wrap:wrap}
.tabs a{padding:8px 13px;border-radius:9px;font-size:11.5px;font-weight:600;color:var(--mu);text-decoration:none;white-space:nowrap;transition:.3s var(--ease)}
.tabs a:hover{color:var(--tx)}.tabs a.on{background:#fff;color:var(--tx);box-shadow:0 2px 8px rgba(11,31,58,.1)}.tabs a.rd{color:var(--red)}
.scroll{overflow-x:auto}
.tbl{width:100%;border-collapse:collapse;min-width:900px}
.tbl th{text-align:left;font-size:10.5px;letter-spacing:.04em;color:var(--mu);padding:12px 12px;background:#f7f9fc;border-bottom:1px solid var(--line)}
.tbl td{padding:14px 12px;border-bottom:1px solid var(--line);vertical-align:middle;font-size:12px}
.tbl tbody tr{transition:background .2s}.tbl tbody tr:hover{background:#f8fafc}
.tbl .no{color:var(--mu);width:40px}
.tbl .sw b{display:block;font-size:12.5px}.tbl .sw small{color:var(--mu);font-size:11px}
.tbl .dk{display:flex;gap:8px;align-items:center;font-weight:600}.tbl .dk svg{color:#334e8a}
.tbl .fl b{display:block;color:var(--green);font-weight:600;word-break:break-all}.tbl .fl small{color:var(--mu);font-size:11px}
.tbl .wk{color:var(--mu);line-height:1.55}
.st{display:inline-block;padding:5px 11px;border-radius:99px;font-size:10.8px;font-weight:700;white-space:nowrap}
.st.sah{background:var(--mint);color:#0a5c3b}.st.menunggu{background:#dbeafe;color:#1d4ed8}.st.revisi{background:#fee2e2;color:#b91c1c}
.ac{display:flex;gap:4px;justify-content:flex-end}
.ac a{width:30px;height:30px;border-radius:8px;display:grid;place-items:center;color:var(--mu);text-decoration:none;transition:.3s var(--ease)}
.ac a:hover{background:var(--soft);color:var(--tx);transform:translateY(-2px)}.ac a.rd{color:var(--red)}.ac a.off{opacity:.35;pointer-events:none}
.empty{text-align:center;padding:46px 12px;color:var(--mu);line-height:1.7}.empty b{display:block;color:var(--tx);font-size:14px;margin-bottom:4px}
.pg{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;padding:14px 20px;color:var(--mu);font-size:11.5px;border-top:1px solid var(--line)}
.pgn{display:flex;gap:6px;align-items:center}
.pgn a,.pgn span{min-width:30px;height:30px;border-radius:8px;display:grid;place-items:center;text-decoration:none;font-weight:600;color:var(--mu);border:1px solid var(--line);padding:0 8px;transition:.3s var(--ease)}
.pgn a:hover{background:var(--soft)}.pgn a.on{background:var(--green);border-color:var(--green);color:#fff}.pgn span{border:0}.pgn .dis{opacity:.4;pointer-events:none}

/* 13. DIALOG & TOAST ----------------------------------------------------- */
dialog{margin:auto;border:0;border-radius:18px;padding:26px;width:min(520px,92vw);box-shadow:0 30px 80px rgba(11,31,58,.3);color:var(--tx)}
dialog[open]{animation:pop .5s var(--ease)}
dialog::backdrop{background:rgba(11,31,58,.5);backdrop-filter:blur(5px)}
dialog h3{font-size:18px;margin-bottom:6px}dialog p{color:var(--mu);line-height:1.6;margin-bottom:12px}
dialog ul{padding-left:18px;display:grid;gap:8px;line-height:1.6;margin-bottom:18px}
dialog .end{display:flex;justify-content:flex-end}
.toast{position:fixed;right:24px;bottom:24px;z-index:50;max-width:340px;padding:13px 16px;border-radius:13px;background:var(--navy);color:#fff;font-weight:500;line-height:1.5;box-shadow:var(--shadow-up);transform:translateY(30px);opacity:0;pointer-events:none;transition:.5s var(--ease)}
.toast.show{transform:none;opacity:1}

/* 14. ANIMASI MASUK ------------------------------------------------------ */
.js .rv{opacity:0;transform:translateY(24px) scale(.985);filter:blur(5px)}
.js .rv.in{opacity:1;transform:none;filter:none;transition:opacity 1s var(--ease),transform 1s var(--ease),filter 1s var(--ease);transition-delay:var(--d,0ms)}
.js .riw tbody tr{opacity:0;transform:translateX(-14px)}
.js .riw.in tbody tr{opacity:1;transform:none;transition:opacity .7s var(--ease),transform .7s var(--ease);transition-delay:calc(450ms + var(--i,0)*80ms)}
@keyframes shine{from{background-position:100% 0}to{background-position:0 0}}
@keyframes pop{from{opacity:0;transform:translateY(12px) scale(.96)}}
@keyframes drop{from{opacity:0;transform:translateY(-8px) scaleY(.92)}}
@keyframes ring{0%{box-shadow:0 0 0 0 rgba(15,122,79,.45)}100%{box-shadow:0 0 0 14px rgba(15,122,79,0)}}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-7px)}}
@keyframes bounce{to{transform:translateY(-10px) scale(1.06)}}
@keyframes sweep{0%,55%{transform:translateX(-100%)}100%{transform:translateX(100%)}}
@keyframes pulse{0%{box-shadow:0 0 0 0 rgba(15,122,79,.55)}100%{box-shadow:0 0 0 8px rgba(15,122,79,0)}}
@keyframes rot{to{transform:rotate(360deg)}}

/* 15. RESPONSIF ---------------------------------------------------------- */
@media(max-width:1180px){.layout{grid-template-columns:1fr}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.search,.pill{display:none}}
@media(max-width:640px){.wrap{padding:14px}.fields{grid-template-columns:1fr}.scard{flex-wrap:wrap}.sact{justify-items:start}.head h1{font-size:23px}}
@media(prefers-reduced-motion:reduce){
  *,*::before,*::after{animation:none!important;transition:none!important}
  .js .rv,.js .riw tbody tr{opacity:1;transform:none;filter:none}
}
</style>