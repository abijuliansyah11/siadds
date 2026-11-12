{{-- Input manual alumni lama (lulusan sebelum sistem dipakai). Hanya menambah; tidak mengubah kode halaman. --}}
@if(\Illuminate\Support\Facades\Route::has('alumni.lama'))
@php
  /* Pilihan lokasi dari data Lokasi Arsip Fisik: ruang -> lemari -> rak (beserta sisa tempat) */
  $lmAda   = class_exists(\App\Models\ArsipRuang::class)
          && defined('App\\Http\\Controllers\\ArsipFisikController::DOKUMEN_ALUMNI')
          && \Illuminate\Support\Facades\Schema::hasTable('arsip_rak')
          && \Illuminate\Support\Facades\Schema::hasColumn('arsip_fisik', 'alumni_id');
  $lmRuang = [];
  if ($lmAda) {
      $lmTerisi = \App\Models\ArsipFisik::whereNotNull('arsip_rak_id')->selectRaw('arsip_rak_id, COUNT(*) as n')->groupBy('arsip_rak_id')->pluck('n', 'arsip_rak_id');
      foreach (\App\Models\ArsipRuang::with('lemari.rak')->orderBy('nama')->get() as $lr0) {
          $lmL = [];
          foreach ($lr0->lemari->sortBy('kode') as $ll0) {
              $lmK = [];
              foreach ($ll0->rak->sortBy('kode') as $lk0) {
                  $lmK[] = ['id' => $lk0->id, 'kode' => $lk0->kode, 'sisa' => max(0, $lk0->kapasitas - (int) ($lmTerisi[$lk0->id] ?? 0))];
              }
              $lmL[] = ['id' => $ll0->id, 'kode' => $ll0->kode, 'rak' => $lmK];
          }
          $lmRuang[] = ['id' => $lr0->id, 'nama' => $lr0->nama, 'lemari' => $lmL];
      }
  }
  $lmButuh = $lmAda ? count(\App\Http\Controllers\ArsipFisikController::DOKUMEN_ALUMNI) : 6;
  $lmFisikSudah = ($lmAda && ($terpilih ?? null)) ? \App\Models\ArsipFisik::where('alumni_id', $terpilih->id)->count() : 0;
  $lmKelas = [];
  foreach (['XII', 'XI', 'X'] as $lk) { foreach (['A', 'B', 'C', 'D', 'E'] as $lr) { $lmKelas[] = $lk . '-' . $lr; } }
  $lmBuka = $errors->any() && old('_form') === 'lama';
