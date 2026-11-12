{{-- Tambahan Dashboard Utama: menyambungkan tombol/kartu ke halaman asli dan menghidupkan bagian yang belum dari database
     (tren, riwayat lintas modul, arsip fisik, tahun ajaran). Hanya MENAMBAH. File dashboard.blade.php, DashboardController
     dan partials/dashboard-aksi tidak diubah. Angka KPI/kelas/gender/tabel tetap dari DashboardController + dashboard.blade.php. --}}
@php
  $r = fn ($n, $p = []) => \Illuminate\Support\Facades\Route::has($n) ? route($n, $p) : '#';
  $tautan = [
    'siswaBaru' => $r('siswa.baru'), 'pendaftaran' => $r('pendaftaran'), 'upload' => $r('upload.dokumen'),
    'label' => $r('label.qr'), 'skl' => $r('label.qr') . '#skl', 'arsipFisik' => $r('arsip.fisik'), 'arsipDigital' => $r('arsip.digital'),
    'verifikasi' => $r('verifikasi'), 'seleksi' => $r('seleksi'), 'daftarUlang' => $r('daftarulang'), 'calon' => $r('calon'),
    'siswaAktif' => $r('siswa.aktif'), 'alumni' => $r('alumni'), 'kelengkapan' => $r('kelengkapan.dokumen'), 'penerimaan' => $r('penerimaan'),
  ];
  /* Angka asli yang sudah dihitung server pada halaman ini (dipakai untuk meniadakan penambahan angka contoh dari localStorage) */
  $angkaServer = [
    'kpi'    => collect($kpis ?? [])->map(fn ($k) => (int) ($k[1] ?? 0))->values()->all(),
    'gender' => isset($ds) ? ['l' => ($ds['aktif'] ?? 0) > 0 ? (int) $ds['l'] : 132, 'p' => ($ds['aktif'] ?? 0) > 0 ? (int) $ds['p'] : 154] : null,
  ];
