{{-- Mengisi tabel Data Calon Siswa dengan data asli dari database. Dipasang setelah script bawaan; tidak mengubah kode lama. --}}
<script>
(function () {
  fetch("{{ route('calon.data') }}", { headers: { 'Accept': 'application/json' } })
    .then(r => { if (!r.ok) throw new Error('Kode ' + r.status); return r.json(); })
    .then(j => {
      D = j.data;                       // ganti data contoh dengan data database
      sel.clear(); S.page = 1;
      render();
      // tunggu animasi hitung awal (±1,5 detik) selesai agar angka database tidak tertimpa data contoh
      setTimeout(kpi, 1700);
      toast(D.length + ' data calon siswa dimuat dari database');
    })
    .catch(e => toast('Gagal memuat data: ' + e.message));
})();
</script>