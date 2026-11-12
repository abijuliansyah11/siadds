<script>
/* ==========================================================================
   LOKASI ARSIP FISIK — Skrip halaman
   Daftar isi:
   1. Pembantu              6. Tabel & pilihan massal
   2. Animasi masuk         7. Label QR & cetak
   3. Pilihan lemari/rak    8. Dialog
   4. Panel detail          9. Pintasan
   5. Form pada panel      10. Mulai
   ========================================================================== */
(function () {
  'use strict';

  const C = window.ARSIPFISIK;

  /* ---------- 1. PEMBANTU ------------------------------------------------ */
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
  const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

  const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (m) =>
    ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]));
  const ico = (n) => '<svg class="i"><use href="#' + n + '"/></svg>';
  const aksiUrl = (basis, id) => basis.replace('/0/', '/' + id + '/');

  const panel = $('#panelDetail');
  let aktifId = null;

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
    const target = $$('.rv');
    if (reduce || !('IntersectionObserver' in window)) { target.forEach((n) => n.classList.add('in')); }
    else {
      const io = new IntersectionObserver((daftar) => daftar.forEach((e) => {
        if (e.isIntersecting) { e.target.classList.add('in'); io.unobserve(e.target); }
      }), { threshold: 0.06, rootMargin: '0px 0px -40px 0px' });
      target.forEach((n) => io.observe(n));
    }

    // Angka menghitung naik
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
  }

  /* ---------- 3. PILIHAN LEMARI / RAK ------------------------------------ */
  function isiRak(selLemari, selRak, pilihRak, kosong) {
    const l = C.lokasi.find((x) => String(x.id) === selLemari.value);
    let opsi = kosong ? '<option value="">Belum ditentukan (antrean)</option>' : '';
    if (l) {
      opsi += l.raks.map((r) =>
        '<option value="' + r.id + '"' + (String(r.id) === String(pilihRak) ? ' selected' : '') +
        (r.sisa < 1 && String(r.id) !== String(pilihRak) ? ' disabled' : '') + '>Rak ' + esc(r.kode) + ' (sisa ' + r.sisa + ')</option>').join('');
    } else if (!kosong) {
      opsi = '<option value="">Belum ada lokasi</option>';
    }
    selRak.innerHTML = opsi;
  }

  function pasangLokasi(selLemari, selRak, opsi) {
    const o = Object.assign({ lemariId: null, rakId: null, kosong: false }, opsi);
    selLemari.innerHTML = (o.kosong ? '<option value="">Belum ditentukan</option>' : '') +
      C.lokasi.map((l) => '<option value="' + l.id + '"' + (String(l.id) === String(o.lemariId) ? ' selected' : '') + '>' + esc(l.label) + '</option>').join('');
    isiRak(selLemari, selRak, o.rakId, o.kosong);
    selLemari.addEventListener('change', () => isiRak(selLemari, selRak, null, o.kosong));
  }

  /* ---------- 4. PANEL DETAIL -------------------------------------------- */
  function htmlPinjam(d) {
    if (!d.pinjam) return '';
    const p = d.pinjam;
    return '<div class="loan ' + (p.lewat ? 'lewat' : '') + '"><b>' + (p.lewat ? 'Lewat jatuh tempo — ' : '') + 'Dipinjam oleh ' + esc(p.oleh) + '</b>' +
      'Sejak ' + esc(p.tanggal || '-') + ' • Jatuh tempo ' + esc(p.jatuhTempo || '-') + (p.keperluan ? '<br>Keperluan: ' + esc(p.keperluan) : '') + '</div>';
  }

  function htmlAlamat(d) {
    const L = d.lokasi;
    const baris = (ikon, label, isi, kecil, kelas) =>
      '<li>' + ico(ikon) + '<span>' + label + '</span><b class="' + (kelas || '') + '">' + isi + (kecil ? '<small>' + kecil + '</small>' : '') + '</b></li>';

    return '<ul class="addr">' +
      baris('building', 'Gedung & Ruangan:', L ? esc(L.alamat) : 'Belum ditentukan', '', L ? '' : 'no') +
      baris('cabinet', 'Lemari Penyimpanan:', L ? 'Lemari ' + esc(L.lemari) : '-', L && L.lemariKet ? esc(L.lemariKet) : '') +
      baris('layers', 'Baris Rak:', L ? 'Rak ' + esc(L.rak) : '-', L ? 'Terisi ' + L.terisi + ' dari ' + L.kapasitas + ' berkas' : '') +
      baris('folder', 'Map Ordner:', d.map ? esc(d.map) : '-') +
      baris('check', 'Kondisi Fisik:', esc(d.kondisiLabel), d.keterangan ? esc(d.keterangan) : '') +
      '</ul>';
  }

  function htmlForm(d) {
    const tab = d.status === 'dipinjam' ? 'pinjam' : 'pindah';
    const token = '<input type="hidden" name="_token" value="' + esc(C.csrf) + '">';
    const kondisi = Object.keys(C.kondisi).map((k) =>
      '<option value="' + k + '"' + (k === d.kondisi ? ' selected' : '') + '>' + esc(C.kondisi[k]) + '</option>').join('');

    const formPinjam = d.status === 'dipinjam'
      ? '<form method="POST" action="' + esc(aksiUrl(C.urls.kembali, d.id)) + '">' + token +
          '<p class="mu" style="font-size:11.5px;line-height:1.6;margin-bottom:10px">Arsip ini sedang dipinjam. Tandai sudah kembali setelah dokumen asli diterima dan diperiksa.</p>' +
          '<button type="submit" class="btn g full">' + ico('check') + 'Tandai Sudah Dikembalikan</button></form>'
      : '<form method="POST" action="' + esc(aksiUrl(C.urls.pinjam, d.id)) + '">' + token +
          '<div class="fld"><label>Nama Peminjam</label><input type="text" name="peminjam" maxlength="100" required placeholder="Nama petugas / wali"></div>' +
          '<div class="fld"><label>Keperluan</label><input type="text" name="keperluan" maxlength="200" placeholder="Contoh: Legalisir ijazah"></div>' +
          '<div class="fld"><label>Jatuh Tempo Pengembalian</label><input type="date" name="jatuh_tempo" required min="' + new Date().toISOString().slice(0, 10) + '"></div>' +
          '<button type="submit" class="btn g full">' + ico('check') + 'Simpan Peminjaman</button></form>';

    return '<div class="ptabs" role="tablist">' +
        '<button type="button" data-tab="pindah" class="' + (tab === 'pindah' ? 'on' : '') + '">Pindahkan Rak</button>' +
        '<button type="button" data-tab="pinjam" class="' + (tab === 'pinjam' ? 'on' : '') + '">Catat Peminjaman</button>' +
        '<button type="button" data-tab="kondisi">Kondisi</button></div>' +

      '<div class="pform ' + (tab === 'pindah' ? 'on' : '') + '" id="tab-pindah">' +
        '<form method="POST" action="' + esc(aksiUrl(C.urls.pindah, d.id)) + '">' + token +
          '<div class="fld"><label>Target Ruang & Lemari Baru</label><select id="pmLemari"></select></div>' +
          '<div class="two"><div class="fld"><label>Rak Baru</label><select name="arsip_rak_id" id="pmRak"></select></div>' +
          '<div class="fld"><label>Kode Map</label><input type="text" name="kode_map" maxlength="30" value="' + esc(d.map || '') + '" placeholder="M-001"></div></div>' +
          '<div class="fld"><label>Catatan / Alasan Pemindahan</label><input type="text" name="catatan" maxlength="300" placeholder="Misal: Penataan ulang kelas XII"></div>' +
          '<button type="submit" class="btn g full">' + ico('move') + 'Simpan Pemindahan Lokasi</button></form></div>' +

      '<div class="pform ' + (tab === 'pinjam' ? 'on' : '') + '" id="tab-pinjam">' + formPinjam + '</div>' +

      '<div class="pform" id="tab-kondisi"><form method="POST" action="' + esc(aksiUrl(C.urls.kondisi, d.id)) + '">' + token +
          '<div class="fld"><label>Kondisi Fisik Dokumen</label><select name="kondisi">' + kondisi + '</select></div>' +
          '<div class="fld"><label>Catatan Pemeriksaan</label><input type="text" name="catatan" maxlength="300" placeholder="Misal: Sudut kertas mulai lapuk"></div>' +
          '<button type="submit" class="btn g full">' + ico('check') + 'Simpan Kondisi</button></form></div>';
  }

  function htmlRiwayat(d) {
    if (!d.log.length) return '';
    return '<div class="dl">RIWAYAT AKTIVITAS</div><ul class="log">' + d.log.map((l) =>
      '<li><b>' + esc(l.aksi) + '</b> — ' + esc(l.ket || '') + '<small>' + esc(l.oleh || '-') + ' • ' + esc(l.waktu) + '</small></li>').join('') + '</ul>';
  }

  function htmlPanel(d) {
    const s = d.siswa, L = d.lokasi;
    const tagKelas = L ? d.status : 'belum';
    const link = (url, teks) => url ? '<a href="' + esc(url) + '">' + teks + ico('arrow') + '</a>' : '';

    return '' +
      '<div class="dh"><span class="t">DETAIL ARSIP TERPILIH</span><span class="tag ' + tagKelas + '">' + esc(d.statusLabel) + '</span></div>' +
      '<div class="kode">' + esc(d.kode) + '</div>' +

      '<div class="sc"><span class="ini">' + esc(s ? s.ini : '?') + '</span><div><b>' + esc(s ? s.nama : '-') + '</b>' +
        '<small>NIS: ' + esc(s ? s.nis : '-') + ' • Kelas ' + esc(s ? s.kelas : '-') + '</small><small class="dok">' + esc(d.jenis) + '</small></div></div>' +

      '<div>' + htmlPinjam(d) +
        '<div class="dl" style="margin-top:0">LABEL FISIK ORDNER</div>' +
        '<div class="lbl"><div class="qr" id="qrPanel"></div><div class="lt"><b>MAS YPI SUMBER HARJO</b><small>SIADDS • ARSIP RESMI</small>' +
          '<strong>' + esc(d.kode) + '</strong><small>' + esc(L ? L.alamat : 'Lokasi belum ditentukan') + '</small></div></div>' +
        '<button type="button" class="btn full" id="btnLabel" style="margin-top:10px">' + ico('print') + 'Cetak Label Ordner (Sticker 50x30mm)</button></div>' +

      '<div><div class="dl">ALAMAT REPOSITORI FISIK</div>' + htmlAlamat(d) + htmlForm(d) + htmlRiwayat(d) +
        '<div class="plinks">' +
          link(d.urlDigital, 'Buka Berkas Digital di Direktori Arsip') +
          link(d.urlProfil, 'Lihat Profil Siswa Terpadu') +
          link(d.urlKelengkapan, 'Periksa Kelengkapan Dokumen Siswa') +
        '</div></div>';
  }

  function tampilPanel(id) {
    const d = C.detail[id];
    if (!d) {
      panel.innerHTML = '<div class="empty"><b>Belum ada arsip dipilih</b>Pilih satu baris pada tabel untuk melihat lokasi, label, dan mengelola arsipnya.</div>';
      return;
    }
    aktifId = id;
    panel.innerHTML = htmlPanel(d);
    panel.classList.remove('swap'); void panel.offsetWidth; panel.classList.add('swap');

    pasangLokasi($('#pmLemari'), $('#pmRak'), { lemariId: d.lokasi ? d.lokasi.lemariId : null, rakId: d.lokasi ? d.lokasi.rakId : null });
    buatQR($('#qrPanel'), d.qr, 70);
    $('#btnLabel').addEventListener('click', () => cetakLabel([d]));
  }

  /* ---------- 5. FORM PADA PANEL ----------------------------------------- */
  function aktifkanTabPanel() {
    panel.addEventListener('click', (e) => {
      const b = e.target.closest('.ptabs button');
      if (!b) return;
      $$('.ptabs button', panel).forEach((x) => x.classList.toggle('on', x === b));
      $$('.pform', panel).forEach((f) => f.classList.toggle('on', f.id === 'tab-' + b.dataset.tab));
    });
  }

  /* ---------- 6. TABEL & PILIHAN MASSAL ---------------------------------- */
  function pilihArsip(id) {
    $$('#tabelArsip tbody tr[data-id]').forEach((tr) => tr.classList.toggle('act', tr.dataset.id === String(id)));
    tampilPanel(id);

    const u = new URL(location.href);
    u.searchParams.set('pilih', id);
    history.replaceState(null, '', u);
  }

  function terpilih() { return $$('.pil:checked').map((c) => c.value); }

  function perbaruiPilihan() {
    const n = terpilih().length;
    $('#jmlPilih').textContent = n; $('#jmlPilih2').textContent = n;
    $('#btnLabelMassal').disabled = n === 0;
    $('#btnMassal').disabled = n === 0;
  }

  function aktifkanTabel() {
    $$('#tabelArsip tbody tr[data-id]').forEach((tr) => tr.addEventListener('click', (e) => {
      if (e.target.closest('input,a,button')) return;
      pilihArsip(tr.dataset.id);
    }));

    $$('.pil').forEach((c) => c.addEventListener('change', perbaruiPilihan));
    const semua = $('#semua');
    if (semua) semua.addEventListener('change', () => { $$('.pil').forEach((c) => { c.checked = semua.checked; }); perbaruiPilihan(); });

    $('#btnRapat').addEventListener('click', (e) => {
      const rapat = $('#tabelArsip').classList.toggle('rapat');
      e.currentTarget.lastChild.textContent = rapat ? 'Tampilan Normal' : 'Tampilan Ringkas';
    });

    $('#btnLabelMassal').addEventListener('click', () => {
      const daftar = terpilih().map((id) => C.detail[id]).filter(Boolean);
      if (!daftar.length) { toast('Label hanya dapat dicetak untuk arsip yang tampil pada halaman ini.'); return; }
      cetakLabel(daftar);
    });
  }

  /* ---------- 7. LABEL QR & CETAK ---------------------------------------- */
  function buatQR(el, teks, ukuran) {
    if (!el) return;
    el.innerHTML = '';
    if (window.QRCode) {
      new QRCode(el, { text: teks, width: ukuran * 2, height: ukuran * 2, correctLevel: QRCode.CorrectLevel.M });
    } else {
      el.textContent = 'QR butuh koneksi internet';
    }
  }

  function cetakLabel(daftar) {
    const area = $('#areaCetak');
    area.innerHTML = '';
    daftar.forEach((d) => {
      const w = document.createElement('div');
      w.className = 'stk';
      w.innerHTML = '<div class="q"></div><div class="tx"><b>MAS YPI SUMBER HARJO</b><small>SIADDS • ARSIP RESMI</small>' +
        '<strong>' + esc(d.kode) + '</strong><small>' + esc(d.siswa ? d.siswa.nama : '') + '</small>' +
        '<small>' + esc(d.lokasi ? d.lokasi.ringkas : 'Lokasi belum ditentukan') + '</small></div>';
      area.appendChild(w);
      buatQR($('.q', w), d.qr, 84);
    });
    document.body.classList.add('cetak-label');
    setTimeout(() => window.print(), 300);
  }

  window.addEventListener('afterprint', () => document.body.classList.remove('cetak-label'));

  /* ---------- 8. DIALOG -------------------------------------------------- */
  function aktifkanDialogUmum() {
    const buka = (tombol, dlg) => { const b = $(tombol); if (b) b.addEventListener('click', () => $(dlg).showModal()); };
    buka('#btnPanduan', '#dlgPanduan');
    buka('#btnLokasi', '#dlgLokasi');
    buka('#btnCatat', '#dlgCatat');
    $$('[data-buka]').forEach((b) => b.addEventListener('click', () => $(b.dataset.buka).showModal()));

    $$('dialog').forEach((dlg) => dlg.addEventListener('click', (e) => {
      if (e.target === dlg || e.target.closest('[data-tutup]')) dlg.close();
    }));

    $('#btnRekap').addEventListener('click', () => window.print());
    $('#formSinkron').addEventListener('submit', (e) => {
      if (!confirm('Tarik data lemari/rak/map dari profil siswa dan buat catatan arsip fisik untuk dokumen yang sudah diunggah?\n\nData yang sudah ada tidak akan diubah.')) e.preventDefault();
    });
  }

  function aktifkanDialogLokasi() {
    const sel = $('#lkRuang'), baru = $('#lkBaru'), nama = $('#lkNama');
    const ubah = () => { const b = sel.value === 'baru'; baru.hidden = !b; nama.required = b; };
    sel.addEventListener('change', ubah); ubah();
  }

  function aktifkanDialogCatat() {
    const cari = $('#ctCari'), hasil = $('#ctHasil'), pilih = $('#ctPilih'), idSiswa = $('#ctSiswaId');
    let timer, data = [];

    pasangLokasi($('#ctLemari'), $('#ctRak'), { kosong: true });

    function tampil(daftar) {
      data = daftar;
      hasil.innerHTML = daftar.length
        ? daftar.map((s, i) => '<li data-i="' + i + '"><span><b>' + esc(s.nama) + '</b><small>NIS ' + esc(s.nis) + '</small></span><em>' + esc(s.kelas) + '</em></li>').join('')
        : '<li class="none">Siswa tidak ditemukan</li>';
      hasil.hidden = false;
    }

    function pilihSiswa(s) {
      idSiswa.value = s.id;
      cari.value = '';
      hasil.hidden = true;
      pilih.hidden = false;
      pilih.textContent = s.nama + ' • NIS ' + s.nis + ' • Kelas ' + s.kelas;

      // Dokumen yang sudah ada berkas digitalnya dicentang otomatis
      $$('#ctJenis input').forEach((c) => {
        const ada = !!(s.status_jenis && s.status_jenis[c.value]);
        c.checked = ada;
        $('small', c.parentElement).textContent = ada ? 'Ada berkas digital' : '';
      });
    }

    const jalankan = () => fetch(C.cariUrl + '?q=' + encodeURIComponent(cari.value.trim()), { headers: { Accept: 'application/json' } })
      .then((r) => r.ok ? r.json() : Promise.reject()).then(tampil).catch(() => toast('Gagal mengambil data siswa.'));

    cari.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(jalankan, 250); });
    cari.addEventListener('focus', jalankan);
    hasil.addEventListener('click', (e) => { const li = e.target.closest('li[data-i]'); if (li) pilihSiswa(data[Number(li.dataset.i)]); });
    document.addEventListener('click', (e) => { if (!e.target.closest('#dlgCatat .finder')) hasil.hidden = true; });

    $('#formCatat').addEventListener('submit', (e) => {
      if (!idSiswa.value) { e.preventDefault(); toast('Pilih siswa terlebih dahulu.'); cari.focus(); }
      else if (!$$('#ctJenis input:checked').length) { e.preventDefault(); toast('Pilih minimal satu jenis dokumen.'); }
    });
  }

  function aktifkanDialogMassal() {
    pasangLokasi($('#mlLemari'), $('#mlRak'), {});
    $('#btnMassal').addEventListener('click', () => {
      const ids = terpilih();
      $('#mlIds').innerHTML = ids.map((id) => '<input type="hidden" name="ids[]" value="' + esc(id) + '">').join('');
      $('#mlInfo').textContent = ids.length + ' arsip dipilih akan dipindahkan ke rak yang sama. Kode map tiap arsip tidak diubah.';
      $('#dlgMassal').showModal();
    });
  }

  /* ---------- 9. PINTASAN ------------------------------------------------ */
  function aktifkanPintasan() {
    document.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        const k = $('#cariTabel'); k.focus(); k.select();
      }
    });
  }

  /* ---------- 10. MULAI -------------------------------------------------- */
  function mulai() {
    animasiMasuk();
    aktifkanTabPanel();
    aktifkanTabel();
    aktifkanDialogUmum();
    aktifkanDialogLokasi();
    aktifkanDialogCatat();
    aktifkanDialogMassal();
    aktifkanPintasan();

    tampilPanel(C.pilih);
    perbaruiPilihan();
  }

  // Tunggu pustaka QR (defer) selesai dimuat sebelum membuat kode QR pertama
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', mulai);
  else mulai();
})();
</script>