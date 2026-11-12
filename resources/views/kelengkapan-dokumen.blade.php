<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Kelengkapan Dokumen | MAS YPI SUMBER HARJO</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script>document.documentElement.classList.add('js');</script>
@include('partials.kelengkapan-dokumen-style')
</head>
<body>
@php
/* ---------- Pembantu tampilan ---------- */
use App\Http\Controllers\KelengkapanDokumenController as KD;

$ic    = fn ($n) => '<svg class="i"><use href="#'.$n.'"/></svg>';
$nama  = auth()->user()->name;
$hit   = $ringkas['hit'];
$total = $ringkas['total'];
$pc    = fn ($n) => $total > 0 ? rtrim(rtrim(number_format($n / $total * 100, 1, ',', ''), '0'), ',') : '0';
$lebar = fn ($n) => $total > 0 ? round($n / $total * 100, 2) : 0;
$u     = fn ($x = []) => route('kelengkapan.dokumen', array_filter(array_merge(request()->except('page', 'pilih'), $x), fn ($v) => $v !== null && $v !== ''));

$ikon  = ['sah' => 'okc', 'menunggu' => 'clock', 'revisi' => 'xc', 'kosong' => 'minc'];
$ketSt = ['sah' => 'Terverifikasi', 'menunggu' => 'Menunggu verifikasi', 'revisi' => 'Perlu revisi', 'kosong' => 'Belum diunggah'];
$filterAktif = request()->hasAny(['q', 'kelas', 'angkatan', 'status', 'fokus']);

/* ---------- Konfigurasi untuk JavaScript ---------- */
$config = [
    'detail'      => $detail,
    'pilih'       => $idPilih,
    'putuskanUrl' => route('arsip.digital.putuskan', 0),
    'csrf'        => csrf_token(),
    'petugas'     => $nama,
];
@endphp

@include('partials.sidebar')

