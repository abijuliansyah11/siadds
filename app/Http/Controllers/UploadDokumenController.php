<?php

namespace App\Http\Controllers;

use App\Models\SiswaAktif;
use App\Models\SiswaDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UploadDokumenController extends Controller
{
    /**
     * Jenis dokumen yang boleh diunggah (sama dengan SiswaDetailController:
     * 6 dokumen wajib + kartu bantuan).
     * tile  = label kartu kategori | sub = keterangan singkat
     * nomor = label kolom nomor registrasi | nama = saran nama dokumen
     */
    public const JENIS = [
        'Kartu Keluarga (KK)'               => ['tile' => 'Kartu Keluarga (KK)',  'sub' => 'Identitas keluarga',   'icon' => 'users',  'nomor' => 'Nomor KK',               'nama' => 'Kartu Keluarga (KK)'],
        'Akta Kelahiran'                    => ['tile' => 'Akta Kelahiran',       'sub' => 'Legalitas Dukcapil',   'icon' => 'file',   'nomor' => 'Nomor Akta Kelahiran',   'nama' => 'Akta Kelahiran'],
        'Ijazah / SKL MTs'                  => ['tile' => 'Ijazah / SKL MTs',     'sub' => 'Jenjang MTs/SMP',      'icon' => 'file',   'nomor' => 'Nomor Seri Ijazah / SKL','nama' => 'Ijazah / SKL MTs'],
        'Pas Foto Resmi 3x4'                => ['tile' => 'Pas Foto 3x4',         'sub' => 'Latar merah/biru',     'icon' => 'user',   'nomor' => 'Keterangan Foto',        'nama' => 'Pas Foto Resmi 3x4'],
        'KTP Orang Tua (Ayah & Ibu)'        => ['tile' => 'KTP Orang Tua / Wali', 'sub' => 'Ayah / Ibu / Wali',    'icon' => 'users',  'nomor' => 'NIK Wali',               'nama' => 'KTP Orang Tua / Wali (Ayah & Ibu)'],
        'Surat Pernyataan Kesediaan Santri' => ['tile' => 'Surat Pernyataan',     'sub' => 'Bermaterai Rp 10.000', 'icon' => 'check',  'nomor' => 'Nomor Surat',            'nama' => 'Surat Pernyataan Kesediaan Santri'],
        'Kartu Bantuan (KIP / PKH / KKS)'   => ['tile' => 'Berkas Pendukung',     'sub' => 'KIP / PKH / Piagam',   'icon' => 'folder', 'nomor' => 'Nomor Kartu',            'nama' => 'Kartu Bantuan (KIP / PKH / KKS)'],
    ];

    private const TAB = ['semua', 'hari', 'menunggu', 'sah', 'ditolak'];

    /* ------------------------------------------------------------------
       HALAMAN UTAMA
       ------------------------------------------------------------------ */
    public function index(Request $request)
    {
        $semuaStatus = SiswaDokumen::selectRaw('status, COUNT(*) as n')->groupBy('status')->pluck('n', 'status');

        $hitung = ['sah' => 0, 'menunggu' => 0, 'revisi' => 0];
        foreach ($semuaStatus as $status => $n) {
            $hitung[ArsipDigitalController::golongan($status)] += $n;
        }

        $hari    = SiswaDokumen::whereDate('created_at', today())->count();
        $kemarin = SiswaDokumen::whereDate('created_at', today()->subDay())->count();

        $kpi = [
            'total'    => array_sum($hitung),
            'hari'     => $hari,
            'delta'    => $kemarin > 0 ? (int) round(($hari - $kemarin) / $kemarin * 100) : null,
            'menunggu' => $hitung['menunggu'],
            'ditolak'  => $hitung['revisi'],
        ];

        $tabAktif = in_array($request->query('tab'), self::TAB, true) ? $request->query('tab') : 'semua';
        $jumlahTab = [
            'semua'    => $kpi['total'],
            'hari'     => $hari,
            'menunggu' => $hitung['menunggu'],
            'sah'      => $hitung['sah'],
            'ditolak'  => $hitung['revisi'],
        ];

        $riwayat = SiswaDokumen::with('siswa:id,nis,nama,kelas');
        switch ($tabAktif) {
            case 'hari':     $riwayat->whereDate('created_at', today()); break;
            case 'menunggu': $riwayat->whereNotIn('status', array_merge(ArsipDigitalController::SAH, [ArsipDigitalController::REVISI])); break;
            case 'sah':      $riwayat->whereIn('status', ArsipDigitalController::SAH); break;
            case 'ditolak':  $riwayat->where('status', ArsipDigitalController::REVISI); break;
        }
        $riwayat = $riwayat->orderByDesc('updated_at')->orderByDesc('id')
            ->paginate(5)->withQueryString()->fragment('riwayat');

        // Siswa & jenis awal (dari tautan "unggah ulang" atau input lama saat validasi gagal)
        $siswaAwal = null;
        if ($id = (int) ($request->query('siswa') ?: old('siswa_id'))) {
            $s = SiswaAktif::with('dokumen:id,siswa_aktif_id,jenis,status')->find($id);
            $siswaAwal = $s ? $this->ringkasSiswa($s) : null;
        }
        $jenisAwal = $request->query('jenis', old('jenis'));
        $jenisAwal = array_key_exists($jenisAwal, self::JENIS) ? $jenisAwal : null;

        return view('upload-dokumen', [
            'kpi' => $kpi, 'riwayat' => $riwayat, 'tabAktif' => $tabAktif, 'jumlahTab' => $jumlahTab,
            'siswaAwal' => $siswaAwal, 'jenisAwal' => $jenisAwal,
            'jenis' => self::JENIS, 'disk' => $this->kapasitasDisk(),
        ]);
    }

    /* ------------------------------------------------------------------
       PENCARIAN SISWA (JSON untuk kolom "Hubungkan Identitas Siswa")
       ------------------------------------------------------------------ */
    public function cari(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $hasil = SiswaAktif::with('dokumen:id,siswa_aktif_id,jenis,status')
            ->when($q !== '', fn ($w) => $w->where(function ($x) use ($q) {
                $x->where('nama', 'like', "%{$q}%")
                  ->orWhere('nis', 'like', "%{$q}%")
                  ->orWhere('nisn', 'like', "%{$q}%");
            }))
            ->orderBy('nama')->limit(8)->get();

        return response()->json($hasil->map(fn ($s) => $this->ringkasSiswa($s))->values());
    }

    /* ------------------------------------------------------------------
       SIMPAN BERKAS
       ------------------------------------------------------------------ */
    public function simpan(Request $request)
    {
        $data = $request->validate([
            'siswa_id'       => 'required|exists:siswa_aktif,id',
            'jenis'          => ['required', Rule::in(array_keys(self::JENIS))],
            'berkas'         => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'nama_dokumen'   => 'nullable|string|max:150',
            'nomor_dokumen'  => 'nullable|string|max:60',
            'tanggal_terbit' => 'nullable|date',
            'deskripsi'      => 'nullable|string|max:500',
        ], [
            'required' => ':attribute wajib diisi.',
            'exists'   => 'Siswa tidak ditemukan.',
            'in'       => 'Jenis dokumen tidak valid.',
            'mimes'    => 'Berkas harus berformat PDF, JPG, JPEG, atau PNG.',
            'max'      => ':attribute melebihi batas yang diizinkan.',
            'date'     => 'Tanggal terbit tidak valid.',
        ], [
            'siswa_id' => 'Siswa', 'jenis' => 'Jenis dokumen', 'berkas' => 'Berkas',
            'nama_dokumen' => 'Nama dokumen', 'nomor_dokumen' => 'Nomor dokumen', 'deskripsi' => 'Catatan',
        ]);

        $siswa  = SiswaAktif::findOrFail($data['siswa_id']);
        $file   = $request->file('berkas');
        $byte   = (int) $file->getSize();
        $gambar = str_starts_with((string) $file->getMimeType(), 'image/');
        $path   = $file->store('dokumen-siswa/' . $siswa->nis, 'public');

        // Satu jenis dokumen per siswa: unggahan baru menggantikan yang lama
        $dok = $siswa->dokumen()->firstOrNew(['jenis' => $data['jenis']]);
        if ($dok->exists && $dok->path) {
            Storage::disk('public')->delete($dok->path);
        }

        $dok->nama_file      = $file->getClientOriginalName();
        $dok->ukuran         = $byte >= 1048576 ? round($byte / 1048576, 2) . ' MB' : max(1, round($byte / 1024)) . ' KB';
        $dok->status         = 'pending';
        $dok->diunggah_oleh  = optional(auth()->user())->name ?? 'Admin';
        $dok->tanggal_unggah = now()->toDateString();
        $dok->path           = $path;

        // Kolom tambahan (dari migration metadata); dilewati jika belum dimigrasi
        $tambahan = [
            'nama_dokumen'      => $data['nama_dokumen'] ?? null,
            'nomor_dokumen'     => $data['nomor_dokumen'] ?? null,
            'tanggal_terbit'    => $data['tanggal_terbit'] ?? null,
            'deskripsi'         => $data['deskripsi'] ?? null,
            'catatan'           => null,   // catatan verifikator lama dihapus
            'diverifikasi_oleh' => null,
        ];
        foreach ($tambahan as $kolom => $nilai) {
            if ($this->kolomAda($kolom)) {
                $dok->{$kolom} = $nilai;
            }
        }
        $dok->save();

        if ($data['jenis'] === SiswaAktif::DOKUMEN_WAJIB[4] && $gambar) {
            $siswa->update(['foto' => $path]);
        }

        return redirect()->route('upload.dokumen', ['siswa' => $siswa->id])
            ->with('status', "Dokumen {$data['jenis']} milik {$siswa->nama} berhasil diunggah dan masuk antrean verifikasi.");
    }

    /* ------------------------------------------------------------------
       PEMBANTU
       ------------------------------------------------------------------ */
    private function ringkasSiswa(SiswaAktif $s): array
    {
        $wajib  = SiswaAktif::DOKUMEN_WAJIB;
        $status = $s->dokumen->pluck('status', 'jenis')->map(fn ($st) => ArsipDigitalController::golongan($st))->all();
        $ada    = count(array_filter($wajib, fn ($j) => isset($status[$j])));

        return [
            'id'           => $s->id,
            'nis'          => $s->nis,
            'nisn'         => $s->nisn,
            'nama'         => $s->nama,
            'kelas'        => $s->kelas,
            'status'       => $s->status ?: 'Aktif',
            'foto'         => $s->foto_url,
            'status_jenis' => (object) $status,
            'terkumpul'    => $ada,
            'total'        => count($wajib),
            'persen'       => round($ada / count($wajib) * 100, 1),
            'profil'       => route('siswa.detail', ['id' => $s->id]),
        ];
    }

    private function kapasitasDisk(): array
    {
        $dir   = storage_path('app');
        $total = (float) @disk_total_space($dir);
        $bebas = (float) @disk_free_space($dir);
        $pakai = max(0, $total - $bebas);
        $gb    = fn ($b) => number_format($b / 1073741824, 1, ',', '.');

        return [
            'pakai'  => $gb($pakai),
            'total'  => $gb($total),
            'persen' => $total > 0 ? (int) round($pakai / $total * 100) : 0,
        ];
    }

    private function kolomAda(string $kolom): bool
    {
        static $cache = [];
        return $cache[$kolom] ??= Schema::hasColumn('siswa_dokumen', $kolom);
    }
}