@endphp
<dialog id="dlgLama" style="width:min(820px,94vw);max-height:92vh;overflow:auto">
  <form method="POST" action="{{ route('alumni.lama') }}" autocomplete="off">
    @csrf
    <input type="hidden" name="_form" value="lama">
    <h3>Tambah Alumni Lama</h3>
    <p class="mu" style="line-height:1.6">Untuk alumni yang lulus sebelum sistem ini dipakai dan tidak ada di Data Siswa Aktif. Setelah disimpan, berkas ijazah, SKL, transkrip, dll. dapat diunggah dari panel detail alumni. Untuk banyak alumni sekaligus, gunakan <b>Impor Data Alumni</b>.</p>
    @if($lmBuka)
      <div class="alert" style="margin:12px 0 0"><b>Gagal disimpan:</b><ul style="margin:6px 0 0 18px;line-height:1.6">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <p style="margin:18px 0 0;font-weight:800;font-size:12px;letter-spacing:.04em;color:var(--mu)">IDENTITAS</p>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0 14px">
      <label class="f">Nama lengkap *<input type="text" name="nama" value="{{ old('nama') }}" maxlength="100" required></label>
      <label class="f">Nama panggilan<input type="text" name="panggilan" value="{{ old('panggilan') }}" maxlength="50"></label>
      <label class="f">Jenis kelamin *<select name="jenis_kelamin" required><option value="">Pilih...</option><option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option><option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option></select></label>
      <label class="f">NISN * (10 digit)<input type="text" name="nisn" value="{{ old('nisn') }}" inputmode="numeric" pattern="[0-9]{10}" maxlength="10" required></label>
      <label class="f">NIS * (nomor induk madrasah)<input type="text" name="nis" value="{{ old('nis') }}" maxlength="20" required></label>
      <label class="f">NIK (16 digit)<input type="text" name="nik" value="{{ old('nik') }}" inputmode="numeric" pattern="[0-9]{16}" maxlength="16"></label>
    </div>

    <p style="margin:20px 0 0;font-weight:800;font-size:12px;letter-spacing:.04em;color:var(--mu)">AKADEMIK &amp; KELULUSAN</p>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0 14px">
      <label class="f">Kelas terakhir *<select name="kelas_terakhir" required>@foreach($lmKelas as $k)<option value="{{ $k }}" @selected(old('kelas_terakhir', 'XII-A') === $k)>{{ $k }}</option>@endforeach</select></label>
      <label class="f">Jurusan / peminatan<input type="text" name="jurusan" value="{{ old('jurusan') }}" maxlength="80" placeholder="mis. MIPA, IPS, Agama"></label>
      <label class="f">Tahun masuk *<input type="number" name="tahun_masuk" value="{{ old('tahun_masuk') }}" min="1980" max="2100" required></label>
      <label class="f">Tahun lulus *<input type="number" name="tahun_lulus" value="{{ old('tahun_lulus') }}" min="1980" max="2100" required></label>
      <label class="f">Tanggal kelulusan<input type="date" name="tanggal_kelulusan" value="{{ old('tanggal_kelulusan') }}"></label>
      <label class="f">Rata-rata nilai<input type="number" name="rata_rata" value="{{ old('rata_rata') }}" min="0" max="100" step="0.01"></label>
      <label class="f">Nomor ijazah <small class="mu">(kosong = dibuat otomatis)</small><input type="text" name="nomor_ijazah" value="{{ old('nomor_ijazah') }}" maxlength="40" placeholder="huruf, angka, tanda minus"></label>
      <label class="f">Nomor SKL<input type="text" name="nomor_skl" value="{{ old('nomor_skl') }}" maxlength="60"></label>
    </div>
    <label class="f">Prestasi / catatan<input type="text" name="prestasi" value="{{ old('prestasi') }}" maxlength="1000"></label>

    <p style="margin:20px 0 0;font-weight:800;font-size:12px;letter-spacing:.04em;color:var(--mu)">IJAZAH FISIK &amp; LOKASI ARSIP</p>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:0 14px">
      <label class="f">Status ijazah asli<select name="status_ijazah" id="lmStatus"><option value="tersimpan" @selected(old('status_ijazah', 'tersimpan') === 'tersimpan')>Tersimpan di TU</option><option value="menunggu" @selected(old('status_ijazah') === 'menunggu')>Menunggu diambil</option><option value="diambil" @selected(old('status_ijazah') === 'diambil')>Sudah diambil</option></select></label>
      <label class="f lm-ambil">Diambil oleh<input type="text" name="diambil_oleh" value="{{ old('diambil_oleh') }}" maxlength="100"></label>
      <label class="f lm-ambil">Tanggal pengambilan<input type="date" name="tanggal_pengambilan" value="{{ old('tanggal_pengambilan') }}"></label>
    </div>
    @if($lmAda && count($lmRuang))
      <p class="mu" style="margin:14px 0 0;line-height:1.6;font-size:12px">Pilih tempat penyimpanan agar alumni ini <b>otomatis tercatat di halaman Lokasi Arsip Fisik</b> ({{ $lmButuh }} dokumen kelulusan, masing-masing dengan kode arsip). Angkatan memakai <b>tahun lulus</b> dan kelas memakai <b>kelas terakhir</b> yang Anda isi di atas. Kosongkan rak bila belum ditentukan.</p>
      <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:0 14px">
        <label class="f">Arsip (ruang)<select id="lmRuang"></select></label>
        <label class="f">Lemari<select id="lmLemari"></select></label>
        <label class="f">Rak<select name="arsip_rak_id" id="lmRak" data-old="{{ old('arsip_rak_id') }}"></select></label>
        <label class="f">Kode map / ordner <small class="mu">(kosong = otomatis)</small><input type="text" name="kode_map" value="{{ old('kode_map') }}" maxlength="30" placeholder="mis. M-ALUMNI-2023-012"></label>
      </div>
    @elseif($lmAda)
      <p class="mu" style="margin:14px 0 0;line-height:1.6;font-size:12px">Belum ada ruang, lemari, dan rak. Buat dulu lewat <a href="{{ route('arsip.fisik') }}" style="color:var(--green);font-weight:700">Lokasi Arsip Fisik → Tambah Lokasi</a> agar alumni dapat ditempatkan.</p>
    @else
      <p class="mu" style="margin:14px 0 0;line-height:1.6;font-size:12px">Penempatan arsip fisik alumni belum aktif. Jalankan <b>php artisan migrate</b> terlebih dahulu.</p>
    @endif

    <div class="dact"><button type="button" class="btn" data-lm-close>Batal</button><button type="submit" class="btn g">Simpan Alumni</button></div>
  </form>
