<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>SKL — {{ count($halaman) === 1 ? $halaman[0]['nama'] : count($halaman) . ' alumni' }} | {{ $set['madrasah'] }}</title>
<style>
:root{--navy:#0b1f3a;--green:#0f7a4f}
*{box-sizing:border-box}
html{-webkit-print-color-adjust:exact;print-color-adjust:exact}
body{margin:0;background:#e9eef4;font-family:Arial,Helvetica,"Liberation Sans",sans-serif;color:#000}
.bar{position:sticky;top:0;z-index:9;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:10px;padding:11px 22px;background:var(--navy);color:#fff;font-size:13px}
.bar .ket{display:flex;flex-direction:column;gap:2px}.bar small{color:#fcd34d;font-size:11.5px}
.bar .ak{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
.bar label{font-size:11.5px;color:#cbd5e1;display:flex;align-items:center;gap:6px}
.bar input[type=date]{border:0;border-radius:8px;padding:6px 8px;font:600 12px Arial,sans-serif}
.bar button,.bar a{border:0;border-radius:10px;padding:9px 16px;font:700 12px Arial,sans-serif;cursor:pointer;text-decoration:none;background:rgba(255,255,255,.14);color:#fff}
.bar .g{background:var(--green)}

/* ---------- Lembar A4 ---------- */
.page{width:210mm;height:297mm;margin:20px auto;background:#fff;padding:12mm 16mm 12mm;box-shadow:0 18px 50px rgba(11,31,58,.2);font-size:11pt;line-height:1.28;position:relative;overflow:hidden}
.isi{height:273mm;overflow:hidden;position:relative}

.kop{display:flex;align-items:center;gap:3mm;padding-bottom:2.2mm;border-bottom:1.2mm double #000;text-align:center}
.kop .lg{width:23mm;height:23mm;flex:0 0 23mm;display:flex;align-items:center;justify-content:center}
.kop .lg img{max-width:100%;max-height:100%;object-fit:contain}
.kop .tx{flex:1}
.kop .k1{font-weight:700;font-size:1.12em;letter-spacing:.01em}
.kop .k2{font-weight:700;font-size:1.05em}
.kop .nm{font-weight:800;font-size:1.5em;line-height:1.15;margin:.1em 0}
.kop .al{font-size:.78em;font-style:italic}
.kop .np{font-size:.8em;font-weight:700}

.jdl{text-align:center;margin:3.2mm 0 2.4mm}
.jdl h1{margin:0;font-size:1.3em;letter-spacing:.02em;text-decoration:underline;font-weight:800}
.jdl p{margin:.15em 0 0;font-size:.95em}

p.t{margin:.5em 0;text-align:justify}
ol.dasar{margin:.2em 0 .3em;padding-left:1.7em}
ol.dasar li{margin:.1em 0}

table.idn{border-collapse:collapse;width:100%;margin:.2em 0}
table.idn td{padding:.08em 0;vertical-align:top}
table.idn td:first-child{width:36%}
table.idn td:nth-child(2){width:3%}
table.idn td:last-child{font-weight:700}

.lulus{text-align:center;font-weight:800;font-size:1.5em;letter-spacing:.06em;margin:.35em 0 .35em}

table.nilai{border-collapse:collapse;width:100%;border:.35mm solid #000}
table.nilai th,table.nilai td{border:.25mm solid #000;padding:.12em .5em;font-size:.92em}
table.nilai thead th{background:#e6e6e6;font-weight:700;text-align:center;padding:.3em .5em}
table.nilai td.no{width:9%;text-align:center}
table.nilai td.v{width:20%;text-align:center}
table.nilai tr.gr td{font-weight:700;text-align:left;padding:.12em .5em}
table.nilai tr.rt td{font-weight:800;text-align:center;background:#e6e6e6;padding:.3em .5em}
table.nilai tr.rt td.v{font-size:1.05em}

.pen{display:flex;justify-content:space-between;gap:6mm;margin-top:.7em;align-items:flex-end}
.qrw{display:flex;gap:3mm;align-items:flex-start;width:50%}
.qr{width:29mm;height:29mm;flex:0 0 29mm;border:.3mm solid #000;padding:1mm;display:flex;align-items:center;justify-content:center;font-size:.62em;text-align:center;color:#444}
.qr img,.qr canvas{width:100%!important;height:100%!important;display:block}
.cat{font-size:.66em;line-height:1.3;padding-top:.2em}
.cat b{display:block;margin-bottom:.15em;font-style:italic}
.ttd{width:46%;text-align:left;font-size:.98em;position:relative}
.ttd .sp{height:20mm;position:relative}
.ttd .sp img{position:absolute;left:0;top:-3mm;height:26mm;max-width:100%;object-fit:contain}
.ttd .kp{font-weight:700;text-decoration:underline}

@media print{
  @page{size:A4;margin:0}
  body{background:#fff}
  .bar{display:none}
  .page{margin:0;box-shadow:none;break-after:page;page-break-after:always}
  .page:last-of-type{break-after:auto;page-break-after:auto}
}
</style>
</head>
<body>
@php
  use App\Http\Controllers\SklController as S;
  $logoKiri  = S::urlGambar($set['logo_kiri']);
  $logoKanan = S::urlGambar($set['logo_kanan']);
  $gbrTtd    = S::urlGambar($set['gambar_ttd']);
@endphp

<div class="bar">
  <div class="ket">
    <b>Pratinjau Surat Keterangan Lulus — {{ count($halaman) }} lembar</b>
    @if($lewat->isNotEmpty())<small>Dilewati (data belum lengkap): {{ $lewat->implode(', ') }}</small>@endif
  </div>
  <div class="ak">
    <label>Tanggal terbit <input type="date" id="tgl" value="{{ request('tgl', now()->format('Y-m-d')) }}"></label>
    <a href="{{ route('label.qr') }}#skl">← Kembali</a>
    <button type="button" class="g" id="btnCetak">Cetak / Simpan PDF</button>
  </div>
</div>

@foreach($halaman as $h)
<div class="page">
 <div class="isi">

  <div class="kop">
    <div class="lg">@if($logoKiri)<img src="{{ $logoKiri }}" alt="" onerror="this.style.display='none'">@endif</div>
    <div class="tx">
      @if($set['kop1'] !== '')<div class="k1">{{ $set['kop1'] }}</div>@endif
      @if($set['kop2'] !== '')<div class="k2">{{ $set['kop2'] }}</div>@endif
      <div class="nm">{{ $set['madrasah'] }}</div>
      @if($set['alamat'] !== '')<div class="al">{{ $set['alamat'] }}</div>@endif
      @if($set['npsn'] !== '')<div class="np">NPSN: {{ $set['npsn'] }}</div>@endif
    </div>
    <div class="lg">@if($logoKanan)<img src="{{ $logoKanan }}" alt="" onerror="this.style.display='none'">@endif</div>
  </div>

  <div class="jdl"><h1>SURAT KETERANGAN LULUS</h1><p>Nomor : {{ $h['nomor'] }}</p></div>

  <p class="t">Kepala {{ $set['madrasah'] }} selaku Ketua Penyelenggara Ujian Madrasah Tahun Pelajaran {{ $h['tp'] }} berdasarkan :</p>
  <ol class="dasar">
    <li>Ketuntasan dari seluruh program pembelajaran pada {{ $set['kurikulum'] }}.</li>
    <li>Kriteria Kelulusan dari Satuan Pendidikan sesuai dengan peraturan perundang-undangan.</li>
    <li>Rapat Pleno Dewan Guru tentang Kelulusan pada tanggal {{ $h['pleno'] }}.</li>
  </ol>

  <p class="t" style="margin-bottom:.15em">Menerangkan bahwa:</p>
  <table class="idn">
    <tr><td>Nama</td><td>:</td><td>{{ $h['nama'] }}</td></tr>
    <tr><td>Tempat, tanggal lahir</td><td>:</td><td>{{ $h['ttl'] }}</td></tr>
    <tr><td>Nama Orang Tua / Wali</td><td>:</td><td>{{ $h['ortu'] }}</td></tr>
    <tr><td>Nomor Induk Siswa</td><td>:</td><td>{{ $h['nis'] }}</td></tr>
    <tr><td>Nomor Induk Siswa Nasional</td><td>:</td><td>{{ $h['nisn'] }}</td></tr>
    <tr><td>Peminatan / Jurusan</td><td>:</td><td>{{ $h['jurusan'] }}</td></tr>
  </table>
  <div style="margin-top:.2em">Dinyatakan :</div>
  <div class="lulus">LULUS</div>

  <table class="nilai">
    <thead><tr><th>No.</th><th>Mata Pelajaran ({{ $set['kurikulum'] }})</th><th>Nilai Ujian Madrasah</th></tr></thead>
    <tbody>
      @foreach($h['grup'] as $g)
        <tr class="gr"><td colspan="3">{{ $g['judul'] }}</td></tr>
        @foreach($g['baris'] as $b)
          <tr><td class="no">{{ $b['no'] }}</td><td>{{ $b['n'] }}</td><td class="v">{{ $b['v'] }}</td></tr>
        @endforeach
      @endforeach
      <tr class="rt"><td colspan="2">Rata-rata</td><td class="v">{{ $h['rata'] }}</td></tr>
    </tbody>
  </table>

  <p class="t" style="margin-top:.6em">Demikian Surat Keterangan Lulus ini dibuat dengan sebenar-benarnya dan dapat dipergunakan sebagaimana mestinya.</p>

  <div class="pen">
    <div class="qrw">
      <div class="qr" @if($h['qr']) data-qr="{{ $h['qr'] }}" @endif>@unless($h['qr'])QR tersedia setelah nomor ijazah terbit @endunless</div>
      <div class="cat"><b>Catatan:</b>SKL ini berlaku sampai ijazah diterbitkan. Keaslian dokumen dapat diperiksa dengan memindai QR Code di samping.</div>
    </div>
    <div class="ttd">
      <span class="tgl-terbit">{{ $set['kota'] }}, {{ $terbit }}</span><br>Kepala Madrasah,
      <div class="sp">@if($gbrTtd)<img src="{{ $gbrTtd }}" alt="" onerror="this.style.display='none'">@endif</div>
      @if($set['kepala'] !== '')<span class="kp">{{ $set['kepala'] }}</span>@else<span>( ............................................ )</span>@endif
      @if($set['nip'] !== '')<br>NIP. {{ $set['nip'] }}@endif
    </div>
  </div>

 </div>
</div>
@endforeach

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>
<script>
(function () {
  'use strict';
  var IDS = @json($idsCetak);
  var OTOMATIS = @json($otomatis);
  var URL_CATAT = @json(route('label.skl.catat'));
  var meta = document.querySelector('meta[name="csrf-token"]');
  var CSRF = meta ? meta.getAttribute('content') : '';

  /* 1. QR Code */
  function buatQr() {
    Array.prototype.forEach.call(document.querySelectorAll('.qr[data-qr]'), function (el) {
      if (el.getAttribute('data-ok')) return;
      if (typeof QRCode === 'undefined') { el.textContent = 'QR tidak termuat (periksa koneksi internet)'; return; }
      el.textContent = '';
      new QRCode(el, { text: el.getAttribute('data-qr'), width: 220, height: 220, correctLevel: QRCode.CorrectLevel.M });
      el.setAttribute('data-ok', '1');
    });
  }

  /* 2. Pas satu halaman A4: kecilkan huruf bila isi meluap */
  function pas() {
    Array.prototype.forEach.call(document.querySelectorAll('.page'), function (pg) {
      var isi = pg.querySelector('.isi');
      var ukuran = 11;
      pg.style.fontSize = ukuran + 'pt';
      while (isi.scrollHeight > isi.clientHeight + 1 && ukuran > 7.5) {
        ukuran -= 0.25;
        pg.style.fontSize = ukuran + 'pt';
      }
    });
  }

  /* 3. Tanggal terbit */
  var tgl = document.getElementById('tgl');
  if (tgl) tgl.addEventListener('change', function () {
    var u = new URL(location.href); u.searchParams.set('tgl', tgl.value); u.searchParams.delete('print');
    location.href = u.toString();
  });

  /* 4. Cetak: catat ke log dulu, lalu buka dialog cetak */
  function catat() {
    return Promise.race([
      fetch(URL_CATAT, {
        method: 'POST', credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF, 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ ids: IDS })
      }),
      new Promise(function (r) { setTimeout(r, 1800); })
    ]).catch(function () {});
  }
  function cetak() { pas(); catat().then(function () { window.print(); }); }

  document.getElementById('btnCetak').addEventListener('click', cetak);

  window.addEventListener('load', function () {
    buatQr();
    pas();
    if (OTOMATIS) setTimeout(cetak, 500);
  });
})();
</script>
</body>
</html>