<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Pendaftaran;
use App\Models\SiswaAktif;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Throwable;

/**
 * Daftar Ulang & Konversi: calon siswa yang Lolos Seleksi diverifikasi syarat daftar ulangnya,
 * lalu dikonversi menjadi Siswa Aktif beserta berkas arsipnya (tanpa input ulang).
 */
class DaftarUlangController extends Controller
{
    /** Rombel kelas X: [nama kelas, peminatan, kapasitas]. Jumlah kapasitas = 160. */
    private const ROMBEL = [
        ['X-A', 'MIPA', 32], ['X-B', 'MIPA', 32], ['X-C', 'IPS', 32], ['X-D', 'IPS', 32], ['X-E', 'Agama', 32],
    ];

    private const SYARAT = [
        'Surat Pernyataan Kesediaan & Tata Tertib Siswa',
        'Verifikasi Ijazah Asli / SKL Legalisir Sah',
        'Konfirmasi Data Orang Tua / Wali & Kontak Darurat',
        'Penyerahan Pas Foto Fisik 3x4 (4 Lembar)',
        'Pengukuran Seragam & Administrasi Madrasah',
    ];

    private const JENIS_KIP = 'Kartu Bantuan (KIP / PKH / KKS)';

    public function index()
    {
        if (! $this->siap()) {
            return view('daftar-ulang', ['du' => ['migrasi' => false]]);
        }

        $tahun = (int) now()->year;
        $p = Pendaftaran::where('status', 'terkirim')
            ->where(fn ($q) => $q->where('status_seleksi', 'L')->orWhereNotNull('siswa_aktif_id'))
            ->orderBy('id')->get();
        $siswa = SiswaAktif::whereIn('id', $p->pluck('siswa_aktif_id')->filter()->all())->get()->keyBy('id');

        return view('daftar-ulang', ['du' => [
            'migrasi' => true,
            'rows'    => $p->map(fn ($r) => $this->baris($r, $siswa->get($r->siswa_aktif_id)))->values()->all(),
            'rbs'     => $this->rombel($tahun),
            'logs'    => $this->logs(),
            'nextNis' => $this->nisBerikut($tahun),
            'csrf'    => csrf_token(),
            'url'     => [
                'syarat'    => route('daftarulang.syarat', ['id' => 0]),
                'konversi'  => route('daftarulang.konversi', ['id' => 0]),
                'massal'    => route('daftarulang.massal'),
                'seleksi'   => route('seleksi'),
                'verifikasi' => route('verifikasi'),
                'pendaftaran' => route('pendaftaran'),
                'siswaAktif' => route('siswa.aktif'),
                'siswaBaru' => route('siswa.baru'),
                'digital'   => route('arsip.digital'),
                'upload'    => route('upload.dokumen'),
            ],
        ]]);
    }

    /** Simpan checklist 5 syarat daftar ulang satu calon siswa. */
    public function syarat(Request $request, int $id): JsonResponse
    {
        if (! $this->siap()) {
            return $this->gagal('Jalankan "php artisan migrate" terlebih dahulu.');
        }
        $p = Pendaftaran::where('status', 'terkirim')->findOrFail($id);
        if ($p->siswa_aktif_id) {
            return $this->gagal('Siswa sudah dikonversi, checklist terkunci.');
        }

        $d = $request->validate(['sy' => ['required', 'array', 'size:5'], 'sy.*' => ['boolean']]);
        $baru = array_map('boolval', array_values($d['sy']));
        $lama = $this->syaratTersimpan($p);

        $p->forceFill(['daftar_ulang' => json_encode(['sy' => $baru], JSON_UNESCAPED_UNICODE)])->save();

        foreach ($baru as $i => $v) {
            if ($v !== $lama[$i]) {
                $this->catat($p->id, '<b>' . e($this->petugas()) . '</b> ' . ($v ? 'memverifikasi' : 'membatalkan verifikasi')
                    . ' syarat "' . e(self::SYARAT[$i]) . '" untuk <b>' . e($p->nama) . '</b>', $v ? '#2563eb' : '#d97706');
            }
        }

        return $this->ok();
    }

