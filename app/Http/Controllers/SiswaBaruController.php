<?php

namespace App\Http\Controllers;

use App\Models\SiswaAktif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaBaruController extends Controller
{
    /** Daftar dokumen pada Tahap 4. */
    private function daftarDokumen(): array
    {
        $w = SiswaAktif::DOKUMEN_WAJIB;

        return [
            ['key' => 'kk',     'label' => $w[0], 'wajib' => true,  'short' => 'KK',      'icon' => 'users',  'hint' => 'PDF, JPG, atau PNG (maks. 5 MB)'],
            ['key' => 'akta',   'label' => $w[1], 'wajib' => true,  'short' => 'Akta',    'icon' => 'file',   'hint' => 'PDF, JPG, atau PNG (maks. 5 MB)'],
            ['key' => 'ijazah', 'label' => $w[2], 'wajib' => true,  'short' => 'Ijazah',  'icon' => 'file',   'hint' => 'Surat keterangan lulus / ijazah, legalisir'],
            ['key' => 'ktp',    'label' => $w[3], 'wajib' => true,  'short' => 'KTP Ortu', 'icon' => 'user',   'hint' => 'KTP Ayah dan Ibu, boleh digabung dalam satu file'],
            ['key' => 'foto',   'label' => $w[4], 'wajib' => true,  'short' => 'Pas Foto', 'icon' => 'user',   'hint' => 'Latar merah, seragam madrasah, 300 DPI'],
            ['key' => 'surat',  'label' => $w[5], 'wajib' => false, 'short' => 'Surat',   'icon' => 'check',  'hint' => 'Bermaterai Rp 10.000,-'],
            ['key' => 'kip',    'label' => 'Kartu Bantuan (KIP / PKH / KKS)', 'wajib' => false, 'short' => 'KIP', 'icon' => 'folder', 'hint' => 'Untuk pendataan program afirmasi madrasah'],
        ];
    }

    public function create()
    {
        $tahun    = (int) now()->year;
        $maks     = SiswaAktif::where('nis', 'like', $tahun . '%')->max('nis');
        $nisSaran = $maks ? (string) ((int) $maks + 1) : $tahun . '001';

        $daftarKelas = [];
        foreach (['X', 'XI', 'XII'] as $t) {
            foreach (['A', 'B', 'C'] as $r) {
                $daftarKelas[] = "{$t}-{$r}";
            }
        }

        return view('siswa-baru', [
            'dokumen'     => $this->daftarDokumen(),
            'nisSaran'    => $nisSaran,
            'tahun'       => $tahun,
            'daftarKelas' => $daftarKelas,
            'batasFile'   => $this->iniByte('upload_max_filesize'),
            'batasTotal'  => $this->iniByte('post_max_size'),
        ]);
    }

    /** Pemeriksaan anti-duplikasi (dipanggil dari halaman lewat fetch). */
    public function cek(Request $request)
    {
        $ada = fn (string $kolom, $nilai) => filled($nilai)
            && (SiswaAktif::where($kolom, (string) $nilai)->exists() || \App\Models\Alumni::where($kolom, (string) $nilai)->exists());

        return response()->json([
            'nisn' => $ada('nisn', $request->nisn),
            'nis'  => $ada('nis', $request->nis),
            'nik'  => $ada('nik', $request->nik),
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'nama'          => 'required|string|max:100',
            'panggilan'     => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'nisn'          => 'required|digits:10|unique:siswa_aktif,nisn|unique:alumni,nisn',
            'nis'           => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9\-]+$/', 'unique:siswa_aktif,nis', 'unique:alumni,nis'],
            'tempat_lahir'  => 'nullable|string|max:60',
            'tanggal_lahir' => 'required|date|before:today',
            'nik'           => 'nullable|digits:16|unique:siswa_aktif,nik',
            'alamat'        => 'nullable|string|max:500',
            'tahun_ajaran'  => 'nullable|string|max:9',
            'kelas'         => ['required', 'regex:/^(X|XI|XII)-[A-Za-z0-9]{1,3}$/'],
            'rombel'        => 'nullable|string|max:80',
            'tahun_masuk'   => 'required|integer|between:2000,2100',
            'tanggal_masuk' => 'nullable|date',
            'asal_sekolah'  => 'required|string|max:150',
            'wali_kelas'    => 'nullable|string|max:100',
            'nama_ayah'     => 'required|string|max:100',
            'nama_ibu'      => 'required|string|max:100',
            'no_hp_wali'    => ['required', 'regex:/^[0-9+\- ]{8,20}$/'],
            'ruang_arsip'   => 'nullable|string|max:100',
            'lemari'        => 'nullable|string|max:40',
            'rak'           => 'nullable|string|max:20',
            'kode_map'      => 'nullable|string|max:40',
        ];
        $dokumen = $this->daftarDokumen();
        foreach ($dokumen as $d) {
            $rules['dok_' . $d['key']] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120';
        }

        $pesan = [
            'required' => ':attribute wajib diisi.',
            'digits'   => ':attribute harus :digits digit angka.',
            'unique'   => ':attribute sudah terdaftar di database.',
            'regex'    => 'Format :attribute tidak valid.',
            'in'       => ':attribute tidak valid.',
            'date'     => ':attribute bukan tanggal yang valid.',
            'before'   => ':attribute harus sebelum hari ini.',
            'max'      => ':attribute melebihi batas yang diizinkan.',
            'mimes'    => ':attribute harus berformat PDF, JPG, atau PNG.',
            'between'  => ':attribute di luar rentang yang diizinkan.',
        ];

        $atribut = [
            'nama' => 'Nama lengkap', 'nisn' => 'NISN', 'nis' => 'NIS', 'nik' => 'NIK',
            'jenis_kelamin' => 'Jenis kelamin', 'tanggal_lahir' => 'Tanggal lahir',
            'kelas' => 'Kelas', 'tahun_masuk' => 'Tahun masuk', 'asal_sekolah' => 'Asal sekolah',
            'nama_ayah' => 'Nama ayah', 'nama_ibu' => 'Nama ibu', 'no_hp_wali' => 'No. HP wali',
            'dok_kk' => 'Berkas KK', 'dok_akta' => 'Berkas Akta', 'dok_ijazah' => 'Berkas Ijazah',
            'dok_ktp' => 'Berkas KTP orang tua', 'dok_foto' => 'Pas foto', 'dok_surat' => 'Surat pernyataan', 'dok_kip' => 'Kartu bantuan',
        ];

        $data = $request->validate($rules, $pesan, $atribut);

        $siswa = DB::transaction(function () use ($request, $data, $dokumen) {
            $siswa = SiswaAktif::create([
                'nis'            => $data['nis'],
                'nisn'           => $data['nisn'],
                'nama'           => $data['nama'],
                'panggilan'      => $data['panggilan'] ?? null,
                'jenis_kelamin'  => $data['jenis_kelamin'],
                'kelas'          => strtoupper($data['kelas']),
                'rombel'         => $data['rombel'] ?? null,
                'tahun_masuk'    => $data['tahun_masuk'],
                'tanggal_masuk'  => $data['tanggal_masuk'] ?? now()->toDateString(),
                'wali_kelas'     => $data['wali_kelas'] ?? null,
                'nama_orang_tua' => $data['nama_ayah'] . ' & ' . $data['nama_ibu'],
                'status'         => 'Aktif',
                'tahun_ajaran'   => $data['tahun_ajaran'] ?? '2026/2027',
                'nik'            => $data['nik'] ?? null,
                'tempat_lahir'   => $data['tempat_lahir'] ?? null,
                'tanggal_lahir'  => $data['tanggal_lahir'],
                'alamat'         => $data['alamat'] ?? null,
                'asal_sekolah'   => $data['asal_sekolah'],
                'nama_ayah'      => $data['nama_ayah'],
                'nama_ibu'       => $data['nama_ibu'],
                'no_hp_wali'     => $data['no_hp_wali'],
                'ruang_arsip'    => $data['ruang_arsip'] ?? null,
                'lemari'         => $data['lemari'] ?? null,
                'rak'            => $data['rak'] ?? null,
                'kode_map'       => $data['kode_map'] ?? ('MAP-' . strtok(strtoupper($data['kelas']), '-') . '-' . $data['tahun_masuk'] . '-' . substr($data['nis'], -3)),
            ]);

            foreach ($dokumen as $d) {
                $file = $request->file('dok_' . $d['key']);
                if (! $file) {
                    continue;
                }

                $ukuran = $this->ukuran((int) $file->getSize());
                $nama   = $file->getClientOriginalName();
                $adalahGambar = str_starts_with((string) $file->getMimeType(), 'image/');
                $path   = $file->store('dokumen-siswa/' . $siswa->nis, 'public');

                $siswa->dokumen()->create([
                    'jenis'          => $d['label'],
                    'nama_file'      => $nama,
                    'ukuran'         => $ukuran,
                    'status'         => $d['key'] === 'kip' ? 'tambahan' : 'valid',
                    'diunggah_oleh'  => optional(auth()->user())->name ?? 'Admin',
                    'tanggal_unggah' => now()->toDateString(),
                    'path'           => $path,
                ]);

                if ($d['key'] === 'foto' && $adalahGambar) {
                    $siswa->update(['foto' => $path]);
                }
            }

            return $siswa;
        });

        return redirect()
            ->route('siswa.aktif', ['id' => $siswa->id])
            ->with('status', "Siswa {$siswa->nama} (NIS {$siswa->nis}) berhasil ditambahkan ke arsip digital.")
            ->with('tautan', route('siswa.detail', ['id' => $siswa->id]));
    }

    private function ukuran(int $byte): string
    {
        return $byte >= 1048576 ? round($byte / 1048576, 1) . ' MB' : max(1, round($byte / 1024)) . ' KB';
    }

    /** Ubah nilai php.ini seperti "8M" menjadi byte (0 = tanpa batas). */
    private function iniByte(string $kunci): int
    {
        $nilai = trim((string) ini_get($kunci));
        if ($nilai === '') {
            return 0;
        }
        $angka = (int) $nilai;

        return match (strtolower(substr($nilai, -1))) {
            'g'     => $angka * 1073741824,
            'm'     => $angka * 1048576,
            'k'     => $angka * 1024,
            default => $angka,
        };
    }
}