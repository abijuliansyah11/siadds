{{-- Tambahan halaman Tambah Siswa Baru: hubungan ke Arsip Digital & Fisik. Hanya menambah. --}}
<script>
(function () {
  var U = {
    digital: @json(route('arsip.digital') . '#daftar'),
    upload: @json(route('upload.dokumen') . '#unggah'),
    kelengkapan: @json(route('kelengkapan.dokumen')),
    fisik: @json(route('arsip.fisik') . '#daftar'),
    label: @json(route('label.qr') . '#tabel')
  };

  /* 1. Quick Action */
  var menu = document.getElementById('qaMenu');
  if (menu) {
    menu.appendChild(document.createElement('hr'));
    [['Direktori Arsip Digital', U.digital], ['Upload Dokumen', U.upload], ['Kelengkapan Dokumen', U.kelengkapan], ['Lokasi Arsip Fisik', U.fisik], ['Cetak Label QR Code', U.label]].forEach(function (x) {
      var a = document.createElement('a'); a.href = x[1]; a.textContent = x[0]; menu.appendChild(a);
    });
  }

  /* 2. Penjelasan alur setelah disimpan (tahap 4 & 5) */
  function info(panel, html) {
    var c = document.querySelector('.panel[data-s="' + panel + '"]');
    if (!c) return;
    var p = document.createElement('div');
    p.className = 'card'; p.style.cssText = 'margin-top:16px;background:#f1faf5;border-color:#cfeedd;line-height:1.7';
    p.innerHTML = html; c.appendChild(p);
  }
  info(4, '<b>Setelah disimpan, berkas langsung masuk ke arsip.</b><br>Dokumen yang diunggah di sini tercatat <b>Valid</b> di <a href="' + U.digital + '" style="color:var(--green);font-weight:700">Direktori Arsip Digital</a>. Berkas yang belum lengkap dapat dilengkapi nanti lewat <a href="' + U.upload + '" style="color:var(--green);font-weight:700">Upload Dokumen</a>, dan kelengkapannya dipantau di <a href="' + U.kelengkapan + '" style="color:var(--green);font-weight:700">Kelengkapan Dokumen</a>.');
  info(5, '<b>Langkah berikutnya setelah menyimpan:</b> catat lokasi map fisik siswa di <a href="' + U.fisik + '" style="color:var(--green);font-weight:700">Lokasi Arsip Fisik</a> (isian Lemari &amp; Rak di samping ikut terbawa), lalu cetak label di <a href="' + U.label + '" style="color:var(--green);font-weight:700">Cetak Label QR Code</a>.');
})();
</script>