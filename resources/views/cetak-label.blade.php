<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Cetak Label QR Code | MAS YPI SUMBER HARJO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script>document.documentElement.classList.add('js');</script>
@include('partials.cetak-label-style')
<style id="stylePage"></style>
</head>
<body>
@php
/* ---------- Pembantu tampilan ---------- */
use App\Http\Controllers\ArsipFisikController as AF;
use App\Http\Controllers\CetakLabelController as CL;
use App\Models\ArsipLabel;

$ic     = fn ($n) => '<svg class="i"><use href="#'.$n.'"/></svg>';
$nama   = auth()->user()->name;
$angka  = fn ($n) => number_format($n, 0, ',', '.');
$u      = fn ($x = []) => route('label.qr', array_filter(array_merge(request()->except('page', 'riwayat_page'), $x), fn ($v) => $v !== null && $v !== ''));
$waktu  = fn ($t) => $t ? $t->locale('id')->translatedFormat('d M Y, H:i').' WIB' : null;
$inisial = function ($n) { $p = preg_split('/\s+/', trim((string) $n)); return mb_strtoupper(mb_substr($p[0] ?? '', 0, 1).(isset($p[1]) ? mb_substr($p[1], 0, 1) : '')); };
$filterAktif = request()->hasAny(['q', 'kategori', 'ruang', 'label', 'siswa', 'fokus']);

/* ---------- Pilihan pengaturan label ---------- */
$templates = [
    'standar'  => ['Standar Ordner',  'QR di kiri, data arsip di kanan'],
    'vertikal' => ['Vertikal Kompak', 'QR di atas, metadata di bawah'],
    'map'      => ['Ordner Map',      'Kompak stiker 50x30mm ringkas'],
    'kop'      => ['Kop Madrasah',    'Lengkap identitas resmi'],
];
$ukuran = ['50x30' => '50 × 30 mm (Standar Ordner)', '70x40' => '70 × 40 mm (Box Arsip)', '90x50' => '90 × 50 mm (Besar)', 'kustom' => 'Kustom'];
$komponen = [
    'kode' => 'Kode Arsip (ARS)', 'dokumen' => 'Nama Dokumen', 'lokasi' => 'Lokasi Fisik Ruang & Rak',
    'siswa' => 'Nama Siswa & NIS', 'logo' => 'Logo MAS YPI Sumber Harjo', 'potong' => 'Garis Batas Potong (Cut Margin)',
];

/* ---------- Konfigurasi untuk JavaScript ---------- */
$config = [
    'data'    => $data,
    'urls'    => ['buat' => route('label.qr.buat'), 'cetak' => route('label.qr.cetak')],
    'csrf'    => csrf_token(),
    'logo'    => asset('images/logo-mas-ypi.png'),
    'sekolah' => 'MAS YPI SUMBER HARJO',
    'kunci'   => ['pilihan' => 'siadds-label-pilihan', 'opsi' => 'siadds-label-opsi'],
    'adaFilter' => $filterAktif,
];
@endphp

@include('partials.sidebar')

