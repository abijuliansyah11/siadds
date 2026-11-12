<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Buku Induk — {{ $siswa->nama }} | MAS YPI SUMBER HARJO</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#0b1f3a;--green:#0f7a4f;--mint:#e3f6ec;--line:#dbe2ea;--mu:#5b6b7e;--tx:#1c2733}
*{box-sizing:border-box}
body{margin:0;background:#e9eef4;font-family:Inter,system-ui,sans-serif;color:var(--tx);font-size:12.5px}
.bar{position:sticky;top:0;z-index:5;display:flex;justify-content:space-between;align-items:center;gap:10px;padding:12px 24px;background:var(--navy);color:#fff}
.bar b{font-size:13px}.bar div{display:flex;gap:8px}
.bar button,.bar a{border:0;border-radius:10px;padding:9px 16px;font:700 12px Inter,sans-serif;cursor:pointer;text-decoration:none;background:rgba(255,255,255,.12);color:#fff}
.bar .g{background:var(--green)}
.page{width:210mm;min-height:297mm;margin:22px auto;background:#fff;padding:16mm 16mm 14mm;box-shadow:0 18px 50px rgba(11,31,58,.18);animation:up .7s cubic-bezier(.2,.8,.2,1) backwards}
@keyframes up{from{opacity:0;transform:translateY(24px)}}
.kop{display:flex;gap:14px;align-items:center;padding-bottom:12px;border-bottom:3px double var(--navy)}
.kop img{width:62px;height:62px;object-fit:contain}
.kop h1{margin:0;font-size:16px;letter-spacing:.02em}.kop p{margin:3px 0 0;color:var(--mu);font-size:11px;line-height:1.5}
.judul{text-align:center;margin:16px 0 14px}.judul h2{margin:0;font-size:15px;letter-spacing:.12em}.judul p{margin:4px 0 0;color:var(--mu)}
.top{display:grid;grid-template-columns:1fr 30mm;gap:16px;align-items:start}
.foto{width:30mm;height:40mm;border:1px solid var(--line);border-radius:6px;object-fit:cover;display:grid;place-items:center;background:#f1f5f9;color:var(--mu);font-size:30px;font-weight:800}
h3{margin:16px 0 6px;font-size:12px;letter-spacing:.08em;color:var(--green);border-bottom:1px solid var(--line);padding-bottom:4px}
table{width:100%;border-collapse:collapse}
td,th{padding:6px 8px;vertical-align:top;text-align:left}
.kv td:first-child{width:38%;color:var(--mu)}.kv td:nth-child(2){width:14px}.kv td:last-child{font-weight:600}
.dok th{background:#f1f5f9;font-size:10.5px;letter-spacing:.05em;color:var(--mu);border:1px solid var(--line)}
.dok td{border:1px solid var(--line)}
.st{font-weight:700}.st.ok{color:#0a5c3b}.st.no{color:#b42318}
.ttd{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:26px;text-align:center}
.ttd .sp{height:62px}.ttd b{text-decoration:underline}
.foot{margin-top:18px;padding-top:8px;border-top:1px solid var(--line);color:var(--mu);font-size:10.5px;display:flex;justify-content:space-between}
@media print{body{background:#fff}.bar{display:none}.page{margin:0;box-shadow:none;width:auto;min-height:0;padding:0;animation:none}@page{size:A4;margin:14mm}}
</style>
</head>
<body>
@php
  $bln = fn ($t) => $t ? $t->copy()->locale('id')->translatedFormat('d F Y') : '-';
  $agama = $siswa->getAttribute('agama') ?: 'Islam';
  $jk = $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
  $ttl = ($siswa->tempat_lahir ?: '-') . ', ' . $bln($siswa->tanggal_lahir);
@endphp

<div class="bar">
  <b>Pratinjau Buku Induk — {{ $siswa->nama }}</b>
  <div><a href="{{ route('siswa.aktif', ['id' => $siswa->id]) }}">← Kembali</a><button type="button" class="g" onclick="window.print()">Cetak / Simpan PDF</button></div>
</div>

<div class="page">
  <div class="kop">
    <img src="{{ asset('images/logo-mas-ypi.png') }}" alt="" onerror="this.style.display='none'">
    <div><h1>MAS YPI SUMBER HARJO</h1><p>Jl. Masjid Nurul Iman, Kab Oku Timur, Kec. Buay Madang Timur, Desa Sumber Harjo<br>NPSN: 10648892 • Sistem Informasi Arsip Digital &amp; Data Siswa (SIADDS)</p></div>
  </div>

  <div class="judul"><h2>BUKU INDUK SISWA</h2><p>Tahun Ajaran {{ $siswa->tahun_ajaran }} • Nomor Induk {{ $siswa->nis }}</p></div>

  <div class="top">
    <div>
      <h3 style="margin-top:0">A. IDENTITAS SISWA</h3>
      <table class="kv">
        <tr><td>Nama Lengkap</td><td>:</td><td>{{ $siswa->nama }}</td></tr>
        <tr><td>Nama Panggilan</td><td>:</td><td>{{ $siswa->panggilan ?: '-' }}</td></tr>
        <tr><td>NIS / NISN</td><td>:</td><td>{{ $siswa->nis }} / {{ $siswa->nisn }}</td></tr>
        <tr><td>NIK</td><td>:</td><td>{{ $siswa->nik ?: '-' }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $jk }}</td></tr>
        <tr><td>Tempat, Tanggal Lahir</td><td>:</td><td>{{ $ttl }}</td></tr>
        <tr><td>Agama</td><td>:</td><td>{{ $agama }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td>{{ $siswa->alamat ?: '-' }}</td></tr>
      </table>
    </div>
    @if($siswa->foto)<img class="foto" src="{{ asset('storage/' . $siswa->foto) }}" alt="Foto {{ $siswa->nama }}">@else<div class="foto">{{ strtoupper(substr($siswa->nama, 0, 1)) }}</div>@endif
  </div>

  <h3>B. DATA AKADEMIK</h3>
  <table class="kv">
    <tr><td>Kelas / Rombel</td><td>:</td><td>{{ $siswa->kelas }}{{ $siswa->rombel ? ' (' . $siswa->rombel . ')' : '' }}</td></tr>
    <tr><td>Tahun Masuk / Tanggal Masuk</td><td>:</td><td>{{ $siswa->tahun_masuk }} / {{ $bln($siswa->tanggal_masuk) }}</td></tr>
    <tr><td>Asal Sekolah</td><td>:</td><td>{{ $siswa->asal_sekolah ?: '-' }}</td></tr>
    <tr><td>Wali Kelas</td><td>:</td><td>{{ $siswa->wali_kelas ?: '-' }}</td></tr>
    <tr><td>Status Siswa</td><td>:</td><td>{{ $siswa->status }}</td></tr>
  </table>

  <h3>C. DATA ORANG TUA / WALI</h3>
  <table class="kv">
    <tr><td>Nama Ayah</td><td>:</td><td>{{ $siswa->nama_ayah ?: '-' }}</td></tr>
    <tr><td>Nama Ibu</td><td>:</td><td>{{ $siswa->nama_ibu ?: '-' }}</td></tr>
    <tr><td>No. HP / WhatsApp Wali</td><td>:</td><td>{{ $siswa->no_hp_wali ?: '-' }}</td></tr>
  </table>

  <h3>D. LOKASI ARSIP FISIK</h3>
  <table class="kv">
    <tr><td>Ruang Penyimpanan</td><td>:</td><td>{{ $siswa->ruang_arsip ?: '-' }}</td></tr>
    <tr><td>Lemari / Rak</td><td>:</td><td>{{ $siswa->lemari ?: '-' }} / {{ $siswa->rak ?: '-' }}</td></tr>
    <tr><td>Kode Label Map Ordner</td><td>:</td><td>{{ $siswa->kode_map ?: '-' }}</td></tr>
  </table>

  <h3>E. KELENGKAPAN DOKUMEN ({{ min($siswa->dokumen->where('status', 'valid')->count(), $wajib) }}/{{ $wajib }} TERVERIFIKASI)</h3>
  <table class="dok">
    <tr><th>NO</th><th>JENIS DOKUMEN</th><th>NAMA BERKAS</th><th>DIUNGGAH</th><th>STATUS</th></tr>
    @foreach(\App\Models\SiswaAktif::DOKUMEN_WAJIB as $i => $jenis)
      @php $d = $siswa->dokumen->firstWhere('jenis', $jenis); @endphp
      <tr>
        <td>{{ $i + 1 }}</td><td>{{ $jenis }}</td>
        <td>{{ $d ? $d->nama_file : '-' }}</td>
        <td>{{ $d ? $bln($d->tanggal_unggah) : '-' }}</td>
        <td>@if($d && $d->status === 'valid')<span class="st ok">Terverifikasi</span>@elseif($d)<span class="st">Menunggu</span>@else<span class="st no">Belum ada</span>@endif</td>
      </tr>
    @endforeach
  </table>

  <div class="ttd">
    <div>Mengetahui,<br>Kepala Madrasah<div class="sp"></div><b>(................................)</b></div>
    <div>Sumber Harjo, {{ now()->locale('id')->translatedFormat('d F Y') }}<br>Wali Kelas<div class="sp"></div><b>{{ $siswa->wali_kelas ?: '(................................)' }}</b></div>
  </div>

  <div class="foot"><span>Dicetak dari SIADDS • {{ optional(auth()->user())->name ?? 'Administrator' }}</span><span>Kemenag Kab. OKU Timur</span></div>
</div>

<script>
if (new URLSearchParams(location.search).get('print') === '1') {
  window.addEventListener('load', function () { setTimeout(function () { window.print(); }, 600); });
}
</script>
</body>
</html>