{{-- Ikon tambahan khusus halaman ini --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="bell" viewBox="0 0 24 24"><path d="M6 17V11a6 6 0 0112 0v6l2 2H4zM10 21h4"/></symbol>
  <symbol id="shield" viewBox="0 0 24 24"><path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M8.5 12l2.5 2.5 4.5-5"/></symbol>
  <symbol id="alert" viewBox="0 0 24 24"><path d="M12 3l10 18H2z"/><path d="M12 10v5M12 18v.01"/></symbol>
  <symbol id="okc" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M8 12.5l2.8 2.8L16 9.5"/></symbol>
  <symbol id="clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></symbol>
  <symbol id="minc" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M8 12h8"/></symbol>
  <symbol id="xc" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7.5v5.5M12 16.5v.01"/></symbol>
  <symbol id="eye" viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></symbol>
  <symbol id="ext" viewBox="0 0 24 24"><path d="M14 4h6v6M20 4l-9 9M18 14v5a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h5"/></symbol>
  <symbol id="redo" viewBox="0 0 24 24"><path d="M3 12a9 9 0 109-9M3 4v5h5"/></symbol>
  <symbol id="refresh" viewBox="0 0 24 24"><path d="M20 12a8 8 0 11-3-6.2M20 4v5h-5"/></symbol>
  <symbol id="filter" viewBox="0 0 24 24"><path d="M3 5h18l-7 8v6l-4-2v-4z"/></symbol>
  <symbol id="info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8v.01"/></symbol>
  <symbol id="back" viewBox="0 0 24 24"><path d="M19 12H5m0 0l6-6m-6 6l6 6"/></symbol>
  <symbol id="chevd" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></symbol>
  <symbol id="send" viewBox="0 0 24 24"><path d="M21 3L10 14M21 3l-7 18-4-7-7-4z"/></symbol>
  <symbol id="print" viewBox="0 0 24 24"><path d="M6 9V3h12v6M6 18H4v-8h16v8h-2M8 14h8v7H8z"/></symbol>
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
    <a href="{{ $u(['fokus' => 'segera']) }}" class="bell" title="Siswa perlu tindak lanjut">{!! $ic('bell') !!}@if($ringkas['segera']>0)<b>{{ $ringkas['segera']>99?'99+':$ringkas['segera'] }}</b>@endif</a>
    <div class="user">
      <div class="av">{{ strtoupper(substr($nama,0,1)) }}</div>
      <div><b>{{ $nama }}</b><small>Administrator</small></div>
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit">Keluar</button></form>
    </div>
  </header>

  <div class="wrap">

    {{-- ======================= JUDUL HALAMAN ======================= --}}
    <nav class="crumb rv" aria-label="Breadcrumb"><span>Dashboard</span>/<span>Arsip Digital & Fisik</span>/<b>Kelengkapan Dokumen</b></nav>

    <section class="head rv" style="--d:60ms">
      <div>
        <h1><span class="ttl">Kelengkapan Dokumen Siswa</span> <span class="tag ok">{!! $ic('shield') !!} Audit Kelengkapan Arsip</span></h1>
        <span class="tag bl ta">TA 2026/2027 Ganjil</span>
        <p>Pantau kelengkapan arsip siswa, periksa status verifikasi dokumen, dan tindak lanjuti berkas yang belum lengkap dalam satu halaman kendali kearsipan terpusat.</p>
      </div>
      <div class="hact">
        <button type="button" class="btn" id="btnPanduan">{!! $ic('info') !!}Panduan</button>
        <button type="button" class="btn" id="btnPengingat">{!! $ic('bell') !!}Pengingat Massal</button>
        <details class="dd" id="ddEkspor">
          <summary class="btn g">{!! $ic('download') !!}Ekspor Laporan {!! $ic('chevd') !!}</summary>
          <div class="menu">
            <a href="{{ route('kelengkapan.dokumen.ekspor', request()->except('page','pilih')) }}">{!! $ic('file') !!}Unduh CSV (Excel)</a>
            <button type="button" id="btnCetak">{!! $ic('print') !!}Cetak Laporan / Simpan PDF</button>
          </div>
        </details>
      </div>
    </section>

    @if(session('status'))<div class="flash rv" role="status">{!! $ic('check') !!}{{ session('status') }}</div>@endif
    @if($errors->any())<div class="flash err rv" role="alert">{!! $ic('alert') !!}{{ $errors->first() }}</div>@endif

    {{-- ======================= KARTU KPI ======================= --}}
    <section class="kpis">
      <div class="card kpi rv" style="--t:#334e8a;--t2:#e0e9ff;--d:100ms">
        <span class="l">TOTAL SISWA</span><span class="ico">{!! $ic('users') !!}</span>
        <strong><span data-count="{{ $total }}">{{ number_format($total,0,',','.') }}</span><small>Siswa</small></strong>
        <div class="n">Berdasarkan filter yang dipilih</div>
      </div>
      <div class="card kpi rv" style="--t:#0f7a4f;--t2:#d9f5e8;--d:170ms">
        <span class="l">DOKUMEN LENGKAP</span><span class="ico">{!! $ic('okc') !!}</span>
        <strong><span data-count="{{ $hit['lengkap'] }}">{{ number_format($hit['lengkap'],0,',','.') }}</span><em>{{ $pc($hit['lengkap']) }}%</em></strong>
        <div class="n">Semua berkas wajib terverifikasi</div>
      </div>
      <div class="card kpi rv" style="--t:#d97706;--t2:#fef3c7;--d:240ms">
        <span class="l">BELUM LENGKAP</span><span class="ico">{!! $ic('alert') !!}</span>
        <strong><span data-count="{{ $hit['belum'] }}">{{ number_format($hit['belum'],0,',','.') }}</span><em>{{ $pc($hit['belum']) }}%</em></strong>
        <div class="n">Terdapat berkas belum diunggah</div>
      </div>
      <div class="card kpi rv" style="--t:#2563eb;--t2:#dbeafe;--d:310ms">
        <span class="l">MENUNGGU VERIFIKASI</span><span class="ico">{!! $ic('clock') !!}</span>
        <strong><span data-count="{{ $hit['menunggu'] }}">{{ number_format($hit['menunggu'],0,',','.') }}</span><em>{{ $pc($hit['menunggu']) }}%</em></strong>
        <div class="n">Menunggu persetujuan staf TU</div>
      </div>
      <div class="card kpi rv" style="--t:#dc2626;--t2:#fee2e2;--d:380ms">
        <span class="l">PERLU PERBAIKAN</span><span class="ico">{!! $ic('xc') !!}</span>
        <strong><span data-count="{{ $hit['revisi'] }}">{{ number_format($hit['revisi'],0,',','.') }}</span><em>{{ $pc($hit['revisi']) }}%</em></strong>
        <div class="n">Berkas ditolak / tidak terbaca</div>
      </div>
    </section>

    <div class="info rv" style="--d:420ms">
      <span>{!! $ic('info') !!}Statistik dihitung langsung dari database berdasarkan cakupan filter yang dipilih.</span>
      <span>Sinkronisasi terakhir: Hari ini, {{ $ringkas['sinkron'] }}</span>
    </div>

    {{-- ======================= RINGKASAN KELENGKAPAN ARSIP ======================= --}}
    <section class="card rk rv" style="--d:80ms">
      <div class="rk-h">
        <div>
          <h2>{!! $ic('check') !!}Ringkasan Kelengkapan Arsip Madrasah</h2>
          <p>Sebanyak <b>{{ number_format($hit['lengkap'],0,',','.') }} dari {{ number_format($total,0,',','.') }} siswa</b> sasaran audit telah memenuhi 100% persyaratan dokumen wajib terverifikasi sah.</p>
        </div>
        <div class="rk-big"><strong><span data-count="{{ round($total>0?$hit['lengkap']/$total*100:0) }}" data-suf="%">{{ round($total>0?$hit['lengkap']/$total*100:0) }}%</span></strong><span>Siswa dengan arsip lengkap</span></div>
      </div>

      <div class="seg" role="img" aria-label="Komposisi kelengkapan arsip siswa">
        <i class="c-lengkap"  style="--w:{{ $lebar($hit['lengkap']) }}%"  title="Lengkap"></i>
        <i class="c-menunggu" style="--w:{{ $lebar($hit['menunggu']) }}%" title="Menunggu verifikasi"></i>
        <i class="c-belum"    style="--w:{{ $lebar($hit['belum']) }}%"    title="Belum lengkap"></i>
        <i class="c-revisi"   style="--w:{{ $lebar($hit['revisi']) }}%"   title="Perlu revisi"></i>
      </div>
      <div class="lg">
        <span><i style="background:#0a6b45"></i>{{ $pc($hit['lengkap']) }}% Lengkap (Terverifikasi)</span>
        <span><i style="background:#2563eb"></i>{{ $pc($hit['menunggu']) }}% Menunggu Verifikasi</span>
        <span><i style="background:#d97706"></i>{{ $pc($hit['belum']) }}% Belum Diunggah</span>
        <span><i style="background:#dc2626"></i>{{ $pc($hit['revisi']) }}% Perlu Revisi / Buram</span>
      </div>

      <div class="minis">
        <div class="mi k1"><div><small>Siswa Butuh Tindak Lanjut</small><b>{{ number_format($ringkas['segera'],0,',','.') }} Siswa</b></div>{!! $ic('users') !!}</div>
        <div class="mi k2"><div><small>Berkas Wajib Belum Diunggah</small><b>{{ number_format($ringkas['slot']['kosong'],0,',','.') }} Berkas</b></div>{!! $ic('upload') !!}</div>
        <div class="mi k3"><div><small>Berkas Antrean Verifikasi</small><b>{{ number_format($ringkas['slot']['menunggu'],0,',','.') }} Berkas</b></div>{!! $ic('file') !!}</div>
        <div class="mi k4"><div><small>Berkas Perlu Perbaikan</small><b>{{ number_format($ringkas['slot']['revisi'],0,',','.') }} Berkas</b></div>{!! $ic('redo') !!}</div>
      </div>
    </section>

    {{-- ======================= FILTER ======================= --}}
    <section class="card flt rv" style="--d:80ms">
      <nav class="tabs" aria-label="Cakupan siswa">
        <a href="{{ $u(['cakupan'=>'aktif']) }}" class="{{ request('cakupan')==='aktif'?'on':'' }}">Siswa Aktif ({{ number_format($jumlahTab['aktif'],0,',','.') }} Siswa)</a>
        <a href="{{ $u(['cakupan'=>null]) }}" class="{{ request('cakupan')==='aktif'?'':'on' }}">Semua Siswa ({{ number_format($jumlahTab['semua'],0,',','.') }} Siswa)</a>
      </nav>

      <div class="quick">
        <span>Filter Cepat:</span>
        <a class="chip amb {{ request('fokus')==='segera'?'on':'' }}" href="{{ $u(['fokus'=>'segera','status'=>null]) }}">Perlu Tindak Lanjut Segera ({{ $ringkas['segera'] }})</a>
        <a class="chip bl {{ request('status')==='menunggu'?'on':'' }}" href="{{ $u(['status'=>'menunggu','fokus'=>null]) }}">Menunggu Verifikasi ({{ $hit['menunggu'] }})</a>
        <a class="chip {{ request('status')==='revisi'?'on':'' }}" href="{{ $u(['status'=>'revisi','fokus'=>null]) }}">Perlu Revisi ({{ $hit['revisi'] }})</a>
        <a class="chip bl {{ request('fokus')==='ijazah'?'on':'' }}" href="{{ $u(['fokus'=>'ijazah','status'=>null]) }}">Pending Verifikasi Ijazah ({{ $ringkas['ijazah'] }})</a>
      </div>

      <form method="GET" action="{{ route('kelengkapan.dokumen') }}" class="frow" id="formFilter">
        @if(request('cakupan'))<input type="hidden" name="cakupan" value="{{ request('cakupan') }}">@endif
        @if(request('fokus'))<input type="hidden" name="fokus" value="{{ request('fokus') }}">@endif
        <input type="hidden" name="per" value="{{ $per }}">
        <label class="fsearch">{!! $ic('search') !!}<input type="search" id="cariTabel" name="q" value="{{ request('q') }}" placeholder="Cari nama siswa, NIS, NISN, atau kelas..." aria-label="Cari siswa"><kbd>Ctrl K</kbd></label>
        <select name="kelas" aria-label="Kelas"><option value="">Semua Kelas</option>@foreach($daftarKelas as $k)<option value="{{ $k }}" @selected(request('kelas')===$k)>{{ $k }}</option>@endforeach</select>
        <select name="status" aria-label="Status dokumen"><option value="">Semua Status Dokumen</option>@foreach(KD::STATUS as $kode=>$lb)<option value="{{ $kode }}" @selected(request('status')===$kode)>{{ $lb }}</option>@endforeach</select>
        <select name="angkatan" aria-label="Angkatan"><option value="">Semua Angkatan</option>@foreach($daftarAngkatan as $a)<option value="{{ $a }}" @selected((string)request('angkatan')===(string)$a)>{{ $a }}</option>@endforeach</select>
        <button type="submit" class="btn g">{!! $ic('filter') !!}Terapkan</button>
        <a href="{{ route('kelengkapan.dokumen') }}" class="icobtn" title="Reset filter" aria-label="Reset filter">{!! $ic('refresh') !!}</a>
      </form>
    </section>

    {{-- ======================= TABEL + PANEL DETAIL ======================= --}}
    <div class="layout" id="tabel">

      {{-- ---------- Tabel siswa ---------- --}}
      <section class="card tb rv" style="--d:80ms">
        <div class="tb-h">
          <h2>Data Berkas Persyaratan Siswa <span class="tag bl">{{ $halaman->count() }} Baris Ditampilkan</span></h2>
          <a href="{{ $u() }}#tabel" class="icobtn" title="Muat ulang data" aria-label="Muat ulang data">{!! $ic('refresh') !!}</a>
        </div>

        <div class="scroll">
        <table class="tbl">
          <thead>
            <tr>
              <th>NO</th><th>IDENTITAS SISWA</th><th>PROGRESS</th>
              @foreach(KD::KOLOM as $jenis=>$singkat)<th class="c" title="{{ $jenis }}">{{ $singkat }}</th>@endforeach
              <th>STATUS</th><th>AKSI</th>
            </tr>
          </thead>
          <tbody>
          @forelse($halaman as $i => $r)
            @php $m = $r['model']; @endphp
            <tr data-id="{{ $m->id }}" class="{{ $m->id===$idPilih?'act':'' }}" style="--i:{{ $i }}">
              <td class="no">{{ $halaman->firstItem()+$i }}</td>
              <td><div class="idn"><img src="{{ $m->foto_url }}" alt="" loading="lazy"><div><b>{{ $m->nama }}</b><small>NIS: {{ $m->nis }}</small><em>{{ $m->kelas }}</em></div></div></td>
              <td><div class="mp"><b>{{ $r['n']['sah'] }}/{{ $r['total'] }} ({{ $r['persen'] }}%)</b><div class="track"><i class="{{ $r['status'] }}" style="--w:{{ $r['persen'] }}%"></i></div></div></td>
              @foreach(array_keys(KD::KOLOM) as $c => $jenis)
                @php $g = $r['sel'][$jenis]; @endphp
                <td class="c"><span class="mk {{ $g }}" style="--c:{{ $c }}" title="{{ $jenis }}: {{ $ketSt[$g] }}">{!! $ic($ikon[$g]) !!}</span></td>
              @endforeach
              <td><span class="st {{ $r['status'] }}">{{ KD::STATUS[$r['status']] }}</span></td>
              <td><div class="aks">
                <a href="{{ route('upload.dokumen',['siswa'=>$m->id]) }}#unggah" title="Upload berkas siswa" aria-label="Upload berkas">{!! $ic('upload') !!}</a>
                <a href="{{ route('siswa.detail',['id'=>$m->id]) }}" title="Profil siswa" aria-label="Profil siswa">{!! $ic('user') !!}</a>
              </div></td>
            </tr>
          @empty
            <tr><td colspan="{{ 5 + count(KD::KOLOM) }}"><div class="empty"><b>Tidak ada siswa yang cocok</b>@if($filterAktif)Ubah atau reset filter untuk melihat seluruh siswa.@else Belum ada data siswa aktif.@endif</div></td></tr>
          @endforelse
          </tbody>
        </table>
        </div>

        @if($halaman->total()>0)
        @php
          $cur = $halaman->currentPage(); $last = $halaman->lastPage();
          $nomor = collect([1,$cur-1,$cur,$cur+1,$last])->filter(fn($p)=>$p>=1&&$p<=$last)->unique()->sort()->values(); $prev = 0;
        @endphp
        <div class="pg">
          <span>Menampilkan {{ $halaman->firstItem() }} - {{ $halaman->lastItem() }} dari {{ number_format($halaman->total(),0,',','.') }} siswa terpantau</span>
          <form method="GET" action="{{ route('kelengkapan.dokumen') }}">
            @foreach(request()->except('per','page','pilih') as $kk=>$vv)<input type="hidden" name="{{ $kk }}" value="{{ $vv }}">@endforeach
            <label>Tampilkan:<select name="per" onchange="this.form.submit()">@foreach([10,25,50] as $n)<option value="{{ $n }}" @selected($per===$n)>{{ $n }} baris</option>@endforeach</select></label>
          </form>
          <div class="pgn">
            <a href="{{ $halaman->previousPageUrl() ?: '#' }}" class="{{ $halaman->onFirstPage()?'dis':'' }}">‹ Sebelumnya</a>
            @foreach($nomor as $p)
              @if($p-$prev>1)<span>…</span>@endif
              <a href="{{ $halaman->url($p) }}" class="{{ $p===$cur?'on':'' }}">{{ $p }}</a>
              @php $prev = $p; @endphp
            @endforeach
            <a href="{{ $halaman->nextPageUrl() ?: '#' }}" class="{{ $halaman->hasMorePages()?'':'dis' }}">Selanjutnya ›</a>
          </div>
        </div>
        @endif
      </section>

      {{-- ---------- Panel detail (diisi JavaScript) ---------- --}}
      <aside class="card dp rv" id="panelDetail" style="--d:160ms" aria-live="polite" aria-label="Detail kelengkapan siswa"></aside>
    </div>

    <footer class="foot rv">
      <span>{!! $ic('shield') !!}<b>SIADDS MAS YPI SUMBER HARJO</b> — Sistem Pemantauan Retensi & Validasi Dokumen Terpusat.</span>
      <span>Seluruh dokumen digital disimpan di server lokal madrasah dan hanya dapat diakses oleh petugas yang berwenang.</span>
    </footer>

  </div>
</div>

{{-- ======================= DIALOG PANDUAN ======================= --}}
<dialog id="dlgPanduan" aria-labelledby="dlgPanduanJudul">
  <h3 id="dlgPanduanJudul">Panduan Membaca Kelengkapan</h3>
  <p>Kelengkapan dihitung dari <b>{{ count(KD::KOLOM) }} dokumen wajib</b> tiap siswa. Status satu siswa ditentukan dengan urutan prioritas berikut:</p>
  <ul class="pl">
    <li><span class="st revisi">Perlu Revisi</span> — ada dokumen yang ditolak verifikator.</li>
    <li><span class="st belum">Belum Lengkap</span> — ada dokumen wajib yang belum diunggah.</li>
    <li><span class="st menunggu">Menunggu Verifikasi</span> — semua sudah diunggah, sebagian belum diperiksa.</li>
    <li><span class="st lengkap">Lengkap</span> — semua dokumen wajib sudah terverifikasi sah.</li>
  </ul>
  <p>Angka <b>progress</b> menunjukkan jumlah dokumen yang sudah terverifikasi sah dari seluruh dokumen wajib. Klik baris siswa untuk membuka checklist dan memverifikasi berkasnya di panel kanan.</p>
  <div class="end"><button type="button" class="btn g" data-tutup>Mengerti</button></div>
</dialog>

{{-- ======================= DIALOG PENGINGAT MASSAL ======================= --}}
<dialog id="dlgPengingat" aria-labelledby="dlgPengingatJudul">
  <h3 id="dlgPengingatJudul">Pengingat Massal ke Wali Siswa</h3>
  <p>Daftar siswa yang <b>belum lengkap</b> atau <b>perlu revisi</b> sesuai filter saat ini ({{ number_format($pengingat['jumlah'],0,',','.') }} siswa). Tiap tombol membuka WhatsApp dengan pesan yang sudah terisi daftar berkas yang kurang; pesan dikirim manual oleh petugas.</p>
  @if($pengingat['jumlah']>0)
  <ul class="pgl">
    @foreach($pengingat['daftar'] as $p)
      <li>
        <div><b>{{ $p['nama'] }}</b><small>{{ $p['kelas'] }} • {{ $p['kurang'] }} berkas kurang</small></div>
        @if($p['wa'])<a href="{{ $p['wa'] }}" target="_blank" rel="noopener" class="btn sm">{!! $ic('send') !!}Kirim WA</a>
        @else<small class="mu">Tidak ada no. HP wali</small>@endif
      </li>
    @endforeach
  </ul>
  @if($pengingat['jumlah']>$pengingat['batas'])<p>Menampilkan {{ $pengingat['batas'] }} siswa pertama. Persempit filter (kelas atau angkatan) untuk melihat sisanya.</p>@endif
  @else
  <p>Tidak ada siswa yang perlu diingatkan pada filter ini.</p>
  @endif
  <div class="end"><button type="button" class="btn g" data-tutup>Tutup</button></div>
</dialog>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>window.KELENGKAPAN = @json($config);</script>
@include('partials.kelengkapan-dokumen-script')
@include('partials.kelengkapan-dokumen-foto')
</body>
</html>