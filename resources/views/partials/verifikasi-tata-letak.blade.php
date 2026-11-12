{{-- Perbaikan tata letak halaman Verifikasi Berkas.
     Penyebab: nama berkas yang panjang melebarkan kolom kiri, lalu kolom kanan menutupinya.
     Hanya CSS tambahan; tidak mengubah kode lama. Untuk membatalkan: hapus baris @include-nya. --}}
<style>
/* Kolom boleh menyempit (minmax(0,1fr)) sehingga isi yang panjang dipotong dengan "...", bukan melebarkan kolom */
.lay { grid-template-columns: 430px minmax(0, 1fr); }
.lay .col { grid-template-columns: minmax(0, 1fr); }
.lay .col .card { min-width: 0; overflow-wrap: anywhere; }
.doc .r1 span:first-child { min-width: 0; }
.doc .r2 { min-width: 0; }
.doc .r2 span:first-child { min-width: 0; flex: 1 1 0; }
@media (max-width: 1100px) {
  .lay { grid-template-columns: minmax(0, 1fr); }
}
</style>