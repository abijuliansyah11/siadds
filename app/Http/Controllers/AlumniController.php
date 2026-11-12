<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AlumniDokumen;
use App\Models\SiswaAktif;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    /** Query daftar alumni dengan seluruh filter dari halaman. */
    private function filter(Request $request)
    {
        $query = Alumni::query();

        if ($cari = trim((string) $request->q)) {
            $query->where(function ($w) use ($cari) {
                $w->where('nama', 'like', "%{$cari}%")
                  ->orWhere('nis', 'like', "%{$cari}%")
                  ->orWhere('nisn', 'like', "%{$cari}%")
                  ->orWhere('nomor_ijazah', 'like', "%{$cari}%")
                  ->orWhere('tahun_lulus', 'like', "%{$cari}%");
            });
        }
        if ($request->filled('tahun'))  { $query->where('tahun_lulus', (int) $request->tahun); }
        if ($request->filled('kelas'))  { $query->where('kelas_terakhir', $request->kelas); }
        if (in_array($request->jk, ['L', 'P'], true)) { $query->where('jenis_kelamin', $request->jk); }
        if ($request->arsip === 'lengkap') { $query->has('dokumen', '>=', count(Alumni::DOKUMEN)); }
        if ($request->arsip === 'belum')   { $query->has('dokumen', '<', count(Alumni::DOKUMEN)); }
        if (in_array($request->ambil, ['diambil', 'tersimpan', 'menunggu'], true)) { $query->where('status_ijazah', $request->ambil); }
        if ($request->filled('ids')) {
            $query->whereIn('id', array_filter(array_map('intval', explode(',', (string) $request->ids))));
        }

        return $query;
    }

    public function index(Request $request)
    {
        $perPage = in_array((int) $request->per_page, [10, 25, 50], true) ? (int) $request->per_page : 10;

        $alumni = $this->filter($request)->with('dokumen:id,alumni_id,jenis')
            ->orderByDesc('tahun_lulus')->orderBy('nama')
            ->paginate($perPage)->withQueryString();

        $terpilih = $request->filled('id') ? Alumni::with('dokumen')->find($request->id) : null;
        if (! $terpilih && $alumni->count() > 0) {
            $terpilih = Alumni::with('dokumen')->find($alumni->first()->id);
        }

        // Statistik
        $total          = Alumni::count();
        $tahunTerbaru   = Alumni::max('tahun_lulus');
        $lulusTerbaru   = $tahunTerbaru ? Alumni::where('tahun_lulus', $tahunTerbaru)->count() : 0;
        $angkatanBaru   = $tahunTerbaru ? Alumni::where('tahun_lulus', $tahunTerbaru)->value('angkatan') : null;
        $tglTerbaru     = $tahunTerbaru ? Alumni::where('tahun_lulus', $tahunTerbaru)->max('tanggal_kelulusan') : null;
        $tglTerbaru     = $tglTerbaru ? Carbon::parse($tglTerbaru) : null;
        $jumlahAngkatan = Alumni::distinct()->count('tahun_lulus');
        $laki           = Alumni::where('jenis_kelamin', 'L')->count();
        $perempuan      = Alumni::where('jenis_kelamin', 'P')->count();
        $topJurusan     = fn (string $jk) => optional(
            Alumni::where('jenis_kelamin', $jk)->whereNotNull('jurusan')
                ->select('jurusan', DB::raw('count(*) as c'))->groupBy('jurusan')->orderByDesc('c')->first()
        )->jurusan;
        $topL = $topJurusan('L');
        $topP = $topJurusan('P');

        $slot     = $total * count(Alumni::DOKUMEN);
        $pctArsip = $slot > 0 ? round(min(AlumniDokumen::count(), $slot) / $slot * 100, 1) : 0;
        $persen   = fn (int $n) => $total > 0 ? round($n / $total * 100, 1) : 0;

        $daftarTahun = Alumni::select('tahun_lulus', 'angkatan')->distinct()->orderByDesc('tahun_lulus')->get();
        $daftarKelas = Alumni::select('kelas_terakhir')->distinct()->orderBy('kelas_terakhir')->pluck('kelas_terakhir');
        $kandidat    = SiswaAktif::where('status', 'Aktif')->where('kelas', 'like', 'XII-%')
            ->orderBy('kelas')->orderBy('nama')->get(['id', 'nis', 'nama', 'kelas', 'rombel']);

        $log = collect();
        if ($terpilih) {
            if ($terpilih->tanggal_kelulusan) {
                $log->push(['judul' => 'Kelulusan ditetapkan melalui rapat pleno', 'oleh' => 'Dewan Guru & Kepala Madrasah', 'waktu' => $terpilih->tanggal_kelulusan]);
            }
            $log->push(['judul' => 'Data dipindahkan ke Arsip Alumni', 'oleh' => 'Sistem SIADDS', 'waktu' => $terpilih->created_at]);
            foreach ($terpilih->dokumen as $d) {
                $log->push(['judul' => "{$d->jenis} diunggah", 'oleh' => $d->diunggah_oleh ?: '-', 'waktu' => $d->updated_at ?? $d->created_at]);
            }
            if ($terpilih->status_ijazah === 'diambil' && $terpilih->tanggal_pengambilan) {
                $log->push(['judul' => 'Ijazah asli diserahkan kepada ' . ($terpilih->diambil_oleh ?: 'yang bersangkutan'), 'oleh' => 'Petugas TU', 'waktu' => $terpilih->tanggal_pengambilan]);
            }
            $log = $log->sortByDesc('waktu')->values();
        }

        $siswaAsal = $terpilih ? SiswaAktif::where('nis', $terpilih->nis)->first() : null;

        return view('alumni', compact(
            'alumni', 'terpilih', 'total', 'tahunTerbaru', 'lulusTerbaru', 'angkatanBaru', 'tglTerbaru',
            'jumlahAngkatan', 'laki', 'perempuan', 'topL', 'topP', 'pctArsip', 'persen',
            'daftarTahun', 'daftarKelas', 'kandidat', 'perPage', 'log', 'siswaAsal'
        ));
    }

    /** Proses kelulusan: siswa aktif kelas XII dipindahkan menjadi alumni. */
    public function proses(Request $request)
    {
        $data = $request->validate([
            'siswa_ids'         => 'required|array|min:1',
            'siswa_ids.*'       => 'integer|exists:siswa_aktif,id',
            'tahun_lulus'       => 'required|integer|between:2000,2100',
            'tanggal_kelulusan' => 'required|date',
        ], [
            'required' => ':attribute wajib diisi.',
            'min'      => 'Pilih minimal satu siswa.',
            'between'  => ':attribute di luar rentang yang diizinkan.',
            'date'     => ':attribute bukan tanggal yang valid.',
        ], ['siswa_ids' => 'Daftar siswa', 'tahun_lulus' => 'Tahun lulus', 'tanggal_kelulusan' => 'Tanggal penetapan']);

        $tanggal  = Carbon::parse($data['tanggal_kelulusan']);
        $angkatan = (int) $data['tahun_lulus'] - 2020;
        $dibuat   = 0;

        DB::transaction(function () use ($data, $tanggal, $angkatan, &$dibuat) {
            $siswaList = SiswaAktif::whereIn('id', $data['siswa_ids'])->where('status', 'Aktif')->get();

            foreach ($siswaList as $s) {
                if (Alumni::where('nis', $s->nis)->orWhere('nisn', $s->nisn)->exists()) {
                    continue;
                }
                $urut = (int) Alumni::max('id') + 1;

                $baru = Alumni::create([
                    'nis'               => $s->nis,
                    'nisn'              => $s->nisn,
                    'nama'              => $s->nama,
                    'panggilan'         => $s->panggilan,
                    'jenis_kelamin'     => $s->jenis_kelamin,
                    'nik'               => $s->nik,
                    'kelas_terakhir'    => $s->kelas,
                    'jurusan'           => $s->rombel,
                    'tahun_masuk'       => $s->tahun_masuk,
                    'tahun_lulus'       => $data['tahun_lulus'],
                    'angkatan'          => $angkatan,
                    'tanggal_kelulusan' => $tanggal->toDateString(),
                    'nomor_ijazah'      => 'MA-' . $tanggal->format('d-m-Y') . '-' . str_pad((string) $urut, 5, '0', STR_PAD_LEFT),
                    'foto'              => $s->foto,
                    'status_ijazah'     => 'tersimpan',
                    'ruang_arsip'       => $s->ruang_arsip,
                    'lemari'            => $s->lemari,
                    'rak'               => $s->rak,
                    'kode_map'          => 'M-ALUMNI-' . $data['tahun_lulus'] . '-' . substr($s->nis, -3),
                ]);

                $this->salinDokumen($s, $baru);
                $s->update(['status' => 'Lulus']);
                $dibuat++;
            }
        });

        if ($dibuat === 0) {
            return redirect()->route('alumni')->withErrors(['siswa_ids' => 'Tidak ada siswa baru yang diproses (mungkin sudah tercatat sebagai alumni).']);
        }

        return redirect()->route('alumni')->with('status', "{$dibuat} siswa berhasil diproses menjadi alumni. Berkas kelulusan dapat dilengkapi dari panel detail.");
    }

    public function unggah(Request $request, int $id)
    {
        $alumni = Alumni::findOrFail($id);
        $labels = array_column(Alumni::DOKUMEN, 'label');

        $data = $request->validate([
            'jenis'  => ['required', \Illuminate\Validation\Rule::in($labels)],
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
        $path   = $file->store('dokumen-alumni/' . $alumni->nis, 'public');

        $isi = [
            'nama_file' => $nama, 'ukuran' => $ukuran, 'status' => 'valid', 'path' => $path,
            'diunggah_oleh' => optional(auth()->user())->name ?? 'Admin', 'tanggal_unggah' => now()->toDateString(),
        ];

        $lama = $alumni->dokumen()->where('jenis', $data['jenis'])->first();
        if ($lama) {
            if ($lama->path) {
                Storage::disk('public')->delete($lama->path);
            }
            $lama->update($isi);
        } else {
            $alumni->dokumen()->create($isi + ['jenis' => $data['jenis']]);
        }

        if ($data['jenis'] === Alumni::DOKUMEN[4]['label'] && $gambar) {
            $alumni->update(['foto' => $path]);
        }

        return redirect()->route('alumni', ['id' => $alumni->id])->with('status', "{$data['jenis']} berhasil diunggah.");
    }

    public function ijazah(Request $request, int $id)
    {
        $alumni = Alumni::findOrFail($id);

        $data = $request->validate([
            'status_ijazah'       => 'required|in:diambil,tersimpan,menunggu',
            'diambil_oleh'        => 'nullable|string|max:100',
            'tanggal_pengambilan' => 'nullable|date',
        ], ['required' => ':attribute wajib diisi.', 'in' => ':attribute tidak valid.', 'date' => ':attribute bukan tanggal yang valid.'],
           ['status_ijazah' => 'Status ijazah', 'tanggal_pengambilan' => 'Tanggal pengambilan']);

        $diambil = $data['status_ijazah'] === 'diambil';
        $alumni->update([
            'status_ijazah'       => $data['status_ijazah'],
            'diambil_oleh'        => $diambil ? ($data['diambil_oleh'] ?? null) : null,
            'tanggal_pengambilan' => $diambil ? ($data['tanggal_pengambilan'] ?? now()->toDateString()) : null,
        ]);

        return redirect()->route('alumni', ['id' => $alumni->id])->with('status', 'Status pengambilan ijazah berhasil diperbarui.');
    }

    /** Ekspor CSV (dapat dibuka di Excel), mengikuti filter yang aktif. */
    public function ekspor(Request $request)
    {
        $rows = $this->filter($request)->withCount('dokumen')->orderByDesc('tahun_lulus')->orderBy('nama')->get();
        $slot = count(Alumni::DOKUMEN);

        return response()->streamDownload(function () use ($rows, $slot) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['NIS', 'NISN', 'Nama', 'L/P', 'Kelas Terakhir', 'Jurusan', 'Tahun Masuk', 'Tahun Lulus', 'Nomor Ijazah', 'Rata-rata', 'Arsip Digital', 'Status Ijazah']);
            foreach ($rows as $a) {
                fputcsv($out, [$a->nis, $a->nisn, $a->nama, $a->jenis_kelamin, $a->kelas_terakhir, $a->jurusan, $a->tahun_masuk, $a->tahun_lulus,
                    $a->nomor_ijazah, $a->rata_rata, $a->dokumen_count . '/' . $slot, $a->status_ijazah]);
            }
            fclose($out);
        }, 'data-alumni-' . now()->format('Ymd') . '.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /* ====================================================================
       FITUR TAMBAHAN: ubah data, impor, cetak SKL, verifikasi QR publik
       ==================================================================== */

    private function pesanValidasi(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'digits'   => ':attribute harus :digits digit angka.',
            'unique'   => ':attribute sudah terdaftar di database.',
            'regex'    => 'Format :attribute tidak valid.',
            'in'       => ':attribute tidak valid.',
            'date'     => ':attribute bukan tanggal yang valid.',
            'max'      => ':attribute melebihi batas yang diizinkan.',
            'between'  => ':attribute di luar rentang yang diizinkan.',
            'integer'  => ':attribute harus berupa angka.',
            'numeric'  => ':attribute harus berupa angka.',
            'gte'      => ':attribute tidak boleh lebih kecil dari tahun masuk.',
        ];
    }

    private function namaAtribut(): array
    {
        return [
            'nama' => 'Nama lengkap', 'nisn' => 'NISN', 'nis' => 'NIS', 'nik' => 'NIK', 'jenis_kelamin' => 'Jenis kelamin',
            'kelas_terakhir' => 'Kelas terakhir', 'tahun_masuk' => 'Tahun masuk', 'tahun_lulus' => 'Tahun lulus',
            'tanggal_kelulusan' => 'Tanggal kelulusan', 'nomor_ijazah' => 'Nomor ijazah', 'rata_rata' => 'Rata-rata',
        ];
    }

    public function update(Request $request, int $id)
    {
        $alumni = Alumni::findOrFail($id);

        $data = $request->validate([
            'nama'              => 'required|string|max:100',
            'panggilan'         => 'nullable|string|max:50',
            'jenis_kelamin'     => 'required|in:L,P',
            'nisn'              => ['required', 'digits:10', \Illuminate\Validation\Rule::unique('alumni', 'nisn')->ignore($alumni->id)],
            'nis'               => ['required', 'string', 'max:20', 'regex:/^[A-Za-z0-9\-]+$/', \Illuminate\Validation\Rule::unique('alumni', 'nis')->ignore($alumni->id)],
            'nik'               => ['nullable', 'digits:16'],
            'kelas_terakhir'    => ['required', 'regex:/^(X|XI|XII)-[A-Za-z0-9]{1,3}$/'],
            'jurusan'           => 'nullable|string|max:80',
            'tahun_masuk'       => 'required|integer|between:2000,2100',
            'tahun_lulus'       => 'required|integer|between:2000,2100|gte:tahun_masuk',
            'tanggal_kelulusan' => 'nullable|date',
            'nomor_ijazah'      => ['nullable', 'string', 'max:40', 'regex:/^[A-Za-z0-9\-]+$/', \Illuminate\Validation\Rule::unique('alumni', 'nomor_ijazah')->ignore($alumni->id)],
            'nomor_skl'         => 'nullable|string|max:60',
            'rata_rata'         => 'nullable|numeric|between:0,100',
            'prestasi'          => 'nullable|string|max:1000',
            'ruang_arsip'       => 'nullable|string|max:100',
            'lemari'            => 'nullable|string|max:40',
            'rak'               => 'nullable|string|max:20',
            'kode_map'          => 'nullable|string|max:40',
        ], $this->pesanValidasi(), $this->namaAtribut());

        $data['kelas_terakhir'] = strtoupper($data['kelas_terakhir']);
        $data['angkatan']       = (int) $data['tahun_lulus'] - 2020;

        $alumni->update($data);

        return redirect()->route('alumni', ['id' => $alumni->id])->with('status', "Data alumni {$alumni->nama} berhasil diperbarui.");
    }

    public function template()
    {
        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['nis', 'nisn', 'nama', 'panggilan', 'jenis_kelamin', 'kelas_terakhir', 'jurusan', 'tahun_masuk', 'tahun_lulus', 'tanggal_kelulusan', 'nomor_ijazah', 'nomor_skl', 'rata_rata', 'status_ijazah']);
            fputcsv($out, ['2020101', '0021234567', 'Contoh Alumni', 'Contoh', 'L', 'XII-A', 'MIPA 1', '2020', '2023', '2023-06-15', 'MA-15-08-2023-00001', '421.3/SKL/MAS-SH/2023', '85.50', 'tersimpan']);
            fclose($out);
        }, 'template-impor-alumni.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function impor(Request $request)
    {
        $request->validate(['berkas' => 'required|file|max:2048'], [
            'required' => 'Pilih berkas CSV terlebih dahulu.',
            'max'      => 'Ukuran berkas maksimal 2 MB.',
        ], ['berkas' => 'Berkas']);

        $file = $request->file('berkas');
        if (! in_array(strtolower($file->getClientOriginalExtension()), ['csv', 'txt'], true)) {
            return redirect()->route('alumni')->withErrors(['berkas' => 'Berkas harus berformat CSV. Gunakan template yang disediakan.']);
        }

        $handle = fopen($file->getRealPath(), 'r');
        $baris1 = preg_replace('/^\xEF\xBB\xBF/', '', (string) fgets($handle));
        rewind($handle);
        $delim  = substr_count($baris1, ';') > substr_count($baris1, ',') ? ';' : ',';

        $header = fgetcsv($handle, 0, $delim);
        if (! $header) {
            fclose($handle);
            return redirect()->route('alumni')->withErrors(['berkas' => 'Berkas kosong atau tidak terbaca.']);
        }
        $header = array_map(fn ($h) => strtolower(trim(preg_replace('/^\xEF\xBB\xBF/', '', (string) $h))), $header);

        $hilang = array_diff(['nis', 'nisn', 'nama', 'jenis_kelamin', 'kelas_terakhir', 'tahun_masuk', 'tahun_lulus'], $header);
        if ($hilang) {
            fclose($handle);
            return redirect()->route('alumni')->withErrors(['berkas' => 'Kolom wajib tidak ditemukan: ' . implode(', ', $hilang) . '. Gunakan template yang disediakan.']);
        }

        $rules = [
            'nis'               => ['required', 'max:20', 'regex:/^[A-Za-z0-9\-]+$/', 'unique:alumni,nis'],
            'nisn'              => ['required', 'digits:10', 'unique:alumni,nisn'],
            'nama'              => ['required', 'max:100'],
            'jenis_kelamin'     => ['required', 'in:L,P'],
            'kelas_terakhir'    => ['required', 'regex:/^(X|XI|XII)-[A-Za-z0-9]{1,3}$/'],
            'tahun_masuk'       => ['required', 'integer', 'between:2000,2100'],
            'tahun_lulus'       => ['required', 'integer', 'between:2000,2100'],
            'tanggal_kelulusan' => ['nullable', 'date'],
            'nomor_ijazah'      => ['nullable', 'max:40', 'regex:/^[A-Za-z0-9\-]+$/', 'unique:alumni,nomor_ijazah'],
            'rata_rata'         => ['nullable', 'numeric', 'between:0,100'],
            'status_ijazah'     => ['nullable', 'in:diambil,tersimpan,menunggu'],
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
            $d['kelas_terakhir'] = strtoupper((string) ($d['kelas_terakhir'] ?? ''));
            if (! empty($d['status_ijazah'])) {
                $d['status_ijazah'] = strtolower($d['status_ijazah']);
            }

            $v = \Illuminate\Support\Facades\Validator::make($d, $rules, $this->pesanValidasi(), $this->namaAtribut());
            if ($v->fails()) {
                $gagal[] = "Baris {$no}: " . $v->errors()->first();
                continue;
            }

            $lulus   = (int) $d['tahun_lulus'];
            $tanggal = ! empty($d['tanggal_kelulusan']) ? Carbon::parse($d['tanggal_kelulusan']) : Carbon::create($lulus, 6, 15);
            $urut    = (int) Alumni::max('id') + 1;
            $status  = $d['status_ijazah'] ?? 'tersimpan';

            Alumni::create([
                'nis'                 => $d['nis'],
                'nisn'                => $d['nisn'],
                'nama'                => $d['nama'],
                'panggilan'           => $d['panggilan'] ?? null,
                'jenis_kelamin'       => $d['jenis_kelamin'],
                'kelas_terakhir'      => $d['kelas_terakhir'],
                'jurusan'             => $d['jurusan'] ?? null,
                'tahun_masuk'         => (int) $d['tahun_masuk'],
                'tahun_lulus'         => $lulus,
                'angkatan'            => $lulus - 2020,
                'tanggal_kelulusan'   => $tanggal->toDateString(),
                'nomor_ijazah'        => $d['nomor_ijazah'] ?? ('MA-' . $tanggal->format('d-m-Y') . '-' . str_pad((string) $urut, 5, '0', STR_PAD_LEFT)),
                'nomor_skl'           => $d['nomor_skl'] ?? null,
                'rata_rata'           => isset($d['rata_rata']) ? (float) $d['rata_rata'] : null,
                'status_ijazah'       => $status,
                'tanggal_pengambilan' => $status === 'diambil' ? $tanggal->copy()->addMonths(2)->toDateString() : null,
                'kode_map'            => 'M-ALUMNI-' . $lulus . '-' . substr($d['nis'], -3),
            ]);
            $berhasil++;
        }
        fclose($handle);

        $balik = redirect()->route('alumni')->with('status', "Impor selesai: {$berhasil} alumni ditambahkan, " . count($gagal) . ' baris dilewati.');
        if ($gagal) {
            $balik->with('peringatan', implode(' • ', array_slice($gagal, 0, 5)) . (count($gagal) > 5 ? ' • dan ' . (count($gagal) - 5) . ' baris lainnya.' : ''));
        }

        return $balik;
    }

    public function cetak(int $id)
    {
        return view('alumni-cetak', ['alumni' => Alumni::findOrFail($id)]);
    }

    /** Halaman publik tujuan QR: memverifikasi keaslian ijazah berdasarkan nomor. */
    public function verifikasiPublik(string $nomor)
    {
        return view('alumni-verifikasi', [
            'alumni' => Alumni::where('nomor_ijazah', $nomor)->first(),
            'nomor'  => $nomor,
        ]);
    }

    /** Salin dokumen siswa yang relevan ke arsip alumni (berkas fisik disalin, bukan dibagi). */
    private function salinDokumen(SiswaAktif $s, Alumni $a): void
    {
        $label = Alumni::DOKUMEN[3]['label']; // Akta Kelahiran & KK
        foreach (['Akta Kelahiran', 'Kartu Keluarga (KK)'] as $jenisSiswa) {
            if ($a->dokumen()->where('jenis', $label)->exists()) {
                break;
            }
            $d = $s->dokumen()->where('jenis', $jenisSiswa)->where('status', 'valid')->first();
            if (! $d || ! $d->path || ! Storage::disk('public')->exists($d->path)) {
                continue;
            }
            $tujuan = 'dokumen-alumni/' . $a->nis . '/' . basename($d->path);
            Storage::disk('public')->copy($d->path, $tujuan);
            $a->dokumen()->create([
                'jenis'          => $label,
                'nama_file'      => $d->nama_file,
                'ukuran'         => $d->ukuran,
                'status'         => 'valid',
                'path'           => $tujuan,
                'diunggah_oleh'  => $d->diunggah_oleh,
                'tanggal_unggah' => now()->toDateString(),
            ]);
        }
    }

    /** Batalkan kelulusan: siswa kembali ke Data Siswa Aktif, data alumni dihapus. */
    public function batal(int $id)
    {
        $alumni = Alumni::with('dokumen')->findOrFail($id);
        $siswa  = SiswaAktif::where('nis', $alumni->nis)->first();

        if (! $siswa) {
            return redirect()->route('alumni', ['id' => $alumni->id])
                ->withErrors(['batal' => 'Data siswa asal tidak ditemukan, sehingga kelulusan tidak dapat dibatalkan.']);
        }

        DB::transaction(function () use ($alumni, $siswa) {
            foreach ($alumni->dokumen as $d) {
                if ($d->path) {
                    Storage::disk('public')->delete($d->path);
                }
            }
            $siswa->update(['status' => 'Aktif']);
            $alumni->delete();
        });

        return redirect()->route('siswa.aktif', ['id' => $siswa->id])
            ->with('status', "Kelulusan {$siswa->nama} dibatalkan. Siswa kembali ke Data Siswa Aktif.")
            ->with('tautan', route('siswa.detail', ['id' => $siswa->id]));
    }
}