<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Lokasi Arsip Fisik | MAS YPI SUMBER HARJO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script>document.documentElement.classList.add('js');</script>
@include('partials.arsip-fisik-style')
</head>
<body>
@php
/* ---------- Pembantu tampilan ---------- */
use App\Http\Controllers\ArsipFisikController as AF;
use App\Models\ArsipFisik;

$ic    = fn ($n) => '<svg class="i"><use href="#'.$n.'"/></svg>';
$nama  = auth()->user()->name;
$u     = fn ($x = []) => route('arsip.fisik', array_filter(array_merge(request()->except('page', 'pilih'), $x), fn ($v) => $v !== null && $v !== ''));
$angka = fn ($n) => number_format($n, 0, ',', '.');
$filterAktif = request()->hasAny(['q', 'ruang', 'lemari', 'rak', 'kategori', 'status', 'kondisi', 'fokus', 'arsip', 'angkatan', 'kelas', 'jenis']);

/* ---------- Konfigurasi untuk JavaScript ---------- */
$config = [
    'detail'  => $detail,
    'pilih'   => $idPilih,
    'lokasi'  => $lokasi,
    'cariUrl' => route('upload.dokumen.cari'),
    'csrf'    => csrf_token(),
    'urls'    => [
        'pindah'  => route('arsip.fisik.pindah', 0),
        'pinjam'  => route('arsip.fisik.pinjam', 0),
        'kembali' => route('arsip.fisik.kembali', 0),
        'kondisi' => route('arsip.fisik.kondisi', 0),
    ],
    'kondisi' => ArsipFisik::KONDISI,
];
@endphp

@include('partials.sidebar')

