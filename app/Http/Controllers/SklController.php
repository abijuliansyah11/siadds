<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\SiswaAktif;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Surat Keterangan Lulus (SKL) — dipakai dari halaman Cetak Label QR Code.
 * Data alumni lama (tabel alumni) tidak diubah selain kolom tambahan SKL.
 */
class SklController extends Controller
{
    /** Judul kelompok mata pelajaran pada tabel nilai. */
    public const KELOMPOK = [
        'A' => 'Kelompok A (Wajib)',
        'B' => 'Kelompok B (Wajib)',
        'C' => 'Kelompok C (Peminatan)',
        'D' => 'Kelompok D (Lintas Minat)',
    ];

    /** Susunan mata pelajaran bawaan (dapat diubah per siswa di dialog). */
    public const MAPEL_AB = [
        ['k' => 'A', 'n' => "Al-Qur'an Hadis"],
        ['k' => 'A', 'n' => 'Akidah Akhlak'],
        ['k' => 'A', 'n' => 'Fikih'],
        ['k' => 'A', 'n' => 'Sejarah Kebudayaan Islam'],
        ['k' => 'A', 'n' => 'Pendidikan Pancasila dan Kewarganegaraan'],
        ['k' => 'A', 'n' => 'Bahasa Indonesia'],
        ['k' => 'A', 'n' => 'Bahasa Arab'],
        ['k' => 'A', 'n' => 'Matematika (Umum)'],
        ['k' => 'A', 'n' => 'Sejarah Indonesia'],
        ['k' => 'A', 'n' => 'Bahasa Inggris'],
        ['k' => 'B', 'n' => 'Seni Budaya'],
        ['k' => 'B', 'n' => 'Pendidikan Jasmani, Olahraga dan Kesehatan'],
        ['k' => 'B', 'n' => 'Prakarya dan Kewirausahaan'],
    ];

    public const MAPEL_C = [
        'MIPA'       => ['Matematika (Peminatan)', 'Biologi', 'Fisika', 'Kimia'],
        'IPS'        => ['Geografi', 'Sejarah (Peminatan)', 'Sosiologi', 'Ekonomi'],
        'Keagamaan'  => ["Tafsir", 'Hadis', 'Ilmu Kalam', 'Ushul Fikih'],
    ];

    public const MAPEL_D = ['Bahasa dan Sastra Inggris'];

    /** Nilai bawaan pengaturan kop & penandatangan (dapat diubah dari dialog Pengaturan). */
    public const PENGATURAN_BAWAAN = [
        'kop1'         => 'KEMENTERIAN AGAMA REPUBLIK INDONESIA',
        'kop2'         => 'KANTOR KEMENTERIAN AGAMA KABUPATEN OKU TIMUR',
        'madrasah'     => 'MADRASAH ALIYAH SWASTA YPI SUMBER HARJO',
        'alamat'       => 'Jl. Masjid Nurul Iman, Desa Sumber Harjo, Kec. Buay Madang Timur, Kab. Oku Timur',
        'npsn'         => '10648892',
        'kurikulum'    => 'Kurikulum Merdeka',
        'kota'         => 'Sumber Harjo',
        'kepala'       => '',
        'nip'          => '',
        'format_nomor' => '421.3/{urut}/MAS-SH/Kep/{tahun}',
        'logo_kiri'    => 'images/logo-kemenag.png',
        'logo_kanan'   => 'images/logo-mas-ypi.png',
        'gambar_ttd'   => '',
    ];

