<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\ArsipFisik;
use App\Models\ArsipFisikLog;
use App\Models\ArsipRak;
use App\Models\SiswaAktif;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

/**
 * Input manual alumni lama (satu per satu) langsung ke tabel alumni.
 * Dipakai untuk alumni yang lulus sebelum sistem ini dipakai, sehingga tidak
 * pernah tercatat di Data Siswa Aktif. Controller ini hanya MENAMBAH data;
 * AlumniController tidak diubah.
 */
class AlumniLamaController extends Controller
{
    public function store(Request $request)
    {
        $pesan = [
            'required' => ':attribute wajib diisi.',
            'digits'   => ':attribute harus :digits digit angka.',
            'unique'   => ':attribute sudah terdaftar di data alumni.',
            'regex'    => 'Format :attribute tidak valid.',
            'in'       => ':attribute tidak valid.',
            'date'     => ':attribute bukan tanggal yang valid.',
            'max'      => ':attribute melebihi batas yang diizinkan.',
            'between'  => ':attribute di luar rentang yang diizinkan.',
            'integer'  => ':attribute harus berupa angka.',
            'numeric'  => ':attribute harus berupa angka.',
            'gte'      => ':attribute tidak boleh lebih kecil dari tahun masuk.',
            'exists'   => ':attribute tidak ditemukan.',
        ];
        $atribut = [
            'nama' => 'Nama lengkap', 'nisn' => 'NISN', 'nis' => 'NIS', 'nik' => 'NIK', 'jenis_kelamin' => 'Jenis kelamin',
            'kelas_terakhir' => 'Kelas terakhir', 'tahun_masuk' => 'Tahun masuk', 'tahun_lulus' => 'Tahun lulus',
            'tanggal_kelulusan' => 'Tanggal kelulusan', 'nomor_ijazah' => 'Nomor ijazah', 'rata_rata' => 'Rata-rata',
            'status_ijazah' => 'Status ijazah', 'tanggal_pengambilan' => 'Tanggal pengambilan',
        ];

        $data = $request->validate([
            'nama'                => 'required|string|max:100',
            'panggilan'           => 'nullable|string|max:50',
            'jenis_kelamin'       => 'required|in:L,P',
            'nisn'                => ['required', 'digits:10', Rule::unique('alumni', 'nisn')],
            'nis'                 => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9\-]+$/', Rule::unique('alumni', 'nis')],
            'nik'                 => ['nullable', 'digits:16'],
            'kelas_terakhir'      => ['required', 'regex:/^(X|XI|XII)-[A-Za-z0-9]{1,3}$/'],
            'jurusan'             => 'nullable|string|max:80',
            'tahun_masuk'         => 'required|integer|between:1980,2100',
            'tahun_lulus'         => 'required|integer|between:1980,2100|gte:tahun_masuk',
            'tanggal_kelulusan'   => 'nullable|date',
            'nomor_ijazah'        => ['nullable', 'string', 'max:40', 'regex:/^[A-Za-z0-9\-]+$/', Rule::unique('alumni', 'nomor_ijazah')],
            'nomor_skl'           => 'nullable|string|max:60',
            'rata_rata'           => 'nullable|numeric|between:0,100',
            'prestasi'            => 'nullable|string|max:1000',
            'status_ijazah'       => 'nullable|in:diambil,tersimpan,menunggu',
            'diambil_oleh'        => 'nullable|string|max:100',
            'tanggal_pengambilan' => 'nullable|date',
            'arsip_rak_id'        => 'nullable|integer|exists:arsip_rak,id',
            'kode_map'            => 'nullable|string|max:30',
        ], $pesan, $atribut + ['arsip_rak_id' => 'Rak arsip', 'kode_map' => 'Kode map']);

        // Siswa yang masih aktif harus diluluskan lewat "Proses Kelulusan Siswa", bukan diinput manual.
        $masihAktif = SiswaAktif::where('status', 'Aktif')
            ->where(fn ($q) => $q->where('nis', $data['nis'])->orWhere('nisn', $data['nisn']))
            ->first();
        if ($masihAktif) {
            return back()->withInput()->withErrors([
                'nis' => "NIS/NISN ini milik siswa aktif ({$masihAktif->nama}, kelas {$masihAktif->kelas}). Gunakan \"Proses Kelulusan Siswa\" agar datanya tidak ganda.",
            ]);
        }

