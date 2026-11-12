<script>
/* ==========================================================================
   CETAK LABEL QR CODE — Skrip halaman
   Daftar isi:
   1. Pembantu & status     6. Pratinjau (tunggal / A4)
   2. Animasi masuk         7. Cetak
   3. Pilihan arsip         8. Buat QR / antrean cetak
   4. Pengaturan label      9. Dialog & pintasan
   5. Pembuat label        10. Mulai
   ========================================================================== */
(function () {
  'use strict';

  const C = window.CETAKLABEL;

  /* ---------- 1. PEMBANTU & STATUS --------------------------------------- */
  const $  = (s, r = document) => r.querySelector(s);
  const $$ = (s, r = document) => Array.from(r.querySelectorAll(s));
  const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

  const PX_MM  = 3.7795;                       // 1 mm = 3,7795 px pada layar
  const KERTAS = { lebar: 210, tinggi: 297, margin: 8, jarak: 2 };   // A4, dalam mm

  const esc = (s) => String(s ?? '').replace(/[&<>"']/g, (m) =>
    ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[m]));
  const ico = (n) => '<svg class="i"><use href="#' + n + '"/></svg>';
  const batas = (n, min, max) => Math.min(max, Math.max(min, Number(n) || min));

  const OPSI_AWAL = {
    template: 'standar', ukuran: '50x30', kw: 60, kh: 35,
    komponen: { kode: true, dokumen: true, lokasi: true, siswa: true, logo: true, potong: true },
    kertas: 'a4', posisi: 1, salinan: 1,
  };

  const S = {
    pilihan: new Map(),          // id => data arsip (bertahan antar halaman)
    opsi: JSON.parse(JSON.stringify(OPSI_AWAL)),
    mode: 'tunggal', zoom: 1, idx: 0, grid: false, dicatat: false,
  };

  const CONTOH = {
    id: 0, kode: 'ARS-2026-0001', jenis: 'Kartu Keluarga (KK)', nama: 'Ahmad Fauzan', nis: '2026001',
    lokasi: 'Ruang TU • L-01 • R-01 • M-001', qr: location.origin + '/arsip-fisik?q=ARS-2026-0001',
  };

  let timerToast;
  function toast(pesan) {
    const t = $('#toast');
    t.textContent = pesan;
    t.classList.add('show');
    clearTimeout(timerToast);
    timerToast = setTimeout(() => t.classList.remove('show'), 4200);
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

  /* ---------- 3. PILIHAN ARSIP ------------------------------------------- */
  const daftarPilihan = () => Array.from(S.pilihan.values());

  function simpanPilihan() {
    try { sessionStorage.setItem(C.kunci.pilihan, JSON.stringify(daftarPilihan())); } catch (e) { /* abaikan */ }
  }

  function muatPilihan() {
    try {
      (JSON.parse(sessionStorage.getItem(C.kunci.pilihan) || '[]') || []).forEach((d) => S.pilihan.set(String(d.id), d));
    } catch (e) { /* abaikan */ }
  }

  function perbaruiPilihan() {
    const n = S.pilihan.size;
    $('#barPilih').hidden = n === 0;
    ['#jmlPilih', '#jmlPilihTeks', '#jmlPilih2'].forEach((s) => { $(s).textContent = n; });

    const baris = $$('.pil');
    baris.forEach((c) => {
      const ada = S.pilihan.has(c.value);
      c.checked = ada;
      c.closest('tr').classList.toggle('sel', ada);
    });
    const semua = $('#semua');
    if (semua) {
      const dipilih = baris.filter((c) => c.checked).length;
      semua.checked = baris.length > 0 && dipilih === baris.length;
      semua.indeterminate = dipilih > 0 && dipilih < baris.length;
    }

    S.idx = Math.min(S.idx, Math.max(0, n - 1));
    simpanPilihan();
    renderPratinjau();
  }

  function ubahPilihan(id, aktif) {
    const d = C.data[id];
    if (!d) return;
    if (aktif) S.pilihan.set(String(id), d); else S.pilihan.delete(String(id));
  }

  function aktifkanTabel() {
    muatPilihan();

    $$('.pil').forEach((c) => c.addEventListener('change', () => { ubahPilihan(c.value, c.checked); perbaruiPilihan(); }));
    $$('#tabelArsip tbody tr[data-id]').forEach((tr) => tr.addEventListener('click', (e) => {
      if (e.target.closest('input,a,button')) return;
      const c = $('.pil', tr);
      ubahPilihan(c.value, !c.checked);
      perbaruiPilihan();
    }));

    const pilihHalaman = (aktif) => { $$('.pil').forEach((c) => ubahPilihan(c.value, aktif)); perbaruiPilihan(); };
    const semua = $('#semua');
    if (semua) semua.addEventListener('change', () => pilihHalaman(semua.checked));
    $('#btnSemuaHal').addEventListener('click', () => pilihHalaman(true));
    $('#btnBatal').addEventListener('click', () => { S.pilihan.clear(); perbaruiPilihan(); toast('Pilihan dibatalkan.'); });
  }

  /* ---------- 4. PENGATURAN LABEL ---------------------------------------- */
  function simpanOpsi() {
    try { localStorage.setItem(C.kunci.opsi, JSON.stringify(S.opsi)); } catch (e) { /* abaikan */ }
  }

  function muatOpsi() {
    try {
      const o = JSON.parse(localStorage.getItem(C.kunci.opsi) || 'null');
      if (o) S.opsi = Object.assign({}, OPSI_AWAL, o, { komponen: Object.assign({}, OPSI_AWAL.komponen, o.komponen) });
    } catch (e) { /* abaikan */ }
  }

  /** Ukuran stiker dalam mm. */
  function ukuranMM() {
    const o = S.opsi;
    if (o.ukuran === 'kustom') return { w: batas(o.kw, 25, 190), h: batas(o.kh, 15, 120) };
    const [w, h] = o.ukuran.split('x').map(Number);
    return { w, h };
  }

  /** Ukuran yang dikirim ke server (contoh 50x30). */
  const kunciUkuran = () => { const { w, h } = ukuranMM(); return S.opsi.ukuran === 'kustom' ? w + 'x' + h : S.opsi.ukuran; };

  /** Jumlah kolom, baris, dan stiker per lembar A4. */
  function tataLetak() {
    const { w, h } = ukuranMM(), { lebar, tinggi, margin, jarak } = KERTAS;
    const kolom = Math.max(1, Math.floor((lebar - margin * 2 + jarak) / (w + jarak)));
    const baris = Math.max(1, Math.floor((tinggi - margin * 2 + jarak) / (h + jarak)));
    return { kolom, baris, per: kolom * baris };
  }

  function isiPilihanPosisi() {
    const { per } = tataLetak(), sel = $('#fmtPosisi');
    S.opsi.posisi = batas(S.opsi.posisi, 1, per);
    sel.innerHTML = Array.from({ length: per }, (_, i) =>
      '<option value="' + (i + 1) + '"' + (i + 1 === S.opsi.posisi ? ' selected' : '') + '>Posisi ' + (i + 1) + (i === 0 ? ' (Lembar Baru)' : '') + '</option>').join('');
    $('#lblTabA4').textContent = 'Pratinjau Lembar A4 (Grid ' + tataLetak().kolom + '×' + tataLetak().baris + ')';
  }

  function terapkanOpsiKeUI() {
    const o = S.opsi;
    $('input[name=template][value="' + o.template + '"]').checked = true;
    $('input[name=ukuran][value="' + o.ukuran + '"]').checked = true;
    $('#kustom').classList.toggle('on', o.ukuran === 'kustom');
    $('#kusW').value = o.kw; $('#kusH').value = o.kh;
    $$('input[name=komponen]').forEach((c) => { c.checked = !!o.komponen[c.value]; });
    $('#fmtKertas').value = o.kertas;
    $('#fmtSalinan').value = o.salinan;
    $('#boxPosisi').hidden = o.kertas === 'roll';
    isiPilihanPosisi();
  }

  function aktifkanPengaturan() {
    const ubah = () => { simpanOpsi(); isiPilihanPosisi(); renderPratinjau(); };

    $$('input[name=template]').forEach((r) => r.addEventListener('change', () => { S.opsi.template = r.value; ubah(); }));
    $$('input[name=ukuran]').forEach((r) => r.addEventListener('change', () => {
      S.opsi.ukuran = r.value;
      $('#kustom').classList.toggle('on', r.value === 'kustom');
      ubah();
    }));
    $('#kusW').addEventListener('input', (e) => { S.opsi.kw = batas(e.target.value, 25, 190); ubah(); });
    $('#kusH').addEventListener('input', (e) => { S.opsi.kh = batas(e.target.value, 15, 120); ubah(); });
    $$('input[name=komponen]').forEach((c) => c.addEventListener('change', () => { S.opsi.komponen[c.value] = c.checked; ubah(); }));

    $('#fmtKertas').addEventListener('change', (e) => { S.opsi.kertas = e.target.value; $('#boxPosisi').hidden = e.target.value === 'roll'; ubah(); });
    $('#fmtPosisi').addEventListener('change', (e) => { S.opsi.posisi = Number(e.target.value); simpanOpsi(); renderPratinjau(); });
    $('#fmtSalinan').addEventListener('input', (e) => { S.opsi.salinan = batas(e.target.value, 1, 20); simpanOpsi(); renderPratinjau(); });

    $('#btnGrid').addEventListener('click', () => {
      S.grid = !S.grid;
      $('#btnGrid').lastChild.textContent = S.grid ? 'Sembunyikan Grid Kosong' : 'Format Grid Penuh';
      setMode('a4');
    });
  }

  /* ---------- 5. PEMBUAT LABEL ------------------------------------------- */
  function buatQR(el, teks) {
    el.innerHTML = '';
    if (window.QRCode) new QRCode(el, { text: teks, width: 220, height: 220, correctLevel: QRCode.CorrectLevel.M });
    else el.textContent = 'QR';
  }

  /** Isi HTML satu stiker sesuai template dan komponen yang dipilih. */
  function htmlLabel(item, o) {
    const k = o.komponen;
    const kepala = (k.logo || o.template === 'kop')
      ? '<div class="hd">' + (k.logo ? '<img src="' + esc(C.logo) + '" alt="">' : '') +
        '<div><b>' + esc(C.sekolah) + '</b><small>SIADDS • ARSIP RESMI</small></div></div>' : '';
    const kode = k.kode    ? '<span class="kd">' + esc(item.kode) + '</span>' : '';
    const dok  = k.dokumen ? '<span class="dk">' + esc(item.jenis) + '</span>' : '';
    const sis  = k.siswa   ? '<span class="ln">' + esc(item.nama) + ' (NIS ' + esc(item.nis) + ')</span>' : '';
    const lok  = k.lokasi  ? '<span class="ln">' + esc(item.lokasi || 'Lokasi belum diatur') + '</span>' : '';
    const q    = '<div class="q"></div>';

    switch (o.template) {
      case 'vertikal': return kepala + q + '<div class="tx">' + kode + dok + sis + lok + '</div>';
      case 'kop':      return kepala + '<div class="row">' + q + '<div class="tx">' + kode + dok + sis + lok + '</div></div>';
      case 'map':      return q + '<div class="tx">' + kode + dok + lok + '</div>';
      default:         return q + '<div class="tx">' + kepala + kode + dok + sis + lok + '</div>';
    }
  }

  /** Buat satu elemen stiker (atau kotak kosong sebagai penanda posisi). */
  function elemenLabel(item, o, kosong) {
    const { w, h } = ukuranMM();
    const el = document.createElement('div');
    el.className = 'lb t-' + o.template + (o.komponen.potong ? ' cut' : '') + (kosong ? ' kosong' : '');
    el.style.setProperty('--w', w);
    el.style.setProperty('--h', h);
    if (!kosong) {
      el.innerHTML = htmlLabel(item, o);
      buatQR($('.q', el), item.qr);
    }
    return el;
  }

  /** Bangun satu lembar A4 berisi daftar stiker (null = posisi kosong). */
  function elemenLembar(daftar, penuhSampai) {
    const { w } = ukuranMM(), { kolom } = tataLetak();
    const lembar = document.createElement('div');
    lembar.className = 'lembar' + (S.grid ? ' penuh' : '');
    lembar.style.gridTemplateColumns = 'repeat(' + kolom + ', ' + w + 'mm)';
    lembar.style.gap = KERTAS.jarak + 'mm';

    daftar.forEach((it) => lembar.appendChild(elemenLabel(it, S.opsi, it === null)));
    for (let i = daftar.length; i < (penuhSampai || 0); i++) lembar.appendChild(elemenLabel(null, S.opsi, true));
    return lembar;
  }

  /** Urutan stiker yang akan dicetak: tiap arsip diulang sesuai "salinan". */
  function urutanCetak(daftar) {
    const hasil = [];
    daftar.forEach((d) => { for (let i = 0; i < S.opsi.salinan; i++) hasil.push(d); });
    return hasil;
  }

  /** Bagi urutan stiker menjadi halaman-halaman A4 (memperhitungkan posisi awal). */
  function bagiHalaman(urutan) {
    const { per } = tataLetak();
    const halaman = [];
    let sisa = urutan.slice();
    let awal = Array(S.opsi.posisi - 1).fill(null);

    while (sisa.length || awal.length) {
      const muat = Math.max(0, per - awal.length);
      halaman.push(awal.concat(sisa.slice(0, muat)));
      sisa = sisa.slice(muat);
      awal = [];
    }
    return halaman;
  }

  /* ---------- 6. PRATINJAU (TUNGGAL / A4) -------------------------------- */
  function setMode(mode) {
    S.mode = mode;
    $$('.vt button').forEach((b) => b.classList.toggle('on', b.dataset.mode === mode));
    renderPratinjau();
  }

  function renderPratinjau() {
    const stage = $('#stage'), daftar = daftarPilihan();
    const contoh = daftar.length === 0;
    const item = contoh ? CONTOH : daftar[Math.min(S.idx, daftar.length - 1)];
    const { w, h } = ukuranMM();

    stage.classList.toggle('a4', S.mode === 'a4');
    $('#zmTeks').textContent = Math.round(S.zoom * 100) + '%';

    if (S.mode === 'tunggal') {
      const skala = (260 / (w * PX_MM)) * S.zoom;
      const kotak = document.createElement('div');
      kotak.className = 'wrap-lb swaplb';
      kotak.style.width = (w * PX_MM * skala) + 'px';
      kotak.style.height = (h * PX_MM * skala) + 'px';
      kotak.style.boxShadow = '0 10px 30px rgba(11,31,58,.22)';
      const lb = elemenLabel(item, S.opsi, false);
      lb.style.transformOrigin = 'top left';
      lb.style.transform = 'scale(' + skala + ')';
      kotak.appendChild(lb);

      stage.innerHTML = '<span class="badge">' + w + ' × ' + h + ' MM CUT-AREA</span>';
      stage.appendChild(kotak);
    } else {
      const urutan = contoh ? [CONTOH] : urutanCetak(daftar);
      const halaman = bagiHalaman(urutan);
      const lembar = elemenLembar(halaman[0], S.grid ? tataLetak().per : 0);
      const skala = Math.max(0.2, ((stage.clientWidth || 340) - 28) / (KERTAS.lebar * PX_MM)) * Math.min(S.zoom, 1.4);
      const kotak = document.createElement('div');
      kotak.className = 'wrap-lb swaplb';
      kotak.style.width = (KERTAS.lebar * PX_MM * skala) + 'px';
      kotak.style.height = (KERTAS.tinggi * PX_MM * skala) + 'px';
      lembar.style.transformOrigin = 'top left';
      lembar.style.transform = 'scale(' + skala + ')';
      kotak.appendChild(lembar);

      stage.innerHTML = '';
      stage.appendChild(kotak);
      $('#navTeks').textContent = contoh
        ? 'Pratinjau contoh • pilih arsip untuk data asli'
        : 'Lembar 1 dari ' + halaman.length + ' • ' + urutan.length + ' stiker';
    }

    if (S.mode === 'tunggal') {
      $('#navTeks').textContent = contoh
        ? 'Pratinjau contoh • pilih arsip untuk data asli'
        : 'Pratinjau label ' + (Math.min(S.idx, daftar.length - 1) + 1) + ' dari ' + daftar.length + ' arsip terseleksi';
    }
    $('#navPrev').disabled = contoh || S.mode !== 'tunggal' || S.idx <= 0;
    $('#navNext').disabled = contoh || S.mode !== 'tunggal' || S.idx >= daftar.length - 1;
  }

  function aktifkanPratinjau() {
    $$('.vt button').forEach((b) => b.addEventListener('click', () => setMode(b.dataset.mode)));
    $('#zmBesar').addEventListener('click', () => { S.zoom = Math.min(2, +(S.zoom + 0.1).toFixed(2)); renderPratinjau(); });
    $('#zmKecil').addEventListener('click', () => { S.zoom = Math.max(0.5, +(S.zoom - 0.1).toFixed(2)); renderPratinjau(); });
    $('#zmReset').addEventListener('click', () => { S.zoom = 1; renderPratinjau(); });
    $('#navPrev').addEventListener('click', () => { S.idx = Math.max(0, S.idx - 1); renderPratinjau(); });
    $('#navNext').addEventListener('click', () => { S.idx = Math.min(S.pilihan.size - 1, S.idx + 1); renderPratinjau(); });
    let t; window.addEventListener('resize', () => { clearTimeout(t); t = setTimeout(renderPratinjau, 200); });
  }

  /* ---------- 7. CETAK --------------------------------------------------- */
  function aturHalamanCetak(mode) {
    const { w, h } = ukuranMM();
    $('#stylePage').textContent = mode === 'roll'
      ? '@page{size:' + w + 'mm ' + h + 'mm;margin:0}#areaCetak .roll{width:' + w + 'mm;height:' + h + 'mm;overflow:hidden}'
      : '@page{size:A4;margin:0}';
  }

  function isiAreaCetak(daftar, mode) {
    const area = $('#areaCetak'), urutan = urutanCetak(daftar);
    area.innerHTML = '';

    if (mode === 'roll') {
      urutan.forEach((it) => {
        const bungkus = document.createElement('div');
        bungkus.className = 'roll';
        bungkus.appendChild(elemenLabel(it, S.opsi, false));
        area.appendChild(bungkus);
      });
    } else {
      bagiHalaman(urutan).forEach((hal) => area.appendChild(elemenLembar(hal, 0)));
    }
    return urutan.length;
  }

  /** mode: 'a4' atau 'roll' (jika kosong, mengikuti pilihan Format Lembar Kertas). */
  function cetak(modePaksa) {
    const daftar = daftarPilihan();
    if (!daftar.length) { toast('Pilih minimal satu arsip pada tabel terlebih dahulu.'); return; }

    const mode = modePaksa || S.opsi.kertas;
    const { w, h } = ukuranMM();
    if (mode === 'a4' && (w > KERTAS.lebar - KERTAS.margin * 2 || h > KERTAS.tinggi - KERTAS.margin * 2)) {
      toast('Ukuran stiker terlalu besar untuk kertas A4. Perkecil ukuran atau pilih format Printer label.');
      return;
    }

    aturHalamanCetak(mode);
    const jumlah = isiAreaCetak(daftar, mode);

    fetch(C.urls.cetak, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': C.csrf },
      body: JSON.stringify({ ids: daftar.map((d) => d.id), salinan: S.opsi.salinan, template: S.opsi.template, ukuran: kunciUkuran() }),
    })
      .then((r) => r.ok ? r.json() : Promise.reject())
      .then(() => {
        S.dicatat = true;
        document.body.classList.add('cetak-label');
        toast(jumlah + ' stiker dikirim ke dialog cetak.');
        setTimeout(() => window.print(), 400);
      })
      .catch(() => { $('#areaCetak').innerHTML = ''; toast('Gagal mencatat ke log audit, pencetakan dibatalkan. Coba lagi.'); });
  }

  window.addEventListener('afterprint', () => {
    document.body.classList.remove('cetak-label');
    if (S.dicatat) { S.dicatat = false; setTimeout(() => location.reload(), 300); }   // segarkan angka & riwayat
  });

  function aktifkanCetak() {
    $('#btnCetak').addEventListener('click', () => cetak());
    $('#btnCetakAtas').addEventListener('click', () => cetak('a4'));
    $('#btnPdf').addEventListener('click', () => { toast('Pada dialog cetak, pilih "Simpan sebagai PDF" sebagai printer.'); cetak('a4'); });
  }

  /* ---------- 8. BUAT QR / ANTREAN CETAK --------------------------------- */
  function kirimBuat(mode) {
    const daftar = daftarPilihan();
    if (!daftar.length) { toast('Pilih minimal satu arsip terlebih dahulu.'); return; }

    $('#fbIds').innerHTML = daftar.map((d) => '<input type="hidden" name="ids[]" value="' + esc(d.id) + '">').join('');
    $('#fbMode').value = mode;
    $('#fbTemplate').value = S.opsi.template;
    $('#fbUkuran').value = kunciUkuran();
    $('#formBuat').submit();
  }

  function aktifkanAksiBuat() {
    $('#btnBuat').addEventListener('click', () => kirimBuat('buat'));
    $('#btnAntrean').addEventListener('click', () => kirimBuat('antrean'));
  }

  /* ---------- 9. DIALOG & PINTASAN --------------------------------------- */
  function aktifkanDialog() {
    $('#btnPanduan').addEventListener('click', () => $('#dlgPanduan').showModal());
    $$('dialog').forEach((dlg) => dlg.addEventListener('click', (e) => {
      if (e.target === dlg || e.target.closest('[data-tutup]')) dlg.close();
    }));

    document.addEventListener('keydown', (e) => {
      if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
        e.preventDefault();
        const k = $('#cariTabel'); k.focus(); k.select();
      }
    });

    const dd = $('#ddAudit');
    document.addEventListener('click', (e) => { if (dd.open && !dd.contains(e.target)) dd.open = false; });
  }

  /* ---------- 10. MULAI -------------------------------------------------- */
  function mulai() {
    muatOpsi();
    terapkanOpsiKeUI();

    animasiMasuk();
    aktifkanTabel();
    aktifkanPengaturan();
    aktifkanPratinjau();
    aktifkanCetak();
    aktifkanAksiBuat();
    aktifkanDialog();

    perbaruiPilihan();      // menyegarkan tabel, bar pilihan, dan pratinjau pertama
  }

  // Tunggu pustaka QR (defer) selesai dimuat sebelum membuat kode QR pertama
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', mulai);
  else mulai();
})();
</script>