    /* ======================================================================
       DAFTAR ALUMNI UNTUK KARTU SKL (JSON)
       ====================================================================== */
    public function daftar(Request $request)
    {
        if ($salah = $this->belumMigrasi()) {
            return $salah;
        }

        $per   = 8;
        $tahun = (int) $request->query('tahun');
        $cari  = trim((string) $request->query('q', ''));
        $stat  = (string) $request->query('status', '');

        $dasar = Alumni::query();
        if ($tahun) {
            $dasar->where('tahun_lulus', $tahun);
        }

        $ringkas = [
            'total'    => (clone $dasar)->count(),
            'lengkap'  => $this->sqlLengkap(clone $dasar)->count(),
            'tercetak' => (clone $dasar)->whereIn('id', DB::table('skl_log')->select('alumni_id'))->count(),
        ];
        $ringkas['perlu'] = max(0, $ringkas['total'] - $ringkas['lengkap']);

        $q = clone $dasar;
        if ($cari !== '') {
            $q->where(function ($w) use ($cari) {
                $w->where('nama', 'like', "%{$cari}%")->orWhere('nis', 'like', "%{$cari}%")
                  ->orWhere('nisn', 'like', "%{$cari}%")->orWhere('nomor_skl', 'like', "%{$cari}%");
            });
        }
        if ($stat === 'belum') {
            $q->whereNotIn('id', DB::table('skl_log')->select('alumni_id'));
        } elseif ($stat === 'sudah') {
            $q->whereIn('id', DB::table('skl_log')->select('alumni_id'));
        } elseif ($stat === 'lengkapi') {
            $q->whereNotIn('id', $this->sqlLengkap(Alumni::query())->select('id'));
        }

        $hal = $q->orderByDesc('tahun_lulus')->orderBy('nama')->paginate($per);

        $ids  = $hal->pluck('id')->all();
        $logs = $ids
            ? DB::table('skl_log')->whereIn('alumni_id', $ids)
                ->selectRaw('alumni_id, count(*) as n, max(created_at) as terakhir')->groupBy('alumni_id')->get()->keyBy('alumni_id')
            : collect();

        return response()->json([
            'ok'      => true,
            'data'    => $hal->getCollection()->map(fn (Alumni $a) => $this->baris($a, $logs->get($a->id)))->values(),
            'meta'    => ['total' => $hal->total(), 'page' => $hal->currentPage(), 'last' => $hal->lastPage(), 'per' => $per],
            'tahun'   => Alumni::query()->select('tahun_lulus')->distinct()->orderByDesc('tahun_lulus')->pluck('tahun_lulus'),
            'ringkas' => $ringkas,
            'set'     => $this->pengaturan(),
        ]);
    }

    /* ======================================================================
       DETAIL / PRATINJAU DATA SATU ALUMNI (untuk dialog "Lengkapi Data")
       ====================================================================== */
    public function detail(int $id)
    {
        if ($salah = $this->belumMigrasi()) {
            return $salah;
        }

        $a     = Alumni::findOrFail($id);
        $siswa = SiswaAktif::where('nis', $a->nis)->first();
        $nilai = $this->bacaNilai($a);

        $ortu = $a->nama_orang_tua ?: ($siswa ? ($siswa->nama_orang_tua ?: ($siswa->nama_ayah ?: $siswa->nama_ibu)) : null);
        $lahir = $a->tanggal_lahir ?: ($siswa ? $siswa->tanggal_lahir : null);

        return response()->json([
            'ok'     => true,
            'alumni' => [
                'id' => $a->id, 'nama' => $a->nama, 'nis' => $a->nis, 'nisn' => $a->nisn, 'tahun_lulus' => $a->tahun_lulus,
                'kelas' => $a->kelas_terakhir,
            ],
            'form'   => [
                'tempat_lahir'      => $a->tempat_lahir ?: ($siswa ? $siswa->tempat_lahir : ''),
                'tanggal_lahir'     => $lahir ? Carbon::parse($lahir)->format('Y-m-d') : '',
                'nama_orang_tua'    => $ortu ?: '',
                'jurusan'           => $a->jurusan ?: '',
                'nomor_skl'         => $a->nomor_skl ?: '',
                'tanggal_kelulusan' => $a->tanggal_kelulusan ? $a->tanggal_kelulusan->format('Y-m-d') : '',
                'mapel'             => $nilai['mapel'] ?: $this->mapelBawaan((string) $a->jurusan),
                'tersimpan'         => $this->lengkap($a),
                'diisi_otomatis'    => ! $a->tempat_lahir && $siswa !== null,
            ],
            'bawaan' => [
                'MIPA' => $this->mapelBawaan('MIPA'), 'IPS' => $this->mapelBawaan('IPS'),
                'Keagamaan' => $this->mapelBawaan('Keagamaan'), 'Umum' => $this->mapelBawaan(''),
            ],
        ]);
    }

