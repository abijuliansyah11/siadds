<?php

namespace App\Http\Controllers;

use App\Models\SiswaAktif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SiswaAktifController extends Controller
{
    /** Subquery: jumlah dokumen valid milik satu siswa. */
    private const SUB_VALID = "(select count(*) from siswa_dokumen where siswa_dokumen.siswa_aktif_id = siswa_aktif.id and siswa_dokumen.status = 'valid')";

    public function index(Request $request)
    {
        $wajib   = SiswaAktif::JUMLAH_DOKUMEN_WAJIB;
        $perPage = in_array((int) $request->per_page, [10, 25, 50], true) ? (int) $request->per_page : 10;

        $query = SiswaAktif::query()
            ->where('status', 'Aktif')
            ->withCount(['dokumen as dokumen_valid_count' => fn ($q) => $q->where('status', 'valid')]);

        if ($cari = trim((string) $request->q)) {
            $query->where(function ($w) use ($cari) {
                $w->where('nama', 'like', "%{$cari}%")
                  ->orWhere('nis', 'like', "%{$cari}%")
                  ->orWhere('nisn', 'like', "%{$cari}%")
                  ->orWhere('nama_orang_tua', 'like', "%{$cari}%");
            });
        }
        if (in_array($request->tingkat, ['X', 'XI', 'XII'], true)) {
            $query->where('kelas', 'like', $request->tingkat . '-%');
        }
        if (in_array($request->jk, ['L', 'P'], true)) {
            $query->where('jenis_kelamin', $request->jk);
        }
        if ($request->status_dokumen === 'lengkap') {
            $query->whereRaw(self::SUB_VALID . ' >= ?', [$wajib]);
        } elseif ($request->status_dokumen === 'belum') {
            $query->whereRaw(self::SUB_VALID . ' < ?', [$wajib]);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun_masuk', (int) $request->tahun);
        }

        $siswa = $query->orderBy('nis')->paginate($perPage)->withQueryString();

        // Statistik (selalu dihitung dari seluruh siswa aktif)
        $aktif         = SiswaAktif::where('status', 'Aktif');
        $total         = (clone $aktif)->count();
        $laki          = (clone $aktif)->where('jenis_kelamin', 'L')->count();
        $perempuan     = (clone $aktif)->where('jenis_kelamin', 'P')->count();
        $belumLengkap  = (clone $aktif)->whereRaw(self::SUB_VALID . ' < ?', [$wajib])->count();
        $jumlahRombel  = (clone $aktif)->distinct('kelas')->count('kelas');
        $persen        = fn (int $n) => $total > 0 ? round($n / $total * 100, 1) : 0;

        $daftarTahun = SiswaAktif::select('tahun_masuk')->distinct()->orderByDesc('tahun_masuk')->pluck('tahun_masuk');

        // Siswa yang detailnya ditampilkan di panel bawah
        $terpilih = null;
        if ($request->filled('id')) {
            $terpilih = SiswaAktif::with('dokumen')->find($request->id);
        }
        if (! $terpilih && $siswa->count() > 0) {
            $terpilih = SiswaAktif::with('dokumen')->find($siswa->first()->id);
        }
        $dokumenTerpilih = $terpilih ? $terpilih->dokumen->keyBy('jenis') : collect();

        return view('siswa-aktif', compact(
            'siswa', 'total', 'laki', 'perempuan', 'belumLengkap', 'jumlahRombel',
            'persen', 'daftarTahun', 'terpilih', 'dokumenTerpilih', 'perPage', 'wajib'
        ));
    }

    /* ====================================================================
       FITUR TAMBAHAN: ekspor, impor, ubah profil, unggah berkas, buku induk
       ==================================================================== */

    /** Query dengan filter yang sama seperti halaman daftar (dipakai untuk ekspor). */
    private function queryTersaring(Request $request)
    {
        $wajib = SiswaAktif::JUMLAH_DOKUMEN_WAJIB;
        $query = SiswaAktif::query()
            ->where('status', 'Aktif')
            ->withCount(['dokumen as dokumen_valid_count' => fn ($q) => $q->where('status', 'valid')]);

        if ($cari = trim((string) $request->q)) {
            $query->where(function ($w) use ($cari) {
                $w->where('nama', 'like', "%{$cari}%")
                  ->orWhere('nis', 'like', "%{$cari}%")
                  ->orWhere('nisn', 'like', "%{$cari}%")
                  ->orWhere('nama_orang_tua', 'like', "%{$cari}%");
            });
        }
        if (in_array($request->tingkat, ['X', 'XI', 'XII'], true)) {
            $query->where('kelas', 'like', $request->tingkat . '-%');
        }
        if (in_array($request->jk, ['L', 'P'], true)) {
            $query->where('jenis_kelamin', $request->jk);
        }
        if ($request->status_dokumen === 'lengkap') {
            $query->whereRaw(self::SUB_VALID . ' >= ?', [$wajib]);
        } elseif ($request->status_dokumen === 'belum') {
            $query->whereRaw(self::SUB_VALID . ' < ?', [$wajib]);
        }
        if ($request->filled('tahun')) {
            $query->where('tahun_masuk', (int) $request->tahun);
        }

        return $query;
    }

    private function pesanValidasi(): array
    {
        return [
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
            'integer'  => ':attribute harus berupa angka.',
        ];
    }

    private function namaAtribut(): array
    {
        return [
            'nama' => 'Nama lengkap', 'nisn' => 'NISN', 'nis' => 'NIS', 'nik' => 'NIK',
            'jenis_kelamin' => 'Jenis kelamin', 'kelas' => 'Kelas', 'tahun_masuk' => 'Tahun masuk',
            'tanggal_masuk' => 'Tanggal masuk', 'tanggal_lahir' => 'Tanggal lahir', 'no_hp_wali' => 'No. HP wali',
            'jenis' => 'Jenis dokumen', 'berkas' => 'Berkas',
        ];
    }

    public function ekspor(Request $request)
    {
        $rows  = $this->queryTersaring($request)->orderBy('nis')->get();
        $wajib = SiswaAktif::JUMLAH_DOKUMEN_WAJIB;

        return response()->streamDownload(function () use ($rows, $wajib) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['NIS', 'NISN', 'Nama', 'Panggilan', 'L/P', 'Kelas', 'Rombel', 'Tahun Masuk', 'Tanggal Masuk', 'Wali Kelas', 'Orang Tua', 'Dokumen Valid', 'Status']);
            foreach ($rows as $s) {
                fputcsv($out, [
                    $s->nis, $s->nisn, $s->nama, $s->panggilan, $s->jenis_kelamin, $s->kelas, $s->rombel, $s->tahun_masuk,
                    optional($s->tanggal_masuk)->format('Y-m-d'), $s->wali_kelas, $s->nama_orang_tua,
                    min($s->dokumen_valid_count, $wajib) . '/' . $wajib, $s->status,
                ]);
            }
            fclose($out);
        }, 'data-siswa-aktif-' . now()->format('Ymd') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function template()
    {
        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['nis', 'nisn', 'nama', 'panggilan', 'jenis_kelamin', 'kelas', 'rombel', 'tahun_masuk', 'tanggal_masuk', 'wali_kelas', 'nama_orang_tua']);
            fputcsv($out, ['2026101', '0091234567', 'Contoh Siswa', 'Contoh', 'L', 'X-A', 'Peminatan MIPA 1', '2026', '2026-07-15', 'Dra. Hj. Nurjanah', 'Bapak Contoh & Ibu Contoh']);
            fclose($out);
        }, 'template-impor-siswa-aktif.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function impor(Request $request)
    {
        $request->validate(['berkas' => 'required|file|max:2048'], [
            'required' => 'Pilih berkas CSV terlebih dahulu.',
            'max'      => 'Ukuran berkas maksimal 2 MB.',
        ], ['berkas' => 'Berkas']);

        $file = $request->file('berkas');
        if (! in_array(strtolower($file->getClientOriginalExtension()), ['csv', 'txt'], true)) {
            return redirect()->route('siswa.aktif')->withErrors(['berkas' => 'Berkas harus berformat CSV. Gunakan template yang disediakan.']);
        }

        $handle = fopen($file->getRealPath(), 'r');
        $baris1 = (string) fgets($handle);
        rewind($handle);
        $baris1 = preg_replace('/^\xEF\xBB\xBF/', '', $baris1);
        $delim  = substr_count($baris1, ';') > substr_count($baris1, ',') ? ';' : ',';

        $header = fgetcsv($handle, 0, $delim);
        if (! $header) {
            fclose($handle);
            return redirect()->route('siswa.aktif')->withErrors(['berkas' => 'Berkas kosong atau tidak terbaca.']);
        }
        $header = array_map(fn ($h) => strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', (string) $h))), $header);

        $hilang = array_diff(['nis', 'nisn', 'nama', 'jenis_kelamin', 'kelas', 'tahun_masuk'], $header);
        if ($hilang) {
            fclose($handle);
            return redirect()->route('siswa.aktif')->withErrors(['berkas' => 'Kolom wajib tidak ditemukan: ' . implode(', ', $hilang) . '. Gunakan template yang disediakan.']);
        }

        $rules = [
            'nis'           => ['required', 'max:20', 'regex:/^[A-Za-z0-9\-]+$/', 'unique:siswa_aktif,nis', 'unique:alumni,nis'],
            'nisn'          => ['required', 'digits:10', 'unique:siswa_aktif,nisn', 'unique:alumni,nisn'],
            'nama'          => ['required', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'kelas'         => ['required', 'regex:/^(X|XI|XII)-[A-Za-z0-9]{1,3}$/'],
            'tahun_masuk'   => ['required', 'integer', 'between:2000,2100'],
            'tanggal_masuk' => ['nullable', 'date'],
        ];

        $berhasil = 0;
        $gagal    = [];
        $no       = 1;

        while (($row = fgetcsv($handle, 0, $delim)) !== false) {
            $no++;
            if (count(array_filter($row, fn ($v) => trim((string) $v) !== '')) === 0) {
                continue;
            }
            $row = array_pad($row, count($header), null);
            $d   = array_combine($header, array_slice($row, 0, count($header)));
            $d   = array_map(fn ($v) => is_string($v) ? trim($v) : $v, $d);
            $d   = array_map(fn ($v) => $v === '' ? null : $v, $d);

            $jk = strtoupper(substr((string) ($d['jenis_kelamin'] ?? ''), 0, 1));
            if (in_array($jk, ['L', 'P'], true)) {
                $d['jenis_kelamin'] = $jk;
            }
            $d['kelas'] = strtoupper((string) ($d['kelas'] ?? ''));

            $v = Validator::make($d, $rules, $this->pesanValidasi(), $this->namaAtribut());
            if ($v->fails()) {
                $gagal[] = "Baris {$no}: " . $v->errors()->first();
                continue;
            }

            SiswaAktif::create([
                'nis'            => $d['nis'],
                'nisn'           => $d['nisn'],
                'nama'           => $d['nama'],
                'panggilan'      => $d['panggilan'] ?? null,
                'jenis_kelamin'  => $d['jenis_kelamin'],
                'kelas'          => $d['kelas'],
                'rombel'         => $d['rombel'] ?? null,
                'tahun_masuk'    => (int) $d['tahun_masuk'],
                'tanggal_masuk'  => $d['tanggal_masuk'] ?? ((int) $d['tahun_masuk'] . '-07-15'),
                'wali_kelas'     => $d['wali_kelas'] ?? null,
                'nama_orang_tua' => $d['nama_orang_tua'] ?? null,
                'status'         => 'Aktif',
                'tahun_ajaran'   => '2026/2027',
            ]);
            $berhasil++;
        }
        fclose($handle);

        $balik = redirect()->route('siswa.aktif')->with('status', "Impor selesai: {$berhasil} siswa ditambahkan, " . count($gagal) . ' baris dilewati.');
        if ($gagal) {
            $balik->with('peringatan', implode(' • ', array_slice($gagal, 0, 5)) . (count($gagal) > 5 ? ' • dan ' . (count($gagal) - 5) . ' baris lainnya.' : ''));
        }

        return $balik;
    }

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
            'lemari'        => 'nullable|string|max:40',
            'rak'           => 'nullable|string|max:20',
        ], $this->pesanValidasi(), $this->namaAtribut());

        $data['kelas'] = strtoupper($data['kelas']);
        $ayah = $data['nama_ayah'] ?? '';
        $ibu  = $data['nama_ibu'] ?? '';
        if ($ayah !== '' || $ibu !== '') {
            $data['nama_orang_tua'] = trim($ayah . ' & ' . $ibu, ' &');
        }

        $siswa->update($data);

        return redirect()->route('siswa.aktif', ['id' => $siswa->id])->with('status', "Profil {$siswa->nama} berhasil diperbarui.");
    }

    public function unggah(Request $request, int $id)
    {
        $siswa = SiswaAktif::findOrFail($id);

        $data = $request->validate([
            'jenis'  => ['required', Rule::in(SiswaAktif::DOKUMEN_WAJIB)],
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], $this->pesanValidasi(), $this->namaAtribut());

        $file   = $request->file('berkas');
        $byte   = (int) $file->getSize();
        $ukuran = $byte >= 1048576 ? round($byte / 1048576, 1) . ' MB' : max(1, round($byte / 1024)) . ' KB';
        $nama   = $file->getClientOriginalName();
        $gambar = str_starts_with((string) $file->getMimeType(), 'image/');
        $path   = $file->store('dokumen-siswa/' . $siswa->nis, 'public');

        $isi = [
            'nama_file'      => $nama,
            'ukuran'         => $ukuran,
            'status'         => 'valid',
            'path'           => $path,
            'diunggah_oleh'  => optional(auth()->user())->name ?? 'Admin',
            'tanggal_unggah' => now()->toDateString(),
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

        return redirect()->route('siswa.aktif', ['id' => $siswa->id])->with('status', "{$data['jenis']} berhasil diunggah.");
    }

    public function bukuInduk(int $id)
    {
        $siswa = SiswaAktif::with('dokumen')->findOrFail($id);

        return view('siswa-buku-induk', ['siswa' => $siswa, 'wajib' => SiswaAktif::JUMLAH_DOKUMEN_WAJIB]);
    }
}