        /* Penempatan arsip fisik (opsional): rak harus cukup untuk seluruh dokumen kelulusan. */
        $rak = null;
        if (! empty($data['arsip_rak_id'])) {
            if ($galat = $this->fisikBelumSiap()) {
                return back()->withInput()->withErrors(['arsip_rak_id' => $galat]);
            }
            $rak   = ArsipRak::with('lemari.ruang')->findOrFail($data['arsip_rak_id']);
            $butuh = count(ArsipFisikController::DOKUMEN_ALUMNI);
            $sisa  = $this->sisaRak($rak);
            if ($sisa < $butuh) {
                return back()->withInput()->withErrors(['arsip_rak_id' => "Rak {$rak->kode} hanya memiliki sisa {$sisa} tempat, sedangkan {$butuh} dokumen kelulusan perlu dicatat. Pilih rak lain."]);
            }
        }

        $lulus   = (int) $data['tahun_lulus'];
        $tanggal = ! empty($data['tanggal_kelulusan']) ? Carbon::parse($data['tanggal_kelulusan']) : Carbon::create($lulus, 6, 15);
        $status  = $data['status_ijazah'] ?? 'tersimpan';

        $alumni = DB::transaction(function () use ($data, $lulus, $tanggal, $status, $rak) {
            // Nomor ijazah otomatis bila dikosongkan (dijamin unik).
            $nomor = $data['nomor_ijazah'] ?? null;
            if (! $nomor) {
                $urut = (int) Alumni::max('id') + 1;
                do {
                    $nomor = 'MA-' . $tanggal->format('d-m-Y') . '-' . str_pad((string) $urut, 5, '0', STR_PAD_LEFT);
                    $urut++;
                } while (Alumni::where('nomor_ijazah', $nomor)->exists());
            }

            $map = ($data['kode_map'] ?? null) ?: ('M-ALUMNI-' . $lulus . '-' . substr($data['nis'], -3));

            $baru = Alumni::create([
                'nis'                 => $data['nis'],
                'nisn'                => $data['nisn'],
                'nama'                => $data['nama'],
                'panggilan'           => $data['panggilan'] ?? null,
                'jenis_kelamin'       => $data['jenis_kelamin'],
                'nik'                 => $data['nik'] ?? null,
                'kelas_terakhir'      => strtoupper($data['kelas_terakhir']),
                'jurusan'             => $data['jurusan'] ?? null,
                'tahun_masuk'         => (int) $data['tahun_masuk'],
                'tahun_lulus'         => $lulus,
                'angkatan'            => max(0, $lulus - 2020),
                'tanggal_kelulusan'   => $tanggal->toDateString(),
                'nomor_ijazah'        => $nomor,
                'nomor_skl'           => $data['nomor_skl'] ?? null,
                'rata_rata'           => isset($data['rata_rata']) ? (float) $data['rata_rata'] : null,
                'prestasi'            => $data['prestasi'] ?? null,
                'status_ijazah'       => $status,
                'diambil_oleh'        => $status === 'diambil' ? ($data['diambil_oleh'] ?? null) : null,
                'tanggal_pengambilan' => $status === 'diambil' ? ($data['tanggal_pengambilan'] ?? $tanggal->copy()->addMonths(2)->toDateString()) : null,
                'kode_map'            => $map,
            ]);

            if ($rak) {
                $this->tempatkan($baru, $rak, $map);
            }

            return $baru;
        });

        $pesan = "Alumni {$alumni->nama} (lulusan {$alumni->tahun_lulus}) berhasil ditambahkan."
               . ($rak ? ' Arsip fisiknya sudah tercatat di Lokasi Arsip Fisik.' : ' Lokasi arsip fisik belum dicatat; gunakan tombol "Catat ke Arsip Fisik" pada panel detail.')
               . ' Lengkapi berkas ijazah, SKL, dan lainnya dari panel detail di bawah.';

