<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Upload Dokumen | MAS YPI SUMBER HARJO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script>document.documentElement.classList.add('js');</script>
@include('partials.upload-dokumen-style')
</head>
<body>
@php
/* ---------- Pembantu tampilan ---------- */
use App\Http\Controllers\ArsipDigitalController as AD;

$ic    = fn ($n) => '<svg class="i"><use href="#'.$n.'"/></svg>';
$nama  = auth()->user()->name;
$bulan = fn ($d) => $d ? \Carbon\Carbon::parse($d)->locale('id')->translatedFormat('d M Y, H:i').' WIB' : '-';
$tabUrl = fn ($t) => route('upload.dokumen', ['tab' => $t]).'#riwayat';

$labelStatus = ['sah' => 'Tervalidasi Sah', 'menunggu' => 'Menunggu Verifikasi', 'revisi' => 'Perlu Perbaikan'];
$daftarTab   = ['semua' => 'Semua', 'hari' => 'Hari Ini', 'menunggu' => 'Menunggu Verifikasi', 'sah' => 'Tervalidasi Sah', 'ditolak' => 'Ditolak'];

/* ---------- Konfigurasi untuk JavaScript ---------- */
$config = [
    'cariUrl'   => route('upload.dokumen.cari'),
    'siswaAwal' => $siswaAwal,
    'jenisAwal' => $jenisAwal,
    'jenis'     => $jenis,
    'ext'       => ['pdf', 'jpg', 'jpeg', 'png'],
    'maxMB'     => 5,
    'draftKey'  => 'siadds-upload-draft',
    'old'       => [
        'nama'  => old('nama_dokumen'),
        'nomor' => old('nomor_dokumen'),
        'tgl'   => old('tanggal_terbit'),
        'desk'  => old('deskripsi'),
    ],
];
@endphp

@include('partials.sidebar')

