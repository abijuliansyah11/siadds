{{-- Tambahan halaman Lokasi Arsip Fisik: hanya menambah, tidak mengubah skrip/tampilan yang sudah ada. --}}
<script>
(function () {
  'use strict';
  var C = window.ARSIPFISIK || {};
  var URL_UPLOAD = @json(route('upload.dokumen'));
  var URL_LABEL  = @json(route('label.qr'));
  /* Rute koreksi: bila belum dipasang di web.php, fitur koreksi menampilkan petunjuk (halaman tidak error) */
  var URL_KOREKSI = @json(\Illuminate\Support\Facades\Route::has('arsip.fisik.koreksi') ? route('arsip.fisik.koreksi', 0) : null);
  var OPSI_ANGKATAN = @json(isset($opsiAngkatan) ? $opsiAngkatan->values()->all() : []);
  var OPSI_KELAS    = @json(isset($opsiKelas) ? $opsiKelas->values()->all() : []);
  var OPSI_JENIS    = @json(array_keys(\App\Http\Controllers\ArsipFisikController::DOKUMEN));
  var OPSI_JENIS_AL = @json(array_keys(\App\Http\Controllers\ArsipFisikController::DOKUMEN_ALUMNI));

  /* 1. Perbaiki teks ganda "Lemari Lemari ..." dan "Rak Rak ..." (kode di database sudah memuat awalan) */
  var POLA = /\b(Lemari|Rak)\s+\1\b/gi;
  function rapikan(akar) {
    var w = document.createTreeWalker(akar, NodeFilter.SHOW_TEXT, {
      acceptNode: function (n) {
        var p = n.parentNode && n.parentNode.nodeName;
        return (p === 'SCRIPT' || p === 'STYLE') ? NodeFilter.FILTER_REJECT : NodeFilter.FILTER_ACCEPT;
      }
    });
    var daftar = [], n;
    while ((n = w.nextNode())) { POLA.lastIndex = 0; if (POLA.test(n.nodeValue)) daftar.push(n); }
    daftar.forEach(function (t) { t.nodeValue = t.nodeValue.replace(POLA, '$1'); });
  }

  /* 2. Tautan tambahan pada panel detail: Upload Dokumen & Cetak Label QR */
  function tambahTautan() {
    var panel = document.getElementById('panelDetail');
    if (!panel) return;
    var wadah = panel.querySelector('.plinks');
    var kodeEl = panel.querySelector('.kode');
    if (!wadah || !kodeEl || wadah.getAttribute('data-tambah')) return;
    var kode = kodeEl.textContent.trim(), d = null;
    Object.keys(C.detail || {}).forEach(function (k) { if (C.detail[k].kode === kode) d = C.detail[k]; });
    wadah.setAttribute('data-tambah', '1');
    var panah = '<svg class="i"><use href="#arrow"/></svg>';
    var html = '';
    if (d && d.alumni) {
      html += '<a href="' + esk(d.alumni.url) + '">Buka Data Alumni' + panah + '</a>';
    }
    if (d && d.siswa && d.siswa.id) {
      html += '<a href="' + URL_UPLOAD + '?siswa=' + encodeURIComponent(d.siswa.id) + '&jenis=' + encodeURIComponent(d.jenis) + '#unggah">Unggah / Ganti Berkas Digital' + panah + '</a>';
    }
    html += '<a href="' + URL_LABEL + '">Buka Halaman Cetak Label QR Code' + panah + '</a>';
    wadah.insertAdjacentHTML('beforeend', html);
  }


  /* 2b. Panel: istilah disesuaikan menjadi Arsip, Angkatan, Kelas, Jenis Dokumen */
  function esk(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (m) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]; }); }
  function sesuaikanPanel() {
    var panel = document.getElementById('panelDetail');
    var kodeEl = panel && panel.querySelector('.kode'), ul = panel && panel.querySelector('ul.addr');
    if (!ul || !kodeEl || ul.getAttribute('data-sesuai')) return;
    var kode = kodeEl.textContent.trim(), d = null;
    Object.keys(C.detail || {}).forEach(function (k) { if (C.detail[k].kode === kode) d = C.detail[k]; });
    if (!d) return;
    ul.setAttribute('data-sesuai', '1');
    var L = d.lokasi, s = d.siswa || {};
    var baris = function (ikon, label, isi, kecil, f) {
      return '<li class="kor" data-f="' + f + '" title="Klik untuk mengoreksi data ini" tabindex="0"><svg class="i"><use href="#' + ikon + '"/></svg><span>' + label + '</span><b>' + esk(isi || '-') + ' <span style="color:#0f7a4f;font-weight:700">\u270E</span>' + (kecil ? '<small>' + esk(kecil) + '</small>' : '') + '</b></li>';
    };
    var lokasi = L ? [('Lemari ' + L.lemari), ('Rak ' + L.rak), d.map].filter(Boolean).join(' \u2022 ') : 'Lokasi belum ditentukan';
    Array.prototype.forEach.call(ul.children, function (li) { li.style.display = 'none'; li.setAttribute('data-lama', '1'); });
    ul.insertAdjacentHTML('afterbegin',
      baris('building', 'Arsip:', L ? L.ruang : 'Belum ditentukan', lokasi, 'krLemari') +
      baris('layers', 'Angkatan:', s.angkatan, '', 'krAngkatan') +
      baris('cabinet', 'Kelas:', s.kelas, '', 'krKelas') +
      baris('folder', 'Jenis Dokumen:', d.jenis, '', 'krJenis'));
  }

  function sesuaikanForm() {
    var f = document.getElementById('tab-pindah');
    if (!f || f.getAttribute('data-sesuai')) return;
    f.setAttribute('data-sesuai', '1');
    Array.prototype.forEach.call(f.querySelectorAll('label'), function (l) {
      var t = l.firstChild; if (!t || t.nodeType !== 3) return;
      var v = t.nodeValue.trim();
      if (v === 'Target Ruang & Lemari Baru') t.nodeValue = 'Arsip Tujuan';
      else if (v === 'Rak Baru') t.nodeValue = 'Rak Tujuan';
    });
  }

  /* 2c. Dialog koreksi: klik baris Arsip / Angkatan / Kelas / Jenis Dokumen pada panel */
  (function () {
    var css = document.createElement('style');
    css.textContent = '.addr li.kor{cursor:pointer;transition:background .2s}.addr li.kor:hover,.addr li.kor:focus-visible{background:#ecfaf3;outline:1px solid rgba(15,122,79,.35)}';
    document.head.appendChild(css);
  })();

  function detailAktif() {
    var panel = document.getElementById('panelDetail'), k = panel && panel.querySelector('.kode'), d = null;
    if (k) Object.keys(C.detail || {}).forEach(function (x) { if (C.detail[x].kode === k.textContent.trim()) d = C.detail[x]; });
    return d;
  }
  function opsi(daftar, pilih, kosong) {
    var h = kosong ? '<option value="">' + esk(kosong) + '</option>' : '', ada = false;
    daftar.forEach(function (v) { var s = String(v) === String(pilih); if (s) ada = true; h += '<option value="' + esk(v) + '"' + (s ? ' selected' : '') + '>' + esk(v) + '</option>'; });
    if (pilih && !ada) h += '<option value="' + esk(pilih) + '" selected>' + esk(pilih) + '</option>';
    return h;
  }
  function isiRakKoreksi(lemariId, rakId) {
    var l = (C.lokasi || []).filter(function (x) { return String(x.id) === String(lemariId); })[0];
    var h = '<option value="">Tidak diubah / belum ditentukan</option>';
    if (l) h += l.raks.map(function (r) {
      return '<option value="' + r.id + '"' + (String(r.id) === String(rakId) ? ' selected' : '') + (r.sisa < 1 && String(r.id) !== String(rakId) ? ' disabled' : '') + '>' + esk(r.kode) + ' (sisa ' + r.sisa + ')</option>';
    }).join('');
    document.getElementById('krRak').innerHTML = h;
  }
  function dialogKoreksi() {
    var dlg = document.getElementById('dlgKoreksi');
    if (dlg) return dlg;
    dlg = document.createElement('dialog'); dlg.id = 'dlgKoreksi';
    dlg.innerHTML = '<form method="POST" id="formKoreksi"><input type="hidden" name="_token" value="' + esk(C.csrf) + '">' +
      '<h3>Koreksi Alamat Arsip</h3><p>Perbaiki data bila ada yang salah. Perubahan tercatat pada riwayat aktivitas. Angkatan dan kelas ikut memperbarui data siswa.</p>' +
      '<div class="two"><div class="fld"><label for="krLemari">Arsip</label><select id="krLemari"></select></div>' +
      '<div class="fld"><label for="krRak">Rak</label><select name="arsip_rak_id" id="krRak"></select></div></div>' +
      '<div class="fld"><label for="krMap">Kode Map</label><input type="text" name="kode_map" id="krMap" maxlength="30" placeholder="M-001"></div>' +
      '<div class="two"><div class="fld"><label for="krAngkatan">Angkatan</label><select name="angkatan" id="krAngkatan"></select></div>' +
      '<div class="fld"><label for="krKelas">Kelas</label><select name="kelas" id="krKelas"></select></div></div>' +
      '<div class="fld"><label for="krJenis">Jenis Dokumen</label><select name="jenis" id="krJenis"></select></div>' +
      '<div class="end"><button type="button" class="btn" data-x>Batal</button><button type="submit" class="btn g">Simpan Koreksi</button></div></form>';
    document.body.appendChild(dlg);
    dlg.addEventListener('click', function (e) { if (e.target === dlg || e.target.closest('[data-x]')) dlg.close(); });
    document.getElementById('krLemari').addEventListener('change', function () { isiRakKoreksi(this.value, null); });
    return dlg;
  }
  function bukaKoreksi(fokus) {
    var t = document.getElementById('toast');
    if (!URL_KOREKSI) {
      if (t) { t.textContent = 'Fitur koreksi belum aktif: tambahkan rute arsip.fisik.koreksi di routes/web.php.'; t.classList.add('err', 'show'); setTimeout(function () { t.classList.remove('show'); }, 6000); }
      return;
    }
    var d = detailAktif(); if (!d) return;
    var dlg = dialogKoreksi(), L = d.lokasi, s = d.siswa || {};
    document.getElementById('formKoreksi').action = URL_KOREKSI.replace('/0/', '/' + d.id + '/');
    var lem = '<option value="">Belum ditentukan</option>' + (C.lokasi || []).map(function (x) {
      return '<option value="' + x.id + '"' + (L && String(x.id) === String(L.lemariId) ? ' selected' : '') + '>' + esk(x.label) + '</option>'; }).join('');
    document.getElementById('krLemari').innerHTML = lem;
    isiRakKoreksi(L ? L.lemariId : null, L ? L.rakId : null);
    document.getElementById('krMap').value = d.map || '';
    var thn = new Date().getFullYear(), rentang = []; for (var y = thn + 1; y >= thn - 8; y--) rentang.push(String(y));
    var ang = OPSI_ANGKATAN.map(String); rentang.forEach(function (y) { if (ang.indexOf(y) < 0) ang.push(y); }); ang.sort().reverse();
    document.getElementById('krAngkatan').innerHTML = opsi(ang, s.angkatan, '');
    document.getElementById('krKelas').innerHTML = opsi(OPSI_KELAS, s.kelas, '');
    document.getElementById('krJenis').innerHTML = opsi(d.alumni ? OPSI_JENIS_AL : OPSI_JENIS, d.jenis, '');
    dlg.showModal();
    var f = document.getElementById(fokus); if (f) f.focus();
  }
  function pasangKoreksi() {
    var panel = document.getElementById('panelDetail'); if (!panel) return;
    panel.addEventListener('click', function (e) { var li = e.target.closest('li.kor'); if (li) bukaKoreksi(li.getAttribute('data-f')); });
    panel.addEventListener('keydown', function (e) { if (e.key === 'Enter') { var li = e.target.closest('li.kor'); if (li) bukaKoreksi(li.getAttribute('data-f')); } });
  }

  /* 3. Pesan sukses/galat dari server ditampilkan sebagai toast (terlihat walau halaman sedang di bawah) */
  function toastFlash() {
    var f = document.querySelector('.flash'), t = document.getElementById('toast');
    if (!f || !t) return;
    t.textContent = f.textContent.trim();
    t.classList.toggle('err', f.classList.contains('err'));
    t.classList.add('show');
    setTimeout(function () { t.classList.remove('show'); }, 5000);
  }

  function mulai() {
    rapikan(document.body);
    pasangKoreksi();
    tambahTautan(); sesuaikanPanel(); sesuaikanForm();
    var tunda;
    new MutationObserver(function () {
      clearTimeout(tunda);
      tunda = setTimeout(function () { rapikan(document.body); tambahTautan(); sesuaikanPanel(); sesuaikanForm(); }, 30);
    }).observe(document.body, { childList: true, subtree: true });
    toastFlash();
  }
  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', mulai); else mulai();
})();
</script>