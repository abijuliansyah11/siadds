<?php

namespace App\Http\Controllers;

use App\Models\SiswaAktif;
use App\Models\SiswaDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SiswaDetailController extends Controller
{
    /** [kategori, keterangan, ikon] untuk setiap jenis dokumen. */
    private const META = [
        'Kartu Keluarga (KK)'                => ['Identitas', 'Dokumen identitas keluarga', 'users'],
        'Akta Kelahiran'                     => ['Identitas', 'Bukti identitas kelahiran siswa', 'file'],
        'Ijazah / SKL MTs'                   => ['Akademik', 'Ijazah / surat keterangan lulus (legalisir)', 'file'],
        'KTP Orang Tua (Ayah & Ibu)'         => ['Identitas', 'Wajib untuk arsip digital madrasah', 'user'],
        'Pas Foto Resmi 3x4'                 => ['Foto', 'Foto KTA & buku induk santri', 'user'],
        'Surat Pernyataan Kesediaan Santri'  => ['Pendukung', 'Bermaterai Rp 10.000', 'check'],
        'Kartu Bantuan (KIP / PKH / KKS)'    => ['Pendukung', 'Program afirmasi madrasah', 'folder'],
    ];

    private function baris(string $jenis, ?SiswaDokumen $d, bool $wajib): array
    {
        $m      = self::META[$jenis] ?? ['Pendukung', 'Dokumen pendukung', 'file'];
        $status = ! $d ? 'belum' : (in_array($d->status, ['valid', 'tambahan'], true) ? 'terverifikasi' : 'menunggu');

        return [
            'jenis' => $jenis, 'kategori' => $m[0], 'ket' => $m[1], 'icon' => $m[2],
            'dok' => $d, 'status' => $status, 'wajib' => $wajib,
        ];
    }

    public function show(Request $request, ?int $id = null)
    {
        $daftar = SiswaAktif::where('status', 'Aktif')->orderBy('nis')->get(['id', 'nis', 'nama', 'kelas']);

        $id    = $id ?: (int) $request->query('id');
        $siswa = $id ? SiswaAktif::with('dokumen')->find($id) : null;
        $siswa = $siswa ?: (SiswaAktif::with('dokumen')->where('status', 'Aktif')->orderBy('nis')->first() ?: SiswaAktif::with('dokumen')->orderBy('nis')->first());

        // Siswa yang sudah lulus tetap bisa dibuka (dari Data Alumni) walau tidak ada di daftar siswa aktif.
        if ($siswa && ! $daftar->contains('id', $siswa->id)) {
            $daftar->push($siswa);
        }
        $alumniTerkait = $siswa ? \App\Models\Alumni::where('nis', $siswa->nis)->first() : null;

        if (! $siswa) {
            return view('siswa-detail', ['siswa' => null, 'daftar' => $daftar]);
        }

        $rows = [];
        foreach (SiswaAktif::DOKUMEN_WAJIB as $jenis) {
            $rows[] = $this->baris($jenis, $siswa->dokumen->firstWhere('jenis', $jenis), true);
        }
        foreach ($siswa->dokumen->whereNotIn('jenis', SiswaAktif::DOKUMEN_WAJIB) as $d) {
            $rows[] = $this->baris($d->jenis, $d, false);
        }

        $wajibRows = array_values(array_filter($rows, fn ($r) => $r['wajib']));
        $total     = count($wajibRows);
        $ter       = count(array_filter($wajibRows, fn ($r) => $r['status'] === 'terverifikasi'));
        $menunggu  = count(array_filter($wajibRows, fn ($r) => $r['status'] === 'menunggu'));
        $belum     = count(array_filter($wajibRows, fn ($r) => $r['status'] === 'belum'));
        $kumpul    = $ter + $menunggu;
        $ringkas   = [
            'total' => $total, 'ter' => $ter, 'menunggu' => $menunggu, 'belum' => $belum,
            'kumpul' => $kumpul, 'pct' => $total > 0 ? round($kumpul / $total * 100, 1) : 0,
            'kurang' => implode(' & ', array_map(fn ($r) => $r['jenis'], array_filter($wajibRows, fn ($r) => $r['status'] === 'belum'))),
        ];

        $log = collect([['judul' => 'Siswa didaftarkan ke arsip digital', 'oleh' => 'Sistem', 'waktu' => $siswa->created_at]])
            ->merge($siswa->dokumen->map(fn ($d) => [
                'judul' => "Dokumen {$d->jenis} diunggah",
                'oleh'  => $d->diunggah_oleh ?: '-',
                'waktu' => $d->updated_at ?? $d->created_at,
            ]))
            ->when(
                $siswa->updated_at && $siswa->created_at && $siswa->updated_at->gt($siswa->created_at->copy()->addMinute()),
                fn ($koleksi) => $koleksi->push(['judul' => 'Profil siswa diperbarui', 'oleh' => 'Operator', 'waktu' => $siswa->updated_at])
            )
            ->sortByDesc('waktu')->values();

        $jenisUnggah = array_merge(SiswaAktif::DOKUMEN_WAJIB, ['Kartu Bantuan (KIP / PKH / KKS)']);

        return view('siswa-detail', compact('siswa', 'daftar', 'rows', 'ringkas', 'log', 'jenisUnggah', 'alumniTerkait'));
    }

    public function unggah(Request $request, int $id)
    {
        $siswa = SiswaAktif::findOrFail($id);
        $jenisSah = array_merge(SiswaAktif::DOKUMEN_WAJIB, ['Kartu Bantuan (KIP / PKH / KKS)']);

        $data = $request->validate([
            'jenis'  => ['required', Rule::in($jenisSah)],
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'required' => ':attribute wajib diisi.',
            'in'       => 'Jenis dokumen tidak valid.',
            'mimes'    => 'Berkas harus berformat PDF, JPG, atau PNG.',
            'max'      => 'Ukuran berkas maksimal 5 MB.',
        ], ['jenis' => 'Jenis dokumen', 'berkas' => 'Berkas']);

        $file   = $request->file('berkas');
        $byte   = (int) $file->getSize();
        $ukuran = $byte >= 1048576 ? round($byte / 1048576, 1) . ' MB' : max(1, round($byte / 1024)) . ' KB';
        $nama   = $file->getClientOriginalName();
        $gambar = str_starts_with((string) $file->getMimeType(), 'image/');
        $path   = $file->store('dokumen-siswa/' . $siswa->nis, 'public');

        $isi = [
            'nama_file'      => $nama,
            'ukuran'         => $ukuran,
            'status'         => 'pending',
            'diunggah_oleh'  => optional(auth()->user())->name ?? 'Admin',
            'tanggal_unggah' => now()->toDateString(),
            'path'           => $path,
        ];

        $lama = $siswa->dokumen()->where('jenis', $data['jenis'])->first();
        if ($lama) {
            if ($lama->path) {
                Storage::disk('public')->delete($lama->path);
            }
            $lama->update($isi);
        } else {
            $siswa->dokumen()->create($isi + ['jenis' => $data['jenis']]);
        }

        if ($data['jenis'] === SiswaAktif::DOKUMEN_WAJIB[4] && $gambar) {
            $siswa->update(['foto' => $path]);
        }

        return redirect()->route('siswa.detail', ['id' => $siswa->id])
            ->with('status', "Dokumen {$data['jenis']} berhasil diunggah dan menunggu verifikasi.");
    }

    public function verifikasi(int $id)
    {
        $dok = SiswaDokumen::findOrFail($id);
        $dok->update(['status' => 'valid']);

        return redirect()->route('siswa.detail', ['id' => $dok->siswa_aktif_id])
            ->with('status', "Dokumen {$dok->jenis} berhasil diverifikasi.");
    }

    /** Ubah profil siswa dari halaman Detail Profil. */
    public function update(Request $request, int $id)
    {
        $siswa = SiswaAktif::findOrFail($id);

        $data = $request->validate([
            'nama'          => 'required|string|max:100',
            'panggilan'     => 'nullable|string|max:50',
            'jenis_kelamin' => 'required|in:L,P',
            'nisn'          => ['required', 'digits:10', Rule::unique('siswa_aktif', 'nisn')->ignore($siswa->id)],
            'nis'           => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9\-]+$/', Rule::unique('siswa_aktif', 'nis')->ignore($siswa->id)],
            'kelas'         => ['required', 'regex:/^(X|XI|XII)-[A-Za-z0-9]{1,3}$/'],
            'rombel'        => 'nullable|string|max:80',
            'tahun_masuk'   => 'required|integer|between:2000,2100',
            'tanggal_masuk' => 'nullable|date',
            'wali_kelas'    => 'nullable|string|max:100',
            'tempat_lahir'  => 'nullable|string|max:60',
            'tanggal_lahir' => 'nullable|date|before:today',
            'nik'           => ['nullable', 'digits:16', Rule::unique('siswa_aktif', 'nik')->ignore($siswa->id)],
            'alamat'        => 'nullable|string|max:500',
            'asal_sekolah'  => 'nullable|string|max:150',
            'nama_ayah'     => 'nullable|string|max:100',
            'nama_ibu'      => 'nullable|string|max:100',
            'no_hp_wali'    => ['nullable', 'regex:/^[0-9+\- ]{8,20}$/'],
            'ruang_arsip'   => 'nullable|string|max:100',
            'lemari'        => 'nullable|string|max:40',
            'rak'           => 'nullable|string|max:20',
            'kode_map'      => 'nullable|string|max:40',
        ], [
            'required' => ':attribute wajib diisi.',
            'digits'   => ':attribute harus :digits digit angka.',
            'unique'   => ':attribute sudah terdaftar di database.',
            'regex'    => 'Format :attribute tidak valid.',
            'in'       => ':attribute tidak valid.',
            'date'     => ':attribute bukan tanggal yang valid.',
            'before'   => ':attribute harus sebelum hari ini.',
            'max'      => ':attribute melebihi batas yang diizinkan.',
            'between'  => ':attribute di luar rentang yang diizinkan.',
            'integer'  => ':attribute harus berupa angka.',
        ], [
            'nama' => 'Nama lengkap', 'nisn' => 'NISN', 'nis' => 'NIS', 'nik' => 'NIK', 'jenis_kelamin' => 'Jenis kelamin',
            'kelas' => 'Kelas', 'tahun_masuk' => 'Tahun masuk', 'tanggal_masuk' => 'Tanggal masuk',
            'tanggal_lahir' => 'Tanggal lahir', 'no_hp_wali' => 'No. HP wali',
        ]);

        $data['kelas'] = strtoupper($data['kelas']);
        $ayah = $data['nama_ayah'] ?? '';
        $ibu  = $data['nama_ibu'] ?? '';
        if ($ayah !== '' || $ibu !== '') {
            $data['nama_orang_tua'] = trim($ayah . ' & ' . $ibu, ' &');
        }

        $siswa->update($data);

        return redirect()->route('siswa.detail', ['id' => $siswa->id])
            ->with('status', "Profil {$siswa->nama} berhasil diperbarui.");
    }
}