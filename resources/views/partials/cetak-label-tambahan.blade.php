{{-- Tambahan halaman Cetak Label QR Code: hanya menambah, tidak mengubah skrip/tampilan yang sudah ada. --}}
<script>
(function () {
  'use strict';
  var C = window.CETAKLABEL || {};
  var URL_FISIK = @json(route('arsip.fisik'));

  /* 1. Segarkan pilihan yang tersimpan di browser (sessionStorage) dengan data terbaru dari database.
        Dijalankan SEBELUM skrip utama membaca pilihan, supaya lokasi/nama/kelas pada label tidak usang
        bila arsip baru saja dipindah atau dikoreksi di halaman Lokasi Arsip Fisik. */
  try {
    var kunci = C.kunci && C.kunci.pilihan;
    var simpan = kunci ? JSON.parse(sessionStorage.getItem(kunci) || '[]') : [];
    if (Array.isArray(simpan) && simpan.length) {
      var segar = simpan.map(function (d) { return (C.data && C.data[d.id]) ? C.data[d.id] : d; });
      sessionStorage.setItem(kunci, JSON.stringify(segar));
    }
  } catch (e) { /* abaikan */ }

  function mulai() {
    var css = document.createElement('style');
    css.textContent = '.kd a,.lk a{color:inherit;text-decoration:none}.kd a:hover,.lk a:hover{color:var(--green);text-decoration:underline}';
    document.head.appendChild(css);

    /* 2. Sambungan ke Lokasi Arsip Fisik (panel di sana menaut ke Arsip Digital, Kelengkapan, Upload & Profil) */
    Array.prototype.forEach.call(document.querySelectorAll('#tabelArsip tbody tr[data-id]'), function (tr) {
      var url = URL_FISIK + '?pilih=' + encodeURIComponent(tr.getAttribute('data-id')) + '#daftar';
      var kd = tr.querySelector('td.kd'), lk = tr.querySelector('.lk');
      if (kd && !kd.querySelector('a')) kd.innerHTML = '<a href="' + url + '" title="Buka di Lokasi Arsip Fisik">' + kd.innerHTML + '</a>';
      if (lk && !lk.querySelector('a')) lk.innerHTML = '<a href="' + url + '" title="' + (lk.classList.contains('no') ? 'Atur lokasi di Lokasi Arsip Fisik' : 'Buka di Lokasi Arsip Fisik') + '">' + lk.innerHTML + '</a>';
    });

    /* 3. Tombol "Cetak Ulang" pada riwayat: arsipnya langsung terpilih setelah halaman terbuka */
    Array.prototype.forEach.call(document.querySelectorAll('table.riwayat a.btn'), function (a) {
      if (a.href.indexOf('auto=1') < 0) a.href = a.href.replace('#tabel', '') + (a.href.indexOf('?') < 0 ? '?' : '&') + 'auto=1#tabel';
    });
    if (new URLSearchParams(location.search).get('auto') === '1') {
      var kotak = document.querySelectorAll('#tabelArsip .pil');
      if (kotak.length === 1 && !kotak[0].checked) {
        kotak[0].checked = true;
        kotak[0].dispatchEvent(new Event('change', { bubbles: true }));
      }
    }
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', function () { setTimeout(mulai, 0); }); else mulai();
})();
</script>