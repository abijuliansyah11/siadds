<script>
/* ==========================================================================
   UPLOAD DOKUMEN — Skrip halaman
   Daftar isi:
   1. Pembantu            6. Pratinjau berkas
   2. Animasi masuk       7. Syarat validasi & kirim
   3. Cari siswa          8. Draft & reset
   4. Kategori dokumen    9. Dialog panduan
   5. Unggah berkas      10. Mulai
   ========================================================================== */
(function () {
  'use strict';

  const C = window.UPLOAD;

  /* ---------- 1. PEMBANTU ------------------------------------------------ */
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
  const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

  const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (m) =>
    ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]));
  const ico = (n) => '<svg class="i"><use href="#' + n + '"/></svg>';
  const ukuran = (b) => b >= 1048576 ? (b / 1048576).toFixed(2) + ' MB' : Math.max(1, Math.round(b / 1024)) + ' KB';

  const LABEL_STATUS = { sah: 'Sudah Terverifikasi', menunggu: 'Menunggu Verifikasi', revisi: 'Perlu Perbaikan', kosong: 'Belum Diunggah' };

  const el = {
    form: $('#formUpload'), siswaId: $('#siswaId'), jenisDok: $('#jenisDok'),
    cari: $('#cariSiswa'), hasil: $('#hasilCari'), kartu: $('#kartuSiswa'),
    tiles: $$('#tiles .tile'), nama: $('#namaDok'), nomor: $('#nomorDok'), lblNomor: $('#lblNomor'),
    tgl: $('#tglTerbit'), desk: $('#deskDok'),
    drop: $('#dropzone'), berkas: $('#berkas'), err: $('#errBerkas'),
    item: $('#fileItem'), fiExt: $('#fiExt'), fiNama: $('#fiNama'), fiMeta: $('#fiMeta'), fiBadge: $('#fiBadge'),
    pvBox: $('#pvBox'), pvInner: $('#pvInner'), pvFormat: $('#pvFormat'), pvHash: $('#pvHash'),
    bar: $('#barAksi'), btnUpload: $('#btnUpload'), btnUploadTx: $('#btnUploadTx'),
    storPath: $('#storPath'), toast: $('#toast'), dlg: $('#dlgPanduan'),
  };

  const S = { siswa: null, jenis: null, file: null, url: null, zoom: 1, rot: 0, namaDiubah: false };

  let toastTimer;
  function toast(pesan) {
    el.toast.textContent = pesan;
    el.toast.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => el.toast.classList.remove('show'), 3600);
  }

  /* ---------- 2. ANIMASI MASUK ------------------------------------------- */
  function animasiMasuk() {
    // Munculkan elemen saat terlihat di layar
    const target = $$('.rv');
    if (reduce || !('IntersectionObserver' in window)) { target.forEach((n) => n.classList.add('in')); }
    else {
      const io = new IntersectionObserver((list) => list.forEach((e) => {
        if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
      }), { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
      target.forEach((n) => io.observe(n));
    }

    // Angka KPI menghitung naik
    $$('[data-count]').forEach((n) => {
      const akhir = Number(n.dataset.count) || 0;
      if (reduce || akhir === 0) return;
      const mulai = performance.now() + 350, durasi = 1500;
      n.textContent = '0';
      (function langkah(t) {
        const p = Math.max(0, Math.min(1, (t - mulai) / durasi));
        n.textContent = Math.round(akhir * (1 - Math.pow(1 - p, 4))).toLocaleString('id-ID');
        if (p < 1) requestAnimationFrame(langkah);
      })(performance.now());
    });

    // Bar progres terisi perlahan
    $$('.track i[data-w]').forEach((b) => setTimeout(() => { b.style.width = b.dataset.w + '%'; }, 500));
  }

  /* ---------- 3. CARI SISWA ---------------------------------------------- */
  let timerCari, indeksAktif = -1, hasilCari = [];

  function kartuKosong() {
    el.kartu.className = 'scard empty';
    el.kartu.innerHTML =
      '<span class="se-ic">' + ico('user') + '</span>' +
      '<div><b>Belum ada siswa dipilih</b><small>Cari nama, NIS, atau NISN di atas untuk menautkan berkas.</small></div>';
  }

  function tampilSiswa() {
    const s = S.siswa;
    if (!s) { kartuKosong(); return; }
    el.kartu.className = 'scard';
    el.kartu.innerHTML =
      '<div class="foto"><img src="' + esc(s.foto) + '" alt="Foto ' + esc(s.nama) + '"><i class="ck">✓</i></div>' +
      '<div class="sinfo">' +
        '<div class="snm"><b>' + esc(s.nama) + '</b><span class="badge ok">Siswa ' + esc(s.status) + '</span></div>' +
        '<div class="smeta"><span>NIS: <b>' + esc(s.nis) + '</b></span><span>NISN: <b>' + esc(s.nisn || '-') + '</b></span><span>Kelas: <b>' + esc(s.kelas) + '</b></span></div>' +
        '<div class="sprog"><span>Arsip Terkumpul:</span><div class="track"><i></i></div><b>' + s.terkumpul + '/' + s.total + ' Berkas (' + s.persen + '%)</b></div>' +
      '</div>' +
      '<div class="sact"><button type="button" class="mini" id="btnGanti">Ganti Siswa</button>' +
      '<a class="lnk" href="' + esc(s.profil) + '" target="_blank" rel="noopener">Buka Profil ' + ico('ext') + '</a></div>';

    requestAnimationFrame(() => setTimeout(() => { $('.track i', el.kartu).style.width = s.persen + '%'; }, 80));
    $('#btnGanti').addEventListener('click', gantiSiswa);
  }

  function pilihSiswa(s) {
    S.siswa = s;
    el.siswaId.value = s ? s.id : '';
    el.cari.value = s ? s.nama + ' (' + s.nis + ')' : '';
    el.storPath.textContent = s ? 'dokumen-siswa/' + s.nis + '/' : 'dokumen-siswa/NIS-siswa/';
    tutupHasil();
    tampilSiswa();
    perbaruiStatusTile();
    cek();
  }

  function gantiSiswa() {
    pilihSiswa(null);
    el.cari.value = '';
    el.cari.focus();
    jalankanCari();
  }

  function tutupHasil() { el.hasil.hidden = true; indeksAktif = -1; }

  function tampilHasil(daftar) {
    hasilCari = daftar;
    el.hasil.innerHTML = daftar.length
      ? daftar.map((s, i) =>
          '<li role="option" data-i="' + i + '"><span><b>' + esc(s.nama) + '</b><small>NIS ' + esc(s.nis) + ' • NISN ' + esc(s.nisn || '-') + '</small></span><em>' + esc(s.kelas) + '</em></li>').join('')
      : '<li class="none">Siswa tidak ditemukan</li>';
    el.hasil.hidden = false;
  }

  function jalankanCari() {
    const q = el.cari.value.trim();
    fetch(C.cariUrl + '?q=' + encodeURIComponent(q), { headers: { Accept: 'application/json' } })
      .then((r) => r.ok ? r.json() : Promise.reject())
      .then(tampilHasil)
      .catch(() => toast('Gagal mengambil data siswa. Periksa koneksi lalu coba lagi.'));
  }

  function aktifkanCari() {
    el.cari.addEventListener('input', () => { clearTimeout(timerCari); timerCari = setTimeout(jalankanCari, 250); });
    el.cari.addEventListener('focus', () => { if (!S.siswa) jalankanCari(); });
    $('#btnCari').addEventListener('click', () => { el.cari.focus(); jalankanCari(); });

    el.hasil.addEventListener('click', (e) => {
      const li = e.target.closest('li[data-i]');
      if (li) pilihSiswa(hasilCari[Number(li.dataset.i)]);
    });

    el.cari.addEventListener('keydown', (e) => {
      const li = $$('li[data-i]', el.hasil);
      if (e.key === 'Escape') return tutupHasil();
      if (!li.length) return;
      if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
        e.preventDefault();
        indeksAktif = (indeksAktif + (e.key === 'ArrowDown' ? 1 : -1) + li.length) % li.length;
        li.forEach((n, i) => n.classList.toggle('act', i === indeksAktif));
      }
      if (e.key === 'Enter' && indeksAktif >= 0) { e.preventDefault(); pilihSiswa(hasilCari[indeksAktif]); }
    });

    document.addEventListener('click', (e) => { if (!e.target.closest('.finder')) tutupHasil(); });
  }

  /* ---------- 4. KATEGORI DOKUMEN ---------------------------------------- */
  function perbaruiStatusTile() {
    el.tiles.forEach((t) => {
      const kecil = $('small', t);
      if (!S.siswa) { kecil.textContent = C.jenis[t.dataset.jenis].sub; kecil.dataset.st = ''; return; }
      const st = S.siswa.status_jenis[t.dataset.jenis] || 'kosong';
      kecil.textContent = LABEL_STATUS[st];
      kecil.dataset.st = st;
    });
  }

  function pilihJenis(jenis) {
    S.jenis = jenis;
    el.jenisDok.value = jenis || '';
    el.tiles.forEach((t) => t.classList.toggle('pick', t.dataset.jenis === jenis));
    if (jenis) {
      const m = C.jenis[jenis];
      el.lblNomor.textContent = m.nomor;
      if (!S.namaDiubah) el.nama.value = m.nama;
    }
    cek();
  }

  function aktifkanKategori() {
    el.tiles.forEach((t) => t.addEventListener('click', () => pilihJenis(t.dataset.jenis)));
    el.nama.addEventListener('input', () => { S.namaDiubah = true; });
  }

  /* ---------- 5. UNGGAH BERKAS ------------------------------------------- */
  function pesanError(teks) { el.err.textContent = teks || ''; }

  function samakanInput(file) {
    const dt = new DataTransfer();
    if (file) dt.items.add(file);
    el.berkas.files = dt.files;
  }

  function terimaBerkas(file) {
    pesanError('');
    const ext = (file.name.split('.').pop() || '').toLowerCase();
    if (!C.ext.includes(ext)) { pesanError('Format tidak didukung. Gunakan PDF, JPG, JPEG, atau PNG.'); return; }
    if (file.size > C.maxMB * 1048576) { pesanError('Ukuran berkas melebihi batas ' + C.maxMB + ' MB.'); return; }

    S.file = file;
    samakanInput(file);

    el.fiExt.textContent = ext === 'pdf' ? 'PDF' : ext.toUpperCase();
    el.fiExt.classList.toggle('im', ext !== 'pdf');
    el.fiNama.textContent = file.name;
    el.fiBadge.textContent = 'Valid (' + ukuran(file.size) + ')';
    el.fiMeta.textContent = 'Format dan ukuran sesuai ketentuan • menghitung checksum SHA-256...';
    el.item.hidden = false;

    tampilPratinjau(file, ext);
    hitungHash(file);
    cek();
  }

  function hapusBerkas() {
    S.file = null;
    samakanInput(null);
    el.item.hidden = true;
    pesanError('');
    kosongkanPratinjau();
    cek();
  }

  function aktifkanUnggah() {
    $('#btnPilih').addEventListener('click', () => el.berkas.click());
    $('#fiGanti').addEventListener('click', () => el.berkas.click());
    $('#fiHapus').addEventListener('click', hapusBerkas);
    $('#fiLihat').addEventListener('click', () => el.pvBox.scrollIntoView({ behavior: 'smooth', block: 'center' }));
    el.berkas.addEventListener('change', () => { if (el.berkas.files[0]) terimaBerkas(el.berkas.files[0]); });

    ['dragenter', 'dragover'].forEach((ev) => el.drop.addEventListener(ev, (e) => { e.preventDefault(); el.drop.classList.add('over'); }));
    ['dragleave', 'drop'].forEach((ev) => el.drop.addEventListener(ev, (e) => { e.preventDefault(); el.drop.classList.remove('over'); }));
    el.drop.addEventListener('drop', (e) => { if (e.dataTransfer.files[0]) terimaBerkas(e.dataTransfer.files[0]); });
  }

  /* ---------- 6. PRATINJAU BERKAS ---------------------------------------- */
  function terapkanTransform() { el.pvInner.style.transform = 'rotate(' + S.rot + 'deg) scale(' + S.zoom + ')'; }

  function kosongkanPratinjau() {
    if (S.url) URL.revokeObjectURL(S.url);
    S.url = null; S.zoom = 1; S.rot = 0; terapkanTransform();
    el.pvBox.classList.remove('has');
    el.pvInner.innerHTML = '<div class="pv-empty">' + ico('cloud') + '<span>Pratinjau akan tampil di sini setelah Anda memilih berkas.</span></div>';
    el.pvFormat.textContent = 'Belum ada';
    el.pvHash.textContent = '—'; el.pvHash.title = '';
  }

  function tampilPratinjau(file, ext) {
    if (S.url) URL.revokeObjectURL(S.url);
    S.url = URL.createObjectURL(file); S.zoom = 1; S.rot = 0; terapkanTransform();
    el.pvInner.innerHTML = ext === 'pdf'
      ? '<iframe src="' + S.url + '#toolbar=0&navpanes=0" title="Pratinjau PDF"></iframe>'
      : '<img src="' + S.url + '" alt="Pratinjau berkas">';
    el.pvFormat.textContent = ext.toUpperCase() + ' • ' + ukuran(file.size);
    el.pvBox.classList.remove('has'); void el.pvBox.offsetWidth; el.pvBox.classList.add('has');
  }

  async function hitungHash(file) {
    el.pvHash.textContent = 'menghitung...';
    try {
      if (!(window.crypto && crypto.subtle)) throw new Error('tidak didukung');
      const buf = await file.arrayBuffer();
      const h = Array.from(new Uint8Array(await crypto.subtle.digest('SHA-256', buf)))
        .map((b) => b.toString(16).padStart(2, '0')).join('');
      if (S.file !== file) return;   // berkas sudah diganti
      el.pvHash.textContent = h.slice(0, 6) + '...' + h.slice(-4);
      el.pvHash.title = h;
      el.fiMeta.textContent = 'Format dan ukuran sesuai ketentuan • Checksum SHA-256 berhasil dihitung';
    } catch (e) {
      el.pvHash.textContent = 'tidak tersedia';
      el.fiMeta.textContent = 'Format dan ukuran sesuai ketentuan • checksum perlu koneksi aman (HTTPS/localhost)';
    }
  }

  function aktifkanPratinjau() {
    $('#pvZoomIn').addEventListener('click',  () => { S.zoom = Math.min(3, S.zoom + 0.25); terapkanTransform(); });
    $('#pvZoomOut').addEventListener('click', () => { S.zoom = Math.max(0.5, S.zoom - 0.25); terapkanTransform(); });
    $('#pvRotate').addEventListener('click',  () => { S.rot = (S.rot + 90) % 360; terapkanTransform(); });
    $('#pvFull').addEventListener('click',    () => {
      if (document.fullscreenElement) document.exitFullscreen();
      else if (el.pvBox.requestFullscreen) el.pvBox.requestFullscreen();
    });
  }

  /* ---------- 7. SYARAT VALIDASI & KIRIM --------------------------------- */
  function cek() {
    const ok = { siswa: !!S.siswa, jenis: !!S.jenis, berkas: !!S.file };
    const lengkap = ok.siswa && ok.jenis && ok.berkas;
    const kurang = [!ok.siswa && 'siswa', !ok.jenis && 'kategori', !ok.berkas && 'berkas'].filter(Boolean);

    el.bar.classList.toggle('ok', lengkap);
    $('#syaratJudul').textContent = lengkap ? 'Semua Syarat Validasi Terpenuhi' : 'Lengkapi data sebelum mengunggah';
    $('#syaratIsi').textContent = lengkap
      ? 'Berkas siap dikirim ke antrean verifikasi staf tata usaha madrasah.'
      : 'Belum lengkap: ' + kurang.join(', ') + '.';
    el.btnUpload.disabled = !lengkap;
  }

  function aktifkanKirim() {
    el.form.addEventListener('submit', (e) => {
      if (el.btnUpload.disabled) { e.preventDefault(); return; }
      el.btnUpload.disabled = true;
      el.btnUploadTx.textContent = 'Mengunggah...';
      el.btnUpload.insertAdjacentHTML('afterbegin', '<span class="spin"></span>');
      localStorage.removeItem(C.draftKey);
    });
  }

  /* ---------- 8. DRAFT & RESET ------------------------------------------- */
  function simpanDraft() {
    try {
      localStorage.setItem(C.draftKey, JSON.stringify({
        siswa: S.siswa, jenis: S.jenis, nama: el.nama.value, namaDiubah: S.namaDiubah,
        nomor: el.nomor.value, tgl: el.tgl.value, desk: el.desk.value,
      }));
      toast('Draft tersimpan di browser ini. Berkas perlu dipilih ulang saat dilanjutkan.');
    } catch (e) { toast('Draft tidak dapat disimpan di browser ini.'); }
  }

  function pulihkanDraft() {
    try {
      const d = JSON.parse(localStorage.getItem(C.draftKey) || 'null');
      if (!d) return false;
      if (d.siswa) pilihSiswa(d.siswa);
      S.namaDiubah = !!d.namaDiubah;
      if (d.jenis) pilihJenis(d.jenis);
      el.nama.value = d.nama || ''; el.nomor.value = d.nomor || '';
      el.tgl.value = d.tgl || '';   el.desk.value = d.desk || '';
      toast('Draft sebelumnya dipulihkan. Pilih ulang berkas untuk melanjutkan.');
      return true;
    } catch (e) { return false; }
  }

  function resetFormulir() {
    localStorage.removeItem(C.draftKey);
    pilihSiswa(null); el.cari.value = '';
    pilihJenis(null);
    el.tiles.forEach((t) => t.classList.remove('pick'));
    S.namaDiubah = false;
    el.nama.value = ''; el.nomor.value = ''; el.tgl.value = ''; el.desk.value = '';
    el.lblNomor.textContent = 'Nomor Registrasi Dokumen';
    hapusBerkas();
    toast('Formulir dikosongkan.');
  }

  function aktifkanDraft() {
    $('#btnDraft').addEventListener('click', simpanDraft);
    $('#btnReset').addEventListener('click', resetFormulir);
  }

  /* ---------- 9. DIALOG PANDUAN ------------------------------------------ */
  function aktifkanDialog() {
    $('#btnPanduan').addEventListener('click', () => el.dlg.showModal());
    $('#btnTutupPanduan').addEventListener('click', () => el.dlg.close());
    el.dlg.addEventListener('click', (e) => { if (e.target === el.dlg) el.dlg.close(); });
  }

  /* ---------- 10. MULAI -------------------------------------------------- */
  function mulai() {
    animasiMasuk();
    aktifkanCari(); aktifkanKategori(); aktifkanUnggah(); aktifkanPratinjau();
    aktifkanKirim(); aktifkanDraft(); aktifkanDialog();

    kartuKosong();
    perbaruiStatusTile();

    // Data awal dari server (tautan "unggah ulang" atau validasi gagal) lebih diutamakan daripada draft
    const dariServer = !!(C.siswaAwal || C.jenisAwal);
    if (C.siswaAwal) pilihSiswa(C.siswaAwal);
    if (C.jenisAwal) pilihJenis(C.jenisAwal);
    if (C.old.nama)  { el.nama.value = C.old.nama; S.namaDiubah = true; }
    if (C.old.nomor) el.nomor.value = C.old.nomor;
    if (C.old.tgl)   el.tgl.value = C.old.tgl;
    if (C.old.desk)  el.desk.value = C.old.desk;
    if (!dariServer) pulihkanDraft();

    if (dariServer && location.hash === '#unggah') setTimeout(() => $('#unggah').scrollIntoView({ behavior: 'smooth' }), 400);
    cek();
  }

  mulai();
})();
</script>