{{-- Ikon tambahan khusus halaman ini --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="bell" viewBox="0 0 24 24"><path d="M6 17V11a6 6 0 0112 0v6l2 2H4zM10 21h4"/></symbol>
  <symbol id="shield" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></symbol>
  <symbol id="alert" viewBox="0 0 24 24"><path d="M12 3l10 18H2z"/><path d="M12 10v5M12 18v.01"/></symbol>
  <symbol id="info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8v.01"/></symbol>
  <symbol id="building" viewBox="0 0 24 24"><path d="M4 21V5a1 1 0 011-1h9a1 1 0 011 1v16M15 9h4a1 1 0 011 1v11M3 21h18M8 8h3M8 12h3M8 16h3"/></symbol>
  <symbol id="cabinet" viewBox="0 0 24 24"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M4 12h16M10 7.5h4M10 16.5h4"/></symbol>
  <symbol id="layers" viewBox="0 0 24 24"><path d="M12 3l9 5-9 5-9-5zM3 13l9 5 9-5"/></symbol>
  <symbol id="pin" viewBox="0 0 24 24"><path d="M12 21s7-6.2 7-11a7 7 0 10-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></symbol>
  <symbol id="box" viewBox="0 0 24 24"><path d="M3 7l9-4 9 4v10l-9 4-9-4zM3 7l9 4 9-4M12 11v10"/></symbol>
  <symbol id="refresh" viewBox="0 0 24 24"><path d="M20 12a8 8 0 11-3-6.2M20 4v5h-5"/></symbol>
  <symbol id="filter" viewBox="0 0 24 24"><path d="M3 5h18l-7 8v6l-4-2v-4z"/></symbol>
  <symbol id="rows" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></symbol>
  <symbol id="move" viewBox="0 0 24 24"><path d="M5 12h14m0 0l-5-5m5 5l-5 5"/></symbol>
  <symbol id="arrow" viewBox="0 0 24 24"><path d="M5 12h14m0 0l-6-6m6 6l-6 6"/></symbol>
  <symbol id="clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></symbol>
  <symbol id="link" viewBox="0 0 24 24"><path d="M10 14a4 4 0 005.7 0l3-3a4 4 0 00-5.7-5.7l-1 1M14 10a4 4 0 00-5.7 0l-3 3a4 4 0 005.7 5.7l1-1"/></symbol>
</svg>

<div class="main">

  {{-- ======================= HEADER ======================= --}}
  <header class="top">
    <form method="GET" action="{{ route('arsip.fisik') }}" class="search" role="search">
      {!! $ic('search') !!}<input type="search" name="q" placeholder="Cari nama, NIS, atau dokumen..." aria-label="Cari arsip fisik">
    </form>
    <span class="pill">Sistem Aktif</span><span class="pill bl">TA 2026/2027 — Ganjil</span>
    <span class="sp"></span>
    <a href="{{ route('siswa.baru') }}" class="btn g">{!! $ic('plus') !!}Quick Action</a>
    <a href="{{ route('arsip.fisik', ['status'=>'dipinjam']) }}" class="bell" title="Arsip sedang dipinjam">{!! $ic('bell') !!}@if($ringkas['jatuhTempo']>0)<b>{{ $ringkas['jatuhTempo'] }}</b>@endif</a>
    <div class="user">
      <div class="av">{{ strtoupper(substr($nama,0,1)) }}</div>
      <div><b>{{ $nama }}</b><small>Administrator</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
    </div>
  </header>

  <div class="wrap">

    {{-- ======================= JUDUL HALAMAN ======================= --}}
    <div class="crumb rv">
      <nav aria-label="Breadcrumb"><span>Dashboard</span>/<span>Arsip Digital & Fisik</span>/<b>Lokasi Arsip Fisik</b></nav>
      <span class="tag bl">TA 2026/2027 Ganjil</span>
    </div>

    <section class="head rv" style="--d:60ms">
      <div>
        <div class="tl">
          <span class="ic">{!! $ic('box') !!}</span>
          <div>
            <h1><span class="ttl">Lokasi Arsip Fisik</span></h1>
            <div class="sub">REPOSITORI FISIK • LEMARI, RAK, ORDNER • TRACKING ARSIP TERINTEGRASI</div>
          </div>
        </div>
        <p>Kelola lokasi penyimpanan dokumen asli siswa agar arsip mudah ditemukan, dipantau, dipinjam, dan dikembalikan ke tempat yang benar secara akurat sesuai prosedur arsip madrasah.</p>
      </div>
      <div class="hact">
        <button type="button" class="btn" id="btnPanduan">{!! $ic('info') !!}Panduan SOP</button>
        <button type="button" class="btn" id="btnRekap">{!! $ic('print') !!}Cetak Rekap</button>
        <button type="button" class="btn bl" id="btnLokasi">{!! $ic('folder') !!}Tambah Lokasi</button>
        <button type="button" class="btn g" id="btnCatat">{!! $ic('plus') !!}Catat Arsip Fisik</button>
      </div>
    </section>

    @if(session('status'))<div class="flash rv" role="status">{!! $ic('check') !!}{{ session('status') }}</div>@endif
    @if($errors->any())<div class="flash err rv" role="alert">{!! $ic('alert') !!}{{ $errors->first() }}</div>@endif

    {{-- ======================= KARTU KPI ======================= --}}
    <section class="kpis">
      <div class="card kpi rv" style="--t:#334e8a;--t2:#e0e9ff;--d:100ms">
        <span class="l">Total Arsip Fisik Terdata</span><span class="ico">{!! $ic('box') !!}</span>
        <strong><span data-count="{{ $ringkas['total'] }}">{{ $angka($ringkas['total']) }}</span></strong>
        <div class="n"><span class="ok">{!! $ic('check') !!}{{ $angka($ringkas['tersimpan']) }} Tersimpan Sah</span><span>{{ $ringkas['lemari'] }} Lemari • {{ $ringkas['map'] }} Map</span></div>
      </div>
      <div class="card kpi rv" style="--t:#0f7a4f;--t2:#d9f5e8;--d:170ms">
        <span class="l">Lokasi Terisi & Kapasitas</span><span class="ico">{!! $ic('cabinet') !!}</span>
        <strong><span data-count="{{ $ringkas['rakTerisi'] }}">{{ $ringkas['rakTerisi'] }}</span><small>/ {{ $ringkas['rakTotal'] }} Rak</small></strong>
        <div class="track"><i class="stabil" style="--w:{{ min(100,$ringkas['pctRak']) }}%"></i></div>
        <div class="n"><span>{{ str_replace('.', ',', $ringkas['pctRak']) }}% Kapasitas Terpakai</span><span>{{ $ringkas['ruang'] }} Ruang Arsip</span></div>
      </div>
      <div class="card kpi rv" style="--t:#2563eb;--t2:#dbeafe;--d:240ms">
        <span class="l">Sedang Dipinjam</span><span class="ico">{!! $ic('clock') !!}</span>
        <strong><span data-count="{{ $ringkas['dipinjam'] }}">{{ $ringkas['dipinjam'] }}</span><small>Berkas</small></strong>
        <div class="n"><span class="{{ $ringkas['jatuhTempo']>0?'wr':'' }}">{!! $ic('alert') !!}{{ $ringkas['jatuhTempo'] }} Jatuh Tempo</span><a href="{{ route('arsip.fisik',['status'=>'dipinjam']) }}#daftar">Lihat Daftar →</a></div>
      </div>
      <div class="card kpi rv" style="--t:#dc2626;--t2:#fee2e2;--d:310ms">
        <span class="l">Lokasi Belum Ditentukan</span><span class="ico">{!! $ic('pin') !!}</span>
        <strong><span data-count="{{ $ringkas['belum'] }}">{{ $ringkas['belum'] }}</span><small>Berkas</small></strong>
        <div class="n"><span class="al">Perlu Label & Rak</span><span>{{ $ringkas['antrean'] }} Antrean</span></div>
      </div>
    </section>

    {{-- ======================= HIERARKI REPOSITORI ======================= --}}
    <section class="card hr rv" style="--d:80ms">
      <div class="hr-h">
        <div>
          <h2>{!! $ic('layers') !!}Hierarki Repositori Fisik Aktif</h2>
          <p>Peta partisi fisik dokumen madrasah berdasarkan ruang, lemari arsip, dan volume rak.</p>
        </div>
        <div class="kep">
          <span>Status Kepadatan:</span>
          <span><i style="background:#0f7a4f"></i>Stabil (&lt;70%)</span>
          <span><i style="background:#d97706"></i>Padat (70–85%)</span>
          <span><i style="background:#dc2626"></i>Kritis (&gt;85%)</span>
          <form method="POST" action="{{ route('arsip.fisik.sinkron') }}" id="formSinkron">@csrf<button type="submit" class="btn sm">{!! $ic('refresh') !!}Sinkronkan dari Data Siswa</button></form>
        </div>
      </div>

      @if(count($hierarki))
      <div class="rooms">
        @foreach($hierarki as $ri => $r)
          <article class="room rv" style="--d:{{ 120 + $ri*90 }}ms">
            <div class="room-h">
              <h3>{!! $ic('building') !!}<span>{{ $r['nama'] }}@if($r['gedung']||$r['lantai']) ({{ trim(($r['gedung']?:'').($r['lantai']?', Lt. '.$r['lantai']:''), ', ') }})@endif
                @if($r['peruntukan'])<small>Peruntukan: {{ $r['peruntukan'] }}</small>@endif</span></h3>
              <span class="tag">{{ $r['jumlahLemari'] }} Lemari Aktif</span>
            </div>
            @forelse($r['lemari'] as $li => $l)
              <div class="lm {{ $l['tingkat'] }}" style="--i:{{ $li }}">
                <div class="lm-h"><div><b>Lemari {{ $l['kode'] }}</b>@if($l['ket'])<small>{{ $l['ket'] }}</small>@endif</div><em>{{ $l['pct'] }}% Kapasitas</em></div>
                <div class="track"><i class="{{ $l['tingkat'] }}" style="--w:{{ min(100,$l['pct']) }}%"></i></div>
                <div class="raks">
                  @foreach($l['rak'] as $k)<span class="rk {{ $k['tingkat'] }}" title="{{ $k['terisi'] }} dari {{ $k['kapasitas'] }} berkas">Rak {{ $k['kode'] }} ({{ $k['pct'] }}%)</span>@endforeach
                </div>
              </div>
            @empty
              <div class="hr-empty" style="padding:18px">Belum ada lemari pada ruang ini.</div>
            @endforelse
          </article>
        @endforeach
      </div>
      @else
      <div class="hr-empty">
        <b>Belum ada lokasi penyimpanan</b>
        Tambahkan ruang, lemari, dan rak lebih dulu, atau tarik data lokasi yang sudah tercatat pada profil siswa.
        <div><button type="button" class="btn bl" data-buka="#dlgLokasi">{!! $ic('folder') !!}Tambah Lokasi</button></div>
      </div>
      @endif
    </section>

    {{-- ======================= FILTER ======================= --}}
    <section class="card flt rv" style="--d:80ms">
      <div class="quick">
        <span>Filter Cepat:</span>
        <a class="chip {{ !$filterAktif?'on':'' }}" href="{{ route('arsip.fisik') }}">Semua Repositori ({{ $angka($ringkas['total']) }})</a>
        @foreach($hierarki as $r)
          <a class="chip {{ (int)request('ruang')===$r['id']?'on':'' }}" href="{{ $u(['ruang'=>$r['id'],'lemari'=>null,'rak'=>null,'fokus'=>null]) }}#daftar">{{ $r['nama'] }} ({{ $r['terisi'] }})</a>
        @endforeach
        <a class="chip bl {{ request('status')==='dipinjam'?'on':'' }}" href="{{ $u(['status'=>'dipinjam']) }}#daftar">Sedang Dipinjam ({{ $ringkas['dipinjam'] }})</a>
        <a class="chip rd {{ request('kondisi')==='perhatian'?'on':'' }}" href="{{ $u(['kondisi'=>'perhatian']) }}#daftar">Kondisi Perhatian ({{ $ringkas['perhatian'] }})</a>
        <a class="chip rd {{ request('fokus')==='belum'?'on':'' }}" href="{{ $u(['fokus'=>'belum']) }}#daftar">Belum Ditentukan ({{ $ringkas['belum'] }})</a>
      </div>

      <form method="GET" action="{{ route('arsip.fisik') }}" id="formFilter">
        <input type="hidden" name="per" value="{{ $per }}">
        <div class="frow">
          <label class="fsearch">{!! $ic('search') !!}<input type="search" id="cariTabel" name="q" value="{{ request('q') }}" placeholder="Cari nama siswa, NIS, kode arsip (ARS-...), nama dokumen, lemari, atau map ordner..." aria-label="Cari arsip"><kbd>Ctrl K</kbd></label>
          <button type="submit" class="btn g">{!! $ic('filter') !!}Terapkan Filter</button>
          <a href="{{ route('arsip.fisik') }}" class="icobtn" title="Reset filter" aria-label="Reset filter">{!! $ic('refresh') !!}</a>
        </div>
        {{-- Filter lama (Ruangan, Lemari, Rak, Kategori, Status, Kondisi) tetap ada tetapi disembunyikan; diganti 4 filter berikut --}}
        <div class="sels" hidden style="display:none">
          <label>Ruangan<select name="ruang"><option value="">Semua Ruangan</option>@foreach($opsi['ruang'] as $o)<option value="{{ $o->id }}" @selected((int)request('ruang')===$o->id)>{{ $o->nama }}</option>@endforeach</select></label>
          <label>Lemari<select name="lemari"><option value="">Semua Lemari</option>@foreach($opsi['lemari'] as $o)<option value="{{ $o['id'] }}" @selected((int)request('lemari')===$o['id'])>{{ $o['label'] }}</option>@endforeach</select></label>
          <label>Baris Rak<select name="rak"><option value="">Semua Rak</option>@foreach($opsi['rak'] as $o)<option value="{{ $o }}" @selected(request('rak')===$o)>{{ $o }}</option>@endforeach</select></label>
          <label>Kategori Dokumen<select name="kategori"><option value="">Semua Kategori</option>@foreach(array_keys(AF::semuaJenis()) as $o)<option value="{{ $o }}" @selected(request('kategori')===$o)>{{ $o }}</option>@endforeach</select></label>
          <label>Status Fisik<select name="status"><option value="">Semua Status</option>@foreach(ArsipFisik::STATUS as $k=>$o)<option value="{{ $k }}" @selected(request('status')===$k)>{{ $o }}</option>@endforeach</select></label>
          <label>Kondisi Kertas<select name="kondisi"><option value="">Semua Kondisi</option>@foreach(ArsipFisik::KONDISI as $k=>$o)<option value="{{ $k }}" @selected(request('kondisi')===$k)>{{ $o }}</option>@endforeach</select></label>
        </div>
        @php
          $opsiAngkatan = \App\Models\SiswaAktif::whereNotNull('tahun_masuk')->where('tahun_masuk','!=','')->distinct()->orderByDesc('tahun_masuk')->pluck('tahun_masuk');
          $opsiKelas    = \App\Models\SiswaAktif::whereNotNull('kelas')->where('kelas','!=','')->distinct()->orderBy('kelas')->pluck('kelas');
          /* Angkatan (= tahun lulus) dan kelas terakhir alumni ikut menjadi pilihan filter */
          if (\Illuminate\Support\Facades\Schema::hasTable('alumni')) {
              $opsiAngkatan = $opsiAngkatan->merge(\App\Models\Alumni::distinct()->pluck('tahun_lulus'))->map(fn ($v) => (string) $v)->unique()->sortDesc()->values();
              $opsiKelas    = $opsiKelas->merge(\App\Models\Alumni::distinct()->pluck('kelas_terakhir'))->filter()->unique()->sort()->values();
          }
        @endphp
        <div class="sels" style="display:grid;grid-template-columns:repeat(4,minmax(0,1fr))">
          <label>Arsip<select name="arsip"><option value="">Semua Arsip</option>@foreach($opsi['ruang'] as $o)<option value="{{ $o->id }}" @selected((int)request('arsip')===$o->id)>{{ $o->nama }}</option>@endforeach</select></label>
          <label>Angkatan<select name="angkatan"><option value="">Semua Angkatan</option>@foreach($opsiAngkatan as $o)<option value="{{ $o }}" @selected((string)request('angkatan')===(string)$o)>{{ $o }}</option>@endforeach</select></label>
          <label>Kelas<select name="kelas"><option value="">Semua Kelas</option>@foreach($opsiKelas as $o)<option value="{{ $o }}" @selected(request('kelas')===$o)>{{ $o }}</option>@endforeach</select></label>
          <label>Jenis Dokumen<select name="jenis"><option value="">Semua Jenis Dokumen</option>@foreach(array_keys(AF::semuaJenis()) as $o)<option value="{{ $o }}" @selected(request('jenis')===$o)>{{ $o }}</option>@endforeach</select></label>
        </div>
      </form>

      <div class="bulk">
        <span><b id="jmlPilih">0</b> Berkas Dipilih</span>
        <button type="button" class="btn sm bl" id="btnLabelMassal" disabled>{!! $ic('qr') !!}Cetak Label QR Massal (<span id="jmlPilih2">0</span>)</button>
        <button type="button" class="btn sm" id="btnMassal" disabled>{!! $ic('move') !!}Pindahkan Bersama</button>
        <span class="sp"></span>
        <span>Terakhir sinkronisasi repositori: Hari ini, {{ $ringkas['sinkron'] }}</span>
      </div>
    </section>

    {{-- ======================= TABEL + PANEL DETAIL ======================= --}}
    <div class="layout" id="daftar">

      {{-- ---------- Tabel arsip ---------- --}}
      <section class="card tb rv" style="--d:80ms">
        <div class="tb-h">
          <h2>{!! $ic('folder') !!}Daftar Penempatan Arsip Fisik Siswa <span class="tag bl">{{ $angka($daftar->total()) }} Item</span></h2>
          <button type="button" class="dens" id="btnRapat">{!! $ic('rows') !!}Tampilan Ringkas</button>
        </div>

        <div class="scroll">
        <table class="tbl" id="tabelArsip">
          <thead><tr>
            <th style="width:30px"><input type="checkbox" id="semua" aria-label="Pilih semua"></th>
            <th>KODE ARSIP</th><th>IDENTITAS SISWA & NIS</th><th>DOKUMEN ASLI</th><th>HIERARKI LOKASI FISIK</th><th>KONDISI</th><th>STATUS</th>
          </tr></thead>
          <tbody>
          @forelse($daftar as $i => $a)
            @php
              $s = $a->siswa ?: ($a->alumni ? (object) ['nama' => $a->alumni->nama, 'nis' => $a->alumni->nis, 'kelas' => $a->alumni->kelas_terakhir . ' (Alumni)'] : null); $rak = $a->rak; $lem = $rak ? $rak->lemari : null; $ruang = $lem ? $lem->ruang : null;
              $meta = AF::DOKUMEN[$a->jenis] ?? AF::DOKUMEN_ALUMNI[$a->jenis] ?? ['Pendukung', 'Dokumen pendukung'];
              $stLabel = $rak ? (ArsipFisik::STATUS[$a->status] ?? $a->status) : 'Belum Ditata';
              $stKelas = $rak ? $a->status : 'belum';
            @endphp
            <tr data-id="{{ $a->id }}" class="{{ $a->id===$idPilih?'act':'' }}" style="--i:{{ $i }}">
              <td><input type="checkbox" class="pil" value="{{ $a->id }}" aria-label="Pilih {{ $a->kode_arsip }}"></td>
              <td class="kd">{{ $a->kode_arsip }}</td>
              <td><div class="sw"><span class="ini c{{ $a->id % 4 }}">{{ $detail[$a->id]['siswa']['ini'] ?? '?' }}</span><div><b>{{ $s ? $s->nama : '-' }}</b><small>NIS: {{ $s ? $s->nis : '-' }} • Kelas {{ $s ? $s->kelas : '-' }}</small></div></div></td>
              <td class="dk"><b>{{ $a->jenis }}</b><small class="sub">{{ $meta[1] }}</small><small class="kat">{{ $meta[0] }}</small></td>
              <td class="lk">
                @if($rak)
                  <b>{{ implode(' • ', array_filter([$lem->kode, $rak->kode, $a->kode_map])) }}</b>
                  <small class="sub">{{ $ruang->nama }}@if($ruang->lantai) (Lt. {{ $ruang->lantai }})@endif</small>
                @else
                  <b class="no">Belum ditentukan</b><small class="sub">Perlu label & rak</small>
                @endif
              </td>
              <td><span class="kn {{ $a->kondisi }}">{{ ArsipFisik::KONDISI[$a->kondisi] ?? $a->kondisi }}</span></td>
              <td><span class="tag {{ $stKelas }}">{{ $stLabel }}</span></td>
            </tr>
          @empty
            <tr><td colspan="7"><div class="empty"><b>Belum ada arsip fisik yang cocok</b>@if($filterAktif)Ubah atau reset filter untuk melihat seluruh arsip.@else Catat arsip fisik pertama dengan tombol <b style="display:inline">Catat Arsip Fisik</b>, atau sinkronkan dari data siswa.@endif</div></td></tr>
          @endforelse
          </tbody>
        </table>
        </div>

        @if($daftar->total()>0)
        @php
          $cur = $daftar->currentPage(); $last = $daftar->lastPage();
          $nomor = collect([1,$cur-1,$cur,$cur+1,$last])->filter(fn($p)=>$p>=1&&$p<=$last)->unique()->sort()->values(); $prev = 0;
        @endphp
        <div class="pg">
          <span>Menampilkan {{ $daftar->firstItem() }} - {{ $daftar->lastItem() }} dari {{ $angka($daftar->total()) }} arsip terdata</span>
          <form method="GET" action="{{ route('arsip.fisik') }}">
            @foreach(request()->except('per','page','pilih') as $kk=>$vv)<input type="hidden" name="{{ $kk }}" value="{{ $vv }}">@endforeach
            <label>Baris:<select name="per" onchange="this.form.submit()">@foreach([10,25,50] as $n)<option value="{{ $n }}" @selected($per===$n)>{{ $n }}</option>@endforeach</select></label>
          </form>
          <div class="pgn">
            <a href="{{ $daftar->previousPageUrl() ?: '#' }}" class="{{ $daftar->onFirstPage()?'dis':'' }}">‹</a>
            @foreach($nomor as $p)
              @if($p-$prev>1)<span>…</span>@endif
              <a href="{{ $daftar->url($p) }}" class="{{ $p===$cur?'on':'' }}">{{ $p }}</a>
              @php $prev = $p; @endphp
            @endforeach
            <a href="{{ $daftar->nextPageUrl() ?: '#' }}" class="{{ $daftar->hasMorePages()?'':'dis' }}">›</a>
          </div>
        </div>
        @endif
      </section>

      {{-- ---------- Panel detail (diisi JavaScript) ---------- --}}
      <aside class="card dp rv" id="panelDetail" style="--d:160ms" aria-live="polite" aria-label="Detail arsip terpilih"></aside>
    </div>

    {{-- ======================= BANNER SOP ======================= --}}
    <section class="sop rv">
      <div class="si">
        {!! $ic('shield') !!}
        <div>
          <b>Standar Operasional Preservasi Arsip Fisik Madrasah</b>
          <p>Simpan dokumen asli di map yang bersih dan ruang yang kering serta terkunci. Catat setiap perpindahan dan peminjaman agar keberadaan arsip selalu dapat ditelusuri.</p>
        </div>
      </div>
      <div class="sa">
        <span>Server Madrasah Aktif</span>
        <a href="{{ route('arsip.fisik',['kondisi'=>'belum']) }}#daftar" class="btn g">Audit Fisik Berkala</a>
      </div>
    </section>

  </div>
</div>

{{-- ======================= DIALOG PANDUAN SOP ======================= --}}
<dialog id="dlgPanduan" aria-labelledby="dlgPanduanJudul">
  <h3 id="dlgPanduanJudul">Panduan SOP Arsip Fisik</h3>
  <p>Alur kerja yang dipakai halaman ini:</p>
  <ul class="pl">
    <li><b>Lokasi:</b> susun hierarki <i>ruang → lemari → rak</i> lewat <b>Tambah Lokasi</b>. Kapasitas tiap rak menentukan persentase kepadatan.</li>
    <li><b>Catat arsip:</b> setiap dokumen asli mendapat <b>kode arsip</b> unik (contoh ARS-2026-0001) dan ditempatkan di rak serta map tertentu.</li>
    <li><b>Pindah:</b> pilih arsip, buka tab <i>Pindahkan Rak</i>. Rak yang penuh tidak bisa dipilih sebagai tujuan.</li>
    <li><b>Pinjam &amp; kembali:</b> catat peminjam dan jatuh tempo. Arsip yang lewat jatuh tempo ditandai merah.</li>
    <li><b>Kondisi:</b> perbarui kondisi kertas (Baik, Perhatian, Rusak) saat audit fisik. Filter <i>Belum Dicek</i> menampilkan arsip yang belum diaudit.</li>
    <li><b>Label QR:</b> cetak sticker 50x30 mm untuk ditempel pada map. QR membuka detail arsip ini.</li>
  </ul>
  <p>Setiap perubahan tercatat otomatis pada riwayat aktivitas arsip.</p>
  <div class="end"><button type="button" class="btn g" data-tutup>Mengerti</button></div>
</dialog>

{{-- ======================= DIALOG TAMBAH LOKASI ======================= --}}
<dialog id="dlgLokasi" aria-labelledby="dlgLokasiJudul">
  <form method="POST" action="{{ route('arsip.fisik.lokasi') }}">
    @csrf
    <h3 id="dlgLokasiJudul">Tambah Lokasi Penyimpanan</h3>
    <p>Buat lemari beserta rak-raknya. Kode rak dibuat otomatis (R-01, R-02, dan seterusnya).</p>
    <div class="fld"><label for="lkRuang">Ruang Arsip</label>
      <select name="ruang" id="lkRuang">
        @foreach($opsi['ruang'] as $o)<option value="{{ $o->id }}">{{ $o->nama }}</option>@endforeach
        <option value="baru" @selected($opsi['ruang']->isEmpty())>+ Ruang baru...</option>
      </select></div>
    <div id="lkBaru">
      <div class="fld"><label for="lkNama">Nama Ruang Baru</label><input type="text" name="ruang_nama" id="lkNama" maxlength="100" placeholder="Contoh: Ruang Tata Usaha"></div>
      <div class="two">
        <div class="fld"><label>Gedung</label><input type="text" name="gedung" maxlength="30" placeholder="Gedung A"></div>
        <div class="fld"><label>Lantai</label><input type="text" name="lantai" maxlength="30" placeholder="1"></div>
      </div>
      <div class="fld"><label>Peruntukan</label><input type="text" name="peruntukan" maxlength="200" placeholder="Contoh: Dokumen Siswa Aktif TA 2024 - 2026"></div>
    </div>
    <div class="two">
      <div class="fld"><label>Kode Lemari</label><input type="text" name="lemari_kode" maxlength="20" placeholder="L-01" required></div>
      <div class="fld"><label>Keterangan Lemari</label><input type="text" name="lemari_ket" maxlength="200" placeholder="Siswa Aktif Angkatan 2026"></div>
    </div>
    <div class="two">
      <div class="fld"><label>Jumlah Rak</label><input type="number" name="jumlah_rak" min="1" max="30" value="4" required></div>
      <div class="fld"><label>Kapasitas per Rak (berkas)</label><input type="number" name="kapasitas" min="1" max="500" value="50" required></div>
    </div>
    <div class="end"><button type="button" class="btn" data-tutup>Batal</button><button type="submit" class="btn g">{!! $ic('check') !!}Simpan Lokasi</button></div>
  </form>
</dialog>

{{-- ======================= DIALOG CATAT ARSIP FISIK ======================= --}}
<dialog id="dlgCatat" aria-labelledby="dlgCatatJudul">
  <form method="POST" action="{{ route('arsip.fisik.simpan') }}" id="formCatat">
    @csrf
    <h3 id="dlgCatatJudul">Catat Arsip Fisik</h3>
    <p>Daftarkan dokumen asli milik siswa beserta lokasi penyimpanannya. Dokumen yang sudah tercatat akan dilewati.</p>
    <input type="hidden" name="siswa_id" id="ctSiswaId">
    <div class="fld finder"><label for="ctCari">Siswa</label>
      <input type="search" id="ctCari" autocomplete="off" placeholder="Ketik nama, NIS, atau NISN siswa...">
      <ul class="res" id="ctHasil" hidden></ul>
      <div class="chosen" id="ctPilih" hidden></div></div>
    <div class="fld"><label>Dokumen Asli yang Dicatat</label>
      <div class="chk" id="ctJenis">
        @foreach(array_keys(AF::DOKUMEN) as $j)<label><input type="checkbox" name="jenis[]" value="{{ $j }}" data-jenis="{{ $j }}">{{ $j }}<small></small></label>@endforeach
      </div></div>
    <div class="two">
      <div class="fld"><label>Lemari</label><select id="ctLemari"></select></div>
      <div class="fld"><label>Rak</label><select name="arsip_rak_id" id="ctRak"></select></div>
    </div>
    <div class="two">
      <div class="fld"><label>Kode Map / Ordner</label><input type="text" name="kode_map" maxlength="30" placeholder="M-001"></div>
      <div class="fld"><label>Kondisi Fisik</label><select name="kondisi">@foreach(ArsipFisik::KONDISI as $k=>$o)<option value="{{ $k }}" @selected($k==='baik')>{{ $o }}</option>@endforeach</select></div>
    </div>
    <div class="end"><button type="button" class="btn" data-tutup>Batal</button><button type="submit" class="btn g">{!! $ic('check') !!}Simpan Arsip</button></div>
  </form>
</dialog>

{{-- ======================= DIALOG PINDAHKAN BERSAMA ======================= --}}
<dialog id="dlgMassal" aria-labelledby="dlgMassalJudul">
  <form method="POST" action="{{ route('arsip.fisik.massal') }}" id="formMassal">
    @csrf
    <h3 id="dlgMassalJudul">Pindahkan Bersama</h3>
    <p id="mlInfo">Pindahkan arsip yang dipilih ke rak yang sama.</p>
    <div id="mlIds"></div>
    <div class="two">
      <div class="fld"><label>Lemari Tujuan</label><select id="mlLemari"></select></div>
      <div class="fld"><label>Rak Tujuan</label><select name="arsip_rak_id" id="mlRak"></select></div>
    </div>
    <div class="fld"><label>Alasan Pemindahan</label><textarea name="catatan" maxlength="300" placeholder="Contoh: Penataan ulang arsip angkatan baru"></textarea></div>
    <div class="end"><button type="button" class="btn" data-tutup>Batal</button><button type="submit" class="btn g">{!! $ic('move') !!}Pindahkan</button></div>
  </form>
</dialog>

{{-- Area cetak label sticker (disembunyikan, tampil hanya saat mencetak label) --}}
<div id="areaCetak" aria-hidden="true"></div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>
<script>window.ARSIPFISIK = @json($config);</script>
@include('partials.arsip-fisik-script')
@include('partials.arsip-fisik-tambahan')
</body>
</html>