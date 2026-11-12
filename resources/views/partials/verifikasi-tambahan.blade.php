{{-- Tambahan Verifikasi Berkas: hubungan ke Seleksi, Daftar Ulang, Data Siswa & Arsip. Hanya menambah. --}}
@php
  $vfUrl = [
      'seleksi'     => route('seleksi'),
      'daftarulang' => route('daftarulang'),
      'calon'       => route('calon'),
      'pendaftaran' => route('pendaftaran'),
      'siswaAktif'  => route('siswa.aktif'),
      'digital'     => route('arsip.digital'),
  ];
@endphp
<script>
(function () {
  var U = @json($vfUrl);
  var QA = [['Status & Seleksi', U.seleksi], ['Daftar Ulang & Konversi', U.daftarulang], ['Data Calon Siswa', U.calon], ['Pendaftaran Baru', U.pendaftaran], ['Data Siswa Aktif', U.siswaAktif], ['Direktori Arsip Digital', U.digital]];

  function menuQA(btn, items) {
    var m = document.getElementById("ppQa");
    if (m) { m.remove(); return; }
    m = document.createElement("div"); m.id = "ppQa";
    var r = btn.getBoundingClientRect();
    m.style.cssText = "position:fixed;top:" + (r.bottom + 8) + "px;right:28px;min-width:250px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 20px 44px rgba(11,31,58,.18);padding:6px;z-index:40";
    items.forEach(function (x) {
      var a = document.createElement("a"); a.href = x[1]; a.textContent = x[0];
      a.style.cssText = "display:block;padding:10px 12px;border-radius:9px;color:var(--tx);text-decoration:none;font:600 12.5px Inter,sans-serif";
      a.onmouseenter = function () { a.style.background = "var(--bg)"; }; a.onmouseleave = function () { a.style.background = ""; };
      m.appendChild(a);
    });
    document.body.appendChild(m);
  }
  document.addEventListener("click", function (e) {
    var b = e.target.closest && e.target.closest("button"), m = document.getElementById("ppQa");
    if (m && !(b && b.id === "qa") && !m.contains(e.target)) m.remove();
    if (b && b.id === "qa") { e.stopPropagation(); e.preventDefault(); menuQA(b, QA); }
  }, true);

  function btn(t, h, g) { return '<a class="btn ' + (g ? 'g' : 's') + '" href="' + h + '">' + t + '</a>'; }

  /* 1. Kartu calon siswa: lanjut ke Seleksi / Data Calon Siswa */
  var stu = document.getElementById('stu');
  function tambah() {
    if (!stu || stu.querySelector('.vf-tx')) return;
    var s = S[cur];
    if (!s) return;
    var reg = encodeURIComponent(s.reg), lengkap = stat(s) === 'T';
    var box = document.createElement('div');
    box.className = 'vf-tx';
    box.style.cssText = 'margin-top:14px;padding-top:12px;border-top:1px solid var(--line);display:flex;gap:8px;flex-wrap:wrap;align-items:center';
    box.innerHTML = btn(lengkap ? 'Lanjut ke Status & Seleksi' : 'Buka Status & Seleksi', U.seleksi + '?reg=' + reg, lengkap) + btn('Data Calon Siswa', U.calon + '?q=' + reg) +
      (lengkap ? '' : '<span class="mu" style="font-size:11.5px">Seluruh 5 dokumen harus Valid agar bisa diloloskan.</span>');
    stu.appendChild(box);
  }
  if (stu) { new MutationObserver(tambah).observe(stu, { childList: true }); tambah(); }

  /* 2. Penjelasan nasib berkas setelah diverifikasi */
  var dl = document.getElementById('docs');
  if (dl && dl.parentNode) {
    var p = document.createElement('p');
    p.className = 'mu'; p.style.cssText = 'margin-top:12px;font-size:11.5px;line-height:1.6';
    p.innerHTML = 'Setelah dinyatakan lolos dan dikonversi lewat <a href="' + U.daftarulang + '" style="color:var(--green);font-weight:700">Daftar Ulang &amp; Konversi</a>, berkas ini otomatis tersalin ke <a href="' + U.digital + '" style="color:var(--green);font-weight:700">Direktori Arsip Digital</a> dengan status mengikuti hasil verifikasi di sini.';
    dl.parentNode.appendChild(p);
  }

  /* 3. Dibuka dari halaman lain: ?reg=REG-xxxx langsung memilih calon siswa itu */
  var reg = new URLSearchParams(location.search).get('reg');
  if (reg) {
    setTimeout(function () {
      var i = S.findIndex(function (s) { return s.reg === reg; });
      if (i >= 0) { pick(i); }
    }, 200);
  }
})();
</script>