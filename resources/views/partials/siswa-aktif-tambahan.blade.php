{{-- Tambahan halaman Data Siswa Aktif: hubungan ke Arsip Digital & Fisik. Hanya menambah, tidak mengubah kode yang ada. --}}
@php
  $saBaris = $siswa->map(fn ($s) => ['id' => $s->id, 'url' => route('kelengkapan.dokumen', ['q' => $s->nis, 'pilih' => $s->id])])->values()->all();
  $saPanel = null;
  $saFisik = collect();
  if ($terpilih) {
    $dokTerpilih = $terpilih->dokumen->keyBy('jenis');
    $saDok = [];
    foreach (\App\Models\SiswaAktif::DOKUMEN_WAJIB as $j) {
      $d = $dokTerpilih->get($j);
      $saDok[$j] = $d
        ? ['ada' => true,  'url' => route('arsip.digital', ['q' => $terpilih->nis, 'pilih' => $d->id]) . '#daftar', 'teks' => 'Periksa di Direktori Arsip']
        : ['ada' => false, 'url' => route('upload.dokumen', ['siswa' => $terpilih->id, 'jenis' => $j]) . '#unggah', 'teks' => 'Unggah via Upload Dokumen'];
    }
    $saPanel = [
      'kelengkapan' => route('kelengkapan.dokumen', ['q' => $terpilih->nis, 'pilih' => $terpilih->id]),
      'upload'      => route('upload.dokumen', ['siswa' => $terpilih->id]) . '#unggah',
      'digital'     => route('arsip.digital', ['q' => $terpilih->nis]) . '#daftar',
      'fisik'       => route('arsip.fisik', ['q' => $terpilih->nis]) . '#daftar',
      'dok'         => $saDok,
    ];
    if (class_exists(\App\Models\ArsipFisik::class)) {
      $saFisik = \App\Models\ArsipFisik::with('rak.lemari.ruang')->where('siswa_aktif_id', $terpilih->id)->orderBy('kode_arsip')->get();
    }
  }
@endphp

@if($terpilih)
<template id="saTplFisik">
  <div style="margin-top:18px;padding-top:14px;border-top:1px solid var(--line)">
    <b>Arsip fisik tercatat di Lokasi Arsip Fisik ({{ $saFisik->count() }})</b>
    @if($saFisik->count())
      <ul style="list-style:none;margin:10px 0 0;padding:0;display:grid;gap:8px">
        @foreach($saFisik as $f)
          @php $rk = $f->rak; $lm = $rk ? $rk->lemari : null; $rg = $lm ? $lm->ruang : null; @endphp
          <li style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;padding:10px 12px;border:1px solid var(--line);border-radius:10px">
            <span><b>{{ $f->kode_arsip }}</b> • {{ $f->jenis }}<br><small class="mu">{{ $rk ? implode(' • ', array_filter([$rg ? $rg->nama : null, $lm->kode, $rk->kode, $f->kode_map])) : 'Belum ditata (belum ada rak)' }}</small></span>
            <a class="btn" href="{{ route('arsip.fisik', ['pilih' => $f->id]) }}#daftar" style="align-self:center">Buka</a>
          </li>
        @endforeach
      </ul>
    @else
      <p class="mu" style="margin-top:8px;line-height:1.6">Belum ada catatan arsip fisik untuk siswa ini. Catat lewat <b>Catat Arsip Fisik</b>, atau klik <b>Sinkronkan dari Data Siswa</b> di halaman Lokasi Arsip Fisik (membaca isian lemari &amp; rak di atas).</p>
    @endif
    <p style="margin-top:12px"><a class="btn" href="{{ route('arsip.fisik', ['q' => $terpilih->nis]) }}#daftar">Buka Lokasi Arsip Fisik</a></p>
  </div>
</template>
@endif