@endphp
<style>
html.dsh-muat .log,html.dsh-muat .arch .kv,html.dsh-muat .chart{opacity:0}
.log,.arch .kv,.chart{transition:opacity .35s}
.kpi[data-href],.bar[data-href],.aud[data-href],tr[data-href]{cursor:pointer}
.bar[data-href]:hover span:first-child,.aud[data-href]:hover>div:first-child{color:var(--green)}
.dsh-warn{margin:0 0 16px;padding:11px 15px;border-radius:12px;background:#fff1cf;color:#6b4500;font-weight:600;line-height:1.5}
.dsh-ok{margin:0 0 16px;padding:11px 15px;border-radius:12px;background:#fee2e2;color:#991b1b;font-weight:600}
.dsh-qa{position:relative}
.dsh-menu{position:absolute;right:0;top:calc(100% + 8px);width:250px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 18px 40px rgba(11,31,58,.18);padding:8px;display:none;z-index:50}
.dsh-menu.on{display:block;animation:rise .25s cubic-bezier(.2,.8,.2,1)}
.dsh-menu a{display:flex;gap:9px;align-items:center;padding:10px 12px;border-radius:9px;color:var(--tx);text-decoration:none;font-weight:600;font-size:12.5px}
.dsh-menu a:hover{background:var(--bg);color:var(--green)}
.dsh-menu small{display:block;color:var(--mu);font-weight:500;font-size:11px}
.search{position:relative}
.dsh-hasil{position:absolute;left:0;top:calc(100% + 8px);width:360px;max-width:80vw;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 18px 40px rgba(11,31,58,.18);padding:6px;display:none;z-index:50;max-height:70vh;overflow:auto}
.dsh-hasil.on{display:block}
.dsh-hasil .g{font-size:10px;letter-spacing:.06em;color:var(--mu);font-weight:700;padding:8px 10px 4px}
.dsh-hasil a{display:block;padding:9px 10px;border-radius:9px;color:var(--tx);text-decoration:none;font-weight:600;font-size:12.5px}
.dsh-hasil a small{display:block;color:var(--mu);font-weight:500;font-size:11px;margin-top:1px}
.dsh-hasil a:hover,.dsh-hasil a.f{background:var(--bg);color:var(--green)}
.dsh-hasil .k{padding:12px;color:var(--mu)}
dialog.dsh-dlg{border:0;border-radius:18px;padding:0;width:min(640px,94vw);max-height:86vh;box-shadow:0 30px 80px rgba(11,31,58,.35);color:var(--tx)}
dialog.dsh-dlg::backdrop{background:rgba(11,31,58,.55)}
dialog.dsh-dlg[open]{animation:rise .35s cubic-bezier(.2,.8,.2,1)}
.dsh-dlg .h{display:flex;justify-content:space-between;align-items:center;padding:16px 20px;border-bottom:1px solid var(--line)}
.dsh-dlg .h b{font-size:16px}
.dsh-dlg .b{padding:10px 20px 18px;overflow:auto;max-height:calc(86vh - 70px)}
.dsh-arch2{display:flex!important;width:100%;justify-content:center;margin-top:8px;background:rgba(255,255,255,.12)!important;border-color:rgba(255,255,255,.25)!important;color:#fff!important}
</style>
<script>document.documentElement.classList.add('dsh-muat');</script>

<script>
(function () {
  'use strict';

  var U = { data: @json(route('dashboard.data')), cari: @json(route('dashboard.cari')) };
  var L = @json($tautan);
  var SERVER = @json($angkaServer);

  function $(s, r) { return (r || document).querySelector(s); }
  function $$(s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); }
  function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
  function id(n) { return Number(n).toLocaleString('id-ID'); }
  function ganti(el) { var n = el.cloneNode(true); el.parentNode.replaceChild(n, el); return n; }   // salinan tanpa pendengar klik lama

  /* ======================================================================
     1. Angka asli dari server + lepas penangan contoh (dashboard-aksi) yang memakai data palsu
        Dijalankan SEKARANG, sebelum skrip hitung-naik bawaan di bawah.
     ====================================================================== */
  (function netralkan() {
    /* Angka KPI & gender: kembalikan ke nilai server (dashboard-aksi menambahkannya dengan data contoh dari localStorage) */
    $$('.kpi strong').forEach(function (e, i) { if (SERVER.kpi && SERVER.kpi[i] != null) e.setAttribute('data-count', SERVER.kpi[i]); });
    var g = $$('.gender b[data-count]');
    if (SERVER.gender && g.length > 1) { g[0].setAttribute('data-count', SERVER.gender.l); g[1].setAttribute('data-count', SERVER.gender.p); }

    /* Kartu KPI: buka halaman aslinya (bukan panel contoh dengan angka tetap) */
    var urlKpi = [L.siswaAktif, L.siswaAktif, L.calon, L.verifikasi, L.verifikasi, L.verifikasi, L.verifikasi];
    $$('.kpis .kpi').forEach(function (k, i) { var n = ganti(k); if (urlKpi[i] && urlKpi[i] !== '#') n.setAttribute('data-href', urlKpi[i]); });

    /* Baris tabel tindak lanjut: buka siswa terkait atau Verifikasi Berkas (bukan modal contoh "Tandai Terverifikasi") */
    $$('table tbody tr').forEach(function (tr) {
      var n = ganti(tr), a = n.querySelector('td a[href]');
      n.setAttribute('data-href', a ? a.getAttribute('href') : L.verifikasi);
    });

    /* Tombol yang dulu membuka formulir/label contoh -> halaman asli */
    $$('a[href="#"]').forEach(function (a) {
      if (a.closest('.side')) return;
      var t = a.textContent.trim(), url = null;
      if (t === 'Tambah Siswa') url = L.siswaBaru;
      else if (t === 'Upload Dokumen') url = L.upload;
      else if (t.indexOf('Cetak Barcode') === 0) url = L.label;
      else if (t.indexOf('Lihat Seluruh Log') === 0) { ganti(a); return; }   // dibuka kembali lewat dialog riwayat di bawah
      if (url && url !== '#') { var n = ganti(a); n.setAttribute('href', url); }
    });

    /* Quick Action: buang menu contoh, ganti dengan menu halaman asli */
    var qa = $('.top a.btn.g'), lama = $('.top .sx-mn');
    if (lama) lama.parentNode.removeChild(lama);
    if (qa && qa.getAttribute('href') === '#' && !$('.top .dsh-qa')) {
      var asli = ganti(qa), kotak = document.createElement('div'); kotak.className = 'dsh-qa';
      asli.parentNode.insertBefore(kotak, asli); kotak.appendChild(asli);
      var menu = document.createElement('div'); menu.className = 'dsh-menu';
      menu.innerHTML = [
        ['Tambah Siswa Baru', 'Input siswa & berkas', L.siswaBaru], ['Pendaftaran Baru (PPDB)', 'Formulir calon siswa', L.pendaftaran],
        ['Verifikasi Berkas', 'Periksa berkas calon siswa', L.verifikasi], ['Status & Seleksi', 'Hasil seleksi PPDB', L.seleksi],
        ['Upload Dokumen', 'Tambah dokumen siswa', L.upload], ['Cetak Label QR Code', 'Stiker arsip fisik', L.label],
        ['Cetak SKL Alumni', 'Surat Keterangan Lulus', L.skl], ['Data Alumni', 'Proses kelulusan & alumni lama', L.alumni]
      ].map(function (m) { return '<a href="' + m[2] + '">' + esc(m[0]) + '<small>' + esc(m[1]) + '</small></a>'; }).join('');
      kotak.appendChild(menu);
      asli.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); menu.classList.toggle('on'); });
      document.addEventListener('click', function (e) { if (!kotak.contains(e.target)) menu.classList.remove('on'); });
      document.addEventListener('keydown', function (e) { if (e.key === 'Escape') menu.classList.remove('on'); });
    }

    /* Kotak cari: buang pencarian contoh */
    var sr = $('.top .sx-sr'); if (sr) sr.parentNode.removeChild(sr);
    var inp = $('.top input[type=search]'); if (inp) ganti(inp);
  })();

  /* ======================================================================
     2. Kotak cari (siswa, calon siswa, alumni, dan halaman)
     ====================================================================== */
  function cari() {
    var kotak = $('.top .search'), input = kotak && $('input', kotak);
    if (!input) return;
    input.placeholder = 'Cari nama, NISN, atau menu… (Ctrl K)';
    var panel = document.createElement('div'); panel.className = 'dsh-hasil'; kotak.appendChild(panel);
    var halaman = [
      ['Dashboard Penerimaan', L.penerimaan, 'ppdb penerimaan'], ['Pendaftaran Baru', L.pendaftaran, 'ppdb daftar'], ['Data Calon Siswa', L.calon, 'calon ppdb'],
      ['Verifikasi Berkas', L.verifikasi, 'verifikasi berkas'], ['Status & Seleksi', L.seleksi, 'seleksi lolos'], ['Daftar Ulang & Konversi', L.daftarUlang, 'daftar ulang konversi'],
      ['Data Siswa Aktif', L.siswaAktif, 'siswa aktif'], ['Tambah Siswa Baru', L.siswaBaru, 'tambah siswa'], ['Data Alumni', L.alumni, 'alumni lulus'],
      ['Direktori Arsip Digital', L.arsipDigital, 'arsip digital dokumen'], ['Upload Dokumen', L.upload, 'upload unggah dokumen'],
      ['Kelengkapan Dokumen', L.kelengkapan, 'kelengkapan lengkap'], ['Lokasi Arsip Fisik', L.arsipFisik, 'arsip fisik lemari rak'],
      ['Cetak Label QR Code', L.label, 'label qr stiker'], ['Cetak SKL', L.skl, 'skl surat keterangan lulus']
    ];
    var tt, urut = 0;
    function tampil(menu, hasil, memuat) {
      var h = '';
      if (menu.length) h += '<div class="g">HALAMAN</div>' + menu.map(function (m) { return '<a href="' + m[1] + '">' + esc(m[0]) + '</a>'; }).join('');
      if (hasil.length) h += '<div class="g">DATA</div>' + hasil.map(function (r) { return '<a href="' + esc(r.url) + '">' + esc(r.judul) + '<small>' + esc(r.sub) + '</small></a>'; }).join('');
      if (!h) h = '<div class="k">' + (memuat ? 'Mencari…' : 'Tidak ada hasil.') + '</div>';
      panel.innerHTML = h; panel.classList.add('on');
    }
    input.addEventListener('input', function () {
      var q = input.value.trim().toLowerCase();
      clearTimeout(tt);
      if (q.length < 2) { panel.classList.remove('on'); return; }
      var menu = halaman.filter(function (m) { return (m[0] + ' ' + m[2]).toLowerCase().indexOf(q) >= 0; }).slice(0, 4);
      tampil(menu, [], true);
      var n = ++urut;
      tt = setTimeout(function () {
        fetch(U.cari + '?q=' + encodeURIComponent(input.value.trim()), { credentials: 'same-origin', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
          .then(function (r) { return r.json(); })
          .then(function (d) { if (n === urut) tampil(menu, d.hasil || [], false); })
          .catch(function () { if (n === urut) tampil(menu, [], false); });
      }, 250);
    });
    input.addEventListener('keydown', function (e) {
      if (e.key === 'Enter') { var a = panel.querySelector('a'); if (a) { e.preventDefault(); location.href = a.href; } }
      if (e.key === 'Escape') { panel.classList.remove('on'); input.blur(); }
    });
    document.addEventListener('click', function (e) { if (!kotak.contains(e.target)) panel.classList.remove('on'); });
    document.addEventListener('keydown', function (e) { if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') { e.preventDefault(); input.focus(); input.select(); } });
  }

  /* ======================================================================
     3. Bagian yang diisi dari /dashboard/data (tahun ajaran, tren, riwayat, arsip fisik)
     ====================================================================== */
  var dataAkhir = null;

  function render(d) {
    var kecil = $('.top small.mu'); if (kecil) kecil.textContent = 'TA ' + d.ta.tahun + ' - ' + d.ta.semester + ' (Asia/Jakarta)';
    var baris = $('.mu.in'); if (baris) {
      var pill = $('.pill', baris); if (pill) pill.textContent = 'T.A. ' + d.ta.tahun;
      var sp = baris.querySelectorAll(':scope > span'); if (sp[1]) sp[1].textContent = 'Sinkronisasi Terakhir: ' + d.sync;
    }
    var foot = $$('.foot span'); if (foot.length) foot[foot.length - 1].textContent = 'Tahun Ajaran ' + d.ta.tahun;
    grafik(d.tren);
    riwayat(d.riwayat);
    arsip(d.arsip);
  }

  function jalur(v, maks) {
    var p = v.map(function (n, i) { return [i * 100, 200 - (n / maks) * 170]; }), s = 'M' + p[0][0] + ' ' + p[0][1];
    for (var i = 1; i < p.length; i++) { var mx = (p[i - 1][0] + p[i][0]) / 2; s += 'C' + mx + ' ' + p[i - 1][1] + ' ' + mx + ' ' + p[i][1] + ' ' + p[i][0] + ' ' + p[i][1]; }
    return s;
  }
  function grafik(t) {
    var kartu = $('svg.chart') && $('svg.chart').closest('.card'); if (!kartu) return;
    var maks = Math.max.apply(null, t.lain.concat(t.prestasi).concat([1]));
    var a = jalur(t.lain, maks), b = jalur(t.prestasi, maks);
    var area = $$('svg.chart .area'), garis = $$('svg.chart .line');
    if (area[0]) area[0].setAttribute('d', a + 'V200H0Z');
    if (area[1]) area[1].setAttribute('d', b + 'V200H0Z');
    if (garis[0]) garis[0].setAttribute('d', a);
    if (garis[1]) garis[1].setAttribute('d', b);
    var lbl = $('.lbl', kartu); if (lbl) lbl.textContent = 'AKTIVITAS PPDB ' + (dataAkhir ? dataAkhir.ta.tahunPpdb : '');
    var jum = function (x) { return x.reduce(function (s, n) { return s + n; }, 0); };
    var p = $('p.mu', kartu); if (p) p.innerHTML = 'Pendaftar baru 8 minggu terakhir: <b style="color:#0f7a4f">Jalur Prestasi ' + id(jum(t.prestasi)) + '</b> • <b style="color:#0b1f3a">Jalur lainnya ' + id(jum(t.lain)) + '</b>';
    var sumbu = $$('.chart + div span', kartu), idx = [0, 2, 5, 7];
    sumbu.forEach(function (s, i) { if (idx[i] != null && t.label[idx[i]]) s.textContent = 'Minggu ' + t.label[idx[i]]; });
  }

  var semuaLog = [];
  function riwayat(list) {
    semuaLog = list;
    var kartu = $$('.row.r3 > .in .card')[0]; if (!kartu) return;
    $$('.log', kartu).forEach(function (l) { l.parentNode.removeChild(l); });
    var tombol = $('a.btn', kartu);
    var tampil = list.slice(0, 6);
    if (!tampil.length) tampil = [{ teks: 'Belum ada aktivitas tercatat.', waktu: '' }];
    tampil.forEach(function (r) {
      var el = document.createElement('div'); el.className = 'log'; el.innerHTML = esc(r.teks) + '<small>' + esc(r.waktu) + '</small>';
      kartu.insertBefore(el, tombol);
    });
    if (tombol) { tombol.textContent = 'Lihat Seluruh Riwayat Aktivitas'; tombol.setAttribute('href', '#'); }
  }

  function arsip(a) {
    var k = $('.arch'); if (!k) return;
    var kecil = $('small', k); if (kecil) kecil.textContent = 'Arsip Fisik Madrasah • KODE: ' + (a.kode || 'belum ada penempatan');
    var p = $('p', k); if (p) p.textContent = a.batch > 0 ? 'Penempatan ' + a.batch + ' berkas fisik terakhir di lemari arsip pusat:' : 'Belum ada berkas fisik yang ditempatkan ke rak. Catat lokasinya di halaman Lokasi Arsip Fisik.';
    var kv = $('.kv', k), wadah = kv && kv.parentNode;
    if (wadah) wadah.innerHTML =
      '<div class="kv"><span>Lokasi Rak</span><b>' + esc(a.lokasi || '-') + '</b></div>' +
      '<div class="kv"><span>Nomor Map</span><b>' + esc(a.map || '-') + '</b></div>' +
      '<div class="kv"><span>Arsip Berlokasi</span><b>' + id(a.berlokasi) + ' dari ' + id(a.total) + '</b></div>' +
      '<div class="kv"><span>Label QR Code</span><b>' + id(a.label) + ' dibuat</b></div>';
    if (!$('.dsh-arch2', k)) {
      var l = document.createElement('a'); l.className = 'btn dsh-arch2'; l.href = a.url; l.textContent = 'Buka Lokasi Arsip Fisik';
      k.appendChild(l);
    }
  }

  /* Klik kartu/baris bertanda data-href */
  document.addEventListener('click', function (e) {
    if (e.target.closest('a,button,input,select,label')) return;
    var el = e.target.closest('[data-href]'); if (el) location.href = el.getAttribute('data-href');
  });

  /* Dialog seluruh riwayat */
  var dlg = document.createElement('dialog'); dlg.className = 'dsh-dlg';
  dlg.innerHTML = '<div class="h"><b>Riwayat Aktivitas Sistem</b><button type="button" class="btn" data-x>Tutup</button></div><div class="b" id="dshLog"></div>';
  document.body.appendChild(dlg);
  dlg.addEventListener('click', function (e) { if (e.target === dlg || e.target.closest('[data-x]')) dlg.close(); });
  document.addEventListener('click', function (e) {
    var a = e.target.closest('.row.r3 .card > a.btn'); if (!a || a.getAttribute('href') !== '#') return;
    e.preventDefault();
    $('#dshLog', dlg).innerHTML = (semuaLog.length ? semuaLog : [{ teks: 'Belum ada aktivitas tercatat.', waktu: '' }]).map(function (r) { return '<div class="log">' + esc(r.teks) + '<small>' + esc(r.waktu) + '</small></div>'; }).join('');
    dlg.showModal();
  });

  function banner(teks) {
    var w = $('.wrap'), b = $('.dsh-info'); if (!w) return;
    if (!teks) { if (b) b.remove(); return; }
    if (!b) { b = document.createElement('div'); b.className = 'dsh-info dsh-warn'; w.insertBefore(b, w.firstChild); }
    b.textContent = teks;
  }
  var pertama = true;
  function muat() {
    return fetch(U.data, { credentials: 'same-origin', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
      .then(function (r) { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
      .then(function (d) { dataAkhir = d; render(d); banner(''); document.documentElement.classList.remove('dsh-muat'); pertama = false; })
      .catch(function () {
        if (!pertama) return;   // gagal menyegarkan otomatis: biarkan data terakhir tetap tampil
        document.documentElement.classList.remove('dsh-muat');
        banner('Tren, riwayat, dan kartu arsip fisik belum dapat dimuat (route dashboard.data). Bagian lain dashboard tetap dari database.');
      });
  }

  cari();
  muat();
  setInterval(function () { if (!document.hidden) muat(); }, 60000);
})();
</script>