    /** Konversi satu calon siswa menjadi siswa aktif. */
    public function konversi(Request $request, int $id): JsonResponse
    {
        if (! $this->siap()) {
            return $this->gagal('Jalankan "php artisan migrate" terlebih dahulu.');
        }
        $d = $request->validate([
            'kelas'   => ['required', Rule::in(array_column(self::ROMBEL, 0))],
            'tanggal' => ['nullable', 'date'],
        ]);

        $h = $this->proses($id, $d['kelas'], $d['tanggal'] ?? null);
        if (is_string($h)) {
            return $this->gagal($h);
        }

        return $this->ok($this->ringkas($h['siswa'], $id));
    }

    /** Konversi banyak calon siswa; kelas dipilih otomatis (rombel pertama yang masih ada kursi). */
    public function massal(Request $request): JsonResponse
    {
        if (! $this->siap()) {
            return $this->gagal('Jalankan "php artisan migrate" terlebih dahulu.');
        }
        $d = $request->validate(['ids' => ['required', 'array', 'min:1', 'max:100'], 'ids.*' => ['integer']]);
        $tahun = (int) now()->year;

        $done = [];
        $skip = [];
        foreach (collect($d['ids'])->unique()->sort()->values() as $id) {
            $kelas = null;
            foreach (self::ROMBEL as $r) {
                if (SiswaAktif::where('kelas', $r[0])->where('tahun_masuk', $tahun)->count() < $r[2]) {
                    $kelas = $r[0];
                    break;
                }
            }
            $h = $kelas ? $this->proses((int) $id, $kelas, null) : 'semua kelas penuh';
            if (is_string($h)) {
                $skip[] = ['id' => (int) $id, 'alasan' => $h];
            } else {
                $done[] = $this->ringkas($h['siswa'], (int) $id);
            }
        }

        return $this->ok(['done' => $done, 'skipped' => $skip]);
    }

    /* ------------------------------------------------------------------ */

    private function proses(int $id, string $kelas, ?string $tanggal): array|string
    {
        $tahun = (int) now()->year;
        $kap = 0;
        foreach (self::ROMBEL as $r) {
            if ($r[0] === $kelas) {
                $kap = $r[2];
            }
        }

        try {
            return DB::transaction(function () use ($id, $kelas, $tanggal, $tahun, $kap) {
                $p = Pendaftaran::where('status', 'terkirim')->lockForUpdate()->find($id);
                if (! $p) {
                    return 'data pendaftar tidak ditemukan';
                }
                if ($p->siswa_aktif_id) {
                    return 'sudah menjadi siswa aktif';
                }
                if ($p->status_seleksi !== 'L') {
                    return 'belum dinyatakan Lolos Seleksi';
                }
                if (count(array_filter($this->syaratTersimpan($p))) < 5) {
                    return 'syarat daftar ulang belum lengkap (harus 5 dari 5)';
                }
                if ($b = $this->bentrok($p)) {
                    return "duplikasi {$b} pada Master Data Siswa Aktif / Alumni";
                }
                if (SiswaAktif::where('kelas', $kelas)->where('tahun_masuk', $tahun)->count() >= $kap) {
                    return "kelas {$kelas} penuh";
                }

                $nis = $this->nisBerikut($tahun);
                $rom = collect(self::ROMBEL)->first(fn ($r) => $r[0] === $kelas);

                $siswa = SiswaAktif::create([
                    'nis'            => $nis,
                    'nisn'           => $p->nisn,
                    'nama'           => $p->nama,
                    'jenis_kelamin'  => $p->jk,
                    'kelas'          => $kelas,
                    'rombel'         => $p->minat ?: ($rom[1] ?? null),
                    'tahun_masuk'    => $tahun,
                    'tanggal_masuk'  => $tanggal ?: now()->toDateString(),
                    'nama_orang_tua' => $p->ayah . ' & ' . $p->ibu,
                    'status'         => 'Aktif',
                    'tahun_ajaran'   => $tahun . '/' . ($tahun + 1),
                    'nik'            => $p->nik,
                    'tempat_lahir'   => $p->tempat,
                    'tanggal_lahir'  => $p->tgl,
                    'alamat'         => mb_substr(implode(', ', array_filter([$p->alamat, $p->desa, $p->kec, $p->kab, $p->prov])), 0, 500) ?: null,
                    'asal_sekolah'   => $p->sek,
                    'nama_ayah'      => $p->ayah,
                    'nama_ibu'       => $p->ibu,
                    'no_hp_wali'     => $p->hpo,
                    'kode_map'       => 'MAP-X-' . $tahun . '-' . substr($nis, -3),
                ]);

                $this->salinDokumen($p, $siswa);

                $p->forceFill([
                    'siswa_aktif_id' => $siswa->id,
                    'dikonversi_at'  => now(),
                    'daftar_ulang'   => json_encode(['sy' => [true, true, true, true, true]]),
                ])->save();

                $this->catat($p->id, '<b>' . e($this->petugas()) . '</b> mengonversi <b>' . e($p->nama)
                    . '</b> menjadi Siswa Aktif<br><small>NIS: ' . e($nis) . ' • Kelas ' . e($kelas) . '</small>', '#0f7a4f');

                return ['siswa' => $siswa];
            });
        } catch (Throwable $e) {
            report($e);

            return 'terjadi kesalahan saat menyimpan (NIS / NISN mungkin sudah dipakai). Coba lagi.';
        }
    }

