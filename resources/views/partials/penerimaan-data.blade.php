{{-- Mengisi halaman Penerimaan dengan data asli. Sumbernya sama dengan halaman Data Calon Siswa
     (route calon.data), jadi angka kedua halaman selalu sama. Dipasang setelah penerimaan-aksi;
     tidak mengubah kode lama. --}}
<script>
(function () {
  const URL_DATA = "{{ route('calon.data') }}";

  // 1) Buang data contoh seketika supaya tidak tampil angka palsu
  D.length = 0;
  Object.assign(S, { tot: 0, T: 0, M: 0, P: 0, R: 0, page: 1 });

  // 2) Hilangkan keterangan "(data contoh)" pada info tabel
  const _view = view;
  view = function () {
    _view();
    const i = document.getElementById('info');
    if (i) i.textContent = i.textContent.replace(' (data contoh)', '');
  };
  view();

  // 3) Ambil data asli dari server
  fetch(URL_DATA, { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
    .then(function (r) { if (!r.ok) throw new Error('kode ' + r.status); return r.json(); })
    .then(function (j) {
      const rows = (j && j.data) || [];
      rows.forEach(function (r) {
        D.push({
          reg: r.reg, name: r.name, sex: r.sex, jalur: r.jalur, nisn: r.nisn,
          school: r.school, date: r.date,
          st: (r.st === 'T' || r.st === 'P') ? r.st : 'M'
        });
      });

      const hitung = function (k) { return D.filter(function (x) { return x.st === k; }).length; };
      Object.assign(S, { tot: D.length, T: hitung('T'), M: hitung('M'), P: hitung('P'), R: 0, page: 1 });

      if (D.length) {
        stats(true);
      } else {
        // Database masih kosong: tampilkan nol (hindari pembagian dengan nol)
        ['#kTot', '#kOk', '#kWait', '#dTot'].forEach(function (id) { const e = document.querySelector(id); if (e) e.textContent = '0'; });
      }

      // Kartu "Lolos Seleksi & Diterima" dari hasil Status & Seleksi (jika datanya ada)
      const L = rows.filter(function (r) { return r.sel === 'Lolos'; }).length;
      const kp = document.querySelectorAll('.kpi')[3];
      if (kp) {
        const s = kp.querySelector('strong'), t = kp.querySelector('.tag');
        if (s) s.textContent = L;
        if (t) t.textContent = L + ' / 160 (' + Math.round(L / 160 * 100) + '%)';
      }

      view();
    })
    .catch(function (e) {
      toast('Gagal memuat data pendaftar (' + e.message + ')');
      view();
    });

  // 4) "+ Pendaftaran Baru" membuka formulir pendaftaran yang sebenarnya (yang menyimpan ke database),
  //    bukan jendela cepat yang hanya mengubah tampilan di browser.
  const URL_FORM = "{{ route('pendaftaran') }}";
  document.addEventListener('click', function (e) {
    if (e.target.closest('.head [data-open]') || e.target.closest('[data-q="d"]')) {
      e.preventDefault();
      e.stopPropagation();
      window.location.href = URL_FORM;
    }
  }, true);
})();
</script>