        return redirect()->route('alumni', ['id' => $alumni->id])->with('status', $pesan);
    }

    /** Catat arsip fisik untuk alumni yang sudah ada (mis. hasil impor atau input sebelumnya). */
    public function catat(Request $request, int $id)
    {
        $alumni = Alumni::findOrFail($id);

        $data = $request->validate([
            'arsip_rak_id' => 'required|integer|exists:arsip_rak,id',
            'kode_map'     => 'nullable|string|max:30',
        ], ['required' => ':attribute wajib dipilih.', 'exists' => ':attribute tidak ditemukan.', 'max' => ':attribute melebihi batas yang diizinkan.'],
           ['arsip_rak_id' => 'Rak arsip', 'kode_map' => 'Kode map']);

        if ($galat = $this->fisikBelumSiap()) {
            return back()->withErrors(['arsip_rak_id' => $galat]);
        }

        $rak      = ArsipRak::with('lemari.ruang')->findOrFail($data['arsip_rak_id']);
        $jenis    = array_keys(ArsipFisikController::DOKUMEN_ALUMNI);
        $sudah    = ArsipFisik::where('alumni_id', $alumni->id)->pluck('jenis')->all();
        $kurang   = count(array_diff($jenis, $sudah));

        if ($kurang === 0) {
            return redirect()->route('alumni', ['id' => $alumni->id])->with('status', 'Seluruh arsip fisik alumni ini sudah tercatat. Untuk memindahkannya, gunakan halaman Lokasi Arsip Fisik.');
        }
        if ($this->sisaRak($rak) < $kurang) {
            return back()->withErrors(['arsip_rak_id' => "Rak {$rak->kode} hanya memiliki sisa {$this->sisaRak($rak)} tempat, sedangkan {$kurang} dokumen perlu dicatat. Pilih rak lain."]);
        }

        $map = ($data['kode_map'] ?? null) ?: ($alumni->kode_map ?: ('M-ALUMNI-' . $alumni->tahun_lulus . '-' . substr($alumni->nis, -3)));
        $map = mb_substr($map, 0, 30);

        $dibuat = DB::transaction(fn () => $this->tempatkan($alumni, $rak, $map));

        return redirect()->route('arsip.fisik', ['q' => $alumni->nis])
            ->with('status', "{$dibuat} arsip fisik alumni {$alumni->nama} dicatat di " . $this->teksLokasi($rak, $map) . '.');
    }

    /* ---------------------------------------------------------------- pembantu */

    /** Buat catatan arsip fisik (satu per dokumen kelulusan) di rak terpilih. Angkatan = tahun lulus, kelas = kelas terakhir. */
    private function tempatkan(Alumni $a, ArsipRak $rak, ?string $map): int
    {
        $rak->loadMissing('lemari.ruang');
        $lokasi = $this->teksLokasi($rak, $map);
        $dibuat = 0;

        foreach (array_keys(ArsipFisikController::DOKUMEN_ALUMNI) as $jenis) {
            if (ArsipFisik::where('alumni_id', $a->id)->where('jenis', $jenis)->exists()) {
                continue;
            }
            $f = ArsipFisik::create([
                'alumni_id'      => $a->id,
                'siswa_aktif_id' => null,
                'jenis'          => $jenis,
                'kode_arsip'     => $this->kodeBaru((int) $a->tahun_lulus),
                'arsip_rak_id'   => $rak->id,
                'kode_map'       => $map,
                'kondisi'        => 'belum',
                'status'         => 'tersimpan',
            ]);
            ArsipFisikLog::create([
                'arsip_fisik_id' => $f->id,
                'aksi'           => 'catat',
                'keterangan'     => "Arsip alumni {$a->nama} (lulusan {$a->tahun_lulus}, kelas {$a->kelas_terakhir}) dicatat di {$lokasi}.",
                'petugas'        => optional(auth()->user())->name ?? 'Admin',
            ]);
            $dibuat++;
        }

        // Samakan data lokasi pada profil alumni dengan rak yang dipilih.
        $a->update([
            'ruang_arsip' => $rak->lemari->ruang->nama,
            'lemari'      => $rak->lemari->kode,
            'rak'         => $rak->kode,
            'kode_map'    => $map ?: $a->kode_map,
        ]);

        return $dibuat;
    }

    /** Pesan galat bila migrasi atau model arsip fisik alumni belum terpasang (agar tidak terbentuk data yatim). */
    private function fisikBelumSiap(): ?string
    {
        if (! Schema::hasColumn('arsip_fisik', 'alumni_id')) {
            return 'Fitur arsip fisik alumni belum aktif. Jalankan "php artisan migrate" terlebih dahulu.';
        }
        if (! in_array('alumni_id', (new ArsipFisik())->getFillable(), true) || ! defined(ArsipFisikController::class . '::DOKUMEN_ALUMNI')) {
            return 'Berkas ArsipFisik.php dan ArsipFisikController.php versi terbaru belum terpasang.';
        }

        return null;
    }

    private function sisaRak(ArsipRak $rak): int
    {
        return max(0, $rak->kapasitas - ArsipFisik::where('arsip_rak_id', $rak->id)->count());
    }

    private function teksLokasi(ArsipRak $rak, ?string $map): string
    {
        $rak->loadMissing('lemari.ruang');

        return implode(' • ', array_filter([$rak->lemari->ruang->nama, $rak->lemari->kode, $rak->kode, $map]));
    }

    /** Kode arsip berurutan per tahun, contoh: ARS-2023-0001 (format sama dengan Lokasi Arsip Fisik). */
    private function kodeBaru(int $tahun): string
    {
        $awal  = "ARS-{$tahun}-";
        $akhir = ArsipFisik::where('kode_arsip', 'like', $awal . '%')->orderByDesc('kode_arsip')->value('kode_arsip');
        $n     = $akhir ? ((int) substr($akhir, -4)) + 1 : 1;

        return $awal . str_pad((string) $n, 4, '0', STR_PAD_LEFT);
    }
}