</dialog>
@if(($terpilih ?? null) && $lmAda && count($lmRuang) && $lmFisikSudah < $lmButuh && \Illuminate\Support\Facades\Route::has('alumni.arsipfisik'))
<dialog id="dlgLamaFisik" style="width:min(560px,94vw)">
  <form method="POST" action="{{ route('alumni.arsipfisik', $terpilih->id) }}" autocomplete="off">
    @csrf
    <input type="hidden" name="_form" value="lamafisik">
    <h3>Catat ke Arsip Fisik</h3>
    <p class="mu" style="line-height:1.6">{{ $terpilih->nama }} • Angkatan {{ $terpilih->tahun_lulus }} • Kelas {{ $terpilih->kelas_terakhir }}.<br>{{ $lmButuh - $lmFisikSudah }} dokumen kelulusan akan dicatat di Lokasi Arsip Fisik pada rak yang dipilih.</p>
    @if($errors->any() && old('_form') === 'lamafisik')
      <div class="alert" style="margin:12px 0 0"><ul style="margin:0 0 0 18px;line-height:1.6">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif
    <label class="f">Arsip (ruang)<select id="lmRuang2"></select></label>
    <label class="f">Lemari<select id="lmLemari2"></select></label>
    <label class="f">Rak<select name="arsip_rak_id" id="lmRak2" data-old="{{ old('arsip_rak_id') }}"></select></label>
    <label class="f">Kode map / ordner <small class="mu">(kosong = otomatis)</small><input type="text" name="kode_map" value="{{ old('kode_map', $terpilih->kode_map) }}" maxlength="30"></label>
    <div class="dact"><button type="button" class="btn" data-lm-close2>Batal</button><button type="submit" class="btn g">Catat Arsip Fisik</button></div>
  </form>