<script>
(function () {
  var BARIS = @json($saBaris);
  var P = @json($saPanel);

  var css = document.createElement('style');
  css.textContent = '.sa-ln{display:inline-block;margin-top:4px;font-size:11px;font-weight:600;color:var(--green);text-decoration:none}.sa-ln:hover{text-decoration:underline}';
  document.head.appendChild(css);

  /* 1. Tabel: tautan cepat ke Kelengkapan Dokumen pada tiap baris */
  var baris = document.querySelectorAll('tr.rw');
  Array.prototype.forEach.call(baris, function (tr, i) {
    var b = BARIS[i], td = tr.lastElementChild;
    if (!b || !td) return;
    var a = document.createElement('a');
    a.className = 'sa-ln'; a.href = b.url; a.textContent = 'Kelengkapan ›';
    a.title = 'Buka di halaman Kelengkapan Dokumen';
    a.addEventListener('click', function (e) { e.stopPropagation(); });   // jangan memicu klik baris
    td.appendChild(document.createElement('br')); td.appendChild(a);
  });

  /* 2. Menu Quick Action: tautan ke halaman arsip */
  var menu = document.getElementById('qaMenu');
  if (menu) {
    [['Direktori Arsip Digital', @json(route('arsip.digital'))], ['Upload Dokumen', @json(route('upload.dokumen'))],
     ['Kelengkapan Dokumen', @json(route('kelengkapan.dokumen'))], ['Lokasi Arsip Fisik', @json(route('arsip.fisik'))]].forEach(function (x) {
      var a = document.createElement('a'); a.href = x[1]; a.textContent = x[0]; menu.appendChild(a);
    });
  }
  if (!P) return;

  /* 3. Panel siswa terpilih: tombol ke halaman arsip */
  var acts = document.querySelector('#detail .dhead .acts');
  if (acts) {
    [['Kelengkapan Dokumen', P.kelengkapan], ['Upload Dokumen', P.upload], ['Arsip Digital', P.digital], ['Lokasi Arsip Fisik', P.fisik]].forEach(function (x) {
      var a = document.createElement('a'); a.className = 'btn'; a.href = x[1]; a.textContent = x[0]; acts.appendChild(a);
    });
  }

  /* 4. Kartu dokumen: periksa di Direktori Arsip (sudah ada) / unggah lewat Upload Dokumen (belum ada) */
  Array.prototype.forEach.call(document.querySelectorAll('#tpn-arsip .dc'), function (dc) {
    var b = dc.querySelector('b'), info = b && P.dok[b.textContent.trim()];
    if (!info) return;
    var a = document.createElement('a');
    a.className = 'btn'; a.href = info.url; a.textContent = info.teks; a.style.marginTop = '8px';
    dc.appendChild(a);
  });

  /* 5. Tab Lokasi: daftar arsip fisik siswa ini */
  var tpl = document.getElementById('saTplFisik'), tab = document.getElementById('tpn-lokasi');
  if (tpl && tab) tab.appendChild(tpl.content.cloneNode(true));

  /* 6. Dialog unggah langsung: arahkan ke jalur verifikasi bila perlu */
  var f = document.querySelector('#dlgUnggah form .dact');
  if (f) {
    var p = document.createElement('p');
    p.className = 'mu'; p.style.cssText = 'margin-top:12px;font-size:11.5px;line-height:1.6';
    p.innerHTML = 'Unggahan di sini langsung berstatus <b>VALID</b>. Untuk berkas yang perlu diperiksa dulu oleh verifikator, gunakan <a href="' + P.upload + '" style="color:var(--green);font-weight:700">Upload Dokumen</a>.';
    f.parentNode.insertBefore(p, f);
  }
})();
</script>
@if(session('tautan') && request('id'))
<script>
(function () {
  var note = document.querySelector('.wrap .note a.btn');
  if (!note) return;
  var id = @json((int) request('id'));
  [['Upload Dokumen', @json(route('upload.dokumen') . '?siswa=') + id + '#unggah'], ['Kelengkapan', @json(route('kelengkapan.dokumen') . '?pilih=') + id], ['Lokasi Arsip Fisik', @json(route('arsip.fisik') . '#daftar')]].forEach(function (x) {
    var a = document.createElement('a'); a.className = 'btn'; a.href = x[1]; a.textContent = x[0]; a.style.marginLeft = '8px';
    note.parentNode.appendChild(a);
  });
})();
</script>
@endif