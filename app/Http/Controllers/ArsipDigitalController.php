<?php

namespace App\Http\Controllers;

use App\Models\ArsipFisik;
use App\Models\SiswaAktif;
use App\Models\SiswaDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArsipDigitalController extends Controller
{
    /** Status yang dianggap sah. Status 'revisi' = perlu perbaikan, sisanya = menunggu. */
    public const SAH    = ['valid', 'tambahan'];
    public const REVISI = 'revisi';

    /** Kategori kartu "Kategori Dokumen Utama". 'jenis' null = semua jenis di luar kategori lain. */
    public const KATEGORI = [
        'kk'     => ['label' => 'Kartu Keluarga',   'sub' => 'Identitas keluarga',          'short' => 'KK',        'icon' => 'users',  'jenis' => ['Kartu Keluarga (KK)']],
        'akta'   => ['label' => 'Akta Kelahiran',   'sub' => 'Legalitas Dukcapil',          'short' => 'Akta',      'icon' => 'file',   'jenis' => ['Akta Kelahiran']],
        'ijazah' => ['label' => 'Ijazah / SKL',     'sub' => 'Jenjang MTs/SMP',             'short' => 'Ijazah/SKL','icon' => 'file',   'jenis' => ['Ijazah / SKL MTs']],
        'foto'   => ['label' => 'Pas Foto Resmi',   'sub' => '3x4 Merah/Biru',              'short' => 'Pas Foto',  'icon' => 'user',   'jenis' => ['Pas Foto Resmi 3x4']],
        'ktp'    => ['label' => 'KTP Wali Murid',   'sub' => 'Ayah / Ibu / Wali',           'short' => 'KTP Ortu',  'icon' => 'users',  'jenis' => ['KTP Orang Tua (Ayah & Ibu)']],
        'lain'   => ['label' => 'Berkas Pendukung', 'sub' => 'KIP, PKH, Surat Pernyataan',  'short' => 'Pendukung', 'icon' => 'folder', 'jenis' => null],
    ];

    /** Batas aman untuk unduhan ZIP (dalam byte). */
    private const BATAS_ZIP = 300 * 1024 * 1024;

    public static function kunci(?string $jenis): string
    {
        foreach (self::KATEGORI as $k => $m) {
            if ($m['jenis'] && in_array($jenis, $m['jenis'], true)) {
                return $k;
            }
        }
        return 'lain';
    }

    public static function golongan(?string $status): string
    {
        if (in_array($status, self::SAH, true)) return 'sah';
        return $status === self::REVISI ? 'revisi' : 'menunggu';
    }

    /* ======================================================================
       HALAMAN UTAMA
       ====================================================================== */
    public function index(Request $request)
    {
        $per = (int) $request->query('per', 10);
        $per = in_array($per, [10, 25, 50], true) ? $per : 10;

        $dokumen = $this->saring($request)
            ->with('siswa')
            ->orderByDesc('updated_at')->orderByDesc('id')
            ->paginate($per)->withQueryString()->fragment('daftar');

        /* Ringkasan total & per kategori (satu query) */
        $ringkas = ['total' => 0, 'sah' => 0, 'menunggu' => 0, 'revisi' => 0];
        $kat = [];
        foreach (self::KATEGORI as $k => $_) {
            $kat[$k] = ['total' => 0, 'sah' => 0, 'menunggu' => 0, 'revisi' => 0];
        }
        $rows = SiswaDokumen::selectRaw('jenis, status, COUNT(*) as n')->groupBy('jenis', 'status')->get();
        foreach ($rows as $row) {
            $g = self::golongan($row->status);
            $k = self::kunci($row->jenis);
            $ringkas['total'] += $row->n;  $ringkas[$g] += $row->n;
            $kat[$k]['total'] += $row->n;  $kat[$k][$g]  += $row->n;
        }

        /* Dokumen aktif untuk panel pratinjau (baris halaman ini + yang dipilih) */
        $kumpulan = $dokumen->getCollection()->keyBy('id');
        $pilih    = (int) $request->query('pilih');
        $idAktif  = $kumpulan->has($pilih) ? $pilih : null;

        if ($pilih && ! $idAktif && ($ekstra = SiswaDokumen::with('siswa')->find($pilih))) {
            $kumpulan->put($pilih, $ekstra);
            $idAktif = $pilih;
        }
        if (! $idAktif && $dokumen->first()) {
            $idAktif = $dokumen->first()->id;
        }

        $fisik  = $this->petaFisik($kumpulan);
        $noReg  = $this->petaNoReg($kumpulan);
        $detail = [];
        foreach ($kumpulan as $id => $d) {
            $detail[$id] = $this->detail($d, $fisik, $noReg, (int) $id === (int) $idAktif);
        }

        return view('arsip-digital', [
            'dokumen'     => $dokumen,
            'ringkas'     => $ringkas,
            'kat'         => $kat,
            'detail'      => $detail,
            'idAktif'     => $idAktif,
            'daftarKelas' => SiswaAktif::whereNotNull('kelas')->distinct()->orderBy('kelas')->pluck('kelas'),
            'per'         => $per,
        ]);
    }

    /* ======================================================================
       BERKAS: LIHAT, UNDUH, HASH
       ====================================================================== */
    public function lihat(int $id)
    {
        $dok = SiswaDokumen::findOrFail($id);
        abort_unless($dok->path && Storage::disk('public')->exists($dok->path), 404, 'Berkas tidak ditemukan di penyimpanan.');

        return response()->file(Storage::disk('public')->path($dok->path));
    }

    public function unduh(int $id)
    {
        $dok = SiswaDokumen::findOrFail($id);
        abort_unless($dok->path && Storage::disk('public')->exists($dok->path), 404, 'Berkas tidak ditemukan di penyimpanan.');

        return Storage::disk('public')->download($dok->path, $dok->nama_file ?: basename($dok->path));
    }

    /** Hash SHA-256 satu berkas (dipanggil JavaScript saat baris dipilih). */
    public function hash(int $id)
    {
        $dok  = SiswaDokumen::findOrFail($id);
        $hash = $dok->path ? $this->hitungHash($dok->path) : null;

        return response()->json(['hash' => $hash]);
    }

    /* ======================================================================
       VERIFIKASI: SATUAN DAN MASSAL
       ====================================================================== */

    /** Simpan keputusan verifikator: Sah / Minta Revisi + catatan. */
    public function putuskan(Request $request, int $id)
    {
        $data = $request->validate([
            'keputusan' => 'required|in:valid,revisi',
            'catatan'   => 'nullable|string|max:500|required_if:keputusan,revisi',
        ], [
            'required_if' => 'Catatan wajib diisi saat meminta revisi.',
            'max'         => 'Catatan maksimal 500 karakter.',
        ]);

        $dok = SiswaDokumen::findOrFail($id);
        $dok->status            = $data['keputusan'];
        $dok->catatan           = $data['catatan'] ?? null;
        $dok->diverifikasi_oleh = optional(auth()->user())->name ?? 'Admin';
        $dok->save();

        $pesan = $data['keputusan'] === 'valid'
            ? "Dokumen {$dok->jenis} dinyatakan sah."
            : "Dokumen {$dok->jenis} dikembalikan untuk revisi.";

        return redirect()->to($this->kembaliKeDaftar())->with('status', $pesan);
    }

    /** Verifikasi beberapa dokumen sekaligus (Sah / Minta Revisi). */
    public function massal(Request $request)
    {
        $data = $request->validate([
            'ids'       => 'required|array|min:1|max:500',
            'ids.*'     => 'integer|exists:siswa_dokumen,id',
            'keputusan' => 'required|in:valid,revisi',
            'catatan'   => 'nullable|string|max:500|required_if:keputusan,revisi',
        ], [
            'ids.required' => 'Pilih minimal satu dokumen.',
            'ids.min'      => 'Pilih minimal satu dokumen.',
            'ids.max'      => 'Maksimal 500 dokumen dalam satu kali proses.',
            'required_if'  => 'Catatan wajib diisi saat meminta revisi.',
            'max'          => 'Catatan maksimal 500 karakter.',
        ]);

        $jumlah = SiswaDokumen::whereIn('id', array_unique($data['ids']))->update([
            'status'            => $data['keputusan'],
            'catatan'           => $data['catatan'] ?? null,
            'diverifikasi_oleh' => optional(auth()->user())->name ?? 'Admin',
        ]);

        $pesan = $data['keputusan'] === 'valid'
            ? "{$jumlah} dokumen dinyatakan sah."
            : "{$jumlah} dokumen dikembalikan untuk revisi.";

        return redirect()->to($this->kembaliKeDaftar())->with('status', $pesan);
    }

    /* ======================================================================
       UNDUH ZIP (dokumen terpilih)
       ====================================================================== */
    public function zip(Request $request)
    {
        $data = $request->validate([
            'ids'   => 'required|array|min:1|max:500',
            'ids.*' => 'integer|exists:siswa_dokumen,id',
        ], ['required' => 'Pilih minimal satu dokumen.', 'min' => 'Pilih minimal satu dokumen.']);

        if (! class_exists(\ZipArchive::class)) {
            return back()->withErrors(['ids' => 'Ekstensi ZIP pada PHP belum aktif. Aktifkan extension=zip di php.ini, lalu mulai ulang server.']);
        }

        $disk = Storage::disk('public');
        $docs = SiswaDokumen::with('siswa:id,nis,nama')->whereIn('id', array_unique($data['ids']))->get();

        $berkas = $docs->filter(fn ($d) => $d->path && $disk->exists($d->path))->values();
        if ($berkas->isEmpty()) {
            return back()->withErrors(['ids' => 'Berkas fisik dari dokumen yang dipilih tidak ditemukan di penyimpanan.']);
        }
        if ($berkas->sum(fn ($d) => $disk->size($d->path)) > self::BATAS_ZIP) {
            return back()->withErrors(['ids' => 'Total ukuran berkas melebihi 300 MB. Pilih lebih sedikit dokumen.']);
        }

        $tmp = tempnam(sys_get_temp_dir(), 'siadds');
        $zip = new \ZipArchive();
        if ($zip->open($tmp, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return back()->withErrors(['ids' => 'Gagal membuat berkas ZIP sementara.']);
        }

        $dipakai = [];
        foreach ($berkas as $d) {
            $ext    = strtolower(pathinfo((string) ($d->nama_file ?: $d->path), PATHINFO_EXTENSION)) ?: 'bin';
            $folder = $d->siswa ? $d->siswa->nis . '_' . Str::slug($d->siswa->nama, '-') : 'tanpa-siswa';
            $dasar  = $folder . '/' . Str::slug($d->jenis, '-');
            $entri  = $dasar . '.' . $ext;
            for ($n = 2; isset($dipakai[$entri]); $n++) {
                $entri = $dasar . '-' . $n . '.' . $ext;
            }
            $dipakai[$entri] = true;
            $zip->addFile($disk->path($d->path), $entri);
        }
        $zip->close();

        return response()->download($tmp, 'arsip-digital-' . now()->format('Ymd-His') . '.zip')->deleteFileAfterSend(true);
    }

    /* ======================================================================
       EKSPOR DAFTAR (CSV, mengikuti filter aktif)
       ====================================================================== */
    public function ekspor(Request $request)
    {
        $nama = 'direktori-arsip-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($request) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['No', 'Jenis Dokumen', 'Nama File', 'Ukuran', 'Nama Siswa', 'NIS', 'Kelas', 'Status', 'Tanggal Unggah', 'Petugas', 'Catatan']);
            $no = 0;
            $this->saring($request)->with('siswa:id,nis,nama,kelas')->orderBy('id')->chunk(500, function ($rows) use ($out, &$no) {
                foreach ($rows as $d) {
                    fputcsv($out, [
                        ++$no, $d->jenis, $d->nama_file, $d->ukuran,
                        optional($d->siswa)->nama, optional($d->siswa)->nis, optional($d->siswa)->kelas,
                        ucfirst(self::golongan($d->status)),
                        optional($d->tanggal_unggah)->format('d-m-Y'), $d->diunggah_oleh, $d->catatan,
                    ]);
                }
            });
            fclose($out);
        }, $nama, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /* ======================================================================
       PEMBANTU
       ====================================================================== */

    private function jenisUtama(): array
    {
        return collect(self::KATEGORI)->pluck('jenis')->filter()->flatten()->all();
    }

    /** Query dokumen dengan semua filter dari URL (dipakai halaman & ekspor). */
    private function saring(Request $r)
    {
        $query = SiswaDokumen::query();

        $kat = (string) $r->query('kategori', '');
        if (isset(self::KATEGORI[$kat])) {
            $j = self::KATEGORI[$kat]['jenis'];
            $j ? $query->whereIn('jenis', $j) : $query->whereNotIn('jenis', $this->jenisUtama());
        }

        switch ($r->query('verif', '')) {
            case 'sah':      $query->whereIn('status', self::SAH); break;
            case 'revisi':   $query->where('status', self::REVISI); break;
            case 'menunggu': $query->whereNotIn('status', array_merge(self::SAH, [self::REVISI])); break;
        }

        switch ($r->query('format', '')) {
            case 'pdf': $query->where('nama_file', 'like', '%.pdf'); break;
            case 'jpg': $query->where(fn ($w) => $w->where('nama_file', 'like', '%.jpg')->orWhere('nama_file', 'like', '%.jpeg')); break;
            case 'png': $query->where('nama_file', 'like', '%.png'); break;
        }

        if ($kelas = (string) $r->query('kelas', '')) {
            $query->whereIn('siswa_aktif_id', SiswaAktif::where('kelas', $kelas)->pluck('id'));
        }

        if ($r->boolean('baru')) {
            $query->where('created_at', '>=', now()->subDays(7));
        }

        if (($q = trim((string) $r->query('q', ''))) !== '') {
            $idSiswa = SiswaAktif::where('nama', 'like', "%{$q}%")
                ->orWhere('nis', 'like', "%{$q}%")
                ->orWhere('nisn', 'like', "%{$q}%")
                ->pluck('id')
                ->merge($this->idSiswaDariNoReg($q))      // cari lewat nomor pendaftaran (REG-...)
                ->unique();

            $query->where(function ($w) use ($q, $idSiswa) {
                $w->where('nama_file', 'like', "%{$q}%")
                  ->orWhere('jenis', 'like', "%{$q}%")
                  ->orWhereIn('siswa_aktif_id', $idSiswa);
            });
        }

        return $query;
    }

    /** Data satu dokumen untuk panel pratinjau (JSON untuk JavaScript). */
    private function detail(SiswaDokumen $d, Collection $fisik, array $noReg, bool $denganHash): array
    {
        $s   = $d->siswa;
        $ext = strtolower(pathinfo((string) ($d->nama_file ?: $d->path), PATHINFO_EXTENSION));
        $ada = (bool) ($d->path && Storage::disk('public')->exists($d->path));
        $tgl = $d->updated_at ?? $d->created_at;

        return [
            'id'        => $d->id,
            'jenis'     => $d->jenis,
            'namaFile'  => $d->nama_file,
            'ukuran'    => $d->ukuran,
            'ext'       => $ext,
            'gambar'    => in_array($ext, ['jpg', 'jpeg', 'png'], true),
            'ada'       => $ada,
            'status'    => self::golongan($d->status),
            'catatan'   => $d->catatan,
            'oleh'      => $d->diunggah_oleh,
            'tanggal'   => $tgl ? $tgl->locale('id')->translatedFormat('d M Y, H:i') : null,
            'siswa'     => $s ? ['id' => $s->id, 'nama' => $s->nama, 'nis' => $s->nis, 'kelas' => $s->kelas, 'noReg' => $noReg[$s->id] ?? null] : null,
            'fisik'     => $this->teksFisik($s, $fisik->get($d->siswa_aktif_id . '|' . $d->jenis)),
            'hash'      => ($denganHash && $ada) ? $this->hitungHash($d->path) : null,
            'url'       => [
                'lihat'  => route('arsip.digital.lihat', $d->id),
                'unduh'  => route('arsip.digital.unduh', $d->id),
                'hash'   => route('arsip.digital.hash', $d->id),
                'profil' => $s ? route('siswa.detail', ['id' => $s->id]) : null,
                'unggah' => $s ? route('upload.dokumen', ['siswa' => $s->id, 'jenis' => $d->jenis]) . '#unggah' : null,
            ],
        ];
    }

    /**
     * ID siswa aktif yang nomor pendaftarannya (REG-...) cocok dengan kata kunci.
     * Nomor tersimpan di pendaftaran.no_registrasi dan calon_siswa.reg;
     * penghubung ke siswa_aktif adalah NISN (cadangan: NIK). Nilai kosong tidak pernah dicocokkan.
     */
    private function idSiswaDariNoReg(string $q): array
    {
        if (mb_strlen($q) < 3) {
            return [];
        }

        $nisn = [];
        $nik  = [];

        if (Schema::hasTable('pendaftaran') && Schema::hasColumn('pendaftaran', 'no_registrasi')) {
            foreach (DB::table('pendaftaran')->where('no_registrasi', 'like', "%{$q}%")->limit(200)->get(['nisn', 'nik']) as $r) {
                if (filled($r->nisn)) $nisn[] = $r->nisn;
                if (filled($r->nik))  $nik[]  = $r->nik;
            }
        }
        if (Schema::hasTable('calon_siswa') && Schema::hasColumn('calon_siswa', 'reg')) {
            foreach (DB::table('calon_siswa')->where('reg', 'like', "%{$q}%")->limit(200)->pluck('nisn') as $n) {
                if (filled($n)) $nisn[] = $n;
            }
        }
        if (! $nisn && ! $nik) {
            return [];
        }

        return SiswaAktif::where(function ($w) use ($nisn, $nik) {
            if ($nisn) $w->whereIn('nisn', array_values(array_unique($nisn)));
            if ($nik)  $w->orWhereIn('nik', array_values(array_unique($nik)));
        })->pluck('id')->all();
    }

    /** Peta siswa_aktif.id => nomor pendaftaran (REG-...), dicocokkan lewat NISN lalu NIK. */
    private function petaNoReg(Collection $kumpulan): array
    {
        $siswa = $kumpulan->pluck('siswa')->filter()->unique('id');
        if ($siswa->isEmpty()) {
            return [];
        }

        $nisn = $siswa->pluck('nisn')->filter(fn ($v) => filled($v))->unique()->values()->all();
        $nik  = $siswa->pluck('nik')->filter(fn ($v) => filled($v))->unique()->values()->all();
        $byNisn = [];
        $byNik  = [];

        if (($nisn || $nik) && Schema::hasTable('pendaftaran') && Schema::hasColumn('pendaftaran', 'no_registrasi')) {
            $rows = DB::table('pendaftaran')->where(function ($w) use ($nisn, $nik) {
                if ($nisn) $w->whereIn('nisn', $nisn);
                if ($nik)  $w->orWhereIn('nik', $nik);
            })->get(['no_registrasi', 'nisn', 'nik']);

            foreach ($rows as $r) {
                if (filled($r->nisn)) $byNisn[$r->nisn] ??= $r->no_registrasi;
                if (filled($r->nik))  $byNik[$r->nik]   ??= $r->no_registrasi;
            }
        }
        if ($nisn && Schema::hasTable('calon_siswa') && Schema::hasColumn('calon_siswa', 'reg')) {
            foreach (DB::table('calon_siswa')->whereIn('nisn', $nisn)->get(['reg', 'nisn']) as $r) {
                if (filled($r->reg)) $byNisn[$r->nisn] ??= $r->reg;
            }
        }

        $peta = [];
        foreach ($siswa as $s) {
            $peta[$s->id] = ($s->nisn && isset($byNisn[$s->nisn])) ? $byNisn[$s->nisn]
                          : (($s->nik && isset($byNik[$s->nik])) ? $byNik[$s->nik] : null);
        }
        return $peta;
    }

    /** Arsip fisik dokumen ini, bila tabel Lokasi Arsip Fisik sudah dipakai. */
    private function petaFisik(Collection $kumpulan): Collection
    {
        if (! class_exists(ArsipFisik::class) || ! Schema::hasTable('arsip_fisik')) {
            return collect();
        }

        return ArsipFisik::with('rak.lemari.ruang')
            ->whereIn('siswa_aktif_id', $kumpulan->pluck('siswa_aktif_id')->unique())
            ->get()
            ->keyBy(fn ($f) => $f->siswa_aktif_id . '|' . $f->jenis);
    }

    /** Teks lokasi fisik: dari catatan arsip fisik, atau dari data lokasi pada profil siswa. */
    private function teksFisik(?SiswaAktif $s, $f): ?array
    {
        if ($f) {
            $url = route('arsip.fisik', ['q' => $f->kode_arsip]);
            if ($f->rak) {
                $rak = $f->rak; $lem = $rak->lemari; $ruang = $lem->ruang;
                return ['kode' => $f->kode_arsip, 'url' => $url, 'teks' => implode(' • ', array_filter([
                    $ruang->nama, $this->awali('Lemari', $lem->kode), $this->awali('Rak', $rak->kode),
                    $f->kode_map ? $this->awali('Map', $f->kode_map) : null,
                ]))];
            }
            return ['kode' => $f->kode_arsip, 'url' => $url, 'teks' => 'Belum ditata (' . $f->kode_arsip . ')'];
        }

        if ($s && ($s->lemari || $s->rak || $s->kode_map)) {
            return ['kode' => null, 'url' => route('arsip.fisik'), 'teks' => implode(' • ', array_filter([
                $s->lemari ? $this->awali('Lemari', $s->lemari) : null,
                $s->rak ? $this->awali('Rak', $s->rak) : null,
                $s->kode_map ? $this->awali('Map', $s->kode_map) : null,
            ]))];
        }

        return null;
    }

    /** Tambahkan awalan hanya jika nilai belum diawali kata itu (mencegah "Lemari Lemari ..."). */
    private function awali(string $awalan, ?string $nilai): string
    {
        $n = trim((string) $nilai);
        return stripos($n, $awalan) === 0 ? $n : trim($awalan . ' ' . $n);
    }

    /** SHA-256 berkas; hasilnya disimpan di cache selama berkas tidak berubah. */
    private function hitungHash(string $path): ?string
    {
        $disk = Storage::disk('public');
        if (! $disk->exists($path)) {
            return null;
        }

        $abs = $disk->path($path);
        try {
            $kunci = 'sha256:' . md5($path . '|' . @filemtime($abs) . '|' . @filesize($abs));
            return Cache::rememberForever($kunci, fn () => hash_file('sha256', $abs));
        } catch (\Throwable $e) {
            return hash_file('sha256', $abs);   // cache tidak tersedia
        }
    }

    /** Alamat kembali setelah aksi: halaman sebelumnya, langsung ke tabel jika berasal dari halaman ini. */
    private function kembaliKeDaftar(): string
    {
        $sebelumnya = url()->previous();
        return str_contains($sebelumnya, '/arsip-digital') ? $sebelumnya . '#daftar' : $sebelumnya;
    }
}