    /* ======================================================================
       SIMPAN DATA SKL
       ====================================================================== */
    public function simpan(Request $request, int $id)
    {
        if ($salah = $this->belumMigrasi()) {
            return $salah;
        }

        $a = Alumni::findOrFail($id);

        $d = $request->validate([
            'tempat_lahir'      => 'required|string|max:60',
            'tanggal_lahir'     => 'required|date|before:today',
            'nama_orang_tua'    => 'required|string|max:120',
            'jurusan'           => 'nullable|string|max:80',
            'nomor_skl'         => 'nullable|string|max:60',
            'tanggal_kelulusan' => 'nullable|date',
            'mapel'             => 'required|array|min:1|max:40',
            'mapel.*.k'         => 'required|in:A,B,C,D',
            'mapel.*.n'         => 'required|string|max:100',
            'mapel.*.v'         => 'required|numeric|between:0,100',
        ], [
            'required'        => ':attribute wajib diisi.',
            'mapel.required'  => 'Isi minimal satu mata pelajaran.',
            'mapel.min'       => 'Isi minimal satu mata pelajaran.',
            'before'          => 'Tanggal lahir harus sebelum hari ini.',
            'between'         => 'Nilai harus antara 0 sampai 100.',
            'numeric'         => 'Nilai harus berupa angka.',
            'max'             => ':attribute terlalu panjang.',
            'date'            => ':attribute bukan tanggal yang valid.',
        ], [
            'tempat_lahir' => 'Tempat lahir', 'tanggal_lahir' => 'Tanggal lahir', 'nama_orang_tua' => 'Nama orang tua / wali',
            'mapel.*.n' => 'Nama mata pelajaran', 'mapel.*.v' => 'Nilai', 'mapel.*.k' => 'Kelompok',
        ]);

        $nomor = trim((string) ($d['nomor_skl'] ?? ''));
        if ($nomor !== '' && Alumni::where('nomor_skl', $nomor)->where('id', '!=', $a->id)->exists()) {
            return response()->json(['message' => 'Nomor SKL tersebut sudah dipakai alumni lain.', 'errors' => ['nomor_skl' => ['Nomor SKL tersebut sudah dipakai alumni lain.']]], 422);
        }

        DB::transaction(function () use ($a, $d, $nomor) {
            $mapel = [];
            foreach ($d['mapel'] as $m) {
                $mapel[] = ['k' => $m['k'], 'n' => trim($m['n']), 'v' => round((float) $m['v'], 2)];
            }
            usort($mapel, fn ($x, $y) => strcmp($x['k'], $y['k']));   // stabil: urutan A→D, urutan input dipertahankan per kelompok

            if ($nomor === '') {
                $nomor = $a->nomor_skl ?: $this->nomorBaru((int) $a->tahun_lulus);
            }

            $a->forceFill([
                'tempat_lahir'   => trim($d['tempat_lahir']),
                'tanggal_lahir'  => $d['tanggal_lahir'],
                'nama_orang_tua' => trim($d['nama_orang_tua']),
                'nilai_skl'      => json_encode(['mapel' => $mapel], JSON_UNESCAPED_UNICODE),
                'nomor_skl'      => $nomor,
            ]);
            if (! empty($d['jurusan'])) {
                $a->jurusan = trim($d['jurusan']);
            }
            if (! empty($d['tanggal_kelulusan'])) {
                $a->tanggal_kelulusan = $d['tanggal_kelulusan'];
            }
            $a->save();
        });

        $a->refresh();

        return response()->json(['ok' => true, 'pesan' => "Data SKL {$a->nama} disimpan.", 'baris' => $this->baris($a, null)]);
    }