    /** Salin berkas pendaftar ke arsip siswa; status mengikuti hasil Verifikasi Berkas. */
    private function salinDokumen(Pendaftaran $p, SiswaAktif $siswa): void
    {
        $v = json_decode((string) ($p->verifikasi ?? ''), true) ?: [];
        $dok = $p->dokumen ?? [];
        $w = SiswaAktif::DOKUMEN_WAJIB;

        $daftar = [
            ['kk', $w[0], $dok['kk'] ?? null, 0],
            ['akta', $w[1], $dok['akta'] ?? null, 1],
            ['ijazah', $w[2], $dok['ijazah'] ?? null, 2],
            ['foto', $w[4], $p->foto_path ? ['name' => basename($p->foto_path), 'path' => $p->foto_path] : null, 3],
            ['kip', self::JENIS_KIP, $dok['kip'] ?? null, null],
        ];

        $disk = Storage::disk('public');
        foreach ($daftar as [$kunci, $label, $f, $idx]) {
            $asal = $f['path'] ?? null;
            if (! $asal || ! $disk->exists($asal)) {
                continue;
            }
            $tujuan = 'dokumen-siswa/' . $siswa->nis . '/' . basename($asal);
            if ($disk->exists($tujuan)) {
                $tujuan = 'dokumen-siswa/' . $siswa->nis . '/' . uniqid() . '-' . basename($asal);
            }
            $disk->copy($asal, $tujuan);

            $status = $kunci === 'kip' ? 'tambahan' : ((($v['docs'][$idx]['st'] ?? 'p') === 'v') ? 'valid' : 'pending');
            $byte = (int) ($f['size'] ?? $disk->size($asal));

            $siswa->dokumen()->create([
                'jenis'          => $label,
                'nama_file'      => $f['name'] ?? basename($asal),
                'ukuran'         => $byte >= 1048576 ? round($byte / 1048576, 1) . ' MB' : max(1, round($byte / 1024)) . ' KB',
                'status'         => $status,
                'diunggah_oleh'  => 'PPDB (konversi) - ' . $this->petugas(),
                'tanggal_unggah' => now()->toDateString(),
                'path'           => $tujuan,
            ]);

            if ($kunci === 'foto') {
                $siswa->update(['foto' => $tujuan]);
            }
        }
    }

    private function bentrok(Pendaftaran $r): ?string
    {
        foreach ([SiswaAktif::class, Alumni::class] as $m) {
            if (filled($r->nisn) && $m::where('nisn', $r->nisn)->exists()) {
                return 'NISN';
            }
            if (filled($r->nik) && $m::where('nik', $r->nik)->exists()) {
                return 'NIK';
            }
        }

        return null;
    }

