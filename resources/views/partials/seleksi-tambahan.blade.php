{{-- Tambahan Status & Seleksi: hubungan ke Verifikasi, Daftar Ulang, Data Siswa & Arsip. Hanya menambah. --}}
@php
  $slUrl = [
      'verifikasi'  => route('verifikasi'),
      'daftarulang' => route('daftarulang'),
      'calon'       => route('calon'),
      'pendaftaran' => route('pendaftaran'),
      'siswaAktif'  => route('siswa.aktif'),
      'digital'     => route('arsip.digital'),
  ];
@endphp
<script>
(function () {
  var U = @json($slUrl);
  var QA = [['Verifikasi Berkas', U.verifikasi], ['Daftar Ulang & Konversi', U.daftarulang], ['Data Calon Siswa', U.calon], ['Pendaftaran Baru', U.pendaftaran], ['Data Siswa Aktif', U.siswaAktif], ['Direktori Arsip Digital', U.digital]];

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

  /* 1. Tautan alur di bawah keterangan tahapan */
  var tn = document.getElementById('tnote');
  if (tn) {
    var row = document.createElement('div');
    row.style.cssText = 'display:flex;gap:8px;flex-wrap:wrap;margin-top:10px';
    row.innerHTML = btn('Verifikasi Berkas', U.verifikasi) + btn('Daftar Ulang & Konversi', U.daftarulang, true) + btn('Data Siswa Aktif', U.siswaAktif);
    tn.parentNode.insertBefore(row, tn.nextSibling);
  }

  /* 2. Panel keputusan: tautan untuk calon siswa yang sedang dipilih */
  var dc = document.getElementById('dcard');
  function tambah() {
    if (!dc || dc.querySelector('.sl-tx')) return;
    var x = D.find(function (y) { return y.id == cur; });
    if (!x) return;
    var box = document.createElement('div');
    box.className = 'sl-tx';
    box.style.cssText = 'margin-top:16px;padding-top:14px;border-top:1px solid var(--line);display:flex;gap:8px;flex-wrap:wrap;align-items:center';
    var reg = encodeURIComponent(x.reg);
    box.innerHTML = btn('Periksa Berkas', U.verifikasi + '?reg=' + reg) +
      (x.sel === 'L' ? btn('Lanjut ke Daftar Ulang & Konversi', U.daftarulang + '?pilih=' + x.id, true)
                     : '<span class="mu" style="font-size:11.5px">Daftar Ulang tersedia setelah dinyatakan Lolos.</span>');
    dc.appendChild(box);
  }
  if (dc) { new MutationObserver(tambah).observe(dc, { childList: true }); tambah(); }

  /* 3. Dibuka dari halaman lain: ?reg=REG-xxxx langsung memilih calon siswa itu */
  var reg = new URLSearchParams(location.search).get('reg');
  if (reg) {
    setTimeout(function () {
      var x = D.find(function (y) { return y.reg === reg; });
      if (x) { setCur(x.id); if (dc) dc.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
    }, 200);
  }
})();
</script>