    /* ======================================================================
       PENGATURAN KOP & PENANDATANGAN
       ====================================================================== */
    public function simpanPengaturan(Request $request)
    {
        if ($salah = $this->belumMigrasi()) {
            return $salah;
        }

        $d = $request->validate([
            'kop1'         => 'nullable|string|max:120',
            'kop2'         => 'nullable|string|max:120',
            'madrasah'     => 'required|string|max:120',
            'alamat'       => 'nullable|string|max:250',
            'npsn'         => 'nullable|string|max:20',
            'kurikulum'    => 'required|string|max:80',
            'kota'         => 'required|string|max:60',
            'kepala'       => 'nullable|string|max:120',
            'nip'          => 'nullable|string|max:40',
            'format_nomor' => ['required', 'string', 'max:80', function ($att, $val, $fail) {
                if (! str_contains($val, '{urut}')) {
                    $fail('Format nomor harus memuat {urut}.');
                }
            }],
            'logo_kiri'    => 'nullable|string|max:250',
            'logo_kanan'   => 'nullable|string|max:250',
            'gambar_ttd'   => 'nullable|string|max:250',
        ], ['required' => ':attribute wajib diisi.', 'max' => ':attribute terlalu panjang.'], [
            'madrasah' => 'Nama madrasah', 'kurikulum' => 'Kurikulum', 'kota' => 'Kota penandatanganan', 'format_nomor' => 'Format nomor',
        ]);

        foreach (array_keys(self::PENGATURAN_BAWAAN) as $kunci) {
            DB::table('skl_pengaturan')->updateOrInsert(
                ['kunci' => 'p_' . $kunci],
                ['nilai' => trim((string) ($d[$kunci] ?? '')), 'updated_at' => now(), 'created_at' => now()]
            );
        }

        return response()->json(['ok' => true, 'pesan' => 'Pengaturan SKL disimpan.', 'set' => $this->pengaturan()]);
    }

    /* ======================================================================
       HALAMAN CETAK (satu atau banyak alumni; satu halaman A4 per alumni)
       ====================================================================== */
    public function cetak(Request $request)
    {
        if (! Schema::hasColumn('alumni', 'nilai_skl')) {
            return redirect()->route('label.qr')->withErrors(['skl' => 'Fitur SKL belum aktif. Jalankan: php artisan migrate']);
        }

        $ids = collect(explode(',', (string) $request->query('ids')))
            ->map(fn ($x) => (int) $x)->filter()->unique()->take(100)->values();

        $semua = $ids->isEmpty() ? collect() : Alumni::whereIn('id', $ids)->orderBy('tahun_lulus')->orderBy('nama')->get();
        if ($semua->isEmpty()) {
            return redirect()->route('label.qr')->withErrors(['skl' => 'Pilih minimal satu alumni untuk dicetak SKL-nya.']);
        }

        $siap  = $semua->filter(fn (Alumni $a) => $this->lengkap($a))->values();
        $lewat = $semua->reject(fn (Alumni $a) => $this->lengkap($a))->pluck('nama')->values();
        if ($siap->isEmpty()) {
            return redirect()->route('label.qr', ['skl_id' => $semua->first()->id])
                ->withErrors(['skl' => 'Data SKL belum lengkap. Lengkapi tempat/tanggal lahir, orang tua, dan nilai terlebih dahulu.']);
        }

        $set = $this->pengaturan();

        try {
            $terbit = $request->query('tgl') ? Carbon::parse($request->query('tgl')) : Carbon::now();
        } catch (\Throwable $e) {
            $terbit = Carbon::now();
        }
        $terbit = $terbit->locale('id');

        $halaman = $siap->map(fn (Alumni $a) => $this->susunHalaman($a, $set))->all();

        return view('skl-cetak', [
            'halaman' => $halaman,
            'lewat'   => $lewat,
            'set'     => $set,
            'terbit'  => $terbit->translatedFormat('d F Y'),
            'idsCetak' => $siap->pluck('id')->all(),
            'otomatis' => $request->query('print') === '1',
        ]);
    }

