@php
$ic=fn($n)=>'<svg class="i"><use href="#'.$n.'"/></svg>';
$menu=[
 ['DASHBOARD',[['grid','Dashboard Utama','dashboard']]],
 ['PENERIMAAN SISWA BARU (PPDB)',[['grid','Dashboard Penerimaan','penerimaan'],['user','Pendaftaran Baru','pendaftaran'],['users','Data Calon Siswa','calon'],['check','Verifikasi Berkas','verifikasi'],['chart','Status & Seleksi','seleksi'],['file','Daftar Ulang & Konversi','daftarulang']]],
 ['DATA SISWA',[['users','Data Siswa Aktif','siswa.aktif'],['user','Tambah Siswa Baru','siswa.baru'],['file','Detail Profil Siswa','siswa.detail'],['users','Data Alumni','alumni']]],
 ['ARSIP DIGITAL & FISIK',[['folder','Direktori Arsip Digital','arsip.digital'],['upload','Upload Dokumen','upload.dokumen'],['check','Kelengkapan Dokumen','kelengkapan.dokumen'],['folder','Lokasi Arsip Fisik','arsip.fisik'],['qr','Cetak Label QR Code','label.qr']]],
];
@endphp
<style>
.side{position:fixed;inset:0 auto 0 0;width:248px;background:linear-gradient(180deg,#0b1f3a,#0e2748);color:#cbd5e1;padding:18px 14px;overflow-y:auto;z-index:20;animation:slide .7s cubic-bezier(.2,.8,.2,1) backwards}
@keyframes slide{from{transform:translateX(-100%)}}
.brand{display:flex;gap:10px;align-items:center;padding:4px 6px 18px}
.brand img{width:38px;height:38px;object-fit:contain;background:#fff;border-radius:10px;padding:3px}
.brand b{color:#fff;font-size:13px;display:block}.brand small{font-size:11px;color:#8ea3c0}
.grp{font-size:10.5px;letter-spacing:.06em;color:#6f87a8;margin:18px 8px 6px;font-weight:600}
.side a{display:flex;align-items:center;gap:10px;padding:9px 10px;border-radius:9px;color:#cbd5e1;text-decoration:none;font-weight:500;transition:background .25s,transform .25s,color .25s}
.side a:hover{background:rgba(255,255,255,.07);color:#fff;transform:translateX(3px)}
.side a.on{background:rgba(255,255,255,.13);color:#fff;box-shadow:inset 3px 0 0 #34d399}
.dbstat{margin:22px 4px 0;padding:11px;border-radius:10px;background:rgba(255,255,255,.06);font-size:11px}
.dbstat b{color:#fff;display:flex;align-items:center;gap:7px}.dot{width:7px;height:7px;border-radius:50%;background:#34d399;animation:pulse 2s infinite}
@keyframes pulse{0%{box-shadow:0 0 0 0 rgba(52,211,153,.6)}100%{box-shadow:0 0 0 7px rgba(52,211,153,0)}}
</style>
<svg width="0" height="0" style="position:absolute">
<symbol id="grid" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></symbol>
<symbol id="user" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></symbol>
<symbol id="users" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.5"/><path d="M2 20c0-3.5 3-5.5 7-5.5s7 2 7 5.5M17 4.5a3.5 3.5 0 010 7M22 20c0-3-2-4.7-5-5.3"/></symbol>
<symbol id="check" viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 12l3 3 5-6"/></symbol>
<symbol id="chart" viewBox="0 0 24 24"><path d="M3 3v18h18M7 15l4-4 3 3 5-6"/></symbol>
<symbol id="file" viewBox="0 0 24 24"><path d="M14 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V8zM14 3v5h5M9 13h6M9 17h6"/></symbol>
<symbol id="folder" viewBox="0 0 24 24"><path d="M3 6a2 2 0 012-2h4l2 2h8a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></symbol>
<symbol id="upload" viewBox="0 0 24 24"><path d="M12 16V4m0 0l-4 4m4-4l4 4M4 17v3h16v-3"/></symbol>
<symbol id="download" viewBox="0 0 24 24"><path d="M12 4v12m0 0l-4-4m4 4l4-4M4 17v3h16v-3"/></symbol>
<symbol id="qr" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM20 14v7M14 20h3"/></symbol>
<symbol id="search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></symbol>
<symbol id="plus" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></symbol>
<symbol id="print" viewBox="0 0 24 24"><path d="M6 9V3h12v6M6 18H4v-8h16v8h-2M8 14h8v7H8z"/></symbol>
</svg>
<aside class="side">
  <div class="brand"><img src="{{ asset('images/logo-mas-ypi.png') }}" alt="Logo"><div><b>MAS YPI SUMBER HARJO</b><small>SIADDS Digital Archive</small></div></div>
  @foreach($menu as $g)
    <div class="grp">{{ $g[0] }}</div>
    @foreach($g[1] as $m)
      <a href="{{ isset($m[2]) ? route($m[2]) : '#' }}" class="{{ isset($m[2]) && request()->routeIs($m[2]) ? 'on' : '' }}">{!! $ic($m[0]) !!}{{ $m[1] }}</a>
    @endforeach
  @endforeach
  <div class="dbstat"><b><span class="dot"></span>Database Terkoneksi</b>Server Madrasah Aktif</div>
</aside>