</dialog>
@endif
<script>
(function () {
  var dlg = document.getElementById('dlgLama');
  if (!dlg) { return; }
  function buka() { if (!dlg.open) { dlg.showModal(); } }

  /* Tombol di kepala halaman (sebelum "Proses Kelulusan Siswa") */
  var hb = document.querySelector('.hd .hb');
  if (hb) {
    var b = document.createElement('button');
    b.type = 'button'; b.className = 'btn'; b.id = 'bLama'; b.textContent = '+ Tambah Alumni Lama';
    b.addEventListener('click', buka);
    hb.insertBefore(b, hb.firstChild);
  }

  /* Quick Action */
  var menu = document.getElementById('qaMenu');
  if (menu) {
    var m = document.createElement('button');
    m.type = 'button'; m.textContent = 'Tambah Alumni Lama';
    m.addEventListener('click', buka);
    menu.insertBefore(m, menu.firstChild);
  }

  /* Tutup */
  [].slice.call(dlg.querySelectorAll('[data-lm-close]')).forEach(function (x) { x.addEventListener('click', function () { dlg.close(); }); });
  dlg.addEventListener('click', function (e) { if (e.target === dlg) { dlg.close(); } });

  /* Kolom "diambil oleh/tanggal" hanya relevan bila status = diambil */
  var st = document.getElementById('lmStatus');
  function sinkron() {
    var tampil = st && st.value === 'diambil';
    [].slice.call(dlg.querySelectorAll('.lm-ambil')).forEach(function (el) { el.style.display = tampil ? '' : 'none'; });
  }
  if (st) { st.addEventListener('change', sinkron); sinkron(); }

  /* Pilihan Arsip -> Lemari -> Rak (data dari Lokasi Arsip Fisik) */
  var RUANG = @json($lmRuang);
  var BUTUH = {{ $lmButuh }};
  function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (m) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]; }); }
  function rantai(idR, idL, idK) {
    var sr = document.getElementById(idR), sl = document.getElementById(idL), sk = document.getElementById(idK);
    if (!sr || !sl || !sk) { return; }
    var lama = sk.getAttribute('data-old') || '';
    function isiRuang() {
      sr.innerHTML = RUANG.map(function (r) { return '<option value="' + r.id + '">' + esc(r.nama) + '</option>'; }).join('');
      isiLemari();
    }
    function ruangAktif() { return RUANG.filter(function (r) { return String(r.id) === String(sr.value); })[0]; }
    function isiLemari() {
      var r = ruangAktif();
      sl.innerHTML = r ? r.lemari.map(function (l) { return '<option value="' + l.id + '">Lemari ' + esc(l.kode) + '</option>'; }).join('') : '';
      isiRak();
    }
    function isiRak() {
      var r = ruangAktif(), l = r && r.lemari.filter(function (x) { return String(x.id) === String(sl.value); })[0];
      var h = '<option value="">Belum ditentukan</option>';
      if (l) { h += l.rak.map(function (k) {
        return '<option value="' + k.id + '"' + (k.sisa < BUTUH ? ' disabled' : '') + '>Rak ' + esc(k.kode) + ' (sisa ' + k.sisa + ')</option>';
      }).join(''); }
      sk.innerHTML = h;
    }
    sr.addEventListener('change', isiLemari);
    sl.addEventListener('change', isiRak);
    isiRuang();
    if (lama) {  /* pulihkan pilihan setelah validasi gagal */
      RUANG.forEach(function (r) { r.lemari.forEach(function (l) { l.rak.forEach(function (k) {
        if (String(k.id) === String(lama)) { sr.value = r.id; isiLemari(); sl.value = l.id; isiRak(); sk.value = k.id; }
      }); }); });
    }
  }
  if (RUANG.length) { rantai('lmRuang', 'lmLemari', 'lmRak'); rantai('lmRuang2', 'lmLemari2', 'lmRak2'); }

  /* Tombol "Catat ke Arsip Fisik" pada panel detail alumni yang dipilih */
  var dlg2 = document.getElementById('dlgLamaFisik');
  if (dlg2) {
    var acts = document.querySelector('#detail .dh .ac');
    if (acts) {
      var bt = document.createElement('button');
      bt.type = 'button'; bt.className = 'btn g'; bt.textContent = 'Catat ke Arsip Fisik';
      bt.addEventListener('click', function () { if (!dlg2.open) { dlg2.showModal(); } });
      acts.insertBefore(bt, acts.firstChild);
    }
    [].slice.call(dlg2.querySelectorAll('[data-lm-close2]')).forEach(function (x) { x.addEventListener('click', function () { dlg2.close(); }); });
    dlg2.addEventListener('click', function (e) { if (e.target === dlg2) { dlg2.close(); } });
    @if($errors->any() && old('_form') === 'lamafisik')
    dlg2.showModal();
    @endif
  }

  @if($lmBuka)
  buka();
  @endif
})();
</script>
@endif