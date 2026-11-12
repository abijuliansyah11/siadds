<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verifikasi Ijazah Alumni | MAS YPI SUMBER HARJO</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#0b1f3a;--green:#0f7a4f;--mint:#e3f6ec;--line:#dbe2ea;--mu:#5b6b7e;--tx:#1c2733}
*{box-sizing:border-box}
body{margin:0;min-height:100vh;display:grid;place-items:center;padding:24px;background:linear-gradient(160deg,#0b1f3a,#12396a);font-family:Inter,system-ui,sans-serif;color:var(--tx)}
.card{width:min(520px,100%);background:#fff;border-radius:22px;padding:30px;box-shadow:0 30px 80px rgba(0,0,0,.35);animation:up .8s cubic-bezier(.2,.8,.2,1) backwards}
@keyframes up{from{opacity:0;transform:translateY(30px) scale(.98)}}
.brand{display:flex;gap:12px;align-items:center;margin-bottom:20px}
.brand img{width:46px;height:46px;object-fit:contain}.brand b{display:block}.brand small{color:var(--mu)}
.badge{display:flex;gap:14px;align-items:center;padding:16px;border-radius:16px;margin-bottom:20px}
.badge.ok{background:var(--mint);color:#0a5c3b}.badge.no{background:#fdecea;color:#b42318}
.badge .i{width:46px;height:46px;border-radius:50%;display:grid;place-items:center;font-size:24px;font-weight:800;color:#fff;flex:none;animation:pop .7s cubic-bezier(.2,.8,.2,1) .3s backwards}
.badge.ok .i{background:var(--green)}.badge.no .i{background:#b42318}
@keyframes pop{from{transform:scale(0) rotate(-40deg)}}
.badge b{font-size:16px;display:block}.badge small{opacity:.85}
dl{display:grid;grid-template-columns:150px 1fr;gap:10px 14px;margin:0}dt{color:var(--mu)}dd{margin:0;font-weight:600}
.foot{margin-top:22px;padding-top:14px;border-top:1px solid var(--line);color:var(--mu);font-size:11.5px;line-height:1.6}
@media(max-width:480px){dl{grid-template-columns:1fr}}
</style>
</head>
<body>
@php
  $bln = fn ($t) => $t ? $t->copy()->locale('id')->translatedFormat('d F Y') : '-';
@endphp
<div class="card">
  <div class="brand"><img src="{{ asset('images/logo-mas-ypi.png') }}" alt="" onerror="this.style.display='none'"><div><b>MAS YPI SUMBER HARJO</b><small>Verifikasi Dokumen Alumni • SIADDS</small></div></div>

  @if($alumni)
    @php $nisn = $alumni->nisn; $nisnMask = strlen($nisn) >= 6 ? substr($nisn, 0, 3) . str_repeat('•', strlen($nisn) - 5) . substr($nisn, -2) : $nisn; @endphp
    <div class="badge ok"><span class="i">✓</span><div><b>Dokumen Terverifikasi</b><small>Data ini tercatat resmi pada arsip permanen madrasah.</small></div></div>
    <dl>
      <dt>Nama Alumni</dt><dd>{{ $alumni->nama }}</dd>
      <dt>Nomor Ijazah</dt><dd>{{ $alumni->nomor_ijazah }}</dd>
      <dt>NISN</dt><dd>{{ $nisnMask }}</dd>
      <dt>Kelas Terakhir</dt><dd>{{ $alumni->kelas_terakhir }}{{ $alumni->jurusan ? ' (' . $alumni->jurusan . ')' : '' }}</dd>
      <dt>Tahun Lulus</dt><dd>{{ $alumni->tahun_lulus }} • Angkatan {{ \App\Models\Alumni::romawi((int) $alumni->angkatan) }}</dd>
      <dt>Penetapan Kelulusan</dt><dd>{{ $bln($alumni->tanggal_kelulusan) }}</dd>
    </dl>
  @else
    <div class="badge no"><span class="i">!</span><div><b>Dokumen Tidak Ditemukan</b><small>Nomor {{ $nomor }} tidak terdaftar pada arsip madrasah.</small></div></div>
    <p style="color:var(--mu);line-height:1.7;margin:0">Pastikan QR Code berasal dari dokumen asli. Jika ragu, hubungi Tata Usaha MAS YPI Sumber Harjo.</p>
  @endif

  <div class="foot">Diverifikasi oleh Sistem Informasi Arsip Digital &amp; Data Siswa (SIADDS) • MAS YPI Sumber Harjo, Kemenag Kab. OKU Timur.</div>
</div>
</body>
</html>