    private function baris(Pendaftaran $r, ?SiswaAktif $s): array
    {
        $sy = $s ? [true, true, true, true, true] : $this->syaratTersimpan($r);
        $dok = $r->dokumen ?? [];
        $v = json_decode((string) ($r->verifikasi ?? ''), true) ?: [];
        $st = ['v' => 'terverifikasi', 'f' => 'perlu perbaikan', 'r' => 'ditolak', 'p' => 'belum diperiksa'][$v['docs'][2]['st'] ?? 'p'] ?? 'belum diperiksa';

        return [
            'id'     => $r->id,
            'reg'    => $r->no_registrasi,
            'name'   => $r->nama,
            'age'    => $r->tgl ? $r->tgl->age : 15,
            'jalur'  => $r->jalur === 'Prestasi' ? 'Prestasi Akademik' : ($r->jalur ?: 'Reguler'),
            'nisn'   => $r->nisn ?: '-',
            'nik'    => $r->nik ?: '-',
            'school' => $r->sek ?: '-',
            'date'   => Carbon::parse($r->diseleksi_at ?? $r->updated_at ?? now())->timezone('Asia/Jakarta')->format('Y-m-d'),
            'nilai'  => $r->nilai_rapor !== null ? (float) $r->nilai_rapor : 0,
            'sy'     => $sy,
            'nis'    => $s?->nis,
            'kelas'  => $s?->kelas,
            'sid'    => $s?->id,
            'u'      => $s ? $this->tautan($s) : null,
            'dup'    => $s ? '' : ($this->bentrok($r) ?? ''),
            'ayah'   => $r->ayah,
            'ibu'    => $r->ibu,
            'hpo'    => $r->hpo,
            'ijz'    => isset($dok['ijazah']['name']) ? $dok['ijazah']['name'] . ' — ' . $st : 'Berkas ijazah belum diunggah',
        ];
    }

    private function ringkas(SiswaAktif $s, int $pendaftaranId): array
    {
        return [
            'id'       => $pendaftaranId,
            'siswa_id' => $s->id,
            'nis'      => $s->nis,
            'kelas'    => $s->kelas,
            'u'        => $this->tautan($s),
        ];
    }

    private function tautan(SiswaAktif $s): array
    {
        return [
            'detail'      => route('siswa.detail', ['id' => $s->id]),
            'upload'      => route('upload.dokumen', ['siswa' => $s->id]) . '#unggah',
            'kelengkapan' => route('kelengkapan.dokumen', ['q' => $s->nis, 'pilih' => $s->id]),
            'digital'     => route('arsip.digital', ['q' => $s->nis]) . '#daftar',
            'fisik'       => route('arsip.fisik', ['q' => $s->nis]) . '#daftar',
            'label'       => route('label.qr', ['q' => $s->nis]) . '#tabel',
        ];
    }

    private function rombel(int $tahun): array
    {
        $ids = Pendaftaran::whereNotNull('siswa_aktif_id')->pluck('siswa_aktif_id')->all();

        return array_map(fn ($r) => [
            $r[0], $r[1], $r[2],
            SiswaAktif::where('kelas', $r[0])->where('tahun_masuk', $tahun)->whereNotIn('id', $ids)->count(),
        ], self::ROMBEL);
    }

    private function syaratTersimpan(Pendaftaran $p): array
    {
        $d = json_decode((string) ($p->daftar_ulang ?? ''), true) ?: [];

        return array_map('boolval', array_pad(array_slice(array_values($d['sy'] ?? []), 0, 5), 5, false));
    }

    private function nisBerikut(int $tahun): string
    {
        $maks = SiswaAktif::where('nis', 'like', $tahun . '%')->max('nis');

        return $maks ? (string) ((int) $maks + 1) : $tahun . '001';
    }

    private function siap(): bool
    {
        return Schema::hasTable('pendaftaran')
            && Schema::hasColumn('pendaftaran', 'siswa_aktif_id')
            && Schema::hasColumn('pendaftaran', 'daftar_ulang')
            && Schema::hasTable('konversi_log');
    }

    private function petugas(): string
    {
        return optional(Auth::user())->name ?? 'Admin';
    }

    private function catat(?int $pendaftaranId, string $html, string $warna): void
    {
        DB::table('konversi_log')->insert([
            'pendaftaran_id' => $pendaftaranId,
            'isi'            => $html,
            'warna'          => $warna,
            'user_id'        => Auth::id(),
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    }

    private function logs(): array
    {
        return DB::table('konversi_log')->orderByDesc('id')->limit(20)->get()->map(fn ($l) => [
            $l->isi . '<br><small>' . Carbon::parse($l->created_at)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('j F Y, H:i') . ' WIB</small>',
            $l->warna,
        ])->all();
    }

    private function ok(array $extra = []): JsonResponse
    {
        return response()->json(array_merge([
            'ok'       => true,
            'logs'     => $this->logs(),
            'next_nis' => $this->nisBerikut((int) now()->year),
        ], $extra));
    }

    private function gagal(string $pesan): JsonResponse
    {
        return response()->json(['ok' => false, 'message' => $pesan], 422);
    }
}