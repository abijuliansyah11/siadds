{{-- Tambahan halaman Detail Profil Siswa: hubungan ke Arsip Digital & Fisik. Hanya menambah, tidak mengubah kode yang ada. --}}
@if($siswa ?? null)
@php
  $sdBaris = collect($rows)->map(fn ($r) => [
      'id'    => optional($r['dok'])->id,
      'url'   => $r['dok']
          ? route('arsip.digital', ['q' => $siswa->nis, 'pilih' => $r['dok']->id]) . '#daftar'
          : route('upload.dokumen', ['siswa' => $siswa->id, 'jenis' => $r['jenis']]) . '#unggah',
      'ada'   => (bool) $r['dok'],
  ])->values()->all();

  $sdUrl = [
      'kelengkapan' => route('kelengkapan.dokumen', ['q' => $siswa->nis, 'pilih' => $siswa->id]),
      'upload'      => route('upload.dokumen', ['siswa' => $siswa->id]) . '#unggah',
      'digital'     => route('arsip.digital', ['q' => $siswa->nis]) . '#daftar',
      'fisik'       => route('arsip.fisik', ['q' => $siswa->nis]) . '#daftar',
      'label'       => route('label.qr', ['q' => $siswa->nis]) . '#tabel',
  ];

  $sdFisik = class_exists(\App\Models\ArsipFisik::class)
      ? \App\Models\ArsipFisik::with('rak.lemari.ruang')->where('siswa_aktif_id', $siswa->id)->orderBy('kode_arsip')->get()
      : collect();
@endphp

<template id="sdTplFisik">
  <div style="margin-top:20px;padding-top:16px;border-top:1px solid var(--line)">
    <b>Arsip fisik tercatat di Lokasi Arsip Fisik ({{ $sdFisik->count() }})</b>
    @if($sdFisik->count())
      <ul style="list-style:none;margin:10px 0 0;padding:0;display:grid;gap:8px">
        @foreach($sdFisik as $f)
          @php $rk = $f->rak; $lm = $rk ? $rk->lemari : null; $rg = $lm ? $lm->ruang : null; @endphp
          <li style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;padding:10px 12px;border:1px solid var(--line);border-radius:10px">
            <span><b>{{ $f->kode_arsip }}</b> • {{ $f->jenis }}<br><small class="mu">{{ $rk ? implode(' • ', array_filter([$rg ? $rg->nama : null, $lm->kode, $rk->kode, $f->kode_map])) : 'Belum ditata (belum ada rak)' }}</small></span>
            <a class="btn" href="{{ route('arsip.fisik', ['pilih' => $f->id]) }}#daftar" style="align-self:center">Buka</a>
          </li>
        @endforeach
      </ul>
    @else
      <p class="mu" style="margin-top:8px;line-height:1.6">Belum ada catatan arsip fisik untuk siswa ini. Catat lewat <b>Catat Arsip Fisik</b>, atau klik <b>Sinkronkan dari Data Siswa</b> di halaman Lokasi Arsip Fisik (membaca isian lemari &amp; rak di atas).</p>
    @endif
    <div style="margin-top:12px;display:flex;gap:8px;flex-wrap:wrap">
      <a class="btn" href="{{ route('arsip.fisik', ['q' => $siswa->nis]) }}#daftar">Buka Lokasi Arsip Fisik</a>
      <a class="btn" href="{{ route('label.qr', ['q' => $siswa->nis]) }}#tabel">Cetak Label QR Code</a>
    </div>
  </div>
</template>

<script>
(function () {
  var BARIS = @json($sdBaris);
  var U = @json($sdUrl);

  var css = document.createElement('style');
  css.textContent = '.sd-ln{display:inline-block;margin-top:8px;font-size:11px;font-weight:700;color:var(--green);text-decoration:none}.sd-ln:hover{text-decoration:underline}';
  document.head.appendChild(css);

  /* 1. Tombol di kepala halaman */
  var kanan = document.querySelector('.ph-r');
  if (kanan) {
    [['Kelengkapan Dokumen', U.kelengkapan], ['Upload Dokumen', U.upload], ['Arsip Digital', U.digital], ['Lokasi Arsip Fisik', U.fisik]].forEach(function (x) {
      var a = document.createElement('a'); a.className = 'btn'; a.href = x[1]; a.textContent = x[0]; kanan.appendChild(a);
    });
  }

  /* 2. Menu Quick Action */
  var menu = document.getElementById('qaMenu');
  if (menu) {
    var hr = document.createElement('hr'); menu.appendChild(hr);
    [['Direktori Arsip Digital', U.digital], ['Upload Dokumen', U.upload], ['Kelengkapan Dokumen', U.kelengkapan], ['Lokasi Arsip Fisik', U.fisik], ['Cetak Label QR Code', U.label]].forEach(function (x) {
      var a = document.createElement('a'); a.href = x[1]; a.textContent = x[0]; menu.appendChild(a);
    });
  }

  /* 3. Kartu ringkasan: Kelengkapan Berkas & Lokasi Map Fisik */
  var kartu = document.querySelectorAll('.sm .sc');
  function tautKartu(k, url, teks) {
    if (!k) return;
    var a = document.createElement('a'); a.className = 'sd-ln'; a.href = url; a.textContent = teks; k.appendChild(a);
  }
  tautKartu(kartu[2], U.kelengkapan, 'Buka Kelengkapan Dokumen ›');
  tautKartu(kartu[3], U.fisik, 'Buka Lokasi Arsip Fisik ›');

  /* 4. Tabel dokumen: tautan per baris (periksa di Direktori Arsip / unggah lewat Upload Dokumen) */
  Array.prototype.forEach.call(document.querySelectorAll('.dt tbody tr'), function (tr, i) {
    var b = BARIS[i], aks = tr.querySelector('td.aks');
    if (!b || !aks) return;
    var a = document.createElement('a');
    a.href = b.url;
    if (b.ada) {
      a.className = 'ia'; a.title = 'Periksa & verifikasi di Direktori Arsip Digital';
      a.innerHTML = '<svg class="i"><use href="#d-arrow"/></svg>';
    } else {
      a.className = 'sd-ln'; a.textContent = 'Upload Dokumen ›'; a.title = 'Unggah lewat halaman Upload Dokumen (siswa sudah terpilih)';
      a.style.marginLeft = '8px';
    }
    aks.appendChild(a);
  });

  /* 5. Tab Lokasi Arsip Fisik: daftar arsip fisik siswa ini */
  var tpl = document.getElementById('sdTplFisik'), tab = document.getElementById('tp-lokasi');
  if (tpl && tab) tab.appendChild(tpl.content.cloneNode(true));
})();
</script>
@endif