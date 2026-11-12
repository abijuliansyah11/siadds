{{-- Tambahan Data Calon Siswa: hubungan ke Verifikasi, Seleksi, Daftar Ulang & Data Siswa. Hanya menambah. --}}
@php
  $csUrl = [
      'verifikasi'  => route('verifikasi'),
      'seleksi'     => route('seleksi'),
      'daftarulang' => route('daftarulang'),
      'siswaAktif'  => route('siswa.aktif'),
  ];
@endphp
<script>
(function () {
  var U = @json($csUrl);
  var css = document.createElement('style');
  css.textContent = '.cs-ln{display:inline-flex;align-items:center;height:32px;padding:0 8px;border-radius:8px;font:600 11px Inter,sans-serif;color:#27498a;text-decoration:none;white-space:nowrap;transition:.2s}.cs-ln:hover{background:var(--soft);color:var(--green)}';
  document.head.appendChild(css);

  /* 1. Tombol alur di kepala halaman */
  var tools = document.querySelector('.head .tools');
  if (tools) {
    [['Verifikasi Berkas', U.verifikasi], ['Status & Seleksi', U.seleksi], ['Daftar Ulang & Konversi', U.daftarulang]].forEach(function (x) {
      var a = document.createElement('a'); a.className = 'btn'; a.href = x[1]; a.textContent = x[0]; tools.insertBefore(a, tools.firstChild);
    });
  }

  /* 2. Tautan di setiap baris tabel */
  var tb = document.getElementById('tb');
  function tautkan() {
    Array.prototype.forEach.call(document.querySelectorAll('#tb tr'), function (tr) {
      var act = tr.querySelector('.act');
      if (!act || act.querySelector('.cs-ln')) return;
      var reg = ((tr.children[2] || {}).textContent || '').trim();
      if (!/^REG-/.test(reg)) return;
      [['Verifikasi', U.verifikasi, 'Periksa berkas di Verifikasi Berkas'], ['Seleksi', U.seleksi, 'Buka di Status & Seleksi']].forEach(function (x) {
        var a = document.createElement('a'); a.className = 'cs-ln'; a.title = x[2]; a.textContent = x[0];
        a.href = x[1] + '?reg=' + encodeURIComponent(reg); act.appendChild(a);
      });
    });
  }
  if (tb) { new MutationObserver(tautkan).observe(tb, { childList: true }); tautkan(); }

  /* 3. Dialog detail: tautan ke Verifikasi, Seleksi, dan Daftar Ulang */
  var dB = document.getElementById('dB');
  function detail() {
    if (!dB || dB.querySelector('.cs-dt')) return;
    var m = /REG-\d{4}-\d+/.exec(dB.textContent || '');
    if (!m) return;
    var reg = encodeURIComponent(m[0]), box = document.createElement('div');
    box.className = 'cs-dt'; box.style.cssText = 'display:flex;gap:8px;flex-wrap:wrap;margin-top:14px';
    box.innerHTML = '<a class="btn" href="' + U.verifikasi + '?reg=' + reg + '">Verifikasi Berkas</a><a class="btn" href="' + U.seleksi + '?reg=' + reg + '">Status & Seleksi</a><a class="btn" href="' + U.daftarulang + '">Daftar Ulang</a>';
    dB.appendChild(box);
  }
  if (dB) { new MutationObserver(detail).observe(dB, { childList: true }); }

  /* 4. Dibuka dari halaman lain: ?q=REG-xxxx langsung menyaring daftar */
  var q = new URLSearchParams(location.search).get('q');
  if (q) {
    setTimeout(function () {
      S.q = q; S.page = 1;
      var f = document.getElementById('q'); if (f) f.value = q;
      render();
    }, 300);
  }
})();
</script>