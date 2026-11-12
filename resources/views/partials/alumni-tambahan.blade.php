{{-- Tambahan halaman Data Alumni: hubungan ke Arsip Digital & Fisik siswa asal. Hanya menambah. --}}
@if(($terpilih ?? null))
@php
  $alUrl = [
      'digital' => route('arsip.digital', ['q' => $terpilih->nis]) . '#daftar',
      'fisik'   => route('arsip.fisik', ['q' => $terpilih->nis]) . '#daftar',
      'label'   => route('label.qr', ['q' => $terpilih->nis]) . '#tabel',
  ];
  if (($siswaAsal ?? null)) {
      $alUrl['kelengkapan'] = route('kelengkapan.dokumen', ['q' => $siswaAsal->nis, 'pilih' => $siswaAsal->id]);
      $alUrl['upload']      = route('upload.dokumen', ['siswa' => $siswaAsal->id]) . '#unggah';
  }
@endphp
<script>
(function () {
  var U = @json($alUrl);
  var ada = !!U.kelengkapan;

  /* 1. Tombol di kepala detail alumni */
  var acts = document.querySelector('#detail .dh .ac');
  if (acts) {
    var pertama = acts.firstChild;
    [['Arsip Digital Siswa', U.digital], ['Lokasi Arsip Fisik', U.fisik]].concat(ada ? [['Kelengkapan Dokumen', U.kelengkapan]] : []).forEach(function (x) {
      var a = document.createElement('a'); a.className = 'btn'; a.href = x[1]; a.textContent = x[0]; acts.insertBefore(a, pertama);
    });
  }

  /* 2. Quick Action */
  var menu = document.getElementById('qaMenu');
  if (menu) {
    menu.appendChild(document.createElement('hr'));
    [['Direktori Arsip Digital', U.digital], ['Lokasi Arsip Fisik', U.fisik], ['Cetak Label QR Code', U.label]].forEach(function (x) {
      var a = document.createElement('a'); a.href = x[1]; a.textContent = x[0]; menu.appendChild(a);
    });
  }

  /* 3. Tab Lokasi: map fisik alumni + arsip fisik siswa semasa aktif */
  var tab = document.getElementById('tp-lokasi');
  if (tab) {
    var d = document.createElement('div');
    d.style.cssText = 'margin-top:20px;padding-top:16px;border-top:1px solid var(--line);line-height:1.7';
    d.innerHTML = '<b>Arsip semasa menjadi siswa</b><p class="mu" style="margin:6px 0 12px">Berkas siswa (KK, akta, ijazah SMP, dll.) tetap tersimpan di arsip digital dan arsip fisik setelah lulus.</p>' +
      '<div style="display:flex;gap:8px;flex-wrap:wrap"><a class="btn" href="' + U.digital + '">Buka Arsip Digital</a><a class="btn" href="' + U.fisik + '">Buka Lokasi Arsip Fisik</a><a class="btn" href="' + U.label + '">Cetak Label QR Code</a></div>' +
      (ada ? '' : '<p class="mu" style="margin-top:10px;font-size:11.5px">Catatan: data siswa asal (NIS sama) tidak ditemukan di Data Siswa Aktif, sehingga pencarian memakai NIS alumni.</p>');
    tab.appendChild(d);
  }

  /* 4. Tab Arsip: tautan ke dokumen siswa */
  var th = document.querySelector('#tp-arsip .th');
  if (th) {
    var p = document.createElement('p');
    p.className = 'mu'; p.style.cssText = 'width:100%;margin:0;font-size:11.5px';
    p.innerHTML = 'Dokumen kelulusan di bawah disimpan terpisah dari dokumen siswa. Dokumen semasa aktif ada di <a href="' + U.digital + '" style="color:var(--green);font-weight:700">Direktori Arsip Digital</a>' + (ada ? ' dan dapat dilengkapi lewat <a href="' + U.upload + '" style="color:var(--green);font-weight:700">Upload Dokumen</a>.' : '.');
    th.appendChild(p);
  }
})();
</script>
@endif