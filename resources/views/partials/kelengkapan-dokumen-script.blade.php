<script>
/* ==========================================================================
   KELENGKAPAN DOKUMEN — Skrip halaman
   Daftar isi:
   1. Pembantu            5. Pemilihan siswa & riwayat URL
   2. Animasi masuk       6. Dialog, dropdown & pintasan
   3. Panel detail        7. Mulai
   4. Kotak penelaahan
   ========================================================================== */
(function () {
  'use strict';

  const C = window.KELENGKAPAN;

  /* ---------- 1. PEMBANTU ------------------------------------------------ */
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
  const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

  const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (m) =>
    ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]));
  const ico = (n) => '<svg class="i"><use href="#' + n + '"/></svg>';

  const LABEL_STATUS = { lengkap: 'Lengkap', menunggu: 'Menunggu Verifikasi', belum: 'Butuh Tindak Lanjut', revisi: 'Perlu Revisi' };
  const IKON_DOKUMEN = { sah: 'okc', menunggu: 'clock', revisi: 'xc', kosong: 'minc' };

  const panel = $('#panelDetail');
  const S = { id: null, pick: null };

  let timerToast;
  function toast(pesan) {
    const t = $('#toast');
    t.textContent = pesan;
    t.classList.add('show');
    clearTimeout(timerToast);
    timerToast = setTimeout(() => t.classList.remove('show'), 3600);
  }

  /* ---------- 2. ANIMASI MASUK ------------------------------------------- */
  function animasiMasuk() {
    // Munculkan elemen saat terlihat di layar
    const target = $$('.rv');
    if (reduce || !('IntersectionObserver' in window)) { target.forEach((n) => n.classList.add('in')); }
    else {
      const io = new IntersectionObserver((daftar) => daftar.forEach((e) => {
        if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
      }), { threshold: 0.06, rootMargin: '0px 0px -40px 0px' });
      target.forEach((n) => io.observe(n));
    }

    // Angka menghitung naik (mendukung akhiran, misalnya %)
    $$('[data-count]').forEach((n) => {
      const akhir = Number(n.dataset.count) || 0, suf = n.dataset.suf || '';
      if (reduce || akhir === 0) return;
      const mulai = performance.now() + 350, durasi = 1500;
      n.textContent = '0' + suf;
      (function langkah(t) {
        const p = Math.max(0, Math.min(1, (t - mulai) / durasi));
        n.textContent = Math.round(akhir * (1 - Math.pow(1 - p, 4))).toLocaleString('id-ID') + suf;
        if (p < 1) requestAnimationFrame(langkah);
      })(performance.now());
    });
  }

  /* ---------- 3. PANEL DETAIL -------------------------------------------- */
  function htmlChecklist(d) {
    return d.cek.map((c, idx) => {
      let aksi = '';
      if (c.st === 'sah')           aksi = c.lihat ? '<a href="' + esc(c.lihat) + '" target="_blank" rel="noopener">Lihat</a>' : '';
      else if (c.st === 'menunggu') aksi = '<button type="button" class="pk" data-pick="' + idx + '">Periksa</button>';
      else if (c.st === 'revisi')   aksi = '<a class="up" href="' + esc(c.upload) + '">Unggah Ulang</a>';
      else                          aksi = '<a class="up" href="' + esc(c.upload) + '">+ Upload</a>';

      return '<li class="cl ' + c.st + '">' +
        '<span class="cli">' + ico(IKON_DOKUMEN[c.st]) + '</span>' +
        '<div class="tx"><b>' + esc(c.jenis) + '</b><small title="' + esc(c.sub) + '">' + esc(c.sub) + '</small></div>' +
        '<span class="ac">' + aksi + '</span></li>';
    }).join('');
  }

  function htmlHitungan(n) {
    const bagian = [];
    if (n.sah)      bagian.push('<span class="a">' + n.sah + ' Terverifikasi</span>');
    if (n.menunggu) bagian.push('<span class="b">' + n.menunggu + ' Menunggu</span>');
    if (n.kosong)   bagian.push('<span class="c">' + n.kosong + ' Belum Diunggah</span>');
    if (n.revisi)   bagian.push('<span class="d">' + n.revisi + ' Perlu Revisi</span>');
    return bagian.join('');
  }

  function htmlPanel(d) {
    return '' +
      '<div class="dh"><span class="t">' + ico('user') + '<span>DETAIL KELENGKAPAN<br>SISWA</span></span>' +
        '<span class="tag ' + d.status + '">' + esc(LABEL_STATUS[d.status]) + '</span></div>' +

      '<div class="dc"><img src="' + esc(d.foto) + '" alt="Foto ' + esc(d.nama) + '">' +
        '<div><b>' + esc(d.nama) + '</b><em>' + esc(d.kelas) + '</em>' +
        '<small>NIS: <b>' + esc(d.nis) + '</b> • NISN: <b>' + esc(d.nisn || '-') + '</b></small>' +
        '<small class="ak">● Status: Siswa ' + esc(d.statusSiswa) + ' Madrasah</small></div></div>' +

      '<div class="dpct"><span>Persentase Kelengkapan</span><b>' + d.persen + '% Lengkap</b></div>' +
      '<div class="track"><i class="' + d.status + '" style="width:0" data-w="' + d.persen + '"></i></div>' +
      '<div class="dcnt">' + htmlHitungan(d.n) + '</div>' +

      '<div class="dl">CHECKLIST ' + d.total + ' DOKUMEN WAJIB:</div>' +
      '<ul class="cls">' + htmlChecklist(d) + '</ul>' +

      '<div id="slotReview"></div>' +

      '<div class="dact"><a class="btn" href="' + esc(d.upload) + '">' + ico('upload') + 'Halaman Upload Berkas Siswa Ini</a></div>' +
      '<div class="dlink"><a href="' + esc(d.profil) + '">' + ico('user') + 'Profil Siswa</a>' +
        '<a class="wa ' + (d.wa ? '' : 'off') + '" href="' + esc(d.wa || '#') + '" target="_blank" rel="noopener" ' +
        'title="' + (d.wa ? 'Kirim pengingat lewat WhatsApp' : 'Tidak ada pengingat: nomor wali kosong atau berkas sudah lengkap') + '">' +
        ico('send') + 'Kirim Pengingat</a></div>';
  }

  function tampilPanel(id) {
    const d = C.detail[id];
    if (!d) {
      panel.innerHTML = '<div class="rv-none">Pilih siswa pada tabel untuk melihat detail kelengkapan dan memverifikasi berkasnya.</div>';
      return;
    }
    S.id = id;
    panel.innerHTML = htmlPanel(d);

    // Animasi masuk panel + bar progres
    panel.classList.remove('swap'); void panel.offsetWidth; panel.classList.add('swap');
    const bar = $('.track i', panel);
    requestAnimationFrame(() => setTimeout(() => { bar.style.width = bar.dataset.w + '%'; }, 60));

    // Berkas pertama yang menunggu verifikasi dibuka otomatis
    const pertama = d.cek.findIndex((c) => c.st === 'menunggu');
    tampilReview(pertama);
  }

  /* ---------- 4. KOTAK PENELAAHAN ---------------------------------------- */
  function tampilReview(idx) {
    const d = C.detail[S.id], slot = $('#slotReview');
    const c = idx >= 0 ? d.cek[idx] : null;
    S.pick = idx;

    $$('.cl', panel).forEach((li, i) => li.style.outline = (i === idx) ? '2px solid rgba(37,99,235,.35)' : '');

    if (!c) {
      slot.innerHTML = '<div class="rv-none">Tidak ada berkas yang menunggu verifikasi untuk siswa ini.</div>';
      return;
    }
    const aksi = C.putuskanUrl.replace('/0/', '/' + c.id + '/');
    slot.innerHTML =
      '<form class="rv-box" id="formPutus" method="POST" action="' + esc(aksi) + '">' +
        '<input type="hidden" name="_token" value="' + esc(C.csrf) + '">' +
        '<h4><span>Penelaahan ' + esc(c.jenis) + '</span><small>Staf TU:<br>' + esc(C.petugas) + '</small></h4>' +
        '<div class="rv-file"><span>' + ico('file') + esc(c.nama || 'berkas') + '</span>' +
          (c.lihat ? '<a href="' + esc(c.lihat) + '" target="_blank" rel="noopener">Pratinjau</a>' : '') + '</div>' +
        '<div class="rd2">' +
          '<label><input type="radio" name="keputusan" value="valid" checked> Verifikasi Sah</label>' +
          '<label class="no"><input type="radio" name="keputusan" value="revisi"> Perlu Revisi</label>' +
        '</div>' +
        '<textarea name="catatan" maxlength="500" placeholder="Catatan verifikator (opsional jika sah, wajib jika ditolak)..."></textarea>' +
        '<button type="submit" class="btn g">' + ico('check') + 'Simpan Keputusan</button>' +
      '</form>';
  }

  function aktifkanReview() {
    // Tombol "Periksa" pada checklist
    panel.addEventListener('click', (e) => {
      const b = e.target.closest('[data-pick]');
      if (b) tampilReview(Number(b.dataset.pick));
    });

    // Catatan wajib diisi saat meminta revisi
    document.addEventListener('submit', (e) => {
      if (e.target.id !== 'formPutus') return;
      const f = e.target;
      const revisi = f.querySelector('input[name=keputusan]:checked').value === 'revisi';
      if (revisi && !f.catatan.value.trim()) {
        e.preventDefault();
        f.catatan.focus();
        toast('Catatan wajib diisi saat meminta revisi agar siswa tahu apa yang harus diperbaiki.');
      }
    });
  }

  /* ---------- 5. PEMILIHAN SISWA & RIWAYAT URL --------------------------- */
  function pilihSiswa(id) {
    $$('.tbl tbody tr[data-id]').forEach((tr) => tr.classList.toggle('act', tr.dataset.id === String(id)));
    tampilPanel(id);

    // Simpan pilihan di URL agar tetap terpilih setelah verifikasi / muat ulang
    const u = new URL(location.href);
    u.searchParams.set('pilih', id);
    history.replaceState(null, '', u);
  }

  function aktifkanTabel() {
    $$('.tbl tbody tr[data-id]').forEach((tr) => tr.addEventListener('click', (e) => {
      if (e.target.closest('a,button')) return;
      pilihSiswa(tr.dataset.id);
    }));
  }

  /* ---------- 6. DIALOG, DROPDOWN & PINTASAN ----------------------------- */
  function aktifkanDialog() {
    const buka = (tombol, dlg) => $(tombol).addEventListener('click', () => $(dlg).showModal());
    buka('#btnPanduan', '#dlgPanduan');
    buka('#btnPengingat', '#dlgPengingat');

    $$('dialog').forEach((dlg) => {
      dlg.addEventListener('click', (e) => { if (e.target === dlg || e.target.closest('[data-tutup]')) dlg.close(); });
    });
  }

  function aktifkanDropdown() {
    const dd = $('#ddEkspor');
    document.addEventListener('click', (e) => { if (dd.open && !dd.contains(e.target)) dd.open = false; });
    $('#btnCetak').addEventListener('click', () => { dd.open = false; setTimeout(() => window.print(), 150); });
  }

  function aktifkanPintasan() {
    document.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        const k = $('#cariTabel');
        k.focus(); k.select();
      }
    });
  }

  /* ---------- 7. MULAI --------------------------------------------------- */
  function mulai() {
    animasiMasuk();
    aktifkanReview();
    aktifkanTabel();
    aktifkanDialog();
    aktifkanDropdown();
    aktifkanPintasan();

    if (C.pilih) tampilPanel(C.pilih); else tampilPanel(null);
  }

  mulai();
})();
</script>