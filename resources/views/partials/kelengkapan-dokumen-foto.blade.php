{{-- Cadangan foto siswa: bila berkas foto hilang/rusak, tampilkan lingkaran inisial. Dipasang setelah script bawaan; tidak mengubah kode lama. --}}
<script>
(function () {
  'use strict';
  const WARNA = ['#0b1f3a', '#0f7a4f', '#2563eb', '#7c3aed', '#b45309', '#0d9488'];
  const inisial = (n) => String(n || '?').trim().split(/\s+/).map((w) => w[0]).slice(0, 2).join('').toUpperCase() || '?';

  function namaDari(img) {
    const alt = (img.getAttribute('alt') || '').replace(/^Foto\s+/i, '').trim();
    if (alt) return alt;
    const b = img.closest('.idn') && img.closest('.idn').querySelector('b');
    return b ? b.textContent : '';
  }

  function pasang(img) {
    if (img.dataset.fb) return;               // cegah perulangan bila gambar cadangan pun gagal
    img.dataset.fb = '1';
    const nama = namaDari(img);
    const warna = WARNA[(nama.length || 0) % WARNA.length];
    const svg = "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 40 40'><rect width='40' height='40' fill='" + warna + "'/>" +
      "<text x='50%' y='54%' text-anchor='middle' dominant-baseline='middle' font-family='Arial,sans-serif' font-weight='700' font-size='15' fill='#fff'>" +
      inisial(nama).replace(/[<>&]/g, '') + "</text></svg>";
    img.src = 'data:image/svg+xml;utf8,' + encodeURIComponent(svg);
  }

  // Berlaku juga untuk foto yang dibuat ulang saat panel detail berganti siswa
  document.addEventListener('error', (e) => {
    const i = e.target;
    if (i && i.tagName === 'IMG' && i.closest && (i.closest('.idn') || i.closest('.dc'))) pasang(i);
  }, true);

  // Foto yang sudah gagal dimuat sebelum skrip ini berjalan
  document.querySelectorAll('.idn img, .dc img').forEach((i) => { if (i.complete && i.naturalWidth === 0) pasang(i); });
})();
</script>