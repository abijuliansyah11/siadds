{{-- Tambahan Pendaftaran Baru: hubungan ke Data Calon Siswa, Verifikasi, Seleksi, Daftar Ulang & Data Siswa. Hanya menambah. --}}
@php
  $pdUrl = [
      'calon'       => route('calon'),
      'verifikasi'  => route('verifikasi'),
      'seleksi'     => route('seleksi'),
      'daftarulang' => route('daftarulang'),
      'siswaAktif'  => route('siswa.aktif'),
  ];
@endphp
<script>
(function () {
  var U = @json($pdUrl);

  /* 1. Tombol alur di kepala halaman */
  var tools = document.querySelector('.head .tools');
  if (tools) {
    [['Data Calon Siswa', U.calon], ['Verifikasi Berkas', U.verifikasi]].forEach(function (x) {
      var a = document.createElement('a'); a.className = 'btn'; a.href = x[1]; a.textContent = x[0]; tools.insertBefore(a, tools.firstChild);
    });
  }

  /* 2. Ringkasan samping: langkah setelah formulir disimpan */
  var hint = document.querySelector('.sum .hint');
  if (hint) {
    var box = document.createElement('div');
    box.className = 'hint';
    box.style.marginTop = '0';
    box.innerHTML = '<b style="color:var(--tx)">Alur selanjutnya:</b><br>' +
      '1. <a href="' + U.calon + '" style="color:var(--green);font-weight:700">Data Calon Siswa</a><br>' +
      '2. <a href="' + U.verifikasi + '" style="color:var(--green);font-weight:700">Verifikasi Berkas</a><br>' +
      '3. <a href="' + U.seleksi + '" style="color:var(--green);font-weight:700">Status &amp; Seleksi</a><br>' +
      '4. <a href="' + U.daftarulang + '" style="color:var(--green);font-weight:700">Daftar Ulang &amp; Konversi</a> → <a href="' + U.siswaAktif + '" style="color:var(--green);font-weight:700">Data Siswa Aktif</a>';
    hint.parentNode.insertBefore(box, hint.nextSibling);
  }

  /* 3. Dialog sukses: lanjut memeriksa berkas calon siswa yang baru didaftarkan */
  var dlg = document.getElementById('dlg'), act = dlg && dlg.querySelector('div[style*="justify-content:center"]');
  if (act) {
    function nomor() { var m = /REG-\d{4}-\d+/.exec(dlg.textContent || ''); return m ? m[0] : ''; }
    [['Periksa Berkas', U.verifikasi, '?reg='], ['Lihat di Data Calon Siswa', U.calon, '?q=']].forEach(function (x) {
      var a = document.createElement('a'); a.className = 'btn s'; a.href = x[1]; a.textContent = x[0];
      a.addEventListener('click', function () { var n = nomor(); if (n) a.href = x[1] + x[2] + encodeURIComponent(n); });
      act.insertBefore(a, act.firstChild);
    });
    act.style.flexWrap = 'wrap';
  }
})();
</script>