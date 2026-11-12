{{-- Halaman Data Alumni: setelah "Proses Kelulusan" berhasil, tampilkan tombol langsung ke Cetak SKL. Hanya menambah. --}}
@if(\Illuminate\Support\Facades\Route::has('label.qr') && str_contains((string) session('status'), 'berhasil diproses menjadi alumni'))
<script>
(function () {
  var note = document.querySelector('.note.in');
  if (!note) return;
  var a = document.createElement('a');
  a.href = @json(route('label.qr', ['skl_status' => 'belum']) . '#skl');
  a.textContent = 'Cetak SKL siswa yang baru lulus →';
  a.style.cssText = 'display:inline-block;margin-left:12px;padding:7px 14px;border-radius:10px;background:#0f7a4f;color:#fff;font-weight:700;font-size:12px;text-decoration:none';
  note.appendChild(a);
})();
</script>
@endif