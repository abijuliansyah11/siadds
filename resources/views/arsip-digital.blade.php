<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Direktori Arsip Digital | MAS YPI SUMBER HARJO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#0b1f3a;--navy2:#142d4e;--green:#0f7a4f;--mint:#d9f5e8;--bg:#f3f5f9;--card:#fff;--line:#e5e9f0;--tx:#0f1b2d;--mu:#64748b;--red:#dc2626;--amber:#b45309;--blue:#2563eb;--r:14px}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:Inter,Arial,sans-serif;background:var(--bg);color:var(--tx);font-size:13px}
svg.i{width:16px;height:16px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex:none}
a{color:inherit}
/* Header */
.main{margin-left:248px}
.top{position:sticky;top:0;z-index:10;display:flex;align-items:center;gap:12px;padding:12px 28px;background:rgba(255,255,255,.88);backdrop-filter:blur(12px);border-bottom:1px solid var(--line)}
.search{display:flex;align-items:center;gap:8px;padding:9px 12px;border:1px solid var(--line);border-radius:10px;width:260px;color:var(--mu);background:#fff;transition:.25s}
.search:focus-within{border-color:var(--green);box-shadow:0 0 0 3px rgba(15,122,79,.12)}
.search input{border:0;outline:0;background:none;width:100%;font:inherit;color:var(--tx)}
.pill{padding:6px 10px;border-radius:99px;background:var(--mint);color:#0a5c3b;font-weight:600;font-size:11.5px}
.pill.bl{background:#e8eefb;color:#334e8a}
.sp{flex:1}
.btn{display:inline-flex;align-items:center;gap:7px;padding:10px 15px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--tx);font:600 12.5px Inter,sans-serif;cursor:pointer;text-decoration:none;transition:transform .2s,box-shadow .2s}
.btn:hover{transform:translateY(-2px);box-shadow:0 8px 18px rgba(11,31,58,.12)}
.btn.g{background:var(--green);border-color:var(--green);color:#fff}.btn.d{background:var(--navy);border-color:var(--navy);color:#fff}
.btn.sm{padding:7px 10px;font-size:11.5px}.btn.off{opacity:.4;pointer-events:none}
.btn:focus-visible,input:focus-visible,select:focus-visible,textarea:focus-visible,a:focus-visible{outline:2px solid var(--green);outline-offset:2px}
.bell{position:relative;display:grid;place-items:center;width:36px;height:36px;border-radius:50%;color:var(--mu);text-decoration:none}
.bell b{position:absolute;top:0;right:0;min-width:17px;height:17px;border-radius:99px;background:var(--red);color:#fff;font-size:10px;display:grid;place-items:center;padding:0 4px}
.user{display:flex;align-items:center;gap:10px}
.av{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--green),var(--navy2));color:#fff;display:grid;place-items:center;font-weight:700}
.user small{display:block;color:var(--mu);font-size:11px}
.user form button{border:0;background:none;color:var(--red);font:600 12px Inter;cursor:pointer;padding:6px}
/* Page */
.wrap{padding:18px 28px 40px;max-width:1380px}
.crumb{display:flex;gap:8px;color:var(--mu);font-size:11.5px;margin-bottom:10px}.crumb b{color:var(--tx);font-weight:600}
.head{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap;margin-bottom:18px}
.head h1{font-size:28px;font-weight:800;letter-spacing:-.02em;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
.head p{color:var(--mu);margin-top:8px;max-width:640px;line-height:1.6}
.hact{display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap}
.flash{padding:11px 14px;border-radius:11px;background:var(--mint);color:#0a5c3b;font-weight:600;margin-bottom:14px}
.flash.err{background:#fee2e2;color:#b91c1c}
.card{background:var(--card);border:1px solid var(--line);border-radius:var(--r);padding:18px}
.kpis{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:14px;margin-bottom:24px}
.kpi{position:relative;overflow:hidden;padding:18px 20px}
.kpi::after{content:"";position:absolute;right:-30px;bottom:-30px;width:130px;height:130px;border-radius:50%;background:var(--t);opacity:.12}
.kpi .l{font-size:11px;font-weight:600;letter-spacing:.05em;color:var(--mu);text-transform:uppercase}
.kpi .ico{position:absolute;right:18px;top:16px;width:38px;height:38px;border-radius:11px;display:grid;place-items:center;background:var(--t2);color:var(--t)}
.kpi .ico svg{width:19px;height:19px}
.kpi strong{display:block;font-size:34px;font-weight:800;letter-spacing:-.02em;margin:10px 0 2px;color:var(--t)}
.kpi strong small{font-size:15px;font-weight:600;margin-left:6px}
.kpi .n{display:flex;align-items:center;gap:7px;color:var(--mu);font-size:11px;margin-top:14px;position:relative;z-index:1}
.kpi .n i{width:6px;height:6px;border-radius:50%;background:var(--t);flex:none}
.sec{display:flex;justify-content:space-between;align-items:center;margin:4px 0 12px}
.sec h2{font-size:16px;font-weight:700;display:flex;align-items:center;gap:8px}.sec span{color:var(--mu);font-size:11.5px}
.cats{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:12px;margin-bottom:24px}
.cat{display:block;text-decoration:none;padding:14px;transition:transform .2s,box-shadow .2s,border-color .2s}
.cat:hover{transform:translateY(-3px);box-shadow:0 12px 26px rgba(11,31,58,.09)}
.cat.on{border-color:var(--green);box-shadow:0 0 0 2px rgba(15,122,79,.18)}
.cat .t{display:flex;justify-content:space-between;align-items:center}
.cat .ci{width:32px;height:32px;border-radius:9px;background:#e8eefb;color:#334e8a;display:grid;place-items:center}
.cat .ct{font-size:11px;font-weight:700;background:var(--bg);border-radius:99px;padding:3px 8px}
.cat b{display:block;font-size:15px;margin:12px 0 3px}.cat small{color:var(--mu);font-size:11px;display:block;min-height:15px}
.track{height:6px;background:#e8edf4;border-radius:9px;overflow:hidden;margin:12px 0 8px}.track i{display:block;height:100%;background:var(--green);border-radius:9px}
.cat .ft{display:flex;justify-content:space-between;font-size:10.5px;color:var(--mu);gap:6px}.cat .ft .rv{color:var(--red);font-weight:600}
.fbar{display:flex;gap:10px;align-items:center;margin-bottom:12px}
.fsearch{flex:1;display:flex;align-items:center;gap:9px;padding:11px 14px;border-radius:11px;background:#eef2fb;color:var(--mu)}
.fsearch input{flex:1;border:0;outline:0;background:none;font:inherit;color:var(--tx)}
.quick{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:12px;font-size:11px;color:var(--mu)}
.chip{display:inline-block;padding:5px 11px;border-radius:99px;border:1px solid var(--line);background:#fff;font-size:11px;font-weight:600;text-decoration:none;color:var(--mu);white-space:nowrap}
.chip.on{background:var(--navy);border-color:var(--navy);color:#fff}
.chip.amb{background:#fef3c7;border-color:#fde68a;color:var(--amber)}.chip.rd{background:#fee2e2;border-color:#fecaca;color:#b91c1c}
.chip.amb.on{background:var(--amber);border-color:var(--amber);color:#fff}.chip.rd.on{background:var(--red);border-color:var(--red);color:#fff}
.chip.ok{background:var(--mint);color:#0a5c3b;border-color:var(--mint)}.chip.wt{background:#fef3c7;color:var(--amber);border-color:#fef3c7}
.sels{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:6px}
.sels select{padding:9px 10px;border:1px solid var(--line);border-radius:9px;background:#eef2fb;font:500 12px Inter,sans-serif;color:var(--tx)}
.sels .cnt{margin-left:auto;color:var(--mu)}
.layout{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:18px;align-items:start}
.tbl{padding:0;overflow:hidden}
.scroll{overflow-x:auto}
table{width:100%;border-collapse:collapse;min-width:760px}
th{text-align:left;font-size:10.5px;letter-spacing:.04em;color:var(--mu);padding:13px 10px;border-bottom:1px solid var(--line);background:#fafbfd}
td{padding:14px 10px;border-bottom:1px solid var(--line);vertical-align:middle;font-size:12px}
tbody tr{cursor:pointer;transition:background .15s}tbody tr:hover{background:#f8fafc}
tbody tr.act{background:#ecfaf3}
td.no{color:var(--mu);width:34px}
.d{display:flex;align-items:center;gap:11px}
.ext{width:38px;height:38px;border-radius:9px;display:grid;place-items:center;font-size:10px;font-weight:800;flex:none;background:#fee2e2;color:#b91c1c}
.ext.im{background:#e0e7ff;color:#3730a3}
.d b{font-size:13.5px;display:block}.d small{color:var(--mu);font-size:11px;display:block;margin-top:2px;max-width:230px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.d small.er{color:var(--red);font-weight:500;white-space:normal}
.sis b{color:var(--green);font-size:12.5px;display:block}.sis small{color:var(--mu);font-size:11px}
.sis em{font-style:normal;font-size:10px;font-weight:700;background:#e8eefb;color:#334e8a;border-radius:6px;padding:2px 6px;margin-left:5px}
.kb{display:inline-block;padding:4px 9px;border-radius:7px;background:var(--bg);font-size:10.5px;font-weight:700;color:#475569}
.st{display:block;margin-top:6px;font-size:10.5px;font-weight:700}.st.sah{color:#0a5c3b}.st.menunggu{color:var(--amber)}.st.revisi{color:var(--red)}
.tg{color:var(--mu);font-size:11px;line-height:1.5}
.pg{display:flex;justify-content:space-between;align-items:center;padding:14px 16px;gap:12px;flex-wrap:wrap;color:var(--mu);font-size:11.5px;border-top:1px solid var(--line)}
.pg select{padding:6px 8px;border:1px solid var(--line);border-radius:8px;font:inherit;margin-left:6px;color:var(--tx)}
.pgn{display:flex;gap:6px;align-items:center}
.pgn a,.pgn span{min-width:28px;height:28px;border-radius:8px;display:grid;place-items:center;text-decoration:none;font-weight:600;color:var(--mu);border:1px solid var(--line);padding:0 6px}
.pgn a.on{background:var(--green);border-color:var(--green);color:#fff}.pgn span{border:0}.pgn .dis{opacity:.4;pointer-events:none}
.empty{text-align:center;padding:48px 12px;color:var(--mu);line-height:1.7}.empty b{display:block;color:var(--tx);font-size:14px;margin-bottom:4px}
/* Panel */
.panel{position:sticky;top:76px}
.panel .pk{display:flex;justify-content:space-between;align-items:center;font-size:10.5px;font-weight:700;color:var(--green);letter-spacing:.03em}
.panel h3{font-size:18px;font-weight:800;margin:8px 0 6px;line-height:1.25}
.panel .sub{color:var(--mu);font-size:11.5px;line-height:1.6}
.prev{height:170px;margin:14px 0;border-radius:12px;border:1px solid var(--line);background:#eef2f7;position:relative;overflow:hidden;display:grid;place-items:center;color:var(--mu)}
.prev img,.prev iframe{width:100%;height:100%;object-fit:contain;border:0;background:#fff}
.prev .tools{position:absolute;right:8px;bottom:8px;display:flex;gap:6px}
.prev .tools a{width:28px;height:28px;border-radius:8px;background:var(--navy);color:#fff;display:grid;place-items:center}
.prev .tg2{position:absolute;left:8px;bottom:8px;background:var(--navy);color:#fff;font:600 10px Inter;padding:4px 8px;border-radius:6px}
.kv{display:flex;justify-content:space-between;gap:10px;padding:5px 0;font-size:12px}.kv span{color:var(--mu)}.kv b{text-align:right;font-weight:600;word-break:break-all}
.hash{margin-top:6px;padding:9px;border-radius:8px;background:#eef2fb;font:500 10.5px ui-monospace,Consolas,monospace;color:#475569;word-break:break-all;line-height:1.5}
.hl{font-size:10px;font-weight:700;color:var(--mu);letter-spacing:.04em;margin-top:10px}
.panel hr{border:0;border-top:1px solid var(--line);margin:16px 0}
.panel h4{font-size:12.5px;margin-bottom:10px}
.rad{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.rad label{display:flex;align-items:center;gap:7px;padding:10px;border-radius:9px;background:#eef2fb;font-weight:600;font-size:12px;cursor:pointer}
.rad input:checked+span{color:var(--green)}.rad label:has(input:checked){outline:2px solid var(--green);background:#ecfaf3}
.panel textarea{width:100%;min-height:68px;margin-top:6px;padding:10px;border:1px solid var(--line);border-radius:9px;background:#eef2fb;font:12px Inter,sans-serif;resize:vertical;color:var(--tx)}
.act2{display:flex;gap:8px;margin-top:12px}.act2 .btn{flex:1;justify-content:center}
.plink{display:flex;justify-content:space-between;gap:10px;margin-top:14px;font-size:11px;font-weight:600;color:var(--green)}
.plink a{display:flex;gap:6px;align-items:center;text-decoration:none}.plink .x{color:var(--mu);opacity:.6}
.guard{display:flex;gap:12px;align-items:center;margin-top:22px;padding:14px 18px;border-radius:var(--r);background:#ecfaf3;color:#0a5c3b;font-size:11.5px;line-height:1.6}
.guard svg{width:22px;height:22px}.guard b{display:block}
@media(max-width:1180px){.layout{grid-template-columns:1fr}.panel{position:static}}
@media(max-width:900px){.side{display:none}.main{margin-left:0}.search,.pill{display:none}}
@media(max-width:600px){.wrap{padding:14px}.head h1{font-size:23px}}
@media(prefers-reduced-motion:reduce){*,*::before{transition:none!important;animation:none!important}}
/* ===== TAMBAHAN: halaman fungsional penuh (CSS lama di atas tidak diubah) ===== */
html{scroll-behavior:smooth}
.layout{scroll-margin-top:84px}
.cats{grid-template-columns:repeat(6,minmax(0,1fr))}
table{min-width:0}
.d small{max-width:260px}.d small.dt{margin-top:3px}
tbody tr.sel{background:#f0f6ff}tbody tr.act.sel{background:#ecfaf3}
th input[type=checkbox],td input[type=checkbox]{accent-color:var(--green);width:15px;height:15px;cursor:pointer}
.panel{max-height:calc(100vh - 92px);overflow-y:auto;scrollbar-width:thin}
.panel.swap>*{animation:panelIn .5s cubic-bezier(.16,1,.3,1) both}
.panel.swap>*:nth-child(2){animation-delay:.04s}.panel.swap>*:nth-child(3){animation-delay:.08s}.panel.swap>*:nth-child(4){animation-delay:.12s}
.hash{cursor:copy;transition:background .2s}.hash:hover{background:#e0e8f8}.hash.menghitung{color:var(--mu);font-style:italic}
.kv a{color:var(--green);font-weight:600;text-decoration:none}.kv a:hover{text-decoration:underline}
.plink2{display:flex;justify-content:space-between;gap:10px;margin-top:10px;padding-top:10px;border-top:1px solid var(--line);font-size:11px;font-weight:600}
.plink2 a{display:flex;gap:6px;align-items:center;text-decoration:none;color:var(--mu);transition:color .2s}.plink2 a:hover{color:var(--tx)}
.bulk{display:flex;justify-content:space-between;align-items:center;gap:14px;flex-wrap:wrap;margin-bottom:18px;padding:14px 20px;border-radius:var(--r);background:linear-gradient(135deg,#0b1f3a,#10294a 65%,#0e3a37);color:#d6e2f2;box-shadow:0 14px 34px rgba(11,31,58,.22);animation:slideDown .5s cubic-bezier(.16,1,.3,1)}
.bulk[hidden]{display:none}
.bulk .bt{display:flex;gap:12px;align-items:center}
.bulk .nb{width:30px;height:30px;border-radius:9px;background:var(--green);color:#fff;display:grid;place-items:center;font-weight:800}
.bulk b{color:#fff;font-size:14px}.bulk small{display:block;color:#9fb4cf;font-size:11px;margin-top:2px}
.bulk .ba{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
.bulk .btn.dk{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.16);color:#e6eefb}
.bulk .link{background:none;border:0;color:#9fb4cf;font:600 12px Inter,sans-serif;cursor:pointer;padding:8px}.bulk .link:hover{color:#fff}
dialog{margin:auto;border:0;border-radius:18px;padding:26px;width:min(480px,92vw);box-shadow:0 30px 80px rgba(11,31,58,.3);color:var(--tx)}
dialog[open]{animation:panelIn .45s cubic-bezier(.16,1,.3,1)}
dialog::backdrop{background:rgba(11,31,58,.5);backdrop-filter:blur(5px)}
dialog h3{font-size:18px;margin-bottom:6px}dialog p{color:var(--mu);line-height:1.6;margin-bottom:12px}
dialog textarea{width:100%;min-height:90px;padding:10px;border:1px solid var(--line);border-radius:10px;background:#eef2fb;font:12.5px Inter,sans-serif;resize:vertical;color:var(--tx);margin-bottom:14px}
dialog .end{display:flex;justify-content:flex-end;gap:8px}
.toast{position:fixed;right:24px;bottom:24px;z-index:50;max-width:360px;padding:13px 16px;border-radius:13px;background:var(--navy);color:#fff;font-weight:500;line-height:1.5;box-shadow:0 22px 44px rgba(11,31,58,.25);transform:translateY(30px);opacity:0;pointer-events:none;transition:.5s cubic-bezier(.16,1,.3,1)}
.toast.show{transform:none;opacity:1}.toast.err{background:#b91c1c}
.spin{width:13px;height:13px;border-radius:50%;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;animation:rot .7s linear infinite}
@keyframes panelIn{from{opacity:0;transform:translateX(14px)}}
@keyframes slideDown{from{opacity:0;transform:translateY(-14px)}}
@keyframes rot{to{transform:rotate(360deg)}}
@media(max-width:1100px){.cats{grid-template-columns:repeat(3,minmax(0,1fr))}}
@media(max-width:700px){.cats{grid-template-columns:repeat(2,minmax(0,1fr))}}
</style>
</head>
<body>
@php
/* ---------- Pembantu tampilan ---------- */
use App\Http\Controllers\ArsipDigitalController as AD;

$ic     = fn ($n) => '<svg class="i"><use href="#'.$n.'"/></svg>';
$nama   = auth()->user()->name;
$url    = fn ($x = []) => route('arsip.digital', array_filter(array_merge(request()->except('page', 'pilih'), $x), fn ($v) => $v !== null && $v !== ''));
$aktifF = request()->hasAny(['q', 'kategori', 'kelas', 'verif', 'format', 'baru']);
$labelSt = ['sah' => 'Sah', 'menunggu' => 'Menunggu', 'revisi' => 'Perlu perbaikan'];
$persen  = $ringkas['total'] > 0 ? round($ringkas['sah'] / $ringkas['total'] * 100) : 0;   // dipakai kartu "Terverifikasi sah"

/* ---------- Konfigurasi untuk JavaScript ---------- */
$config = [
    'detail' => $detail,
    'aktif'  => $idAktif,
    'csrf'   => csrf_token(),
    'urls'   => [
        'putuskan' => route('arsip.digital.putuskan', 0),
        'massal'   => route('arsip.digital.massal'),
        'zip'      => route('arsip.digital.zip'),
        'fisik'    => route('arsip.fisik'),
    ],
    'flash'  => session('status'),
    'galat'  => $errors->first(),
];
@endphp

@include('partials.sidebar')

{{-- Ikon tambahan khusus halaman ini --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
<symbol id="shield" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></symbol>
<symbol id="alert" viewBox="0 0 24 24"><path d="M12 3l10 18H2z"/><path d="M12 10v5M12 18v.01"/></symbol>
<symbol id="hourglass" viewBox="0 0 24 24"><path d="M6 3h12M6 21h12M7 3c0 5 5 6 5 9s-5 4-5 9M17 3c0 5-5 6-5 9s5 4 5 9"/></symbol>
<symbol id="bell" viewBox="0 0 24 24"><path d="M6 17V11a6 6 0 0112 0v6l2 2H4zM10 21h4"/></symbol>
<symbol id="filter" viewBox="0 0 24 24"><path d="M3 5h18l-7 8v6l-4-2v-4z"/></symbol>
<symbol id="ext" viewBox="0 0 24 24"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h5"/></symbol>
<symbol id="link" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></symbol>
<symbol id="redo" viewBox="0 0 24 24"><path d="M3 12a9 9 0 109-9M3 4v5h5"/></symbol>
<symbol id="box" viewBox="0 0 24 24"><path d="M3 7l9-4 9 4v10l-9 4-9-4zM3 7l9 4 9-4M12 11v10"/></symbol>
<symbol id="zip" viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M12 3v4M12 9v2M12 13v2M10 17h4"/></symbol>
</svg>

<div class="main">
  <header class="top">
    <form method="GET" action="{{ route('arsip.digital') }}" class="search" role="search">
      {!! $ic('search') !!}<input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama, NIS, atau dokumen..." aria-label="Cari">
    </form>
    <span class="pill">Sistem Aktif</span><span class="pill bl">TA 2026/2027 — Ganjil</span>
    <span class="sp"></span>
    <a href="{{ route('siswa.baru') }}" class="btn g">{!! $ic('plus') !!}Quick Action</a>
    <a href="{{ $url(['verif'=>'menunggu']) }}#daftar" class="bell" title="Antrean verifikasi">{!! $ic('bell') !!}@if($ringkas['menunggu']>0)<b>{{ $ringkas['menunggu']>99?'99+':$ringkas['menunggu'] }}</b>@endif</a>
    <div class="user">
      <div class="av">{{ strtoupper(substr($nama,0,1)) }}</div>
      <div><b>{{ $nama }}</b><small>Administrator</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
    </div>
  </header>

  <div class="wrap">
    <nav class="crumb" aria-label="Breadcrumb"><span>Dashboard</span>/<span>Arsip Digital & Fisik</span>/<b>Direktori Arsip Digital</b></nav>

    <section class="head">
      <div>
        <h1>Direktori Arsip Digital <span class="pill">SIADDS Engine v3.4</span></h1>
        <p>Temukan, audit visual, validasi stempel integritas SHA-256, dan koordinasikan lokasi fisik dokumen siswa dalam satu repositori terpusat.</p>
      </div>
      <div class="hact">
        <a href="{{ route('arsip.digital.ekspor', request()->except('page','pilih')) }}" class="btn">{!! $ic('download') !!}Ekspor Daftar</a>
        <a href="{{ route('upload.dokumen') }}" class="btn g">{!! $ic('upload') !!}Upload Dokumen</a>
      </div>
    </section>

    @if(session('status'))<div class="flash" role="status">{{ session('status') }}</div>@endif
    @if($errors->any())<div class="flash err" role="alert">{{ $errors->first() }}</div>@endif

    <section class="kpis">
      <div class="card kpi" style="--t:#2563eb;--t2:#e0e9ff"><span class="l">Total Dokumen</span><span class="ico">{!! $ic('folder') !!}</span><strong>{{ number_format($ringkas['total'],0,',','.') }}<small>Berkas</small></strong><div class="n"><i></i>Tercatat di server lokal madrasah</div></div>
      <div class="card kpi" style="--t:#0f7a4f;--t2:#d9f5e8"><span class="l">Terverifikasi sah</span><span class="ico">{!! $ic('shield') !!}</span><strong>{{ number_format($ringkas['sah'],0,',','.') }}<small>Berkas</small></strong><div class="n">{!! $ic('check') !!}{{ $persen }}% dari seluruh berkas sudah sah</div></div>
      <div class="card kpi" style="--t:#b45309;--t2:#fef3c7"><span class="l">Antrean review</span><span class="ico">{!! $ic('hourglass') !!}</span><strong>{{ number_format($ringkas['menunggu'],0,',','.') }}<small>Berkas</small></strong><div class="n"><i></i>Antrean verifikator & TU madrasah</div></div>
      <div class="card kpi" style="--t:#dc2626;--t2:#fee2e2"><span class="l">Perlu perbaikan</span><span class="ico">{!! $ic('alert') !!}</span><strong>{{ number_format($ringkas['revisi'],0,',','.') }}<small>Berkas</small></strong><div class="n"><i></i>Perlu unggah ulang oleh siswa/operator</div></div>
    </section>

    <div class="sec"><h2>{!! $ic('folder') !!}Kategori Dokumen Utama</h2><span>Klik kartu untuk menyaring direktori</span></div>
    <section class="cats">
      @foreach(AD::KATEGORI as $k=>$m)
        @php $c=$kat[$k]; $p=$c['total']>0?round($c['sah']/$c['total']*100):0; @endphp
        <a href="{{ (request('kategori')===$k ? $url(['kategori'=>null]) : $url(['kategori'=>$k])) }}#daftar" class="card cat {{ request('kategori')===$k?'on':'' }}">
          <div class="t"><span class="ci">{!! $ic($m['icon']) !!}</span><span class="ct">{{ number_format($c['total'],0,',','.') }}</span></div>
          <b>{{ $m['label'] }}</b><small>{{ $m['sub'] }}</small>
          <div class="track"><i style="width:{{ $p }}%"></i></div>
          <div class="ft"><span>{{ $c['sah'] }} Sah &nbsp;{{ $c['menunggu'] }} Menunggu</span>@if($c['revisi']>0)<span class="rv">{{ $c['revisi'] }} Koreksi</span>@endif</div>
        </a>
      @endforeach
    </section>

    <section class="card" style="margin-bottom:18px">
      <form id="fil" method="GET" action="{{ route('arsip.digital') }}#daftar"><input type="hidden" name="per" value="{{ $per }}"></form>
      <div class="fbar">
        <label class="fsearch">{!! $ic('search') !!}<input form="fil" type="search" id="cariTabel" name="q" value="{{ request('q') }}" placeholder="Cari nama siswa, NIS, NISN, no. pendaftaran (REG-...), atau nama dokumen... (Ctrl+K)" aria-label="Cari dokumen"></label>
        <button form="fil" type="submit" class="btn g">{!! $ic('filter') !!}Terapkan Filter</button>
        <a href="{{ route('arsip.digital',['per'=>$per]) }}#daftar" class="btn">Reset</a>
      </div>
      <div class="quick">
        <span>FILTER CEPAT:</span>
        <a class="chip {{ !$aktifF?'on':'' }}" href="{{ route('arsip.digital',['per'=>$per]) }}#daftar">Semua Arsip ({{ number_format($ringkas['total'],0,',','.') }})</a>
        <a class="chip {{ request()->boolean('baru')?'on':'' }}" href="{{ route('arsip.digital',['baru'=>1,'per'=>$per]) }}#daftar">Terbaru Diunggah (7 hari)</a>
        <a class="chip amb {{ request('verif')==='menunggu'?'on':'' }}" href="{{ route('arsip.digital',['verif'=>'menunggu','per'=>$per]) }}#daftar">● Menunggu Verifikasi ({{ $ringkas['menunggu'] }})</a>
        <a class="chip rd {{ request('verif')==='revisi'?'on':'' }}" href="{{ route('arsip.digital',['verif'=>'revisi','per'=>$per]) }}#daftar">● Perlu Perbaikan ({{ $ringkas['revisi'] }})</a>
      </div>
      <div class="sels">
        <select form="fil" name="kategori" aria-label="Kategori" onchange="this.form.submit()"><option value="">Semua Kategori</option>@foreach(AD::KATEGORI as $k=>$m)<option value="{{ $k }}" @selected(request('kategori')===$k)>{{ $m['label'] }}</option>@endforeach</select>
        <select form="fil" name="kelas" aria-label="Kelas" onchange="this.form.submit()"><option value="">Semua Kelas</option>@foreach($daftarKelas as $kl)<option value="{{ $kl }}" @selected(request('kelas')===$kl)>{{ $kl }}</option>@endforeach</select>
        <select form="fil" name="verif" aria-label="Verifikasi" onchange="this.form.submit()"><option value="">Semua Verifikasi</option><option value="sah" @selected(request('verif')==='sah')>Sah</option><option value="menunggu" @selected(request('verif')==='menunggu')>Menunggu</option><option value="revisi" @selected(request('verif')==='revisi')>Perlu Perbaikan</option></select>
        <select form="fil" name="format" aria-label="Format" onchange="this.form.submit()"><option value="">Format File (Semua)</option><option value="pdf" @selected(request('format')==='pdf')>PDF</option><option value="jpg" @selected(request('format')==='jpg')>JPG</option><option value="png" @selected(request('format')==='png')>PNG</option></select>
        <span class="cnt">Menampilkan <b>{{ $dokumen->firstItem() ?? 0 }} - {{ $dokumen->lastItem() ?? 0 }}</b> dari {{ number_format($dokumen->total(),0,',','.') }} dokumen</span>
      </div>
    </section>

    {{-- Bar pilihan massal (muncul saat ada dokumen yang dicentang) --}}
    <section class="bulk" id="barPilih" hidden>
      <div class="bt"><span class="nb" id="jmlPilih">0</span><div><b><span id="jmlTeks">0</span> Dokumen Dipilih</b><small>Pilihan tetap tersimpan saat pindah halaman</small></div></div>
      <div class="ba">
        <button type="button" class="btn g sm" id="btnSah">{!! $ic('check') !!}Verifikasi Sah</button>
        <button type="button" class="btn dk sm" id="btnRevisi">{!! $ic('redo') !!}Minta Revisi</button>
        <button type="button" class="btn dk sm" id="btnZip">{!! $ic('zip') !!}Unduh ZIP</button>
        <button type="button" class="link" id="btnBatal">Batal</button>
      </div>
    </section>

    <div class="layout" id="daftar">
      <section class="card tbl">
        <div class="scroll">
        <table>
          <thead><tr><th style="width:34px"><input type="checkbox" id="semua" aria-label="Pilih semua pada halaman ini"></th><th>NO</th><th>DOKUMEN & FORMAT</th><th>IDENTITAS SISWA / NIS</th><th>KATEGORI</th></tr></thead>
          <tbody>
          @forelse($dokumen as $i=>$d)
            @php
              $s=$d->siswa; $g=AD::golongan($d->status);
              $ext=strtolower(pathinfo((string)($d->nama_file?:$d->path),PATHINFO_EXTENSION));
              $im=in_array($ext,['jpg','jpeg','png'],true);
              $kk=AD::KATEGORI[AD::kunci($d->jenis)];
              $tgl=$detail[$d->id]['tanggal'] ?? '-';
            @endphp
            <tr data-id="{{ $d->id }}" class="{{ (int)$d->id===(int)$idAktif?'act':'' }}">
              <td><input type="checkbox" class="pil" value="{{ $d->id }}" aria-label="Pilih {{ $d->nama_file }}"></td>
              <td class="no">{{ str_pad($dokumen->firstItem()+$i,2,'0',STR_PAD_LEFT) }}</td>
              <td><div class="d"><span class="ext {{ $im?'im':'' }}">{{ strtoupper($ext?:'FILE') }}</span><div><b>{{ $d->jenis }}</b>
                @if($g==='revisi' && $d->catatan)<small class="er">{{ $d->catatan }}</small>@else<small title="{{ $d->nama_file }}">{{ $d->nama_file ?: '-' }} • {{ $d->ukuran ?: '-' }}</small>@endif
                <small class="dt">{{ $tgl }} • {{ $d->diunggah_oleh ?: '-' }}</small></div></div></td>
              <td class="sis">@if($s)<b>{{ $s->nama }}</b><small>{{ $s->nis }}</small><em>{{ $s->kelas }}</em>@if(!empty($detail[$d->id]['siswa']['noReg']))<small style="display:block;margin-top:3px">{{ $detail[$d->id]['siswa']['noReg'] }}</small>@endif
                @else<small>Siswa tidak ditemukan</small>@endif</td>
              <td><span class="kb">{{ $kk['short'] }}</span><span class="st {{ $g }}">{{ $labelSt[$g] }}</span></td>
            </tr>
          @empty
            <tr><td colspan="5"><div class="empty"><b>Belum ada dokumen yang cocok</b>@if($aktifF)Ubah atau reset filter untuk melihat semua berkas.@else Unggah dokumen pertama dari halaman <a href="{{ route('upload.dokumen') }}" style="color:var(--green);font-weight:700">Upload Dokumen</a>.@endif</div></td></tr>
          @endforelse
          </tbody>
        </table>
        </div>
        @if($dokumen->total()>0)
        @php
          $cur=$dokumen->currentPage(); $last=$dokumen->lastPage();
          $hal=collect([1,$cur-1,$cur,$cur+1,$last])->filter(fn($p)=>$p>=1&&$p<=$last)->unique()->sort()->values(); $prev=0;
        @endphp
        <div class="pg">
          <form method="GET" action="{{ route('arsip.digital') }}#daftar">
            @foreach(request()->except('per','page','pilih') as $kk2=>$vv)<input type="hidden" name="{{ $kk2 }}" value="{{ $vv }}">@endforeach
            <label>Tampilkan per halaman:<select name="per" onchange="this.form.submit()">@foreach([10,25,50] as $n)<option value="{{ $n }}" @selected($per===$n)>{{ $n }} Berkas</option>@endforeach</select></label>
          </form>
          <div class="pgn">
            <a href="{{ $dokumen->previousPageUrl() ?: '#' }}" class="{{ $dokumen->onFirstPage()?'dis':'' }}" aria-label="Sebelumnya">‹</a>
            @foreach($hal as $p)
              @if($p-$prev>1)<span>…</span>@endif
              <a href="{{ $dokumen->url($p) }}" class="{{ $p===$cur?'on':'' }}">{{ $p }}</a>
              @php $prev=$p; @endphp
            @endforeach
            <a href="{{ $dokumen->nextPageUrl() ?: '#' }}" class="{{ $dokumen->hasMorePages()?'':'dis' }}" aria-label="Berikutnya">›</a>
          </div>
        </div>
        @endif
      </section>

      {{-- Panel pratinjau (diisi JavaScript agar berganti tanpa memuat ulang halaman) --}}
      <aside class="card panel" id="panelDetail" aria-live="polite" aria-label="Pratinjau dokumen"></aside>
    </div>

    <div class="guard">{!! $ic('shield') !!}<div><b>Perlindungan Data & Regulasi Kemenag / Dukcapil</b>Seluruh berkas dokumen siswa disimpan di server lokal MAS YPI SUMBER HARJO dan hanya dapat diakses oleh petugas madrasah yang berwenang.</div></div>
  </div>
</div>

{{-- Dialog: Minta Revisi massal --}}
<dialog id="dlgRevisi" aria-labelledby="dlgRevisiJudul">
  <form method="POST" action="{{ route('arsip.digital.massal') }}" id="formRevisi">
    @csrf
    <h3 id="dlgRevisiJudul">Minta Revisi Massal</h3>
    <p id="drInfo">Dokumen yang dipilih dikembalikan ke siswa/operator untuk diunggah ulang.</p>
    <div id="drIds"></div>
    <input type="hidden" name="keputusan" value="revisi">
    <textarea name="catatan" id="drCatatan" maxlength="500" required placeholder="Tulis alasan revisi, misalnya: foto buram, KK tidak lengkap satu halaman..."></textarea>
    <div class="end"><button type="button" class="btn" id="drBatal">Batal</button><button type="submit" class="btn g">{!! $ic('check') !!}Kirim Permintaan Revisi</button></div>
  </form>
</dialog>

{{-- Formulir tersembunyi untuk Verifikasi Sah massal & Unduh ZIP --}}
<form id="formAksi" method="POST" hidden>@csrf<div id="faIds"></div><input type="hidden" name="keputusan" id="faKeputusan"></form>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>window.ARSIPDIGITAL = @json($config);</script>
<script>
/* ==========================================================================
   DIREKTORI ARSIP DIGITAL — Skrip halaman
   Daftar isi:  1. Pembantu   2. Pilihan massal   3. Panel pratinjau
                4. Aksi massal   5. Pintasan   6. Mulai
   ========================================================================== */
(function () {
  'use strict';

  const C = window.ARSIPDIGITAL;

  /* ---------- 1. PEMBANTU ------------------------------------------------ */
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
  const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (m) =>
    ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]));
  const ico = (n) => '<svg class="i"><use href="#' + n + '"/></svg>';

  const panel = $('#panelDetail');
  const KUNCI = 'siadds-arsip-pilihan';
  const S = { pilihan: new Set(), aktif: null };

  let timerToast;
  function toast(pesan, galat) {
    const t = $('#toast');
    t.textContent = pesan;
    t.classList.toggle('err', !!galat);
    t.classList.add('show');
    clearTimeout(timerToast);
    timerToast = setTimeout(() => t.classList.remove('show'), 4200);
  }

  /* ---------- 2. PILIHAN MASSAL ------------------------------------------ */
  function muatPilihan() {
    try { (JSON.parse(sessionStorage.getItem(KUNCI) || '[]') || []).forEach((id) => S.pilihan.add(String(id))); } catch (e) { /* abaikan */ }
  }
  function simpanPilihan() {
    try { sessionStorage.setItem(KUNCI, JSON.stringify(Array.from(S.pilihan))); } catch (e) { /* abaikan */ }
  }

  function perbaruiPilihan() {
    const n = S.pilihan.size;
    $('#barPilih').hidden = n === 0;
    $('#jmlPilih').textContent = n;
    $('#jmlTeks').textContent = n;

    const kotak = $$('.pil');
    kotak.forEach((c) => {
      const ada = S.pilihan.has(c.value);
      c.checked = ada;
      c.closest('tr').classList.toggle('sel', ada);
    });
    const semua = $('#semua');
    if (semua) {
      const dipilih = kotak.filter((c) => c.checked).length;
      semua.checked = kotak.length > 0 && dipilih === kotak.length;
      semua.indeterminate = dipilih > 0 && dipilih < kotak.length;
    }
    simpanPilihan();
  }

  function aktifkanPilihan() {
    $$('.pil').forEach((c) => c.addEventListener('change', () => {
      if (c.checked) S.pilihan.add(c.value); else S.pilihan.delete(c.value);
      perbaruiPilihan();
    }));

    const semua = $('#semua');
    if (semua) semua.addEventListener('change', () => {
      $$('.pil').forEach((c) => { if (semua.checked) S.pilihan.add(c.value); else S.pilihan.delete(c.value); });
      perbaruiPilihan();
    });

    $('#btnBatal').addEventListener('click', () => { S.pilihan.clear(); perbaruiPilihan(); toast('Pilihan dibatalkan.'); });
  }

  /* ---------- 3. PANEL PRATINJAU ----------------------------------------- */
  function htmlPratinjau(d) {
    if (d.ada && d.gambar) return '<img src="' + esc(d.url.lihat) + '" alt="Pratinjau ' + esc(d.jenis) + '">';
    if (d.ada && d.ext === 'pdf') return '<iframe src="' + esc(d.url.lihat) + '#toolbar=0&navpanes=0" title="Pratinjau PDF"></iframe>';
    return '<span>Berkas tidak ditemukan di penyimpanan</span>';
  }

  function htmlPanel(d) {
    const label = { sah: 'TERVALIDASI', menunggu: 'MENUNGGU VERIFIKASI', revisi: 'PERLU PERBAIKAN' }[d.status];
    const chip  = { sah: ['ok', 'Sah'], menunggu: ['wt', 'Menunggu'], revisi: ['rd', 'Koreksi'] }[d.status];
    const s = d.siswa;
    const fisik = d.fisik
      ? '<a href="' + esc(d.fisik.url) + '" title="Buka di Lokasi Arsip Fisik">' + esc(d.fisik.teks) + '</a>'
      : '<span style="color:var(--mu)">Belum ditetapkan</span>';

    return '' +
      '<div class="pk"><span>PRATINJAU AKTIF (' + label + ')</span><span class="chip ' + chip[0] + '">' + chip[1] + '</span></div>' +
      '<h3>' + esc(d.jenis) + (s ? ' — ' + esc(s.nama) : '') + '</h3>' +
      '<div class="sub">' + (s ? 'NIS: ' + esc(s.nis) + ' • Kelas ' + esc(s.kelas) + (s.noReg ? ' • No. Pendaftaran: ' + esc(s.noReg) : '') + '<br>' : '') +
        'Diunggah oleh ' + esc(d.oleh || '-') + (d.tanggal ? ' • ' + esc(d.tanggal) : '') + '</div>' +

      '<div class="prev">' + htmlPratinjau(d) +
        (d.ada ? '<span class="tg2">' + esc((d.ext || '').toUpperCase()) + ' • Berkas Asli</span>' +
          '<div class="tools"><a href="' + esc(d.url.lihat) + '" target="_blank" rel="noopener" aria-label="Buka di tab baru">' + ico('ext') + '</a></div>' : '') +
      '</div>' +

      '<div class="kv"><span>Nama File:</span><b>' + esc(d.namaFile || '-') + '</b></div>' +
      '<div class="kv"><span>Ukuran:</span><b>' + esc(d.ukuran || '-') + ' (' + esc((d.ext || '-').toUpperCase()) + ')</b></div>' +
      '<div class="kv"><span>Arsip Fisik:</span><b style="color:var(--green)">' + fisik + '</b></div>' +

      (d.ada
        ? '<div class="hl">SHA-256 INTEGRITAS DIGITAL: <span style="font-weight:500;text-transform:none">(klik untuk menyalin)</span></div>' +
          '<div class="hash' + (d.hash ? '' : ' menghitung') + '" id="hashBox" title="Klik untuk menyalin">' + esc(d.hash || 'menghitung...') + '</div>'
        : '') +

      '<hr>' +
      '<form method="POST" id="formPutus" action="' + esc(C.urls.putuskan.replace('/0/', '/' + d.id + '/')) + '">' +
        '<input type="hidden" name="_token" value="' + esc(C.csrf) + '">' +
        '<h4>Keputusan Verifikator Madrasah</h4>' +
        '<div class="rad">' +
          '<label><input type="radio" name="keputusan" value="valid"' + (d.status !== 'revisi' ? ' checked' : '') + '><span>(+) Sah / Valid</span></label>' +
          '<label><input type="radio" name="keputusan" value="revisi"' + (d.status === 'revisi' ? ' checked' : '') + '><span>Minta Revisi</span></label>' +
        '</div>' +
        '<div class="hl" style="margin-top:14px">Catatan Verifikator / Audit:</div>' +
        '<textarea name="catatan" maxlength="500" placeholder="Contoh: Dokumen asli telah dicocokkan dengan data Dukcapil.">' + esc(d.catatan || '') + '</textarea>' +
        '<div class="act2"><button type="submit" class="btn g">' + ico('check') + 'Simpan Keputusan</button></div>' +
      '</form>' +

      '<div class="plink">' +
        (s ? '<a href="' + esc(d.url.profil) + '">' + ico('link') + 'Buka Profil Lengkap Siswa</a>' : '') +
        '<a href="' + esc(d.url.unduh) + '" class="' + (d.ada ? '' : 'x') + '">' + ico('download') + 'Unduh Berkas</a>' +
      '</div>' +
      (s ? '<div class="plink2"><a href="' + esc(d.url.unggah) + '">' + ico('upload') + 'Unggah Ulang Berkas</a>' +
            '<a href="' + esc(d.fisik ? d.fisik.url : C.urls.fisik || '#') + '">' + ico('box') + 'Lokasi Arsip Fisik</a></div>' : '');
  }

  function tampilPanel(id) {
    const d = C.detail[id];
    if (!d) {
      panel.innerHTML = '<div class="empty"><b>Belum ada dokumen dipilih</b>Pilih satu baris di tabel untuk melihat pratinjau dan memverifikasinya.</div>';
      return;
    }
    S.aktif = id;
    panel.innerHTML = htmlPanel(d);
    panel.classList.remove('swap'); void panel.offsetWidth; panel.classList.add('swap');
    panel.scrollTop = 0;

    // Hash dihitung server hanya untuk dokumen aktif awal; yang lain diambil saat dipilih
    if (d.ada && !d.hash) ambilHash(d);
  }

  function ambilHash(d) {
    fetch(d.url.hash, { headers: { Accept: 'application/json' } })
      .then((r) => r.ok ? r.json() : Promise.reject())
      .then((j) => {
        d.hash = j.hash || null;
        const kotak = $('#hashBox');
        if (S.aktif === String(d.id) || S.aktif === d.id) {
          if (kotak) { kotak.textContent = d.hash || 'tidak tersedia'; kotak.classList.remove('menghitung'); }
        }
      })
      .catch(() => { const k = $('#hashBox'); if (k) k.textContent = 'tidak tersedia'; });
  }

  function salinTeks(teks) {
    if (navigator.clipboard && window.isSecureContext) {
      return navigator.clipboard.writeText(teks);
    }
    return new Promise((ok, gagal) => {
      const t = document.createElement('textarea');
      t.value = teks; t.style.position = 'fixed'; t.style.opacity = '0';
      document.body.appendChild(t); t.select();
      try { document.execCommand('copy') ? ok() : gagal(); } catch (e) { gagal(); }
      document.body.removeChild(t);
    });
  }

  function pilihBaris(id) {
    $$('tbody tr[data-id]').forEach((tr) => tr.classList.toggle('act', tr.dataset.id === String(id)));
    tampilPanel(String(id));

    // Simpan pilihan di URL agar tetap terpilih setelah verifikasi / muat ulang
    const u = new URL(location.href);
    u.searchParams.set('pilih', id);
    history.replaceState(null, '', u);
  }

  function aktifkanPanel() {
    $$('tbody tr[data-id]').forEach((tr) => tr.addEventListener('click', (e) => {
      if (e.target.closest('input,a,button')) return;
      pilihBaris(tr.dataset.id);
    }));

    // Salin hash saat diklik
    panel.addEventListener('click', (e) => {
      const k = e.target.closest('#hashBox');
      if (!k || k.classList.contains('menghitung') || !C.detail[S.aktif] || !C.detail[S.aktif].hash) return;
      salinTeks(C.detail[S.aktif].hash).then(() => toast('Hash SHA-256 disalin ke clipboard.')).catch(() => toast('Gagal menyalin. Salin manual dengan menyeleksi teks.', true));
    });

    // Catatan wajib saat meminta revisi + cegah klik ganda
    document.addEventListener('submit', (e) => {
      if (e.target.id !== 'formPutus') return;
      const f = e.target;
      const revisi = f.querySelector('input[name=keputusan]:checked').value === 'revisi';
      if (revisi && !f.catatan.value.trim()) {
        e.preventDefault(); f.catatan.focus();
        toast('Catatan wajib diisi saat meminta revisi agar siswa tahu apa yang harus diperbaiki.', true);
        return;
      }
      const b = f.querySelector('button[type=submit]');
      b.disabled = true; b.innerHTML = '<span class="spin"></span>Menyimpan...';
    });
  }

  /* ---------- 4. AKSI MASSAL --------------------------------------------- */
  const isiIds = (el) => { el.innerHTML = Array.from(S.pilihan).map((id) => '<input type="hidden" name="ids[]" value="' + esc(id) + '">').join(''); };

  function aktifkanAksiMassal() {
    const form = $('#formAksi');

    $('#btnSah').addEventListener('click', () => {
      const n = S.pilihan.size;
      if (!n || !confirm('Nyatakan ' + n + ' dokumen terpilih sebagai SAH?')) return;
      form.action = C.urls.massal;
      $('#faKeputusan').value = 'valid';
      isiIds($('#faIds'));
      S.pilihan.clear(); simpanPilihan();
      form.submit();
    });

    $('#btnZip').addEventListener('click', () => {
      if (!S.pilihan.size) return;
      form.action = C.urls.zip;
      $('#faKeputusan').value = '';
      isiIds($('#faIds'));
      toast('Menyiapkan berkas ZIP, unduhan akan dimulai sebentar lagi...');
      form.submit();
    });

    const dlg = $('#dlgRevisi');
    $('#btnRevisi').addEventListener('click', () => {
      if (!S.pilihan.size) return;
      isiIds($('#drIds'));
      $('#drInfo').textContent = S.pilihan.size + ' dokumen terpilih akan dikembalikan untuk diunggah ulang.';
      dlg.showModal();
      $('#drCatatan').focus();
    });
    $('#drBatal').addEventListener('click', () => dlg.close());
    dlg.addEventListener('click', (e) => { if (e.target === dlg) dlg.close(); });
    $('#formRevisi').addEventListener('submit', (e) => {
      if (!$('#drCatatan').value.trim()) { e.preventDefault(); toast('Catatan wajib diisi.', true); return; }
      S.pilihan.clear(); simpanPilihan();
    });
  }

  /* ---------- 5. PINTASAN ------------------------------------------------ */
  function aktifkanPintasan() {
    document.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        const k = $('#cariTabel'); k.focus(); k.select();
      }
    });
  }

  /* ---------- 6. MULAI --------------------------------------------------- */
  function mulai() {
    muatPilihan();
    aktifkanPilihan();
    aktifkanPanel();
    aktifkanAksiMassal();
    aktifkanPintasan();

    perbaruiPilihan();
    tampilPanel(C.aktif === null ? null : String(C.aktif));

    if (C.galat) toast(C.galat, true); else if (C.flash) toast(C.flash);
  }

  mulai();
})();
</script>
</body>
</html>