{{-- Ikon tambahan khusus halaman ini --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="bell" viewBox="0 0 24 24"><path d="M6 17V11a6 6 0 0112 0v6l2 2H4zM10 21h4"/></symbol>
  <symbol id="shield" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></symbol>
  <symbol id="alert" viewBox="0 0 24 24"><path d="M12 3l10 18H2z"/><path d="M12 10v5M12 18v.01"/></symbol>
  <symbol id="hourglass" viewBox="0 0 24 24"><path d="M6 3h12M6 21h12M7 3c0 5 5 6 5 9s-5 4-5 9M17 3c0 5-5 6-5 9s5 4 5 9"/></symbol>
  <symbol id="cloud" viewBox="0 0 24 24"><path d="M7 18a4 4 0 01-.5-7.97A5.5 5.5 0 0117 9.5a4.2 4.2 0 01.5 8.5M12 12v8m0-8l-3 3m3-3l3 3"/></symbol>
  <symbol id="eye" viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></symbol>
  <symbol id="swap" viewBox="0 0 24 24"><path d="M4 8h14l-3-3M20 16H6l3 3"/></symbol>
  <symbol id="trash" viewBox="0 0 24 24"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 13h10l1-13M9 7V4h6v3"/></symbol>
  <symbol id="dots" viewBox="0 0 24 24"><circle cx="12" cy="5" r="1.2"/><circle cx="12" cy="12" r="1.2"/><circle cx="12" cy="19" r="1.2"/></symbol>
  <symbol id="redo" viewBox="0 0 24 24"><path d="M3 12a9 9 0 109-9M3 4v5h5"/></symbol>
  <symbol id="chat" viewBox="0 0 24 24"><path d="M4 5h16v11H9l-5 4z"/></symbol>
  <symbol id="zoomin" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4M8 11h6M11 8v6"/></symbol>
  <symbol id="zoomout" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4M8 11h6"/></symbol>
  <symbol id="rotate" viewBox="0 0 24 24"><path d="M20 12a8 8 0 11-3-6.2M20 4v5h-5"/></symbol>
  <symbol id="expand" viewBox="0 0 24 24"><path d="M4 9V4h5M20 9V4h-5M4 15v5h5M20 15v5h-5"/></symbol>
  <symbol id="ext" viewBox="0 0 24 24"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h5"/></symbol>
  <symbol id="info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8v.01"/></symbol>
  <symbol id="back" viewBox="0 0 24 24"><path d="M19 12H5m0 0l6-6m-6 6l6 6"/></symbol>
  <symbol id="arrow" viewBox="0 0 24 24"><path d="M5 12h14m0 0l-6-6m6 6l-6 6"/></symbol>
  <symbol id="save" viewBox="0 0 24 24"><path d="M5 4h11l3 3v13H5zM8 4v5h7V4M8 20v-6h8v6"/></symbol>
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
    <a href="{{ route('arsip.digital', ['verif' => 'menunggu']) }}#daftar" class="bell" title="Antrean verifikasi dokumen">{!! $ic('bell') !!}@if($kpi['menunggu']>0)<b>{{ $kpi['menunggu']>99?'99+':$kpi['menunggu'] }}</b>@endif</a>
    <div class="user">
      <div class="av">{{ strtoupper(substr($nama,0,1)) }}</div>
      <div><b>{{ $nama }}</b><small>Administrator</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
    </div>
  </header>

  <div class="wrap">

    {{-- ======================= JUDUL HALAMAN ======================= --}}
    <nav class="crumb rv" aria-label="Breadcrumb"><span>Dashboard</span>/<span>Arsip Digital & Fisik</span>/<b>Upload Dokumen</b></nav>

    <section class="head rv" style="--d:60ms">
      <div>
        <h1><span class="ttl">Upload Dokumen Siswa</span> <span class="pill bl">SIADDS Engine v3.4</span></h1>
        <p>Unggah dan hubungkan dokumen digital dengan data siswa secara aman, terstruktur, dan sesuai tata kelola kearsipan madrasah.</p>
      </div>
      <div class="hact">
        <a href="{{ route('arsip.digital') }}" class="btn">{!! $ic('back') !!}Direktori Arsip</a>
        <button type="button" class="btn" id="btnPanduan">{!! $ic('info') !!}Panduan Validasi Format</button>
      </div>
    </section>

    @if(session('status'))<div class="flash rv" role="status">{!! $ic('check') !!}{{ session('status') }}</div>@endif
    @if($errors->any())<div class="flash err rv" role="alert">{!! $ic('alert') !!}{{ $errors->first() }}</div>@endif

    {{-- ======================= KARTU KPI ======================= --}}
    <section class="kpis">
      <div class="card kpi rv" style="--t:#2563eb;--t2:#e0e9ff;--d:120ms">
        <span class="l">TOTAL DOKUMEN</span><span class="ico">{!! $ic('folder') !!}</span>
        <strong><span data-count="{{ $kpi['total'] }}">{{ number_format($kpi['total'],0,',','.') }}</span><small>Berkas</small></strong>
        <div class="n">{!! $ic('shield') !!}Tersimpan di repositori madrasah</div>
      </div>
      <div class="card kpi rv" style="--t:#0f7a4f;--t2:#d9f5e8;--d:200ms">
        <span class="l">DIUNGGAH HARI INI</span><span class="ico">{!! $ic('check') !!}</span>
        <strong><span data-count="{{ $kpi['hari'] }}">{{ number_format($kpi['hari'],0,',','.') }}</span><small>Berkas</small></strong>
        @if($kpi['delta']===null)<div class="n">Belum ada data pembanding kemarin</div>
        @else<div class="n {{ $kpi['delta']>=0?'up':'dn' }}">{!! $ic('chart') !!}{{ $kpi['delta']>=0?'+':'' }}{{ $kpi['delta'] }}% dari kemarin</div>@endif
      </div>
      <div class="card kpi rv" style="--t:#b45309;--t2:#fef3c7;--d:280ms">
        <span class="l">MENUNGGU VERIFIKASI</span><span class="ico">{!! $ic('hourglass') !!}</span>
        <strong><span data-count="{{ $kpi['menunggu'] }}">{{ number_format($kpi['menunggu'],0,',','.') }}</span><small>Berkas</small></strong>
        <div class="n">Antrean tim verifikator TU</div>
      </div>
      <div class="card kpi rv" style="--t:#dc2626;--t2:#fee2e2;--d:360ms">
        <span class="l">PERLU TINDAK LANJUT</span><span class="ico">{!! $ic('alert') !!}</span>
        <strong><span data-count="{{ $kpi['ditolak'] }}">{{ number_format($kpi['ditolak'],0,',','.') }}</span><small>Berkas Ditolak</small></strong>
        <div class="n dn">Resolusi buram / format salah</div>
      </div>
    </section>

    {{-- ======================= FORM + PANEL KANAN ======================= --}}
    <div class="layout" id="unggah">

      {{-- ---------- KOLOM KIRI: FORM 3 LANGKAH ---------- --}}
      <form class="col" id="formUpload" method="POST" action="{{ route('upload.dokumen.simpan') }}" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="siswa_id" id="siswaId" value="{{ old('siswa_id') }}">
        <input type="hidden" name="jenis" id="jenisDok" value="{{ old('jenis') }}">

        {{-- LANGKAH 1 — Hubungkan identitas siswa --}}
        <section class="card rv" style="--d:100ms">
          <header class="sh">
            <span class="ico">{!! $ic('user') !!}</span>
            <div><h2>1. Hubungkan Identitas Siswa</h2><p>Pastikan berkas terindeks ke buku induk digital secara presisi</p></div>
            <span class="req">Wajib Ditautkan</span>
          </header>
          <div class="finder">
            <label class="fsearch">{!! $ic('search') !!}<input type="search" id="cariSiswa" autocomplete="off" placeholder="Ketik nama, NIS, atau NISN siswa..." aria-label="Cari siswa"><button type="button" class="mini" id="btnCari">Cari Ulang</button></label>
            <ul class="res" id="hasilCari" role="listbox" hidden></ul>
          </div>
          <div class="scard empty" id="kartuSiswa"></div>
        </section>

        {{-- LANGKAH 2 — Kategori & metadata --}}
        <section class="card rv" style="--d:140ms">
          <header class="sh">
            <span class="ico">{!! $ic('folder') !!}</span>
            <div><h2>2. Kategori & Metadata Dokumen</h2><p>Tentukan jenis dokumen dan lengkapi atribut identitas berkas</p></div>
          </header>
          <span class="lbl">Pilih Jenis / Kategori Berkas:</span>
          <div class="tiles" id="tiles">
            @foreach($jenis as $nm => $m)
              <button type="button" class="tile" data-jenis="{{ $nm }}">
                <span class="ti">{!! $ic($m['icon']) !!}</span>
                <span><b>{{ $m['tile'] }}</b><small data-st="">{{ $m['sub'] }}</small></span>
              </button>
            @endforeach
          </div>
          <div class="fields">
            <div class="field"><label for="namaDok">Nama Dokumen</label><input type="text" id="namaDok" name="nama_dokumen" maxlength="150" placeholder="Pilih kategori terlebih dahulu"></div>
            <div class="field"><label for="nomorDok" id="lblNomor">Nomor Registrasi Dokumen</label><input type="text" id="nomorDok" name="nomor_dokumen" maxlength="60" placeholder="Opsional"></div>
            <div class="field"><label for="tglTerbit">Tanggal Terbit Dokumen</label><input type="date" id="tglTerbit" name="tanggal_terbit"></div>
            <div class="field"><label>Petugas Operator Pengunggah</label><input type="text" value="{{ $nama }} (Administrator)" readonly tabindex="-1"></div>
            <div class="field full"><label for="deskDok">Catatan & Deskripsi Dokumen</label><textarea id="deskDok" name="deskripsi" maxlength="500" placeholder="Contoh: Scan bolak-balik, 1 lembar format PDF terstandar."></textarea></div>
          </div>
        </section>

        {{-- LANGKAH 3 — Unggah berkas --}}
        <section class="card rv" style="--d:180ms">
          <header class="sh">
            <span class="ico">{!! $ic('file') !!}</span>
            <div><h2>3. Unggah Berkas Digital</h2><p>Format dan ukuran berkas diperiksa otomatis sebelum dikirim</p></div>
            <span class="end">Maks. 5 MB</span>
          </header>
          <div class="drop" id="dropzone">
            <span class="cloud">{!! $ic('cloud') !!}</span>
            <b>Seret dan lepaskan file dokumen di sini</b>
            <p>Atau klik tombol di bawah untuk memilih file dari komputer lokal Anda</p>
            <button type="button" class="btn" id="btnPilih">Pilih File dari Komputer</button>
            <div class="fmt"><span>Format PDF</span><span>JPG, JPEG, PNG</span><span>Maks. 5 MB</span></div>
            <input type="file" id="berkas" name="berkas" accept=".pdf,.jpg,.jpeg,.png" hidden>
          </div>
          <div class="drop-err" id="errBerkas" role="alert"></div>
          <div class="fileitem" id="fileItem" hidden>
            <span class="fi" id="fiExt">PDF</span>
            <div class="fn"><b><span id="fiNama"></span><span class="badge ok" id="fiBadge">Valid</span></b><small id="fiMeta"></small></div>
            <div class="acts">
              <button type="button" class="ib" id="fiLihat" title="Lihat pratinjau" aria-label="Lihat pratinjau">{!! $ic('eye') !!}</button>
              <button type="button" class="ib" id="fiGanti" title="Ganti berkas" aria-label="Ganti berkas">{!! $ic('swap') !!}</button>
              <button type="button" class="ib rd" id="fiHapus" title="Hapus berkas" aria-label="Hapus berkas">{!! $ic('trash') !!}</button>
            </div>
          </div>
        </section>

        {{-- BAR AKSI --}}
        <section class="card bar rv" id="barAksi" style="--d:220ms">
          <span class="ck">{!! $ic('check') !!}</span>
          <div class="tx"><b id="syaratJudul">Lengkapi data sebelum mengunggah</b><small id="syaratIsi">Belum lengkap: siswa, kategori, berkas.</small></div>
          <div class="acts">
            <button type="button" class="btn" id="btnReset">Reset Formulir</button>
            <button type="button" class="btn" id="btnDraft">{!! $ic('save') !!}Simpan Draft</button>
            <button type="submit" class="btn g" id="btnUpload" disabled><span id="btnUploadTx">Upload Dokumen Sekarang</span><svg class="i arr"><use href="#arrow"/></svg></button>
          </div>
        </section>
      </form>

      {{-- ---------- KOLOM KANAN ---------- --}}
      <aside class="rail">

        {{-- Pratinjau dokumen --}}
        <section class="card rv" style="--d:140ms" aria-label="Pratinjau dokumen">
          <div class="pv-top"><span class="ico">{!! $ic('file') !!}</span><h3>Pratinjau Dokumen</h3><span class="badge" id="pvFormat">Belum ada</span></div>
          <div class="pv" id="pvBox">
            <div class="pv-inner" id="pvInner">
              <div class="pv-empty">{!! $ic('cloud') !!}<span>Pratinjau akan tampil di sini setelah Anda memilih berkas.</span></div>
            </div>
          </div>
          <div class="pv-tools">
            <button type="button" class="ib" id="pvZoomIn" title="Perbesar" aria-label="Perbesar">{!! $ic('zoomin') !!}</button>
            <button type="button" class="ib" id="pvZoomOut" title="Perkecil" aria-label="Perkecil">{!! $ic('zoomout') !!}</button>
            <button type="button" class="ib" id="pvRotate" title="Putar" aria-label="Putar">{!! $ic('rotate') !!}</button>
            <button type="button" class="ib" id="pvFull" title="Layar penuh" aria-label="Layar penuh">{!! $ic('expand') !!}</button>
          </div>
          <div class="hashbox"><span>Hash SHA-256<br>Integritas:</span><code id="pvHash" title="">—</code></div>
        </section>

        {{-- Integrasi ruang penyimpanan --}}
        <section class="card stor rv" style="--d:200ms">
          <h3><i></i>Integrasi Ruang Penyimpanan</h3>
          <p>Berkas akan disimpan ke folder <code id="storPath">dokumen-siswa/NIS-siswa/</code> pada penyimpanan server madrasah.</p>
          <div class="cap"><span>Kapasitas Server:</span><b>{{ $disk['pakai'] }} GB / {{ $disk['total'] }} GB</b></div>
          <div class="track" style="max-width:none"><i data-w="{{ $disk['persen'] }}"></i></div>
        </section>

        {{-- Ketentuan & tata tertib --}}
        <section class="card rules rv" style="--d:260ms">
          <h3>{!! $ic('shield') !!}Ketentuan & Tata Tertib Arsip</h3>
          <ol>
            <li>Pastikan dokumen asli difoto atau dipindai tegak lurus, tanpa terpotong, dengan cahaya yang cukup.</li>
            <li>Nama siswa, NISN, dan tanggal lahir pada dokumen identitas harus sesuai Buku Induk Madrasah.</li>
            <li>Setelah dinyatakan sah oleh petugas, simpan berkas fisik asli pada ordner arsip sesuai nomor map.</li>
          </ol>
          <a class="ln" href="{{ route('label.qr') }}" title="Buka halaman Cetak Label QR Code">Cetak Kode QR & Label Ordner Fisik {!! $ic('arrow') !!}</a>
        </section>
      </aside>
    </div>

    {{-- ======================= RIWAYAT UPLOAD ======================= --}}
    <section class="card riw rv" id="riwayat" style="--d:80ms">
      <div class="riw-h">
        <div><h2>Riwayat Upload Dokumen Terbaru</h2><p>Jejak audit berkas yang baru saja diproses ke dalam repositori madrasah</p></div>
        <nav class="tabs" aria-label="Filter riwayat">
          @foreach($daftarTab as $kt => $lb)
            <a href="{{ $tabUrl($kt) }}" class="{{ $tabAktif===$kt?'on':'' }} {{ $kt==='ditolak'?'rd':'' }}">{{ $lb }} ({{ number_format($jumlahTab[$kt],0,',','.') }})</a>
          @endforeach
        </nav>
      </div>

      <div class="scroll">
        <table class="tbl">
          <thead><tr><th>NO</th><th>SISWA & NIS</th><th>NAMA DOKUMEN</th><th>FILE & UKURAN</th><th>WAKTU UNGGAH</th><th>PETUGAS OPERATOR</th><th>STATUS VALIDASI</th><th style="text-align:right">AKSI</th></tr></thead>
          <tbody>
          @forelse($riwayat as $i => $d)
            @php
              $s   = $d->siswa;
              $g   = AD::golongan($d->status);
              $ext = strtoupper(pathinfo((string)($d->nama_file ?: $d->path), PATHINFO_EXTENSION));
              $ik  = $jenis[$d->jenis]['icon'] ?? 'file';
            @endphp
            <tr style="--i:{{ $i }}">
              <td class="no">{{ str_pad($riwayat->firstItem()+$i,2,'0',STR_PAD_LEFT) }}</td>
              <td class="sw">@if($s)<b>{{ $s->nama }}</b><small>NIS: {{ $s->nis }} • {{ $s->kelas }}</small>@else<small>Siswa tidak ditemukan</small>@endif</td>
              <td><span class="dk">{!! $ic($ik) !!}{{ $d->nama_dokumen ?: $d->jenis }}</span></td>
              <td class="fl"><b>{{ $d->nama_file ?: '-' }}</b><small>{{ $d->ukuran ?: '-' }} • {{ $ext ?: '-' }}</small></td>
              <td class="wk">{{ $bulan($d->updated_at ?? $d->created_at) }}</td>
              <td class="wk">{{ $d->diunggah_oleh ?: '-' }}</td>
              <td><span class="st {{ $g }}">{{ $labelStatus[$g] }}</span></td>
              <td>
                <div class="ac">
                  @if($g==='revisi')
                    @if($s)<a class="rd" href="{{ route('upload.dokumen',['siswa'=>$s->id,'jenis'=>$d->jenis]) }}#unggah" title="Unggah ulang" aria-label="Unggah ulang">{!! $ic('redo') !!}</a>@endif
                    <a href="{{ route('arsip.digital',['pilih'=>$d->id]) }}" title="{{ $d->catatan ?: 'Lihat catatan verifikator' }}" aria-label="Lihat catatan">{!! $ic('chat') !!}</a>
                  @else
                    <a href="{{ route('arsip.digital.lihat',$d->id) }}" target="_blank" rel="noopener" class="{{ $d->path?'':'off' }}" title="Lihat berkas" aria-label="Lihat berkas">{!! $ic('eye') !!}</a>
                    <a href="{{ route('arsip.digital.unduh',$d->id) }}" class="{{ $d->path?'':'off' }}" title="Unduh berkas" aria-label="Unduh berkas">{!! $ic('download') !!}</a>
                    <a href="{{ route('arsip.digital',['pilih'=>$d->id]) }}" title="Buka di Direktori Arsip" aria-label="Buka di Direktori Arsip">{!! $ic('dots') !!}</a>
                  @endif
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="8"><div class="empty"><b>Belum ada riwayat unggahan</b>Berkas yang Anda unggah akan muncul di sini beserta status validasinya.</div></td></tr>
          @endforelse
          </tbody>
        </table>
      </div>

      @if($riwayat->total()>0)
      @php
        $cur  = $riwayat->currentPage(); $last = $riwayat->lastPage();
        $hal  = collect([1,$cur-1,$cur,$cur+1,$last])->filter(fn($p)=>$p>=1&&$p<=$last)->unique()->sort()->values(); $prev = 0;
      @endphp
      <div class="pg">
        <span>Menampilkan {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }} dari {{ number_format($riwayat->total(),0,',','.') }} berkas</span>
        <div class="pgn">
          <a href="{{ $riwayat->previousPageUrl() ?: '#' }}" class="{{ $riwayat->onFirstPage()?'dis':'' }}">‹ Sebelumnya</a>
          @foreach($hal as $p)
            @if($p-$prev>1)<span>…</span>@endif
            <a href="{{ $riwayat->url($p) }}" class="{{ $p===$cur?'on':'' }}">{{ $p }}</a>
            @php $prev = $p; @endphp
          @endforeach
          <a href="{{ $riwayat->nextPageUrl() ?: '#' }}" class="{{ $riwayat->hasMorePages()?'':'dis' }}">Selanjutnya ›</a>
        </div>
      </div>
      @endif
    </section>

  </div>
</div>

{{-- ======================= DIALOG PANDUAN ======================= --}}
<dialog id="dlgPanduan" aria-labelledby="dlgJudul">
  <h3 id="dlgJudul">Panduan Validasi Format</h3>
  <p>Agar berkas lolos pemeriksaan otomatis dan cepat diverifikasi petugas:</p>
  <ul>
    <li>Format yang diterima: <b>PDF, JPG, JPEG, PNG</b>.</li>
    <li>Ukuran maksimal <b>5 MB</b> per berkas.</li>
    <li>Satu jenis dokumen per siswa. Unggahan baru <b>menggantikan</b> berkas lama dan kembali ke antrean verifikasi.</li>
    <li>Pindai tegak lurus, tidak buram, seluruh sisi dokumen terlihat, dan teks terbaca jelas.</li>
    <li>Pas foto: latar merah atau biru sesuai ketentuan madrasah.</li>
  </ul>
  <div class="end"><button type="button" class="btn g" id="btnTutupPanduan">Mengerti</button></div>
</dialog>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>window.UPLOAD = @json($config);</script>
@include('partials.upload-dokumen-script')
</body>
</html>