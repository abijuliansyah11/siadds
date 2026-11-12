{{-- Fitur Cetak SKL pada halaman Cetak Label QR Code.
     Hanya MENAMBAH: kartu SKL disisipkan sebelum bagian Riwayat lewat JavaScript. Skrip & tampilan lama tidak diubah. --}}
<style>
.skl-card{margin:20px 0;padding:22px;background:var(--card,#fff);border:1px solid var(--line,#dbe2ea);border-radius:18px;box-shadow:0 10px 30px rgba(11,31,58,.06);scroll-margin-top:16px}
.skl-top{display:flex;flex-wrap:wrap;justify-content:space-between;align-items:flex-start;gap:12px}
.skl-top h2{margin:0;font-size:18px;color:var(--navy,#0b1f3a)}
.skl-top p{margin:4px 0 0;max-width:640px;color:var(--mu,#5b6b7e);font-size:13px;line-height:1.55}
.skl-btn{display:inline-flex;align-items:center;gap:6px;border:1px solid var(--line,#dbe2ea);background:#fff;color:var(--navy,#0b1f3a);border-radius:11px;padding:9px 14px;font:700 12.5px Inter,system-ui,sans-serif;cursor:pointer;text-decoration:none;transition:transform .2s,box-shadow .2s,background .2s}
.skl-btn:hover{transform:translateY(-1px);box-shadow:0 6px 16px rgba(11,31,58,.12)}
.skl-btn.g{background:var(--green,#0f7a4f);border-color:var(--green,#0f7a4f);color:#fff}
.skl-btn.n{background:var(--navy,#0b1f3a);border-color:var(--navy,#0b1f3a);color:#fff}
.skl-btn[disabled],.skl-btn.off{opacity:.45;pointer-events:none}
.skl-btn.sm{padding:6px 10px;font-size:11.5px;border-radius:9px}
.skl-kpi{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin:16px 0 14px}
.skl-kpi div{padding:12px 14px;border-radius:13px;background:#f4f7fb;border:1px solid var(--line,#dbe2ea)}
.skl-kpi small{display:block;font-size:10.5px;letter-spacing:.06em;color:var(--mu,#5b6b7e);font-weight:700}
.skl-kpi b{font-size:22px;color:var(--navy,#0b1f3a)}
.skl-bar{display:flex;flex-wrap:wrap;gap:10px;align-items:center;margin-bottom:12px}
.skl-bar input,.skl-bar select,.skl-dlg input,.skl-dlg select{border:1px solid var(--line,#dbe2ea);border-radius:10px;padding:9px 11px;font:500 13px Inter,system-ui,sans-serif;background:#fff;color:inherit;min-width:0}
.skl-bar input[type=search]{flex:1;min-width:200px}
.skl-bar input:focus,.skl-bar select:focus,.skl-dlg input:focus,.skl-dlg select:focus{outline:2px solid rgba(15,122,79,.35);border-color:var(--green,#0f7a4f)}
.skl-wrap{overflow-x:auto;border:1px solid var(--line,#dbe2ea);border-radius:13px}
table.skl-t{width:100%;border-collapse:collapse;font-size:13px}
.skl-t th{background:#f4f7fb;color:var(--mu,#5b6b7e);font-size:10.5px;letter-spacing:.06em;text-align:left;padding:10px 12px;white-space:nowrap}
.skl-t td{padding:10px 12px;border-top:1px solid var(--line,#dbe2ea);vertical-align:middle}
.skl-t tbody tr{animation:sklIn .45s cubic-bezier(.2,.8,.2,1) backwards}
.skl-t tbody tr:hover{background:#f8fbff}
@keyframes sklIn{from{opacity:0;transform:translateY(8px)}}
.skl-t td small{display:block;color:var(--mu,#5b6b7e);font-size:11.5px;margin-top:2px}
.skl-t td.ak{white-space:nowrap;text-align:right}
.skl-pill{display:inline-block;border-radius:999px;padding:3px 10px;font-size:11px;font-weight:700;margin:1px 2px 1px 0}
.skl-pill.ok{background:#d9f5e8;color:#0a6a43}.skl-pill.warn{background:#fff1cf;color:#8a5a00}.skl-pill.mu{background:#e8edf3;color:#445468}
.skl-empty{padding:26px;text-align:center;color:var(--mu,#5b6b7e)}
.skl-pg{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-top:12px;font-size:12.5px;color:var(--mu,#5b6b7e)}
.skl-pg div{display:flex;gap:6px}
.skl-msg{margin:10px 0 0;padding:10px 14px;border-radius:11px;background:#fff1cf;color:#6b4500;font-size:13px}

dialog.skl-dlg{border:0;border-radius:20px;padding:0;width:min(900px,94vw);max-height:92vh;box-shadow:0 30px 80px rgba(11,31,58,.35);color:var(--tx,#1c2733)}
dialog.skl-dlg::backdrop{background:rgba(11,31,58,.55);backdrop-filter:blur(2px)}
dialog.skl-dlg[open]{animation:sklPop .35s cubic-bezier(.2,.8,.2,1)}
@keyframes sklPop{from{opacity:0;transform:translateY(16px) scale(.98)}}
.skl-dlg form{display:flex;flex-direction:column;max-height:92vh}
.skl-dh{padding:18px 22px;border-bottom:1px solid var(--line,#dbe2ea)}
.skl-dh h3{margin:0;font-size:17px;color:var(--navy,#0b1f3a)}.skl-dh p{margin:4px 0 0;font-size:12.5px;color:var(--mu,#5b6b7e)}
.skl-db{padding:18px 22px;overflow:auto}
.skl-df{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;padding:14px 22px;border-top:1px solid var(--line,#dbe2ea);background:#f8fafc}
.skl-df div{display:flex;gap:8px;flex-wrap:wrap}
.skl-g{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.skl-g label,.skl-m label{display:flex;flex-direction:column;gap:5px;font-size:12px;font-weight:700;color:var(--mu,#5b6b7e)}
.skl-g label span.h{font-weight:500;font-size:11px}
.skl-g .full{grid-column:1/-1}
.skl-note{margin:0 0 12px;padding:9px 13px;border-radius:11px;background:#e7f1ff;color:#17407a;font-size:12.5px}
.skl-sub{display:flex;justify-content:space-between;align-items:center;gap:8px;flex-wrap:wrap;margin:18px 0 8px}
.skl-sub h4{margin:0;font-size:13px;color:var(--navy,#0b1f3a)}
table.skl-mp{width:100%;border-collapse:collapse}
.skl-mp th{font-size:10.5px;letter-spacing:.06em;color:var(--mu,#5b6b7e);text-align:left;padding:4px 6px}
.skl-mp td{padding:3px 4px}
.skl-mp input,.skl-mp select{width:100%}
.skl-mp td.v{width:110px}.skl-mp td.k{width:84px}.skl-mp td.x{width:44px;text-align:center}
.skl-mp .del{border:0;background:#fde8e8;color:#b42318;border-radius:8px;width:30px;height:30px;cursor:pointer;font-size:16px;line-height:1}
.skl-avg{font-size:13px;color:var(--navy,#0b1f3a)}.skl-avg b{font-size:18px;color:var(--green,#0f7a4f)}
.skl-err{color:#b42318;font-size:12.5px;min-height:18px;font-weight:600}
.skl-toast{position:fixed;left:50%;bottom:26px;transform:translate(-50%,30px);opacity:0;z-index:99999;background:#0b1f3a;color:#fff;padding:11px 18px;border-radius:12px;font:600 13px Inter,system-ui,sans-serif;box-shadow:0 14px 34px rgba(0,0,0,.3);transition:.3s;pointer-events:none;max-width:90vw}
.skl-toast.on{opacity:1;transform:translate(-50%,0)}.skl-toast.bad{background:#b42318}
@media(max-width:760px){.skl-kpi{grid-template-columns:repeat(2,1fr)}.skl-g{grid-template-columns:1fr}.skl-t th:nth-child(3),.skl-t td:nth-child(3){display:none}}
@media print{.skl-card,dialog.skl-dlg,.skl-toast{display:none!important}}
</style>

<template id="sklTpl">
<section class="skl-card" id="skl">
  <div class="skl-top">
    <div>
      <h2>Surat Keterangan Lulus (SKL)</h2>
      <p>Cetak SKL untuk siswa yang baru lulus atau alumni yang memintanya. Lengkapi data lahir, orang tua, dan nilai sekali saja; setelah itu SKL dapat dicetak kapan pun dengan nomor, QR Code, dan tanda tangan kepala madrasah.</p>
    </div>
    <div style="display:flex;gap:8px;flex-wrap:wrap">
      <button type="button" class="skl-btn" id="sklSet">Pengaturan Kop &amp; Tanda Tangan</button>
      <button type="button" class="skl-btn g" id="sklMassal" disabled>Cetak SKL Terpilih (<span id="sklJml">0</span>)</button>
    </div>
  </div>

  <div class="skl-kpi">
    <div><small>TOTAL ALUMNI</small><b id="kTotal">0</b></div>
    <div><small>DATA SKL LENGKAP</small><b id="kLengkap">0</b></div>
    <div><small>PERLU DILENGKAPI</small><b id="kPerlu">0</b></div>
    <div><small>SUDAH DICETAK</small><b id="kCetak">0</b></div>
  </div>

  <div class="skl-bar">
    <input type="search" id="sklQ" placeholder="Cari nama, NIS, NISN, atau nomor SKL…" autocomplete="off">
    <select id="sklTahun"><option value="">Semua tahun lulus</option></select>
    <select id="sklStatus">
      <option value="">Semua status</option>
      <option value="belum">Belum dicetak</option>
      <option value="sudah">Sudah dicetak</option>
      <option value="lengkapi">Data belum lengkap</option>
    </select>
  </div>

  <div id="sklPesan"></div>
  <div class="skl-wrap">
    <table class="skl-t">
      <thead><tr><th style="width:36px"><input type="checkbox" id="sklAll" title="Pilih semua yang lengkap di halaman ini"></th><th>ALUMNI</th><th>LULUS · KELAS</th><th>NOMOR SKL</th><th>STATUS</th><th style="text-align:right">AKSI</th></tr></thead>
      <tbody id="sklBody"><tr><td colspan="6" class="skl-empty">Memuat data alumni…</td></tr></tbody>
    </table>
  </div>
  <div class="skl-pg"><span id="sklInfo"></span><div><button type="button" class="skl-btn sm" id="sklPrev">← Sebelumnya</button><button type="button" class="skl-btn sm" id="sklNext">Berikutnya →</button></div></div>
</section>
</template>

{{-- Dialog: data SKL satu alumni --}}
<dialog class="skl-dlg" id="sklDlg">
  <form id="sklForm" autocomplete="off">
    <div class="skl-dh"><h3 id="sklJudul">Data SKL</h3><p id="sklSub"></p></div>
    <div class="skl-db">
      <div class="skl-note" id="sklNote" hidden>Sebagian data diisi otomatis dari data siswa. Periksa lalu simpan.</div>
      <div class="skl-g">
        <label>Tempat lahir<input name="tempat_lahir" maxlength="60" required></label>
        <label>Tanggal lahir<input type="date" name="tanggal_lahir" required></label>
        <label>Nama orang tua / wali<input name="nama_orang_tua" maxlength="120" required></label>
        <label>Peminatan / jurusan<input name="jurusan" maxlength="80" list="sklJurusan" placeholder="mis. Ilmu Pengetahuan Alam (MIPA)"></label>
        <label>Nomor SKL<input name="nomor_skl" maxlength="60" placeholder="Kosongkan agar dibuat otomatis"><span class="h">Format nomor dapat diubah di Pengaturan.</span></label>
        <label>Tanggal rapat pleno kelulusan<input type="date" name="tanggal_kelulusan"></label>
      </div>
      <datalist id="sklJurusan"><option value="Ilmu Pengetahuan Alam (MIPA)"><option value="Ilmu Pengetahuan Sosial (IPS)"><option value="Keagamaan"></datalist>

      <div class="skl-sub">
        <h4>Nilai Ujian Madrasah per Mata Pelajaran</h4>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
          <button type="button" class="skl-btn sm" id="sklBawaan">Isi Mapel Bawaan</button>
          <button type="button" class="skl-btn sm" id="sklTambah">+ Tambah Mata Pelajaran</button>
        </div>
      </div>
      <table class="skl-mp">
        <thead><tr><th>KELOMPOK</th><th>MATA PELAJARAN</th><th>NILAI</th><th></th></tr></thead>
        <tbody id="sklMapel"></tbody>
      </table>
      <p class="skl-avg">Rata-rata: <b id="sklRata">-</b></p>
      <div class="skl-err" id="sklErr" role="alert"></div>
    </div>
    <div class="skl-df">
      <button type="button" class="skl-btn" data-skl-tutup>Batal</button>
      <div>
        <button type="submit" class="skl-btn n" id="sklSimpan">Simpan</button>
        <button type="button" class="skl-btn g" id="sklSimpanCetak">Simpan &amp; Cetak SKL</button>
      </div>
    </div>
  </form>
</dialog>

{{-- Dialog: pengaturan kop & penandatangan --}}
<dialog class="skl-dlg" id="sklSetDlg">
  <form id="sklSetForm" autocomplete="off">
    <div class="skl-dh"><h3>Pengaturan Kop &amp; Tanda Tangan SKL</h3><p>Berlaku untuk semua SKL yang dicetak. Kosongkan Kepala Madrasah bila ingin tanda tangan basah.</p></div>
    <div class="skl-db">
      <div class="skl-g">
        <label>Baris kop 1<input name="kop1" maxlength="120"></label>
        <label>Baris kop 2<input name="kop2" maxlength="120"></label>
        <label class="full">Nama madrasah<input name="madrasah" maxlength="120" required></label>
        <label class="full">Alamat<input name="alamat" maxlength="250"></label>
        <label>NPSN<input name="npsn" maxlength="20"></label>
        <label>Kurikulum<input name="kurikulum" maxlength="80" required></label>
        <label>Kepala madrasah<input name="kepala" maxlength="120" placeholder="Nama beserta gelar"></label>
        <label>NIP<input name="nip" maxlength="40"></label>
        <label>Kota penandatanganan<input name="kota" maxlength="60" required></label>
        <label>Format nomor SKL<input name="format_nomor" maxlength="80" required><span class="h">Gunakan {urut} dan {tahun}. Contoh: 421.3/{urut}/MAS-SH/Kep/{tahun}</span></label>
        <label>Logo kiri (Kemenag)<input name="logo_kiri" maxlength="250"><span class="h">Letakkan berkas di folder public, mis. images/logo-kemenag.png</span></label>
        <label>Logo kanan (madrasah)<input name="logo_kanan" maxlength="250"></label>
        <label class="full">Gambar tanda tangan + stempel (opsional)<input name="gambar_ttd" maxlength="250" placeholder="mis. images/ttd-kepala.png (PNG transparan)"></label>
      </div>
      <div class="skl-err" id="sklSetErr" role="alert"></div>
    </div>
    <div class="skl-df"><button type="button" class="skl-btn" data-skl-tutup>Batal</button><button type="submit" class="skl-btn n">Simpan Pengaturan</button></div>
  </form>
</dialog>

<div class="skl-toast" id="sklToast" role="status" aria-live="polite"></div>

<script>
(function () {
  'use strict';

  var U = {
    daftar: @json(route('label.skl.daftar')),
    detail: @json(route('label.skl.detail', ['id' => 0])),
    simpan: @json(route('label.skl.simpan', ['id' => 0])),
    pengaturan: @json(route('label.skl.pengaturan')),
    cetak: @json(route('label.skl.cetak'))
  };
  var metaCsrf = document.querySelector('meta[name="csrf-token"]');
  var CSRF = metaCsrf ? metaCsrf.getAttribute('content') : '';
  var Q = new URLSearchParams(location.search);

  var S = { page: 1, q: Q.get('skl_q') || '', tahun: Q.get('skl_tahun') || '', status: Q.get('skl_status') || '', pilih: {}, baris: [], set: null, last: 1, idAktif: 0 };

  function $(id) { return document.getElementById(id); }
  function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]; }); }
  function idUrl(base, id) { return base.replace(/\/0(\?.*)?$/, '/' + id); }

  var tt;
  function toast(t, bad) {
    var el = $('sklToast'); if (!el) return;
    el.textContent = t; el.className = 'skl-toast on' + (bad ? ' bad' : '');
    clearTimeout(tt); tt = setTimeout(function () { el.className = 'skl-toast' + (bad ? ' bad' : ''); }, 3600);
  }

  function api(url, o) {
    o = o || {};
    var h = { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': CSRF };
    if (o.json) { h['Content-Type'] = 'application/json'; o.body = JSON.stringify(o.json); delete o.json; }
    o.headers = h; o.credentials = 'same-origin';
    return fetch(url, o).then(function (r) {
      return r.json().catch(function () { return {}; }).then(function (d) {
        if (!r.ok) { d._status = r.status; throw d; }
        return d;
      });
    });
  }
  function pesanGalat(e) {
    if (e && e.errors) { var k = Object.keys(e.errors)[0]; if (k) return e.errors[k][0]; }
    return (e && e.message) ? e.message : 'Terjadi gangguan. Coba lagi.';
  }

  /* ---------- Sisipkan kartu SKL sebelum bagian Riwayat ---------- */
  var tpl = $('sklTpl');
  if (!tpl) return;
  var sec = tpl.content.firstElementChild.cloneNode(true);
  var riw = $('riwayat');
  if (riw && riw.parentNode) riw.parentNode.insertBefore(sec, riw);
  else (document.querySelector('.wrap') || document.body).appendChild(sec);

  /* Tombol pintas di header halaman */
  var hact = document.querySelector('.hact');
  if (hact) {
    var a = document.createElement('a');
    a.href = '#skl'; a.className = 'btn'; a.textContent = 'Cetak SKL';
    var tombolA4 = $('btnCetakAtas');
    hact.insertBefore(a, tombolA4 || null);
  }

  var tbody = sec.querySelector('#sklBody');

  /* ---------- Daftar ---------- */
  var timer;
  function muat() {
    var p = new URLSearchParams({ page: S.page });
    if (S.q) p.set('q', S.q); if (S.tahun) p.set('tahun', S.tahun); if (S.status) p.set('status', S.status);
    return api(U.daftar + '?' + p.toString()).then(function (d) {
      S.baris = d.data; S.last = d.meta.last; S.set = d.set;
      if (S.page > d.meta.last && d.meta.last >= 1) { S.page = d.meta.last; return muat(); }
      isiTahun(d.tahun);
      $('kTotal').textContent = d.ringkas.total; $('kLengkap').textContent = d.ringkas.lengkap;
      $('kPerlu').textContent = d.ringkas.perlu; $('kCetak').textContent = d.ringkas.tercetak;
      render(d.meta);
      $('sklPesan').innerHTML = '';
    }).catch(function (e) {
      tbody.innerHTML = '<tr><td colspan="6" class="skl-empty">Data SKL tidak dapat dimuat.</td></tr>';
      $('sklPesan').innerHTML = '<div class="skl-msg">' + esc(pesanGalat(e)) + '</div>';
    });
  }
  function isiTahun(list) {
    var s = $('sklTahun'); if (s.options.length > 1) return;
    list.forEach(function (t) { var o = document.createElement('option'); o.value = t; o.textContent = 'Lulus ' + t; s.appendChild(o); });
    s.value = S.tahun;
  }
  function render(meta) {
    if (!S.baris.length) {
      tbody.innerHTML = '<tr><td colspan="6" class="skl-empty">Tidak ada alumni yang cocok. Siswa yang diluluskan lewat <b>Data Alumni → Proses Kelulusan</b> akan muncul di sini.</td></tr>';
    } else {
      tbody.innerHTML = S.baris.map(function (r, i) {
        var cb = '<input type="checkbox" class="sklCb" value="' + r.id + '"' + (r.lengkap ? '' : ' disabled') + (S.pilih[r.id] ? ' checked' : '') + '>';
        var st = (r.lengkap ? '<span class="skl-pill ok">Data lengkap</span>' : '<span class="skl-pill warn">Perlu dilengkapi</span>') +
                 (r.dicetak ? '<span class="skl-pill mu" title="' + esc(r.terakhir || '') + '">Dicetak ' + r.dicetak + '×</span>' : '');
        var ak = '<button type="button" class="skl-btn sm" data-aksi="form" data-id="' + r.id + '">' + (r.lengkap ? 'Ubah Data' : 'Lengkapi Data') + '</button> ' +
          (r.lengkap ? '<a class="skl-btn sm" target="_blank" rel="noopener" href="' + U.cetak + '?ids=' + r.id + '">Pratinjau</a> <a class="skl-btn sm g" target="_blank" rel="noopener" href="' + U.cetak + '?ids=' + r.id + '&print=1">Cetak</a>' : '');
        return '<tr style="animation-delay:' + (i * 40) + 'ms"><td>' + cb + '</td><td><b>' + esc(r.nama) + '</b><small>NIS ' + esc(r.nis) + ' · NISN ' + esc(r.nisn) + '</small></td>' +
          '<td>' + esc(r.tahun) + '<small>' + esc(r.kelas) + (r.jurusan ? ' · ' + esc(r.jurusan) : '') + '</small></td>' +
          '<td>' + (r.nomor ? esc(r.nomor) : '<small>Dibuat otomatis saat data disimpan</small>') + '</td><td>' + st + '</td><td class="ak">' + ak + '</td></tr>';
      }).join('');
    }
    $('sklInfo').textContent = meta.total + ' alumni • halaman ' + meta.page + ' dari ' + meta.last;
    $('sklPrev').disabled = meta.page <= 1; $('sklNext').disabled = meta.page >= meta.last;
    hitungPilih();
  }
  function hitungPilih() {
    var n = Object.keys(S.pilih).filter(function (k) { return S.pilih[k]; }).length;
    $('sklJml').textContent = n; $('sklMassal').disabled = n === 0;
    var cbs = tbody.querySelectorAll('.sklCb:not(:disabled)');
    var semua = cbs.length > 0 && Array.prototype.every.call(cbs, function (c) { return c.checked; });
    $('sklAll').checked = semua;
  }

  tbody.addEventListener('change', function (e) {
    if (e.target.classList.contains('sklCb')) { S.pilih[e.target.value] = e.target.checked; hitungPilih(); }
  });
  $('sklAll').addEventListener('change', function (e) {
    Array.prototype.forEach.call(tbody.querySelectorAll('.sklCb:not(:disabled)'), function (c) { c.checked = e.target.checked; S.pilih[c.value] = e.target.checked; });
    hitungPilih();
  });
  tbody.addEventListener('click', function (e) {
    var b = e.target.closest('[data-aksi="form"]'); if (b) bukaForm(parseInt(b.getAttribute('data-id'), 10));
  });
  $('sklMassal').addEventListener('click', function () {
    var ids = Object.keys(S.pilih).filter(function (k) { return S.pilih[k]; });
    if (ids.length) window.open(U.cetak + '?ids=' + ids.join(',') + '&print=1', '_blank');
  });
  $('sklQ').value = S.q;
  $('sklQ').addEventListener('input', function (e) { clearTimeout(timer); timer = setTimeout(function () { S.q = e.target.value.trim(); S.page = 1; muat(); }, 300); });
  $('sklTahun').addEventListener('change', function (e) { S.tahun = e.target.value; S.page = 1; muat(); });
  $('sklStatus').value = S.status;
  $('sklStatus').addEventListener('change', function (e) { S.status = e.target.value; S.page = 1; muat(); });
  $('sklPrev').addEventListener('click', function () { if (S.page > 1) { S.page--; muat(); } });
  $('sklNext').addEventListener('click', function () { if (S.page < S.last) { S.page++; muat(); } });

  /* ---------- Dialog data SKL ---------- */
  var dlg = $('sklDlg'), form = $('sklForm'), mapelBody = $('sklMapel'), BAWAAN = {};

  function barisMapel(m) {
    var tr = document.createElement('tr');
    tr.innerHTML = '<td class="k"><select>' + ['A', 'B', 'C', 'D'].map(function (k) { return '<option' + (m.k === k ? ' selected' : '') + '>' + k + '</option>'; }).join('') + '</select></td>' +
      '<td><input class="n" maxlength="100" placeholder="Nama mata pelajaran"></td>' +
      '<td class="v"><input class="v" type="number" step="0.01" min="0" max="100" inputmode="decimal" placeholder="0–100"></td>' +
      '<td class="x"><button type="button" class="del" title="Hapus baris">×</button></td>';
    tr.querySelector('input.n').value = m.n || '';
    tr.querySelector('input.v').value = (m.v === '' || m.v == null) ? '' : m.v;
    return tr;
  }
  function isiMapel(list) { mapelBody.innerHTML = ''; list.forEach(function (m) { mapelBody.appendChild(barisMapel(m)); }); rata(); }
  function bacaMapel() {
    return Array.prototype.map.call(mapelBody.querySelectorAll('tr'), function (tr) {
      return { k: tr.querySelector('select').value, n: tr.querySelector('input.n').value.trim(), v: tr.querySelector('input.v').value };
    }).filter(function (m) { return m.n !== '' || m.v !== ''; });
  }
  function rata() {
    var v = bacaMapel().map(function (m) { return parseFloat(m.v); }).filter(function (x) { return !isNaN(x); });
    $('sklRata').textContent = v.length ? (v.reduce(function (a, b) { return a + b; }, 0) / v.length).toFixed(2).replace('.', ',') : '-';
  }
  mapelBody.addEventListener('input', rata);
  mapelBody.addEventListener('click', function (e) { var b = e.target.closest('.del'); if (b) { b.closest('tr').remove(); rata(); } });
  $('sklTambah').addEventListener('click', function () { var tr = barisMapel({ k: 'C', n: '', v: '' }); mapelBody.appendChild(tr); tr.querySelector('input.n').focus(); });
  $('sklBawaan').addEventListener('click', function () {
    var j = (form.elements.jurusan.value || '').toLowerCase(), set = 'Umum';
    if (/mipa|ipa|sains/.test(j)) set = 'MIPA'; else if (/ips|sosial/.test(j)) set = 'IPS'; else if (/agama/.test(j)) set = 'Keagamaan';
    var lama = bacaMapel(), peta = {};
    lama.forEach(function (m) { peta[m.n.toLowerCase()] = m.v; });
    var baru = (BAWAAN[set] || []).map(function (m) { var v = peta[m.n.toLowerCase()]; return { k: m.k, n: m.n, v: v == null ? '' : v }; });
    var nama = baru.map(function (m) { return m.n.toLowerCase(); });
    lama.forEach(function (m) { if (nama.indexOf(m.n.toLowerCase()) < 0 && m.v !== '') baru.push(m); });
    isiMapel(baru);
    toast('Susunan mata pelajaran ' + (set === 'Umum' ? 'umum' : set) + ' diterapkan. Isi nilainya.');
  });

  function bukaForm(id) {
    S.idAktif = id; $('sklErr').textContent = '';
    api(idUrl(U.detail, id)).then(function (d) {
      var f = d.form; BAWAAN = d.bawaan || {};
      $('sklJudul').textContent = (f.tersimpan ? 'Ubah Data SKL — ' : 'Lengkapi Data SKL — ') + d.alumni.nama;
      $('sklSub').textContent = 'NIS ' + d.alumni.nis + ' • NISN ' + d.alumni.nisn + ' • Lulus ' + d.alumni.tahun_lulus + ' • ' + (d.alumni.kelas || '');
      $('sklNote').hidden = !f.diisi_otomatis;
      ['tempat_lahir', 'tanggal_lahir', 'nama_orang_tua', 'jurusan', 'nomor_skl', 'tanggal_kelulusan'].forEach(function (k) { form.elements[k].value = f[k] || ''; });
      isiMapel(f.mapel);
      if (!dlg.open) dlg.showModal();
    }).catch(function (e) { toast(pesanGalat(e), true); });
  }

  function kirim(ke) {
    $('sklErr').textContent = '';
    var mapel = bacaMapel();
    for (var i = 0; i < mapel.length; i++) {
      if (mapel[i].n === '') { $('sklErr').textContent = 'Ada baris nilai tanpa nama mata pelajaran.'; return; }
      if (mapel[i].v === '') { $('sklErr').textContent = 'Nilai "' + mapel[i].n + '" belum diisi. Hapus barisnya bila tidak dipakai.'; return; }
    }
    if (!mapel.length) { $('sklErr').textContent = 'Isi minimal satu mata pelajaran.'; return; }

    var jendela = ke === 'cetak' ? window.open('', '_blank') : null;   // dibuka sekarang agar tidak diblokir browser
    var body = { mapel: mapel.map(function (m) { return { k: m.k, n: m.n, v: parseFloat(m.v) }; }) };
    ['tempat_lahir', 'tanggal_lahir', 'nama_orang_tua', 'jurusan', 'nomor_skl', 'tanggal_kelulusan'].forEach(function (k) { body[k] = form.elements[k].value; });

    $('sklSimpan').disabled = $('sklSimpanCetak').disabled = true;
    api(idUrl(U.simpan, S.idAktif), { method: 'PUT', json: body }).then(function (d) {
      dlg.close(); toast(d.pesan || 'Data SKL disimpan.'); muat();
      if (jendela) jendela.location = U.cetak + '?ids=' + S.idAktif + '&print=1';
    }).catch(function (e) {
      if (jendela) jendela.close();
      $('sklErr').textContent = pesanGalat(e);
    }).then(function () { $('sklSimpan').disabled = $('sklSimpanCetak').disabled = false; });
  }
  form.addEventListener('submit', function (e) { e.preventDefault(); kirim('simpan'); });
  $('sklSimpanCetak').addEventListener('click', function () { if (form.reportValidity()) kirim('cetak'); });

  /* ---------- Dialog pengaturan ---------- */
  var sdlg = $('sklSetDlg'), sform = $('sklSetForm');
  $('sklSet').addEventListener('click', function () {
    $('sklSetErr').textContent = '';
    var s = S.set || {};
    Array.prototype.forEach.call(sform.elements, function (el) { if (el.name) el.value = s[el.name] == null ? '' : s[el.name]; });
    sdlg.showModal();
  });
  sform.addEventListener('submit', function (e) {
    e.preventDefault();
    var body = {};
    Array.prototype.forEach.call(sform.elements, function (el) { if (el.name) body[el.name] = el.value; });
    api(U.pengaturan, { method: 'POST', json: body }).then(function (d) {
      S.set = d.set; sdlg.close(); toast(d.pesan || 'Pengaturan disimpan.');
    }).catch(function (er) { $('sklSetErr').textContent = pesanGalat(er); });
  });

  /* Tutup dialog */
  [dlg, sdlg].forEach(function (d) {
    d.addEventListener('click', function (e) { if (e.target.closest('[data-skl-tutup]') || e.target === d) d.close(); });
  });

  /* Segarkan daftar saat kembali dari tab cetak (agar status "Dicetak" terbarui) */
  document.addEventListener('visibilitychange', function () { if (!document.hidden && S.baris.length) muat(); });

  /* ---------- Mulai ---------- */
  muat().then(function () {
    var id = parseInt(Q.get('skl_id'), 10);
    if (Q.get('skl_id') || Q.get('skl_q') || Q.get('skl_status') || Q.get('skl_tahun') || location.hash === '#skl') {
      sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
    if (id) bukaForm(id);
  });
})();
</script>