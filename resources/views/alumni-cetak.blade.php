<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SKL — {{ $alumni->nama }} | MAS YPI SUMBER HARJO</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--navy:#0b1f3a;--green:#0f7a4f;--line:#dbe2ea;--mu:#5b6b7e;--tx:#1c2733}
*{box-sizing:border-box}
body{margin:0;background:#e9eef4;font-family:Inter,system-ui,sans-serif;color:var(--tx);font-size:13px}
.bar{position:sticky;top:0;z-index:5;display:flex;justify-content:space-between;align-items:center;gap:10px;padding:12px 24px;background:var(--navy);color:#fff}
.bar div{display:flex;gap:8px}
.bar button,.bar a{border:0;border-radius:10px;padding:9px 16px;font:700 12px Inter,sans-serif;cursor:pointer;text-decoration:none;background:rgba(255,255,255,.12);color:#fff}
.bar .g{background:var(--green)}
.page{width:210mm;min-height:297mm;margin:22px auto;background:#fff;padding:16mm 18mm 14mm;box-shadow:0 18px 50px rgba(11,31,58,.18);animation:up .7s cubic-bezier(.2,.8,.2,1) backwards}
@keyframes up{from{opacity:0;transform:translateY(24px)}}
.kop{display:flex;gap:14px;align-items:center;padding-bottom:12px;border-bottom:3px double var(--navy)}
.kop img{width:64px;height:64px;object-fit:contain}
.kop h1{margin:0;font-size:17px}.kop p{margin:3px 0 0;color:var(--mu);font-size:11px;line-height:1.5}
.judul{text-align:center;margin:22px 0 18px}.judul h2{margin:0;font-size:16px;letter-spacing:.14em;text-decoration:underline}.judul p{margin:5px 0 0}
p.isi{line-height:1.8;text-align:justify;margin:10px 0}
table{border-collapse:collapse;width:100%}td{padding:5px 8px;vertical-align:top}
.kv td:first-child{width:36%;color:var(--mu)}.kv td:nth-child(2){width:14px}.kv td:last-child{font-weight:600}
.lulus{margin:18px 0;padding:12px;text-align:center;border:2px solid var(--green);border-radius:8px;font-size:18px;font-weight:800;letter-spacing:.3em;color:var(--green)}
h3{margin:18px 0 6px;font-size:12px;letter-spacing:.08em;color:var(--green);border-bottom:1px solid var(--line);padding-bottom:4px}
.ttd{margin-top:30px;margin-left:55%;text-align:center}.ttd .sp{height:70px}.ttd b{text-decoration:underline}
.foot{margin-top:24px;padding-top:8px;border-top:1px solid var(--line);color:var(--mu);font-size:10.5px;display:flex;justify-content:space-between}
@media print{body{background:#fff}.bar{display:none}.page{margin:0;box-shadow:none;width:auto;min-height:0;padding:0;animation:none}@page{size:A4;margin:14mm}}
</style>
</head>
<body>
@php
  $bln = fn ($t) => $t ? $t->copy()->locale('id')->translatedFormat('d F Y') : '-';
  $jk = $alumni->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
  $noSkl = $alumni->nomor_skl ?: ('421.3/SKL/MAS-SH/' . $alumni->tahun_lulus);
@endphp

<div class="bar">
  <b>Pratinjau Surat Keterangan Lulus — {{ $alumni->nama }}</b>
  <div><a href="{{ route('alumni', ['id' => $alumni->id]) }}">← Kembali</a><button type="button" class="g" onclick="window.print()">Cetak / Simpan PDF</button></div>
</div>

<div class="page">
  <div class="kop">
    <img src="{{ asset('images/logo-mas-ypi.png') }}" alt="" onerror="this.style.display='none'">
    <div><h1>MAS YPI SUMBER HARJO</h1><p>Jl. Masjid Nurul Iman, Kab Oku Timur, Kec. Buay Madang Timur, Desa Sumber Harjo<br>NPSN: 10648892 • Kementerian Agama Kab. OKU Timur</p></div>
  </div>

  <div class="judul"><h2>SURAT KETERANGAN LULUS</h2><p>Nomor: {{ $noSkl }}</p></div>

  <p class="isi">Kepala Madrasah Aliyah Swasta YPI Sumber Harjo menerangkan dengan sebenarnya bahwa:</p>
  <table class="kv">
    <tr><td>Nama Lengkap</td><td>:</td><td>{{ $alumni->nama }}</td></tr>
    <tr><td>NIS / NISN</td><td>:</td><td>{{ $alumni->nis }} / {{ $alumni->nisn }}</td></tr>
    <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $jk }}</td></tr>
    <tr><td>Kelas Terakhir</td><td>:</td><td>{{ $alumni->kelas_terakhir }}{{ $alumni->jurusan ? ' (' . $alumni->jurusan . ')' : '' }}</td></tr>
    <tr><td>Tahun Masuk</td><td>:</td><td>{{ $alumni->tahun_masuk }}</td></tr>
    <tr><td>Nomor Ijazah</td><td>:</td><td>{{ $alumni->nomor_ijazah ?: '-' }}</td></tr>
  </table>

  <div class="lulus">LULUS</div>

  <p class="isi">Yang bersangkutan dinyatakan <b>LULUS</b> dari satuan pendidikan MAS YPI Sumber Harjo pada Tahun Pelajaran {{ $alumni->tahun_lulus - 1 }}/{{ $alumni->tahun_lulus }}, berdasarkan hasil rapat pleno dewan guru yang ditetapkan pada tanggal {{ $bln($alumni->tanggal_kelulusan) }}.</p>

  <h3>RINGKASAN HASIL AKADEMIK</h3>
  <table class="kv">
    <tr><td>Rata-rata Kelulusan</td><td>:</td><td>{{ $alumni->rata_rata !== null ? number_format($alumni->rata_rata, 2) : '-' }}</td></tr>
    <tr><td>Angkatan</td><td>:</td><td>{{ \App\Models\Alumni::romawi((int) $alumni->angkatan) }} ({{ $alumni->tahun_lulus }})</td></tr>
    <tr><td>Prestasi</td><td>:</td><td>@if($alumni->prestasi)@foreach(preg_split('/\r\n|\r|\n/', $alumni->prestasi) as $pr)<div>• {{ $pr }}</div>@endforeach @else - @endif</td></tr>
  </table>

  <p class="isi">Surat keterangan ini diberikan sebagai dasar penerbitan ijazah dan dapat dipergunakan sebagaimana mestinya.</p>

  <div class="ttd">Sumber Harjo, {{ now()->locale('id')->translatedFormat('d F Y') }}<br>Kepala Madrasah<div class="sp"></div><b>(................................)</b></div>

  <div class="foot"><span>Dicetak dari SIADDS • {{ optional(auth()->user())->name ?? 'Administrator' }}</span><span>Verifikasi: /verifikasi-alumni/{{ $alumni->nomor_ijazah ?: '-' }}</span></div>
</div>

<script>
if (new URLSearchParams(location.search).get('print') === '1') {
  window.addEventListener('load', function () { setTimeout(function () { window.print(); }, 600); });
}
</script>
</body>
</html>