{{-- Ikon tambahan khusus halaman ini --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="bell" viewBox="0 0 24 24"><path d="M6 17V11a6 6 0 0112 0v6l2 2H4zM10 21h4"/></symbol>
  <symbol id="shield" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></symbol>
  <symbol id="alert" viewBox="0 0 24 24"><path d="M12 3l10 18H2z"/><path d="M12 10v5M12 18v.01"/></symbol>
  <symbol id="info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8v.01"/></symbol>
  <symbol id="book" viewBox="0 0 24 24"><path d="M4 5a2 2 0 012-2h13v16H6a2 2 0 00-2 2zM4 19a2 2 0 012-2h13"/></symbol>
  <symbol id="pin" viewBox="0 0 24 24"><path d="M12 21s7-6.2 7-11a7 7 0 10-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></symbol>
  <symbol id="filter" viewBox="0 0 24 24"><path d="M3 5h18l-7 8v6l-4-2v-4z"/></symbol>
  <symbol id="refresh" viewBox="0 0 24 24"><path d="M20 12a8 8 0 11-3-6.2M20 4v5h-5"/></symbol>
  <symbol id="history" viewBox="0 0 24 24"><path d="M3 12a9 9 0 109-9 9.5 9.5 0 00-6.7 2.8L3 8M3 3v5h5M12 7v5l3 2"/></symbol>
  <symbol id="zoomin" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></symbol>
  <symbol id="zoomout" viewBox="0 0 24 24"><path d="M5 12h14"/></symbol>
  <symbol id="single" viewBox="0 0 24 24"><rect x="4" y="6" width="16" height="12" rx="2"/><path d="M8 10h3v3H8zM14 10h3M14 13h3"/></symbol>
  <symbol id="sheet" viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="18" rx="1.5"/><path d="M5 9h14M5 15h14M12 3v18"/></symbol>
  <symbol id="stack" viewBox="0 0 24 24"><path d="M12 3l9 5-9 5-9-5zM3 13l9 5 9-5"/></symbol>
  <symbol id="clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></symbol>
  <symbol id="box" viewBox="0 0 24 24"><path d="M3 7l9-4 9 4v10l-9 4-9-4zM3 7l9 4 9-4M12 11v10"/></symbol>
  <symbol id="arrow" viewBox="0 0 24 24"><path d="M5 12h14m0 0l-6-6m6 6l-6 6"/></symbol>
</svg>

<div class="main">

  {{-- ======================= HEADER ======================= --}}
  <header class="top">
    <form method="GET" action="{{ route('arsip.digital') }}" class="search" role="search">
      {!! $ic('search') !!}<input type="search" name="q" placeholder="Cari nama, NIS, atau dokumen..." aria-label="Cari dokumen">
    </form>
    <span class="pill">Sistem Aktif</span><span class="pill bl">TA 2026/2027 — Ganjil</span>
    <span class="sp"></span>
    <a href="{{ route('siswa.baru') }}" class="btn g">{!! $ic('plus') !!}Quick Action</a>
    <a href="{{ $u(['label'=>'belum','q'=>null,'fokus'=>null]) }}#tabel" class="bell" title="Arsip belum berlabel">{!! $ic('bell') !!}@if($ringkas['belum']>0)<b>{{ $ringkas['belum']>99?'99+':$ringkas['belum'] }}</b>@endif</a>
    <div class="user">
      <div class="av">{{ strtoupper(substr($nama,0,1)) }}</div>
      <div><b>{{ $nama }}</b><small>Administrator</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
    </div>
  </header>

  <div class="wrap">

    {{-- ======================= JUDUL HALAMAN ======================= --}}
    <nav class="crumb rv" aria-label="Breadcrumb"><span>Dashboard</span>/<span>Arsip Digital & Fisik</span>/<b>Cetak Label QR Code</b></nav>

    <section class="head rv" style="--d:60ms">
      <div>
        <h1><span class="ttl">Cetak Label QR Code</span></h1>
        <span class="tag bl">{!! $ic('qr') !!}SIADDS QR Engine v2.4</span>
        <p>Buat label QR Code untuk stiker arsip fisik agar dokumen mudah dikenali, ditemukan, dan dilacak berdasarkan kode arsip serta lokasi penyimpanannya.</p>
      </div>
      <div class="hact">
        <button type="button" class="btn" id="btnPanduan">{!! $ic('book') !!}Panduan QR Code</button>
        <a href="{{ route('arsip.fisik') }}" class="btn">{!! $ic('box') !!}Lihat Lokasi Fisik</a>
        <button type="button" class="btn g" id="btnCetakAtas">{!! $ic('print') !!}Cetak Lembar Label (A4)</button>
      </div>
    </section>

    @if(session('status'))<div class="flash rv" role="status">{!! $ic('check') !!}{{ session('status') }}</div>@endif
    @if($errors->any())<div class="flash err rv" role="alert">{!! $ic('alert') !!}{{ $errors->first() }}</div>@endif

    {{-- ======================= KARTU KPI ======================= --}}
    <section class="kpis">
      <div class="card kpi rv" style="--t:#0b1f3a;--t2:#e6ecf6;--d:100ms">
        <span class="l">TOTAL ARSIP FISIK</span><span class="ico">{!! $ic('folder') !!}</span>
        <strong><span data-count="{{ $ringkas['total'] }}">{{ $angka($ringkas['total']) }}</span></strong>
        <div class="n"><span>{!! $ic('check') !!}Terdata dalam repositori lokal</span></div>
      </div>
      <div class="card kpi rv" style="--t:#0f7a4f;--t2:#d9f5e8;--d:170ms">
        <span class="l">LABEL QR DIBUAT</span><span class="ico">{!! $ic('qr') !!}</span>
        <strong><span data-count="{{ $ringkas['dibuat'] }}">{{ $angka($ringkas['dibuat']) }}</span></strong>
        <div class="n"><span class="ok">{{ str_replace('.', ',', $ringkas['pctDibuat']) }}% telah berlabel</span></div>
      </div>
      <div class="card kpi rv" style="--t:#b45309;--t2:#fef3c7;--d:240ms">
        <span class="l">BELUM ADA LABEL</span><span class="ico">{!! $ic('alert') !!}</span>
        <strong><span data-count="{{ $ringkas['belum'] }}">{{ $angka($ringkas['belum']) }}</span></strong>
        <div class="n"><span class="al">{!! $ic('alert') !!}Antrean dokumen perlu label</span></div>
      </div>
      <div class="card kpi rv" style="--t:#2563eb;--t2:#dbeafe;--d:310ms">
        <span class="l">STIKER TERCETAK</span><span class="ico">{!! $ic('print') !!}</span>
        <strong><span data-count="{{ $ringkas['tercetak'] }}">{{ $angka($ringkas['tercetak']) }}</span></strong>
        <div class="n"><span class="ok">{!! $ic('shield') !!}Tercatat pada log audit</span></div>
      </div>
    </section>

    {{-- ======================= AREA KERJA ======================= --}}
    <div class="work" id="tabel">

      {{-- ---------- Kolom kiri: filter + pilihan + tabel ---------- --}}
      <div class="col">

        <section class="card flt rv" style="--d:80ms">
          <form method="GET" action="{{ route('label.qr') }}" id="formFilter">
            <input type="hidden" name="per" value="{{ $per }}">
            @if(request('fokus'))<input type="hidden" name="fokus" value="{{ request('fokus') }}">@endif
            <div class="frow">
              <label class="fsearch">{!! $ic('search') !!}<input type="search" id="cariTabel" name="q" value="{{ request('q') }}" placeholder="Cari berdasarkan kode arsip (ARS-...), nama siswa, NIS, atau lokasi..." aria-label="Cari arsip"><kbd>Ctrl K</kbd></label>
            </div>
            <div class="sels">
              <label>Kategori Dokumen<select name="kategori"><option value="">Semua Kategori</option>@foreach(array_keys(AF::DOKUMEN) as $o)<option value="{{ $o }}" @selected(request('kategori')===$o)>{{ $o }}</option>@endforeach</select></label>
              <label>Lokasi Fisik<select name="ruang"><option value="">Semua Ruang</option>@foreach($opsi['ruang'] as $o)<option value="{{ $o->id }}" @selected((int)request('ruang')===$o->id)>{{ $o->nama }}</option>@endforeach</select></label>
              <label>Status Label<select name="label"><option value="">Semua Status</option>@foreach(CL::STATUS as $k=>$o)<option value="{{ $k }}" @selected(request('label')===$k)>{{ $o }}</option>@endforeach</select></label>
              <label>Status Siswa<select name="siswa"><option value="">Semua Siswa</option>@foreach($opsi['status'] as $o)<option value="{{ $o }}" @selected(request('siswa')===$o)>{{ $o }}</option>@endforeach</select></label>
            </div>
            <div class="quick">
              <a class="chip {{ !$filterAktif?'on':'' }}" href="{{ route('label.qr') }}">Semua Arsip ({{ $angka($ringkas['total']) }})</a>
              <a class="chip {{ request('label')==='belum'?'on':'' }}" href="{{ $u(['label'=>'belum','fokus'=>null]) }}#tabel">Belum Ada Label ({{ $angka($ringkas['belum']) }})</a>
              <a class="chip bl {{ request('label')==='siap'?'on':'' }}" href="{{ $u(['label'=>'siap','fokus'=>null]) }}#tabel">Siap Cetak ({{ $angka($ringkas['siap']) }})</a>
              <a class="chip rd {{ request('fokus')==='lokasi'?'on':'' }}" href="{{ $u(['fokus'=>'lokasi','label'=>null]) }}#tabel">Lokasi Belum Diatur ({{ $angka($ringkas['lokasiBelum']) }})</a>
              <span class="sp"></span>
              <a class="chip ghost" href="{{ route('label.qr') }}">Reset Filter</a>
              <button type="submit" class="btn g sm">{!! $ic('filter') !!}Terapkan</button>
            </div>
          </form>
        </section>

        {{-- Bar pilihan (muncul saat ada arsip yang dipilih) --}}
        <section class="pick" id="barPilih" hidden>
          <div class="pt"><span class="nb" id="jmlPilih">0</span><div><b><span id="jmlPilihTeks">0</span> Arsip Dipilih</b><small>Siap digenerate & dicetak</small></div></div>
          <div class="ac">
            <button type="button" class="btn g sm" id="btnBuat">{!! $ic('qr') !!}Buat QR Code (<span id="jmlPilih2">0</span>)</button>
            <button type="button" class="btn dk sm" id="btnAntrean">{!! $ic('stack') !!}+ Antrean Cetak</button>
            <button type="button" class="link" id="btnBatal">Batal</button>
          </div>
        </section>

        <section class="card tb rv" style="--d:100ms">
          <div class="scroll">
          <table class="tbl" id="tabelArsip">
            <thead><tr>
              <th style="width:34px"><input type="checkbox" id="semua" aria-label="Pilih semua pada halaman ini"></th>
              <th>KODE ARSIP</th><th>IDENTITAS SISWA & NIS</th><th>KATEGORI DOKUMEN</th><th>LOKASI FISIK</th><th>STATUS LABEL</th>
            </tr></thead>
            <tbody>
            @forelse($daftar as $i => $a)
              @php $d = $data[$a->id]; $st = $d['label']; @endphp
              <tr data-id="{{ $a->id }}" style="--i:{{ $i }}">
                <td><input type="checkbox" class="pil" value="{{ $a->id }}" aria-label="Pilih {{ $a->kode_arsip }}"></td>
                <td class="kd">{{ $a->kode_arsip }}</td>
                <td class="sw"><b>{{ $d['nama'] }}</b><small>NIS: {{ $d['nis'] }} • Kelas {{ $d['kelas'] }}</small></td>
                <td><span class="kat">{{ $a->jenis }}</span></td>
                <td>@if($d['lokasi'])<span class="lk">{{ $d['lokasi'] }}</span>@else<span class="lk no">{!! $ic('alert') !!} Belum Diatur</span>@endif</td>
                <td><span class="stl {{ $st }}">{{ CL::STATUS[$st] ?? $st }}</span></td>
              </tr>
            @empty
              <tr><td colspan="6"><div class="empty"><b>Belum ada arsip yang cocok</b>@if($filterAktif)Ubah atau reset filter untuk melihat seluruh arsip.@else Catat arsip fisik lebih dulu di halaman <a href="{{ route('arsip.fisik') }}"><b style="display:inline;color:var(--green)">Lokasi Arsip Fisik</b></a>.@endif</div></td></tr>
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
            <span>Menampilkan {{ $daftar->firstItem() }} - {{ $daftar->lastItem() }} dari {{ $angka($daftar->total()) }} arsip</span>
            <form method="GET" action="{{ route('label.qr') }}">
              @foreach(request()->except('per','page','riwayat_page') as $kk=>$vv)<input type="hidden" name="{{ $kk }}" value="{{ $vv }}">@endforeach
              <label>Baris:<select name="per" onchange="this.form.submit()">@foreach([10,25,50] as $n)<option value="{{ $n }}" @selected($per===$n)>{{ $n }}</option>@endforeach</select></label>
            </form>
            <div class="pgn">
              <a href="{{ $daftar->url(1) }}" class="{{ $daftar->onFirstPage()?'dis':'' }}" aria-label="Halaman pertama">«</a>
              <a href="{{ $daftar->previousPageUrl() ?: '#' }}" class="{{ $daftar->onFirstPage()?'dis':'' }}" aria-label="Sebelumnya">‹</a>
              @foreach($nomor as $p)
                @if($p-$prev>1)<span>…</span>@endif
                <a href="{{ $daftar->url($p) }}" class="{{ $p===$cur?'on':'' }}">{{ $p }}</a>
                @php $prev = $p; @endphp
              @endforeach
              <a href="{{ $daftar->nextPageUrl() ?: '#' }}" class="{{ $daftar->hasMorePages()?'':'dis' }}" aria-label="Berikutnya">›</a>
              <a href="{{ $daftar->url($last) }}" class="{{ $daftar->hasMorePages()?'':'dis' }}" aria-label="Halaman terakhir">»</a>
            </div>
          </div>
          @endif
        </section>
      </div>

      {{-- ---------- Kolom kanan: pengaturan & pratinjau ---------- --}}
      <aside class="card cfg rv" style="--d:140ms" aria-label="Pengaturan dan pratinjau label">
        <div class="vt" role="tablist">
          <button type="button" class="on" data-mode="tunggal">{!! $ic('single') !!}Pratinjau Stiker Tunggal</button>
          <button type="button" data-mode="a4">{!! $ic('sheet') !!}<span id="lblTabA4">Pratinjau Lembar A4</span></button>
        </div>

        <div class="st-t">PILIH TEMPLATE LABEL <em>Rekomendasi</em></div>
        <div class="tpl" id="tplGrup">
          @foreach($templates as $k => [$judul, $ket])
            <label style="--i:{{ $loop->index }}"><input type="radio" name="template" value="{{ $k }}" {{ $k==='standar'?'checked':'' }}><b>@if($k==='standar'){!! $ic('check') !!}@endif{{ $judul }}</b><small>{{ $ket }}</small></label>
          @endforeach
        </div>

        <div class="st-t">UKURAN LABEL FISIK</div>
        <div class="uk" id="ukGrup">
          @foreach($ukuran as $k => $lb)
            <label style="--i:{{ $loop->index }}"><input type="radio" name="ukuran" value="{{ $k }}" {{ $k==='50x30'?'checked':'' }}>{{ $lb }}</label>
          @endforeach
        </div>
        <div class="kus" id="kustom">Lebar <input type="number" id="kusW" min="25" max="190" value="60"> × Tinggi <input type="number" id="kusH" min="15" max="120" value="35"> mm</div>

        <div class="st-t">KOMPONEN INFORMASI LABEL</div>
        <div class="kmp" id="kmpGrup">
          @foreach($komponen as $k => $lb)
            <label><input type="checkbox" name="komponen" value="{{ $k }}" checked>{{ $lb }}</label>
          @endforeach
        </div>

        <div class="pvh">
          <div class="st-t">PRATINJAU HASIL LABEL</div>
          <div class="zm"><button type="button" id="zmKecil" aria-label="Perkecil">{!! $ic('zoomout') !!}</button><span id="zmTeks">100%</span><button type="button" id="zmBesar" aria-label="Perbesar">{!! $ic('zoomin') !!}</button><button type="button" id="zmReset" aria-label="Setel ulang zoom">{!! $ic('refresh') !!}</button></div>
        </div>
        <div class="stage" id="stage"></div>
        <div class="nav2"><span id="navTeks">Pratinjau contoh</span><div><button type="button" id="navPrev">‹ Prev</button><button type="button" id="navNext">Next ›</button></div></div>

        <div class="fmt">
          <label>Format Lembar Kertas<select id="fmtKertas"><option value="a4">A4 — susun otomatis</option><option value="roll">Printer label (1 stiker per halaman)</option></select></label>
          <label id="boxPosisi">Mulai dari Posisi Ke-<select id="fmtPosisi"></select></label>
          <label>Salinan per Label<input type="number" id="fmtSalinan" min="1" max="20" value="1"></label>
          <label>&nbsp;<button type="button" class="btn full" id="btnGrid" style="margin-top:5px">{!! $ic('sheet') !!}Format Grid Penuh</button></label>
        </div>

        <div class="acts">
          <button type="button" class="btn g big full" id="btnCetak">{!! $ic('print') !!}Cetak Label Sekarang (Print Dialog)</button>
          <div class="two">
            <button type="button" class="btn" id="btnPdf">{!! $ic('download') !!}Unduh PDF A4</button>
            <button type="button" class="btn" id="btnSemuaHal">{!! $ic('check') !!}Pilih Halaman Ini</button>
          </div>
        </div>
        <p class="catat">Pencetakan tercatat di log saat dialog cetak dibuka. Untuk PDF, pilih <b>Simpan sebagai PDF</b> pada dialog cetak browser.</p>
      </aside>
    </div>

    {{-- ======================= RIWAYAT ======================= --}}
    <section class="card riw rv" id="riwayat" style="--d:80ms">
      <div class="riw-h">
        <h2>{!! $ic('history') !!}Riwayat Pembuatan & Pencetakan Label QR Code</h2>
        <div class="ra">
          <details class="dd" id="ddAudit">
            <summary class="btn sm">{!! $ic('filter') !!}Filter Audit{{ request('riwayat') ? ' ('.(ArsipLabel::STATUS[request('riwayat')] ?? '').')' : '' }}</summary>
            <div class="menu">
              <a href="{{ $u(['riwayat'=>null]) }}#riwayat" class="{{ !request('riwayat')?'on':'' }}">Semua</a>
              @foreach(ArsipLabel::STATUS as $k => $lb)<a href="{{ $u(['riwayat'=>$k]) }}#riwayat" class="{{ request('riwayat')===$k?'on':'' }}">{{ $lb }}</a>@endforeach
            </div>
          </details>
          <a href="{{ route('label.qr.ekspor', array_filter(['riwayat'=>request('riwayat')])) }}" class="btn sm">{!! $ic('download') !!}Ekspor Log (CSV)</a>
        </div>
      </div>

      <div class="scroll">
      <table class="tbl riwayat">
        <thead><tr><th>NO</th><th>KODE ARSIP</th><th>NAMA DOKUMEN</th><th>IDENTITAS SISWA</th><th>WAKTU PEMBUATAN QR</th><th>WAKTU CETAK TERAKHIR</th><th>QTY</th><th>OPERATOR</th><th>STATUS</th><th>AKSI</th></tr></thead>
        <tbody>
        @forelse($riwayat as $i => $l)
          @php $a = $l->arsip; $s = $a ? $a->siswa : null; $op = $l->dicetak_oleh ?: $l->dibuat_oleh; @endphp
          <tr style="--i:{{ $i }}">
            <td class="mu">{{ $riwayat->firstItem()+$i }}</td>
            <td class="kode">@if($a)<a href="{{ route('label.qr',['q'=>$a->kode_arsip]) }}#tabel">{{ $a->kode_arsip }}</a>@else-@endif</td>
            <td>{{ $a ? $a->jenis : '-' }}</td>
            <td>{{ $s ? $s->nama : '-' }}</td>
            <td class="wk">{{ $waktu($l->created_at) }}</td>
            <td class="wk">{{ $waktu($l->dicetak_at) ?: '- (Belum Cetak)' }}</td>
            <td>{{ $l->qty }} Label</td>
            <td><span class="op"><i>{{ $inisial($op) }}</i>{{ $op ?: '-' }}</span></td>
            <td><span class="sr {{ $l->status }}">{{ ArsipLabel::STATUS[$l->status] ?? $l->status }}</span></td>
            <td>@if($a)<a href="{{ route('label.qr',['q'=>$a->kode_arsip]) }}#tabel" class="btn sm">Cetak Ulang</a>@endif</td>
          </tr>
        @empty
          <tr><td colspan="10"><div class="empty"><b>Belum ada riwayat label</b>Label yang dibuat atau dicetak akan tercatat di sini beserta operator dan waktunya.</div></td></tr>
        @endforelse
        </tbody>
      </table>
      </div>

      @if($riwayat->total()>0)
      @php
        $rc = $riwayat->currentPage(); $rl = $riwayat->lastPage();
        $rn = collect([1,$rc-1,$rc,$rc+1,$rl])->filter(fn($p)=>$p>=1&&$p<=$rl)->unique()->sort()->values(); $rp = 0;
      @endphp
      <div class="pg">
        <span>Menampilkan {{ $riwayat->firstItem() }} - {{ $riwayat->lastItem() }} dari {{ $angka($riwayat->total()) }} catatan</span>
        <div class="pgn">
          <a href="{{ $riwayat->previousPageUrl() ?: '#' }}" class="{{ $riwayat->onFirstPage()?'dis':'' }}">‹</a>
          @foreach($rn as $p)
            @if($p-$rp>1)<span>…</span>@endif
            <a href="{{ $riwayat->url($p) }}" class="{{ $p===$rc?'on':'' }}">{{ $p }}</a>
            @php $rp = $p; @endphp
          @endforeach
          <a href="{{ $riwayat->nextPageUrl() ?: '#' }}" class="{{ $riwayat->hasMorePages()?'':'dis' }}">›</a>
        </div>
      </div>
      @endif
    </section>

    {{-- ======================= KEAMANAN ======================= --}}
    <section class="aman rv">
      {!! $ic('shield') !!}
      <div>
        <b>Keamanan & Integritas Data QR Code SIADDS</b>
        QR Code hanya memuat <strong>tautan ke sistem beserta kode arsip</strong> (misalnya ARS-2026-0001). Data pribadi seperti NIK atau data orang tua <strong>tidak disimpan di dalam QR</strong>. Pemindaian oleh kamera umum hanya menampilkan tautan; untuk membuka detail arsip, pengguna wajib login sebagai administrator atau operator resmi. Teks yang tercetak pada stiker (misalnya nama siswa) mengikuti pilihan <strong>Komponen Informasi Label</strong>.
      </div>
    </section>

  </div>
</div>

{{-- ======================= DIALOG PANDUAN ======================= --}}
<dialog id="dlgPanduan" aria-labelledby="dlgPanduanJudul">
  <h3 id="dlgPanduanJudul">Panduan Cetak Label QR Code</h3>
  <p>Langkah kerja yang disarankan:</p>
  <ul class="pl">
    <li><b>Pilih arsip</b> pada tabel dengan centang. Pilihan tetap tersimpan saat Anda pindah halaman.</li>
    <li><b>Atur label:</b> pilih template, ukuran stiker, dan komponen informasi. Pratinjau di kanan berubah langsung.</li>
    <li><b>Buat QR Code</b> untuk mencatat label, atau <b>+ Antrean Cetak</b> untuk menandai arsip yang siap dicetak.</li>
    <li><b>Cetak:</b> pilih <i>A4 — susun otomatis</i> untuk kertas stiker lembaran, atau <i>Printer label</i> untuk printer stiker (satu stiker per halaman).</li>
    <li><b>Mulai dari Posisi Ke-</b> berguna untuk memakai lembar stiker yang sebagian sudah terpakai.</li>
    <li>Pada dialog cetak: atur <b>Skala 100%</b> dan matikan <b>Header/Footer</b> agar ukuran stiker akurat.</li>
  </ul>
  <p>QR Code membuka halaman Lokasi Arsip Fisik dengan kode arsip tersebut. Pastikan alamat server (<code>APP_URL</code>) pada file <code>.env</code> sesuai alamat yang dipakai perangkat pemindai.</p>
  <div class="end"><button type="button" class="btn g" data-tutup>Mengerti</button></div>
</dialog>

{{-- Formulir tersembunyi untuk Buat QR / Antrean Cetak --}}
<form id="formBuat" method="POST" action="{{ route('label.qr.buat') }}" hidden>
  @csrf
  <div id="fbIds"></div>
  <input type="hidden" name="mode" id="fbMode"><input type="hidden" name="template" id="fbTemplate"><input type="hidden" name="ukuran" id="fbUkuran">
</form>

{{-- Area cetak (disembunyikan, tampil hanya saat mencetak) --}}
<div id="areaCetak" aria-hidden="true"></div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" defer></script>
<script>window.CETAKLABEL = @json($config);</script>
@include('partials.cetak-label-script')
@include('partials.cetak-label-tambahan')
@includeIf('partials.cetak-label-skl')
</body>
</html>