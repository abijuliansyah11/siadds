{{-- Tambahan Dashboard Penerimaan: hubungan ke Seleksi, Daftar Ulang, Data Siswa & Arsip. Hanya menambah. --}}
@php
  $pnLolos = 0; $pnSiap = 0; $pnAktif = 0; $pnTerkirim = 0;
  try {
      if (\Illuminate\Support\Facades\Schema::hasTable('pendaftaran')) {
          $pnTerkirim = \App\Models\Pendaftaran::where('status', 'terkirim')->count();
          if (\Illuminate\Support\Facades\Schema::hasColumn('pendaftaran', 'status_seleksi')) {
              $pnLolos = \App\Models\Pendaftaran::where('status', 'terkirim')->where('status_seleksi', 'L')->count();
          }
          if (\Illuminate\Support\Facades\Schema::hasColumn('pendaftaran', 'siswa_aktif_id')) {
              $pnAktif = \App\Models\Pendaftaran::whereNotNull('siswa_aktif_id')->count();
              foreach (\App\Models\Pendaftaran::where('status', 'terkirim')->where('status_seleksi', 'L')->whereNull('siswa_aktif_id')->pluck('daftar_ulang') as $raw) {
                  $sy = (json_decode((string) $raw, true) ?: [])['sy'] ?? [];
                  if (count(array_filter($sy)) >= 5) { $pnSiap++; }
              }
          }
      }
  } catch (\Throwable $e) { }
  $pnUrl = [
      'seleksi'     => route('seleksi'),
      'verifikasi'  => route('verifikasi'),
      'daftarulang' => route('daftarulang'),
      'siswaAktif'  => route('siswa.aktif'),
      'siswaBaru'   => route('siswa.baru'),
      'digital'     => route('arsip.digital'),
      'upload'      => route('upload.dokumen'),
  ];
@endphp
<script>
(function () {
  var N = { lolos: @json($pnLolos), siap: @json($pnSiap), aktif: @json($pnAktif), terkirim: @json($pnTerkirim) };
  var U = @json($pnUrl);
  var q = function (s) { return document.querySelector(s); };

  /* 1. Kartu "Lolos Seleksi & Diterima" memakai data database */
  var kpi = document.querySelectorAll('.kpis .kpi')[3];
  if (kpi) {
    var s = kpi.querySelector('strong'), t = kpi.querySelector('.tag');
    if (s) s.textContent = N.lolos;
    if (t) t.textContent = N.lolos + ' / 160 (' + Math.round(N.lolos / 160 * 100) + '%)';
  }

  /* 2. Alur lanjutan: Seleksi → Daftar Ulang → Siswa Aktif → Arsip */
  var kp = q('.kpis');
  if (kp) {
    var sec = document.createElement('section');
    sec.className = 'card'; sec.style.cssText = 'margin-bottom:22px';
    function kartu(judul, angka, ket, href, aksi) {
      return '<a href="' + href + '" style="display:block;padding:14px;border-radius:12px;background:var(--bg);text-decoration:none;color:var(--tx);transition:.25s" onmouseenter="this.style.background=\'var(--mint)\'" onmouseleave="this.style.background=\'\'"><small class="mu" style="font-weight:600;letter-spacing:.04em">' + judul + '</small><div style="font-size:26px;font-weight:800;margin:6px 0 2px">' + angka + '</div><div class="mu" style="font-size:12px">' + ket + '</div><b style="color:var(--green);font-size:11.5px;display:block;margin-top:8px">' + aksi + ' →</b></a>';
    }
    sec.innerHTML = '<h3>Alur Setelah Pendaftaran</h3><p class="mu" style="margin-bottom:12px">Dari pendaftar sampai menjadi siswa aktif dan terarsip. Klik kartu untuk membuka halamannya.</p>' +
      '<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:12px">' +
      kartu('LOLOS SELEKSI', N.lolos, 'dari ' + N.terkirim + ' pendaftar terkirim', U.seleksi, 'Status & Seleksi') +
      kartu('SIAP DIKONVERSI', N.siap, 'syarat daftar ulang 5/5', U.daftarulang, 'Daftar Ulang & Konversi') +
      kartu('SUDAH SISWA AKTIF', N.aktif, 'hasil konversi PPDB', U.siswaAktif, 'Data Siswa Aktif') +
      kartu('ARSIP DIGITAL', '↗', 'berkas ikut tersalin saat konversi', U.digital, 'Direktori Arsip Digital') +
      '</div>';
    kp.insertAdjacentElement('afterend', sec);
  }

  /* 3. Tautan yang sebelumnya belum berfungsi */
  var fl = q('a.folder');
  if (fl) fl.setAttribute('href', U.digital);
  var rev = q('#goRev');
  if (rev) {
    var a = document.createElement('a');
    a.className = 'btn'; a.href = U.verifikasi; a.textContent = 'Buka Halaman Verifikasi Berkas';
    a.style.cssText = 'width:100%;justify-content:center;margin-top:8px';
    rev.insertAdjacentElement('afterend', a);
  }
})();
</script>