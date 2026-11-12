<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Pendaftaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PendaftaranController extends Controller
{
    /** Dokumen yang diunggah di langkah 5 (foto diunggah di langkah 1). */
    private const DOKUMEN = ['akta', 'kk', 'ijazah', 'kip'];
    private const DOKUMEN_WAJIB = ['akta', 'kk', 'ijazah'];

    /**
     * Simpan formulir pendaftaran.
     *   status = draft     -> boleh belum lengkap (hanya nama wajib)
     *   status = terkirim  -> semua isian wajib harus benar, lalu dicatat juga ke calon_siswa
     */
    public function store(Request $request): JsonResponse
    {
        $final = $request->input('status') === 'terkirim';

        // Cari data yang sudah ada (draft yang sama), supaya tidak menjadi dobel
        $record = $request->filled('id') ? Pendaftaran::find($request->input('id')) : null;
        if (! $record && $request->filled('nisn')) {
            $record = Pendaftaran::where('nisn', $request->input('nisn'))->where('status', 'draft')->first();
        }
        $ignore = $record?->id;

        $w = $final ? 'required' : 'nullable';
        $hp = 'regex:/^(\+62|0)[0-9\s-]{8,14}$/';

        $rules = [
            'nama'   => ['required', 'string', 'min:3', 'max:120'],
            'nisn'   => [$w, 'digits:10', Rule::unique('pendaftaran', 'nisn')->ignore($ignore)],
            'nik'    => [$w, 'digits:16', Rule::unique('pendaftaran', 'nik')->ignore($ignore)],
            'jk'     => [$w, Rule::in(['L', 'P'])],
            'agama'  => [$w, 'string', 'max:20'],
            'tempat' => [$w, 'string', 'max:80'],
            'tgl'    => [$w, 'date', 'before:today'],
            'hp'     => [$w, $hp],
            'email'  => ['nullable', 'email', 'max:120'],
            'alamat' => [$w, 'string', 'max:255'],
            'desa'   => [$w, 'string', 'max:80'],
            'kec'    => [$w, 'string', 'max:80'],
            'kab'    => [$w, 'string', 'max:80'],
            'prov'   => [$w, 'string', 'max:80'],
            'pos'    => ['nullable', 'digits:5'],
            'sek'    => [$w, 'string', 'max:120'],
            'lulus'  => [$w, 'digits:4'],
            'jalur'  => [$w, Rule::in(['Reguler', 'Prestasi', 'Afirmasi'])],
            'minat'  => ['nullable', 'string', 'max:20'],
            'ayah'   => [$w, 'string', 'max:120'],
            'ibu'    => [$w, 'string', 'max:120'],
            'kerja'  => ['nullable', 'string', 'max:30'],
            'hpo'    => [$w, $hp],
            'wali'   => ['nullable', 'string', 'max:120'],
            'foto'   => ['nullable', 'image', 'max:2048'],
        ];
        foreach (self::DOKUMEN as $k) {
            $rules["dok_$k"] = ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'];
        }

        $messages = [
            'required' => ':attribute wajib diisi.',
            'digits'   => ':attribute harus :digits digit angka.',
            'unique'   => ':attribute sudah terdaftar pada pendaftar lain.',
            'regex'    => ':attribute tidak valid (contoh 0821-7890-1234).',
            'email'    => 'Format email tidak valid.',
            'before'   => 'Tanggal lahir tidak valid.',
            'max'      => ':attribute terlalu panjang / ukuran berkas melebihi 2 MB.',
            'image'    => 'Foto harus berformat JPG/PNG.',
            'mimes'    => 'Berkas harus berformat PDF, JPG, atau PNG.',
            'in'       => ':attribute tidak valid.',
        ];
        $attributes = [
            'nama' => 'Nama lengkap', 'nisn' => 'NISN', 'nik' => 'NIK', 'jk' => 'Jenis kelamin',
            'agama' => 'Agama', 'tempat' => 'Tempat lahir', 'tgl' => 'Tanggal lahir', 'hp' => 'Nomor HP',
            'alamat' => 'Alamat', 'desa' => 'Desa / kelurahan', 'kec' => 'Kecamatan', 'kab' => 'Kabupaten / kota',
            'prov' => 'Provinsi', 'pos' => 'Kode pos', 'sek' => 'Asal sekolah', 'lulus' => 'Tahun lulus',
            'jalur' => 'Jalur', 'ayah' => 'Nama ayah', 'ibu' => 'Nama ibu', 'hpo' => 'Nomor HP orang tua',
            'foto' => 'Pas foto',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        $validator->after(function ($v) use ($request, $record, $final) {
            // NISN tidak boleh sudah dipakai calon siswa lain
            if ($request->filled('nisn') && ! $v->errors()->has('nisn')) {
                $bentrok = CalonSiswa::where('nisn', $request->input('nisn'))
                    ->when($record, fn ($q) => $q->where('reg', '!=', $record->no_registrasi))
                    ->exists();
                if ($bentrok) {
                    $v->errors()->add('nisn', 'NISN sudah terdaftar pada calon siswa lain.');
                }
            }

            // Saat dikirim, foto + dokumen wajib harus ada (baru diunggah atau sudah tersimpan)
            if ($final) {
                if (! $request->hasFile('foto') && ! $record?->foto_path) {
                    $v->errors()->add('foto', 'Pas foto wajib diunggah.');
                }
                foreach (self::DOKUMEN_WAJIB as $k) {
                    if (! $request->hasFile("dok_$k") && empty($record?->dokumen[$k]['path'])) {
                        $v->errors()->add("dok_$k", 'Dokumen wajib belum diunggah: ' . strtoupper($k) . '.');
                    }
                }
            }
        });

        $validator->validate();   // gagal -> otomatis balasan JSON 422

        $data = $request->only(Pendaftaran::FIELD);
        $data['status'] = $final ? 'terkirim' : 'draft';
        $data['diubah_oleh'] = Auth::id();

        $record = DB::transaction(function () use ($record, $data, $request, $final) {
            if ($record) {
                $record->update($data);
            } else {
                $data['no_registrasi'] = Pendaftaran::nomorBerikutnya();
                $data['dibuat_oleh'] = Auth::id();
                $record = Pendaftaran::create($data);
            }

            // ---- Berkas ----
            $dir = 'pendaftaran/' . $record->id;
            if ($request->hasFile('foto')) {
                if ($record->foto_path) {
                    Storage::disk('public')->delete($record->foto_path);
                }
                $record->foto_path = $request->file('foto')->store($dir, 'public');
            }
            $dok = $record->dokumen ?? [];
            foreach (self::DOKUMEN as $k) {
                if ($request->hasFile("dok_$k")) {
                    if (! empty($dok[$k]['path'])) {
                        Storage::disk('public')->delete($dok[$k]['path']);
                    }
                    $f = $request->file("dok_$k");
                    $dok[$k] = [
                        'name' => $f->getClientOriginalName(),
                        'path' => $f->store($dir, 'public'),
                        'size' => $f->getSize(),
                    ];
                }
            }
            $record->dokumen = $dok;

            // ---- Kelengkapan ----
            $isi = collect(Pendaftaran::WAJIB)->filter(fn ($k) => filled($record->{$k}))->count();
            $docs = collect(self::DOKUMEN_WAJIB)->filter(fn ($k) => ! empty($dok[$k]['path']))->count()
                + ($record->foto_path ? 1 : 0);
            $total = count(Pendaftaran::WAJIB) + count(self::DOKUMEN_WAJIB) + 1;
            $record->kelengkapan = (int) round(($isi + $docs) / $total * 100);
            $record->progres = [
                'wajib_terisi' => $isi, 'wajib_total' => count(Pendaftaran::WAJIB),
                'dokumen' => $docs, 'dokumen_total' => count(self::DOKUMEN_WAJIB) + 1,
            ];
            $record->save();

            // ---- Saat dikirim: catat juga ke daftar calon siswa (dibaca halaman Penerimaan) ----
            if ($final) {
                CalonSiswa::updateOrCreate(
                    ['reg' => $record->no_registrasi],
                    [
                        'nama'          => $record->nama,
                        'nisn'          => $record->nisn,
                        'asal_sekolah'  => $record->sek,
                        'jalur'         => $record->jalur,
                        'tanggal_masuk' => now('Asia/Jakarta')->toDateString(),
                        'jenis_kelamin' => $record->jk,
                        'status_berkas' => 'M',
                    ]
                );
            }

            return $record;
        });

        return response()->json([
            'ok'            => true,
            'message'       => $final ? 'Pendaftaran berhasil dikirim.' : 'Draft tersimpan di database.',
            'id'            => $record->id,
            'no_registrasi' => $record->no_registrasi,
            'kelengkapan'   => $record->kelengkapan,
        ]);
    }
}