    /* ======================================================================
       CATAT PENCETAKAN (dipanggil JavaScript tepat sebelum dialog cetak dibuka)
       ====================================================================== */
    public function catat(Request $request)
    {
        if (! Schema::hasTable('skl_log')) {
            return response()->json(['ok' => false, 'message' => 'Jalankan php artisan migrate.'], 409);
        }

        $d = $request->validate(['ids' => 'required|array|min:1|max:100', 'ids.*' => 'integer|exists:alumni,id']);
        $petugas = optional(auth()->user())->name ?? 'Admin';

        $nomor = Alumni::whereIn('id', $d['ids'])->pluck('nomor_skl', 'id');
        foreach (array_unique($d['ids']) as $id) {
            DB::table('skl_log')->insert([
                'alumni_id' => $id, 'nomor' => $nomor->get($id), 'petugas' => $petugas,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        return response()->json(['ok' => true, 'jumlah' => count(array_unique($d['ids']))]);
    }

    /* ======================================================================
       PEMBANTU
       ====================================================================== */

    private function belumMigrasi()
    {
        if (Schema::hasTable('skl_log') && Schema::hasTable('skl_pengaturan') && Schema::hasColumn('alumni', 'nilai_skl')) {
            return null;
        }

        return response()->json(['ok' => false, 'message' => 'Fitur SKL belum aktif. Jalankan perintah: php artisan migrate'], 409);
    }

    /** Lengkap = tempat/tanggal lahir, orang tua, dan nilai sudah tersimpan. */
    private function lengkap(Alumni $a): bool
    {
        return filled($a->tempat_lahir) && filled($a->tanggal_lahir) && filled($a->nama_orang_tua) && filled($a->nilai_skl);
    }

    /** Versi SQL dari lengkap(). */
    private function sqlLengkap($q)
    {
        return $q->whereNotNull('tempat_lahir')->where('tempat_lahir', '!=', '')
            ->whereNotNull('tanggal_lahir')
            ->whereNotNull('nama_orang_tua')->where('nama_orang_tua', '!=', '')
            ->whereNotNull('nilai_skl')->where('nilai_skl', '!=', '');
    }

    private function bacaNilai(Alumni $a): array
    {
        $x = $a->nilai_skl ? json_decode($a->nilai_skl, true) : null;

        return ['mapel' => is_array($x) && isset($x['mapel']) && is_array($x['mapel']) ? $x['mapel'] : []];
    }

    /** Daftar mapel kosong-nilai sesuai peminatan. */
    private function mapelBawaan(string $jurusan): array
    {
        $j = mb_strtolower($jurusan);
        $c = null;
        if (preg_match('/mipa|ipa|sains/', $j) || $jurusan === 'MIPA') {
            $c = 'MIPA';
        } elseif (preg_match('/ips|sosial/', $j) || $jurusan === 'IPS') {
            $c = 'IPS';
        } elseif (preg_match('/agama|keagamaan/', $j) || $jurusan === 'Keagamaan') {
            $c = 'Keagamaan';
        }

        $hasil = self::MAPEL_AB;
        if ($c) {
            foreach (self::MAPEL_C[$c] as $n) {
                $hasil[] = ['k' => 'C', 'n' => $n];
            }
            foreach (self::MAPEL_D as $n) {
                $hasil[] = ['k' => 'D', 'n' => $n];
            }
        }

        return array_map(fn ($m) => $m + ['v' => ''], $hasil);
    }

    private function baris(Alumni $a, $log): array
    {
        return [
            'id' => $a->id, 'nama' => $a->nama, 'nis' => $a->nis, 'nisn' => $a->nisn,
            'kelas' => $a->kelas_terakhir, 'jurusan' => $a->jurusan, 'tahun' => $a->tahun_lulus,
            'nomor' => $a->nomor_skl, 'lengkap' => $this->lengkap($a),
            'dicetak' => $log ? (int) $log->n : 0,
            'terakhir' => $log && $log->terakhir ? Carbon::parse($log->terakhir)->locale('id')->translatedFormat('d M Y, H:i') . ' WIB' : null,
        ];
    }

    public function pengaturan(): array
    {
        $hasil = self::PENGATURAN_BAWAAN;
        if (Schema::hasTable('skl_pengaturan')) {
            $simpan = DB::table('skl_pengaturan')->where('kunci', 'like', 'p\_%')->pluck('nilai', 'kunci');
            foreach (array_keys($hasil) as $k) {
                if ($simpan->has('p_' . $k) && ($simpan->get('p_' . $k) !== '' || in_array($k, ['kepala', 'nip', 'gambar_ttd'], true))) {
                    $hasil[$k] = (string) $simpan->get('p_' . $k);
                }
            }
        }

        return $hasil;
    }

    /** Nomor SKL berikutnya untuk satu tahun lulus, mis. 421.3/007/MAS-SH/Kep/2026. */
    private function nomorBaru(int $tahun): string
    {
        $set   = $this->pengaturan();
        $kunci = 'urut_' . $tahun;

        $urut = (int) (DB::table('skl_pengaturan')->where('kunci', $kunci)->lockForUpdate()->value('nilai') ?? 0);
        do {
            $urut++;
            $nomor = str_replace(['{urut}', '{tahun}'], [str_pad((string) $urut, 3, '0', STR_PAD_LEFT), (string) $tahun], $set['format_nomor']);
        } while (Alumni::where('nomor_skl', $nomor)->exists());

        DB::table('skl_pengaturan')->updateOrInsert(
            ['kunci' => $kunci],
            ['nilai' => (string) $urut, 'updated_at' => now(), 'created_at' => now()]
        );

        return $nomor;
    }

    private function angka(float $v): string
    {
        return rtrim(rtrim(number_format($v, 2, ',', ''), '0'), ',');
    }

    /** Menyusun semua isi satu halaman SKL. */
    private function susunHalaman(Alumni $a, array $set): array
    {
        $mapel = $this->bacaNilai($a)['mapel'];
        $grup  = [];
        $no    = 0;
        $jumlah = 0.0;
        $n      = 0;

        foreach (self::KELOMPOK as $k => $judul) {
            $baris = [];
            foreach ($mapel as $m) {
                if (($m['k'] ?? '') === $k) {
                    $no++;
                    $n++;
                    $jumlah += (float) $m['v'];
                    $baris[] = ['no' => $no, 'n' => $m['n'], 'v' => $this->angka((float) $m['v'])];
                }
            }
            if ($baris) {
                $grup[] = ['judul' => $judul, 'baris' => $baris];
            }
        }

        $lahir = Carbon::parse($a->tanggal_lahir)->locale('id');
        $tp    = ($a->tahun_lulus - 1) . '/' . $a->tahun_lulus;

        return [
            'id'      => $a->id,
            'nama'    => $a->nama,
            'nomor'   => $a->nomor_skl,
            'ttl'     => $a->tempat_lahir . ', ' . $lahir->translatedFormat('d F Y'),
            'ortu'    => $a->nama_orang_tua,
            'nis'     => $a->nis,
            'nisn'    => $a->nisn,
            'jurusan' => $a->jurusan ?: '-',
            'tp'      => $tp,
            'pleno'   => $a->tanggal_kelulusan ? $a->tanggal_kelulusan->copy()->locale('id')->translatedFormat('d F Y') : '-',
            'grup'    => $grup,
            'rata'    => $n ? number_format($jumlah / $n, 2, ',', '') : '-',
            'qr'      => $a->nomor_ijazah ? route('alumni.verifikasi', ['nomor' => $a->nomor_ijazah]) : null,
        ];
    }

    /** URL gambar dari pengaturan: tautan penuh dipakai apa adanya, selain itu relatif ke folder public. */
    public static function urlGambar(?string $p): ?string
    {
        $p = trim((string) $p);
        if ($p === '') {
            return null;
        }

        return preg_match('#^(https?:)?//#i', $p) ? $p : asset(ltrim($p, '/'));
    }
}