{{-- Daftar Ulang & Konversi: data dari database + konversi ke Siswa Aktif. Hanya menambah, kode halaman tidak diubah. --}}
@if(isset($du) && $du)
<script>
(function () {
  var DU = @json($du);
  var q = function (s, c) { return (c || document).querySelector(s); };
  var NEXT = DU.nextNis || '';

  /* Migration belum dijalankan: tampilkan peringatan saja */
  if (DU.migrasi === false) {
    var w = q('.wrap'), b = document.createElement('div');
    b.className = 'banner'; b.style.cssText = 'background:#fee2e2;color:#991b1b';
    b.innerHTML = '<span>⚠ <b>Database belum siap.</b> Jalankan <code>php artisan migrate</code> agar Daftar Ulang &amp; Konversi tersimpan ke database. Data di bawah hanya contoh.</span>';
    if (w) w.insertBefore(b, w.children[1] || null);
    return;
  }

  /* 1. Ganti data contoh dengan data database */
  D.length = 0;
  DU.rows.forEach(function (r) {
    D.push({ id: r.id, reg: r.reg, name: r.name, jalur: r.jalur, age: r.age, nisn: r.nisn, nik: r.nik, school: r.school, date: r.date,
      nilai: r.nilai, sy: r.sy.map(Boolean), g: 1, nis: r.nis, kelas: r.kelas, sid: r.sid, u: r.u, dup: r.dup,
      ayah: r.ayah, ibu: r.ibu, hpo: r.hpo, ijz: r.ijz });
  });
  RB.length = 0; DU.rbs.forEach(function (r) { RB.push(r); });
  LOGS.length = 0; DU.logs.forEach(function (l) { LOGS.push([l[0], l[1]]); });
  sel.clear();
  var awal = D.filter(function (y) { return kS(y) == 'K'; })[0] || D[0];
  cur = awal ? awal.id : 0;
  var pm = new URLSearchParams(location.search).get('pilih');
  if (pm && D.some(function (y) { return String(y.id) === pm; })) cur = +pm;
  S.G = '1';

  /* 2. Teks yang sebelumnya contoh / tidak sesuai kenyataan */
  SY[4][1] = 'Seragam batik, pramuka, dan olahraga';
  var li = document.querySelectorAll('#dR li');
  if (li[2]) li[2].innerHTML = 'NIS (Nomor Induk Siswa) dibuat otomatis berurutan: tahun masuk + nomor urut, sama seperti halaman Tambah Siswa Baru.';
  if (li[3]) li[3].innerHTML = 'Data identitas dan orang tua disalin ke Data Siswa Aktif. Berkas (KK, Akta, Ijazah, Pas Foto, KIP) disalin ke Arsip Digital dengan status mengikuti hasil Verifikasi Berkas.';

  /* 3. Panel kanan: tangani daftar kosong, lalu sempurnakan isi panel */
  var P0 = window.panel;
  function tombol(teks, href) { return '<a class="btn s" href="' + href + '">' + teks + '</a>'; }
  window.panel = function () {
    var x = D.find(function (y) { return y.id == cur; });
    if (!x) {
      q('#pcard').innerHTML = '<div class="sh"><div><h3>Panel Verifikasi Persyaratan Akhir & Penetapan NIS</h3><small>Belum ada calon siswa yang lolos seleksi</small></div></div>' +
        '<p class="mu" style="line-height:1.7">Calon siswa muncul di sini setelah dinyatakan <b>Lolos</b> di Status &amp; Seleksi.</p>' +
        '<div class="acts">' + tombol('Buka Status & Seleksi', DU.url.seleksi) + tombol('Buka Verifikasi Berkas', DU.url.verifikasi) + '</div>';
      return;
    }
    P0();
    var ck = document.querySelectorAll('#pcard .ck');
    function teks(i, t) { var s = ck[i] && ck[i].querySelector('small'); if (s) s.textContent = t; }
    teks(1, x.ijz);
    teks(2, 'Ayah: ' + (x.ayah || '-') + ' • Ibu: ' + (x.ibu || '-') + ' • HP: ' + (x.hpo || '-'));
    var ni = q('#pcard .cf input[readonly]');
    if (ni && !x.nis && NEXT) ni.value = NEXT;
    var dp = q('#pcard .dup');
    if (dp && x.dup && !x.nis) {
      dp.classList.add('bad');
      dp.innerHTML = '⚠<span><b>Duplikasi Terdeteksi:</b> ' + x.dup + ' sudah ada pada Master Data Siswa Aktif / Alumni. Konversi ditolak.</span>';
      var cv = q('#cv'); if (cv) cv.disabled = true;
    }
    var acts = q('#pcard .acts');
    if (acts) {
      var box = document.createElement('div');
      box.style.cssText = 'display:flex;gap:8px;flex-wrap:wrap;justify-content:center;margin-top:14px;padding-top:14px;border-top:1px solid var(--line)';
      box.innerHTML = (x.nis && x.u)
        ? tombol('Detail Profil Siswa', x.u.detail) + tombol('Upload Dokumen', x.u.upload) + tombol('Kelengkapan Dokumen', x.u.kelengkapan) + tombol('Arsip Digital', x.u.digital) + tombol('Lokasi Arsip Fisik', x.u.fisik) + tombol('Cetak Label QR', x.u.label)
        : tombol('Verifikasi Berkas', DU.url.verifikasi + '?reg=' + encodeURIComponent(x.reg)) + tombol('Status & Seleksi', DU.url.seleksi + '?reg=' + encodeURIComponent(x.reg)) + tombol('Data Siswa Aktif', DU.url.siswaAktif);
      acts.parentNode.insertBefore(box, acts.nextSibling);
    }
  };

  /* 4. Komunikasi dengan server */
  function kirim(url, body) {
    return fetch(url, { method: 'POST', headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': DU.csrf }, body: JSON.stringify(body || {}) })
      .then(function (r) { return r.json().catch(function () { return {}; }).then(function (j) { j._st = r.status; return j; }); });
  }
  function pesan(j) { return j.message || (j.errors && Object.values(j.errors)[0] && Object.values(j.errors)[0][0]) || (j._st === 419 ? 'Sesi habis, muat ulang halaman' : 'terjadi kesalahan, coba lagi'); }
  function sinkron(j) {
    if (j.logs) { LOGS.length = 0; j.logs.forEach(function (l) { LOGS.push([l[0], l[1]]); }); }
    if (j.next_nis) NEXT = j.next_nis;
  }
  function terapkan(h) {
    var x = D.find(function (y) { return y.id == h.id; });
    if (!x) return;
    x.nis = h.nis; x.kelas = h.kelas; x.sid = h.siswa_id; x.u = h.u; x.dup = '';
    x.sy = [true, true, true, true, true]; sel.delete(x.id);
  }
  function url(t, id) { return t.replace('/0/', '/' + id + '/'); }

  /* 5. Checklist syarat tersimpan ke database (setelah handler halaman mengubahnya) */
  var timer;
  document.addEventListener('click', function (e) {
    if (!(e.target.closest && e.target.closest('[data-s]'))) return;
    var x = D.find(function (y) { return y.id == cur; });
    if (!x || x.nis) return;
    var id = x.id, sy = x.sy.map(Boolean);
    clearTimeout(timer);
    timer = setTimeout(function () {
      kirim(url(DU.url.syarat, id), { sy: sy }).then(function (j) {
        if (j.ok) { sinkron(j); logs(); } else { toast('Gagal menyimpan checklist: ' + pesan(j)); }
      }).catch(function () { toast('Gagal menyimpan checklist: koneksi bermasalah'); });
    }, 350);
  });

  /* 6. Konversi, batch, Quick Action, Direktori Siswa Aktif (menggantikan perilaku contoh) */
  function konversiSatu(btn) {
    var x = D.find(function (y) { return y.id == cur; });
    if (!x) return;
    var k = q('#kls'), tgl = q('#tgl');
    kls = k ? k.value : null;
    if (cnt(x) < 5) { toast('Konversi ditolak: syarat belum lengkap'); return; }
    btn.disabled = true;
    kirim(url(DU.url.konversi, x.id), { kelas: k ? k.value : '', tanggal: tgl ? tgl.value : null }).then(function (j) {
      if (!j.ok) { btn.disabled = false; btn.classList.remove('bad2'); void btn.offsetHeight; btn.classList.add('bad2'); toast('Konversi ditolak: ' + pesan(j)); return; }
      terapkan(j); sinkron(j);
      toast(x.name + ' kini Siswa Aktif • NIS ' + x.nis);
      var nx = D.filter(function (y) { return kS(y) == 'K' && y.id != x.id; }).sort(function (a, b) { return a.id - b.id; })[0];
      all(); if (nx) setTimeout(function () { setCur(nx.id); }, 900);
    }).catch(function () { btn.disabled = false; toast('Konversi gagal: koneksi bermasalah'); });
  }
  function konversiBatch(btn) {
    if (!sel.size) { toast('Centang calon siswa yang berstatus Siap Dikonversi'); return; }
    btn.disabled = true;
    kirim(DU.url.massal, { ids: Array.from(sel) }).then(function (j) {
      btn.disabled = false;
      if (!j.ok) { toast('Konversi massal gagal: ' + pesan(j)); return; }
      (j.done || []).forEach(terapkan); sinkron(j); sel.clear(); all();
      var n = (j.skipped || []).length;
      toast((j.done || []).length + ' siswa dikonversi' + (n ? ', ' + n + ' dilewati (' + j.skipped[0].alasan + ')' : ''));
    }).catch(function () { btn.disabled = false; toast('Konversi massal gagal: koneksi bermasalah'); });
  }
  function menuQA(btn) {
    var m = q('#duQa');
    if (m) { m.remove(); return; }
    m = document.createElement('div'); m.id = 'duQa';
    var r = btn.getBoundingClientRect();
    m.style.cssText = 'position:fixed;top:' + (r.bottom + 8) + 'px;right:28px;min-width:250px;background:#fff;border:1px solid var(--line);border-radius:14px;box-shadow:0 20px 44px rgba(11,31,58,.18);padding:6px;z-index:40';
    [['Status & Seleksi', DU.url.seleksi], ['Verifikasi Berkas', DU.url.verifikasi], ['Pendaftaran Baru', DU.url.pendaftaran], ['Data Siswa Aktif', DU.url.siswaAktif], ['Tambah Siswa Baru', DU.url.siswaBaru], ['Direktori Arsip Digital', DU.url.digital], ['Upload Dokumen', DU.url.upload]].forEach(function (x) {
      var a = document.createElement('a'); a.href = x[1]; a.textContent = x[0];
      a.style.cssText = 'display:block;padding:10px 12px;border-radius:9px;color:var(--tx);text-decoration:none;font:600 12.5px Inter,sans-serif';
      a.onmouseenter = function () { a.style.background = 'var(--bg)'; }; a.onmouseleave = function () { a.style.background = ''; };
      m.appendChild(a);
    });
    document.body.appendChild(m);
  }
  document.addEventListener('click', function (e) {
    var b = e.target.closest && e.target.closest('button');
    var m = q('#duQa');
    if (m && !(b && b.id === 'qa') && !m.contains(e.target)) m.remove();
    if (!b) return;
    if (b.id === 'cv') { e.stopPropagation(); e.preventDefault(); konversiSatu(b); }
    else if (b.id === 'batch') { e.stopPropagation(); e.preventDefault(); konversiBatch(b); }
    else if (b.id === 'qa') { e.stopPropagation(); e.preventDefault(); menuQA(b); }
    else if (b.id === 'dir') { e.stopPropagation(); e.preventDefault(); location.href = DU.url.siswaAktif; }
  }, true);

  /* 7. Tampilkan ulang dengan data database */
  kfirst = true;
  all();
})();
</script>
@endif