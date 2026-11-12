<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\ArsipFisik;
use App\Models\ArsipFisikLog;
use App\Models\ArsipLemari;
use App\Models\ArsipRak;
use App\Models\ArsipRuang;
use App\Models\SiswaAktif;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class ArsipFisikController extends Controller
{
    /** Jenis dokumen fisik => [kategori, keterangan]. */
    public const DOKUMEN = [
        'Kartu Keluarga (KK)'               => ['Identitas', 'Berkas Wajib PPDB'],
        'Akta Kelahiran'                    => ['Identitas', 'Dokumen Primer'],
        'Ijazah / SKL MTs'                  => ['Akademik',  'Legalisir / Ijazah Asli'],
        'Pas Foto Resmi 3x4'                => ['Foto',      'Berkas Wajib'],
        'KTP Orang Tua (Ayah & Ibu)'        => ['Identitas', 'Dokumen Pendukung'],
        'Surat Pernyataan Kesediaan Santri' => ['Pendukung', 'Bermaterai'],
        'Kartu Bantuan (KIP / PKH / KKS)'   => ['Pendukung', 'Bantuan Sosial'],
    ];

    /** Dokumen kelulusan alumni yang dicatat sebagai arsip fisik (label sama dengan Alumni::DOKUMEN). */
    public const DOKUMEN_ALUMNI = [
        'Ijazah Madrasah Asli'            => ['Akademik',  'Ijazah Asli Lulusan'],
        'Surat Ket. Lulus (SKL)'          => ['Akademik',  'Surat Keterangan Lulus'],
        'Transkrip Nilai Akademik'        => ['Akademik',  'Transkrip Nilai'],
        'Akta Kelahiran & KK'             => ['Identitas', 'Dokumen Primer'],
        'Pasfoto Wisuda 3x4 (Cap 3 Jari)' => ['Foto',      'Berkas Wisuda'],
        'Berita Acara & Tanda Terima'     => ['Pendukung', 'Penyerahan Ijazah'],
    ];

    /** Semua jenis dokumen (siswa + alumni), dipakai filter dan validasi. */
    public static function semuaJenis(): array
    {
        return self::DOKUMEN + self::DOKUMEN_ALUMNI;
    }

    /** True bila migrasi arsip alumni sudah dijalankan (kolom alumni_id ada). */
    private function adaAlumni(): bool
    {
        static $ada = null;

        return $ada ??= Schema::hasColumn('arsip_fisik', 'alumni_id');
    }

    /** Batas tingkat kepadatan (persen kapasitas). */
    private const BATAS_PADAT  = 70;
    private const BATAS_KRITIS = 85;

    /* ======================================================================
       HALAMAN UTAMA
       ====================================================================== */
    public function index(Request $request)
    {
        $per = (int) $request->query('per', 10);
        $per = in_array($per, [10, 25, 50], true) ? $per : 10;

        $terisi   = ArsipFisik::whereNotNull('arsip_rak_id')
            ->selectRaw('arsip_rak_id, COUNT(*) as n')->groupBy('arsip_rak_id')->pluck('n', 'arsip_rak_id');
        $hierarki = $this->hierarki($terisi);

        /* Daftar arsip (tabel) */
        $daftar = $this->saring($request)
            ->with(['siswa:id,nis,nama,kelas,tahun_masuk', 'alumni:id,nis,nama,kelas_terakhir,tahun_lulus', 'rak.lemari.ruang'])
            ->orderBy('kode_arsip')
            ->paginate($per)->withQueryString()->fragment('daftar');

        /* Detail panel: baris halaman ini + arsip yang dipilih */
        $pilih = (int) $request->query('pilih');
        $idPilih = $pilih ?: ($daftar->first() ? $daftar->first()->id : null);

        $kumpulan = $daftar->getCollection()->keyBy('id');
        if ($idPilih && ! $kumpulan->has($idPilih)) {
            $tambahan = ArsipFisik::with(['siswa:id,nis,nama,kelas,tahun_masuk', 'alumni:id,nis,nama,kelas_terakhir,tahun_lulus', 'rak.lemari.ruang'])->find($idPilih);
            if ($tambahan) $kumpulan->put($idPilih, $tambahan); else $idPilih = null;
        }

        $logs = ArsipFisikLog::whereIn('arsip_fisik_id', $kumpulan->keys())->orderByDesc('id')->get()->groupBy('arsip_fisik_id');
        $detail = [];
        foreach ($kumpulan as $id => $a) {
            $detail[$id] = $this->detail($a, $terisi, $logs->get($id, collect()));
        }

        return view('arsip-fisik', [
            'ringkas'  => $this->ringkasan($terisi),
            'hierarki' => $hierarki,
            'daftar'   => $daftar,
            'detail'   => $detail,
            'idPilih'  => $idPilih,
            'lokasi'   => $this->opsiLokasi($hierarki),
            'per'      => $per,
            'opsi'     => [
                'ruang'  => ArsipRuang::orderBy('nama')->get(['id', 'nama']),
                'lemari' => $this->opsiLokasi($hierarki),
                'rak'    => ArsipRak::distinct()->orderBy('kode')->pluck('kode'),
            ],
        ]);
    }

    /* ======================================================================
       LOKASI — tambah ruang / lemari / rak
       ====================================================================== */
    public function simpanLokasi(Request $request)
    {
        $data = $request->validate([
            'ruang'       => 'required|string',
            'ruang_nama'  => 'nullable|string|max:100|required_if:ruang,baru',
            'gedung'      => 'nullable|string|max:30',
            'lantai'      => 'nullable|string|max:30',
            'peruntukan'  => 'nullable|string|max:200',
            'lemari_kode' => 'required|string|max:20',
            'lemari_ket'  => 'nullable|string|max:200',
            'jumlah_rak'  => 'required|integer|min:1|max:30',
            'kapasitas'   => 'required|integer|min:1|max:500',
        ], [
            'required'    => ':attribute wajib diisi.',
            'required_if' => 'Nama ruang baru wajib diisi.',
            'integer'     => ':attribute harus berupa angka.',
            'min'         => ':attribute terlalu kecil.',
            'max'         => ':attribute melebihi batas.',
        ], [
            'lemari_kode' => 'Kode lemari', 'jumlah_rak' => 'Jumlah rak', 'kapasitas' => 'Kapasitas rak',
        ]);

        $kode = trim($data['lemari_kode']);

        if ($data['ruang'] !== 'baru') {
            $ruang = ArsipRuang::find($data['ruang']);
            if (! $ruang) {
                return back()->withErrors(['ruang' => 'Ruang arsip tidak ditemukan.']);
            }
            if (ArsipLemari::where('arsip_ruang_id', $ruang->id)->where('kode', $kode)->exists()) {
                return back()->withErrors(['lemari_kode' => "Lemari {$kode} sudah ada di {$ruang->nama}."]);
            }
        }

        DB::transaction(function () use ($data, $kode, &$ruang) {
            if ($data['ruang'] === 'baru') {
                $ruang = ArsipRuang::create([
                    'nama' => trim($data['ruang_nama']), 'gedung' => $data['gedung'] ?? null,
                    'lantai' => $data['lantai'] ?? null, 'peruntukan' => $data['peruntukan'] ?? null,
                ]);
            }
            $lemari = ArsipLemari::create([
                'arsip_ruang_id' => $ruang->id, 'kode' => $kode, 'keterangan' => $data['lemari_ket'] ?? null,
            ]);
            for ($i = 1; $i <= (int) $data['jumlah_rak']; $i++) {
                ArsipRak::create([
                    'arsip_lemari_id' => $lemari->id,
                    'kode'            => 'R-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'kapasitas'       => (int) $data['kapasitas'],
                ]);
            }
        });

        return redirect()->route('arsip.fisik')
            ->with('status', "Lokasi {$kode} di {$ruang->nama} berhasil ditambahkan dengan {$data['jumlah_rak']} rak.");
    }

    /* ======================================================================
       CATAT ARSIP FISIK
       ====================================================================== */
    public function simpanArsip(Request $request)
    {
        $data = $request->validate([
            'siswa_id'     => 'required|integer|exists:siswa_aktif,id',
            'jenis'        => 'required|array|min:1',
            'jenis.*'      => [Rule::in(array_keys(self::DOKUMEN))],
            'arsip_rak_id' => 'nullable|integer|exists:arsip_rak,id',
            'kode_map'     => 'nullable|string|max:30',
            'kondisi'      => ['required', Rule::in(array_keys(ArsipFisik::KONDISI))],
        ], [
            'required' => ':attribute wajib diisi.',
            'min'      => 'Pilih minimal satu jenis dokumen.',
            'exists'   => ':attribute tidak ditemukan.',
            'in'       => ':attribute tidak valid.',
        ], ['siswa_id' => 'Siswa', 'jenis' => 'Jenis dokumen', 'kondisi' => 'Kondisi']);

        $siswa = SiswaAktif::findOrFail($data['siswa_id']);
        $rak   = ! empty($data['arsip_rak_id']) ? ArsipRak::with('lemari.ruang')->findOrFail($data['arsip_rak_id']) : null;
        $baru  = array_values(array_filter($data['jenis'], fn ($j) => ! ArsipFisik::where('siswa_aktif_id', $siswa->id)->where('jenis', $j)->exists()));

        if ($rak && count($baru) > $this->sisaRak($rak)) {
            return back()->withErrors(['arsip_rak_id' => 'Rak ' . $rak->kode . ' hanya memiliki sisa ' . $this->sisaRak($rak) . ' tempat.']);
        }

        DB::transaction(function () use ($baru, $siswa, $rak, $data) {
            foreach ($baru as $jenis) {
                $a = ArsipFisik::create([
                    'siswa_aktif_id' => $siswa->id,
                    'jenis'          => $jenis,
                    'kode_arsip'     => $this->kodeBaru($this->tahun($siswa)),
                    'arsip_rak_id'   => $rak ? $rak->id : null,
                    'kode_map'       => $data['kode_map'] ?? null,
                    'kondisi'        => $data['kondisi'],
                    'status'         => $rak ? 'tersimpan' : 'antrean',
                ]);
                $this->catat($a, 'catat', 'Dicatat di ' . $this->teksLokasi($rak, $data['kode_map'] ?? null));
            }
        });

        $lewat = count($data['jenis']) - count($baru);
        $pesan = count($baru) . " arsip fisik milik {$siswa->nama} berhasil dicatat."
               . ($lewat ? " {$lewat} dilewati karena sudah tercatat." : '');

        return redirect()->route('arsip.fisik')->with('status', $pesan);
    }

    /* ======================================================================
       PINDAH, PINJAM, KEMBALI, KONDISI
       ====================================================================== */
    public function pindah(Request $request, int $id)
    {
        $data = $request->validate([
            'arsip_rak_id' => 'required|integer|exists:arsip_rak,id',
            'kode_map'     => 'nullable|string|max:30',
            'catatan'      => 'nullable|string|max:300',
        ], ['required' => 'Rak tujuan wajib dipilih.', 'exists' => 'Rak tujuan tidak ditemukan.']);

        $a   = ArsipFisik::with('rak.lemari.ruang')->findOrFail($id);
        $rak = ArsipRak::with('lemari.ruang')->findOrFail($data['arsip_rak_id']);

        if ($rak->id !== $a->arsip_rak_id && $this->sisaRak($rak) < 1) {
            return back()->withErrors(['arsip_rak_id' => "Rak {$rak->kode} sudah penuh. Pilih rak lain."]);
        }

        $dari = $this->teksLokasi($a->rak, $a->kode_map);
        $a->arsip_rak_id = $rak->id;
        $a->kode_map     = $data['kode_map'] ?? $a->kode_map;
        if ($a->status === 'antrean') $a->status = 'tersimpan';
        $a->save();

        $this->catat($a, 'pindah', "Dipindahkan dari {$dari} ke " . $this->teksLokasi($rak, $a->kode_map)
            . (! empty($data['catatan']) ? '. Alasan: ' . $data['catatan'] : ''));

        return back()->with('status', "Arsip {$a->kode_arsip} dipindahkan ke " . $this->teksLokasi($rak, $a->kode_map) . '.');
    }

    public function pindahMassal(Request $request)
    {
        $data = $request->validate([
            'ids'          => 'required|array|min:1',
            'ids.*'        => 'integer|exists:arsip_fisik,id',
            'arsip_rak_id' => 'required|integer|exists:arsip_rak,id',
            'catatan'      => 'nullable|string|max:300',
        ], ['required' => ':attribute wajib diisi.', 'min' => 'Pilih minimal satu arsip.'], ['ids' => 'Arsip', 'arsip_rak_id' => 'Rak tujuan']);

        $rak   = ArsipRak::with('lemari.ruang')->findOrFail($data['arsip_rak_id']);
        $items = ArsipFisik::with('rak.lemari.ruang')->whereIn('id', $data['ids'])->get();
        $masuk = $items->filter(fn ($a) => $a->arsip_rak_id !== $rak->id)->count();
        $sisa  = $this->sisaRak($rak);

        if ($masuk > $sisa) {
            return back()->withErrors(['arsip_rak_id' => "Rak {$rak->kode} hanya memiliki sisa {$sisa} tempat, sedangkan {$masuk} arsip akan dipindahkan."]);
        }

        DB::transaction(function () use ($items, $rak, $data) {
            foreach ($items as $a) {
                if ($a->arsip_rak_id === $rak->id) continue;
                $dari = $this->teksLokasi($a->rak, $a->kode_map);
                $a->arsip_rak_id = $rak->id;
                if ($a->status === 'antrean') $a->status = 'tersimpan';
                $a->save();
                $this->catat($a, 'pindah', "Dipindahkan (massal) dari {$dari} ke " . $this->teksLokasi($rak, $a->kode_map)
                    . (! empty($data['catatan']) ? '. Alasan: ' . $data['catatan'] : ''));
            }
        });

        return back()->with('status', "{$masuk} arsip dipindahkan ke " . $this->teksLokasi($rak, null) . '.');
    }

    public function pinjam(Request $request, int $id)
    {
        $data = $request->validate([
            'peminjam'    => 'required|string|max:100',
            'keperluan'   => 'nullable|string|max:200',
            'jatuh_tempo' => 'required|date|after_or_equal:today',
        ], [
            'required' => ':attribute wajib diisi.', 'date' => 'Tanggal jatuh tempo tidak valid.',
            'after_or_equal' => 'Jatuh tempo tidak boleh sebelum hari ini.',
        ], ['peminjam' => 'Nama peminjam', 'jatuh_tempo' => 'Jatuh tempo']);

        $a = ArsipFisik::findOrFail($id);
        if ($a->status === 'dipinjam') {
            return back()->withErrors(['peminjam' => 'Arsip ini sedang dipinjam.']);
        }

        $a->update([
            'status' => 'dipinjam', 'peminjam' => $data['peminjam'], 'keperluan' => $data['keperluan'] ?? null,
            'tanggal_pinjam' => today(), 'jatuh_tempo' => $data['jatuh_tempo'],
        ]);
        $this->catat($a, 'pinjam', "Dipinjam oleh {$data['peminjam']} sampai " . \Carbon\Carbon::parse($data['jatuh_tempo'])->format('d-m-Y')
            . (! empty($data['keperluan']) ? '. Keperluan: ' . $data['keperluan'] : ''));

        return back()->with('status', "Arsip {$a->kode_arsip} dicatat dipinjam oleh {$data['peminjam']}.");
    }

    public function kembali(int $id)
    {
        $a = ArsipFisik::findOrFail($id);
        $oleh = $a->peminjam;

        $a->update([
            'status' => $a->arsip_rak_id ? 'tersimpan' : 'antrean',
            'peminjam' => null, 'keperluan' => null, 'tanggal_pinjam' => null, 'jatuh_tempo' => null,
        ]);
        $this->catat($a, 'kembali', 'Dikembalikan' . ($oleh ? " oleh {$oleh}" : '') . ' ke repositori.');

        return back()->with('status', "Arsip {$a->kode_arsip} sudah dikembalikan ke repositori.");
    }

    public function kondisi(Request $request, int $id)
    {
        $data = $request->validate([
            'kondisi' => ['required', Rule::in(array_keys(ArsipFisik::KONDISI))],
            'catatan' => 'nullable|string|max:300',
        ], ['required' => 'Kondisi wajib dipilih.', 'in' => 'Kondisi tidak valid.']);

        $a = ArsipFisik::findOrFail($id);
        $a->update(['kondisi' => $data['kondisi'], 'keterangan' => $data['catatan'] ?? $a->keterangan]);
        $this->catat($a, 'kondisi', 'Kondisi fisik diperbarui menjadi ' . ArsipFisik::KONDISI[$data['kondisi']]
            . (! empty($data['catatan']) ? '. Catatan: ' . $data['catatan'] : ''));

        return back()->with('status', "Kondisi arsip {$a->kode_arsip} diperbarui.");
    }

    /* ======================================================================
       KOREKSI ALAMAT ARSIP (lokasi, angkatan, kelas, jenis dokumen)
       ====================================================================== */
    public function koreksi(Request $request, int $id)
    {
        $data = $request->validate([
            'arsip_rak_id' => 'nullable|integer|exists:arsip_rak,id',
            'kode_map'     => 'nullable|string|max:30',
            'angkatan'     => 'nullable|digits:4',
            'kelas'        => 'nullable|string|max:30',
            'jenis'        => ['required', Rule::in(array_keys(self::semuaJenis()))],
        ], [
            'required' => ':attribute wajib diisi.',
            'digits'   => 'Angkatan harus berupa tahun 4 digit.',
            'in'       => 'Jenis dokumen tidak valid.',
            'exists'   => 'Rak tujuan tidak ditemukan.',
        ], ['jenis' => 'Jenis dokumen']);

        $a     = ArsipFisik::with('rak.lemari.ruang', 'siswa', 'alumni')->findOrFail($id);
        $siswa = $a->siswa;
        $ubah  = [];

        if ($data['jenis'] !== $a->jenis) {
            $cocok = $a->alumni_id ? isset(self::DOKUMEN_ALUMNI[$data['jenis']]) : isset(self::DOKUMEN[$data['jenis']]);
            if (! $cocok) {
                return back()->withErrors(['jenis' => 'Jenis dokumen tidak sesuai dengan pemilik arsip ini.']);
            }
            $ganda = ArsipFisik::where($a->alumni_id ? 'alumni_id' : 'siswa_aktif_id', $a->alumni_id ?: $a->siswa_aktif_id)->where('jenis', $data['jenis'])->where('id', '!=', $a->id)->exists();
            if ($ganda) {
                return back()->withErrors(['jenis' => "Pemilik arsip ini sudah memiliki arsip fisik {$data['jenis']}."]);
            }
            $ubah[]   = "jenis dokumen {$a->jenis} menjadi {$data['jenis']}";
            $a->jenis = $data['jenis'];
        }

        if (! empty($data['arsip_rak_id']) && (int) $data['arsip_rak_id'] !== (int) $a->arsip_rak_id) {
            $rak = ArsipRak::with('lemari.ruang')->findOrFail($data['arsip_rak_id']);
            if ($this->sisaRak($rak) < 1) {
                return back()->withErrors(['arsip_rak_id' => "Rak {$rak->kode} sudah penuh. Pilih rak lain."]);
            }
            $ubah[] = 'lokasi dari ' . $this->teksLokasi($a->rak, $a->kode_map) . ' ke ' . $this->teksLokasi($rak, $data['kode_map'] ?? $a->kode_map);
            $a->arsip_rak_id = $rak->id;
            if ($a->status === 'antrean') $a->status = 'tersimpan';
        }

        if (! empty($data['kode_map']) && $data['kode_map'] !== $a->kode_map) {
            $ubah[]      = 'kode map menjadi ' . $data['kode_map'];
            $a->kode_map = $data['kode_map'];
        }

        if ($siswa) {
            if (! empty($data['angkatan']) && (string) $data['angkatan'] !== (string) $siswa->tahun_masuk) {
                $ubah[] = 'angkatan ' . ($siswa->tahun_masuk ?: '-') . ' menjadi ' . $data['angkatan'];
                $siswa->tahun_masuk = $data['angkatan'];
            }
            if (! empty($data['kelas']) && $data['kelas'] !== $siswa->kelas) {
                $ubah[] = 'kelas ' . ($siswa->kelas ?: '-') . ' menjadi ' . $data['kelas'];
                $siswa->kelas = $data['kelas'];
            }
        }

        /* Arsip alumni: angkatan = tahun lulus, kelas = kelas terakhir (mengubah data alumni) */
        $alumni = $a->alumni;
        if ($alumni) {
            if (! empty($data['angkatan']) && (string) $data['angkatan'] !== (string) $alumni->tahun_lulus) {
                if ((int) $data['angkatan'] < (int) $alumni->tahun_masuk) {
                    return back()->withErrors(['angkatan' => 'Tahun lulus tidak boleh lebih kecil dari tahun masuk alumni (' . $alumni->tahun_masuk . ').']);
                }
                $ubah[] = 'angkatan (tahun lulus) ' . $alumni->tahun_lulus . ' menjadi ' . $data['angkatan'];
                $alumni->tahun_lulus = (int) $data['angkatan'];
                $alumni->angkatan    = max(0, (int) $data['angkatan'] - 2020);
            }
            if (! empty($data['kelas']) && strtoupper($data['kelas']) !== $alumni->kelas_terakhir) {
                if (! preg_match('/^(X|XI|XII)-[A-Za-z0-9]{1,3}$/', $data['kelas'])) {
                    return back()->withErrors(['kelas' => 'Format kelas tidak valid. Contoh: XII-A.']);
                }
                $ubah[] = 'kelas ' . ($alumni->kelas_terakhir ?: '-') . ' menjadi ' . strtoupper($data['kelas']);
                $alumni->kelas_terakhir = strtoupper($data['kelas']);
            }
        }

        if (! $ubah) {
            return back()->with('status', "Tidak ada perubahan pada arsip {$a->kode_arsip}.");
        }

        DB::transaction(function () use ($a, $siswa, $ubah) {
            $a->save();
            if ($siswa && $siswa->isDirty()) $siswa->save();
            if ($a->alumni && $a->alumni->isDirty()) $a->alumni->save();
            $this->catat($a, 'catat', 'Koreksi data: ' . implode('; ', $ubah) . '.');
        });

        return back()->with('status', "Arsip {$a->kode_arsip} berhasil dikoreksi.");
    }

    /* ======================================================================
       SINKRONISASI dari data lokasi yang sudah ada di data siswa
       ====================================================================== */
    public function sinkron()
    {
        $dibuat = 0;

        DB::transaction(function () use (&$dibuat) {
            SiswaAktif::with('dokumen:id,siswa_aktif_id,jenis')
                ->whereNotNull('lemari')->where('lemari', '!=', '')
                ->whereNotNull('rak')->where('rak', '!=', '')
                ->chunkById(100, function ($kelompok) use (&$dibuat) {
                    foreach ($kelompok as $s) {
                        $ruang  = ArsipRuang::firstOrCreate(['nama' => trim((string) $s->ruang_arsip) ?: 'Ruang Arsip']);
                        $lemari = ArsipLemari::firstOrCreate(['arsip_ruang_id' => $ruang->id, 'kode' => trim($s->lemari)]);
                        $rak    = ArsipRak::firstOrCreate(['arsip_lemari_id' => $lemari->id, 'kode' => trim($s->rak)], ['kapasitas' => 50]);

                        foreach ($s->dokumen as $d) {
                            if (! isset(self::DOKUMEN[$d->jenis])) continue;
                            if (ArsipFisik::where('siswa_aktif_id', $s->id)->where('jenis', $d->jenis)->exists()) continue;

                            $a = ArsipFisik::create([
                                'siswa_aktif_id' => $s->id, 'jenis' => $d->jenis,
                                'kode_arsip'     => $this->kodeBaru($this->tahun($s)),
                                'arsip_rak_id'   => $rak->id, 'kode_map' => $s->kode_map ?: null,
                                'kondisi'        => 'belum', 'status' => 'tersimpan',
                            ]);
                            $this->catat($a, 'catat', 'Disinkronkan dari data lokasi pada profil siswa.');
                            $dibuat++;
                        }
                    }
                });
        });

        return back()->with('status', $dibuat > 0
            ? "Sinkronisasi selesai: {$dibuat} arsip fisik dibuat dari data lokasi siswa."
            : 'Tidak ada data baru. Semua arsip dari data lokasi siswa sudah tercatat, atau belum ada siswa dengan lemari & rak terisi.');
    }

    /* ======================================================================
       PEMBANTU — query & perhitungan
       ====================================================================== */

    /** Query arsip dengan semua filter dari URL. */
    private function saring(Request $r)
    {
        $q = ArsipFisik::query();

        if ($id = (int) $r->query('ruang')) {
            $q->whereHas('rak.lemari', fn ($w) => $w->where('arsip_ruang_id', $id));
        }
        if ($id = (int) $r->query('lemari')) {
            $q->whereHas('rak', fn ($w) => $w->where('arsip_lemari_id', $id));
        }
        if (($k = (string) $r->query('rak', '')) !== '') {
            $q->whereHas('rak', fn ($w) => $w->where('kode', $k));
        }
        if (($j = (string) $r->query('kategori', '')) !== '' && isset(self::semuaJenis()[$j])) {
            $q->where('jenis', $j);
        }
        if (array_key_exists((string) $r->query('status'), ArsipFisik::STATUS)) {
            $q->where('status', $r->query('status'));
        }
        if (array_key_exists((string) $r->query('kondisi'), ArsipFisik::KONDISI)) {
            $q->where('kondisi', $r->query('kondisi'));
        }
        if ($r->query('fokus') === 'belum') {
            $q->whereNull('arsip_rak_id');
        }
        /* Filter baru: Arsip (ruang), Angkatan, Kelas, Jenis Dokumen */
        if ($id = (int) $r->query('arsip')) {
            $q->whereHas('rak.lemari', fn ($w) => $w->where('arsip_ruang_id', $id));
        }
        if (($ak = (string) $r->query('angkatan', '')) !== '') {
            $q->where(function ($w) use ($ak) {
                $w->whereHas('siswa', fn ($s) => $s->where('tahun_masuk', $ak));
                if ($this->adaAlumni()) $w->orWhereHas('alumni', fn ($s) => $s->where('tahun_lulus', $ak));
            });
        }
        if (($kl = (string) $r->query('kelas', '')) !== '') {
            $q->where(function ($w) use ($kl) {
                $w->whereHas('siswa', fn ($s) => $s->where('kelas', $kl));
                if ($this->adaAlumni()) $w->orWhereHas('alumni', fn ($s) => $s->where('kelas_terakhir', $kl));
            });
        }
        if (($jn = (string) $r->query('jenis', '')) !== '' && isset(self::semuaJenis()[$jn])) {
            $q->where('jenis', $jn);
        }
        if (($cari = trim((string) $r->query('q', ''))) !== '') {
            $idSiswa = SiswaAktif::where('nama', 'like', "%{$cari}%")
                ->orWhere('nis', 'like', "%{$cari}%")->orWhere('nisn', 'like', "%{$cari}%")->pluck('id');

            $idAlumni = $this->adaAlumni()
                ? Alumni::where('nama', 'like', "%{$cari}%")->orWhere('nis', 'like', "%{$cari}%")->orWhere('nisn', 'like', "%{$cari}%")->pluck('id')
                : collect();

            $q->where(function ($w) use ($cari, $idSiswa, $idAlumni) {
                if ($idAlumni->isNotEmpty()) $w->orWhereIn('alumni_id', $idAlumni);
                $w->orWhere('kode_arsip', 'like', "%{$cari}%")
                  ->orWhere('jenis', 'like', "%{$cari}%")
                  ->orWhere('kode_map', 'like', "%{$cari}%")
                  ->orWhereIn('siswa_aktif_id', $idSiswa)
                  ->orWhereHas('rak.lemari', fn ($l) => $l->where('kode', 'like', "%{$cari}%"));
            });
        }

        return $q;
    }

    /** Pohon ruang -> lemari -> rak lengkap dengan persentase kepadatan. */
    private function hierarki(Collection $terisi): array
    {
        return ArsipRuang::with('lemari.rak')->orderBy('nama')->get()->map(function ($r) use ($terisi) {
            $lemari = $r->lemari->sortBy('kode')->map(function ($l) use ($terisi) {
                $rak = $l->rak->sortBy('kode')->map(function ($k) use ($terisi) {
                    $n = (int) ($terisi[$k->id] ?? 0);
                    $p = $this->persen($n, $k->kapasitas);
                    return ['id' => $k->id, 'kode' => $k->kode, 'kapasitas' => $k->kapasitas, 'terisi' => $n, 'pct' => $p, 'tingkat' => $this->tingkat($p)];
                })->values();

                $kap = (int) $rak->sum('kapasitas');
                $isi = (int) $rak->sum('terisi');
                $pct = $this->persen($isi, $kap);

                return ['id' => $l->id, 'kode' => $l->kode, 'ket' => $l->keterangan, 'kapasitas' => $kap,
                        'terisi' => $isi, 'pct' => $pct, 'tingkat' => $this->tingkat($pct), 'rak' => $rak->all()];
            })->values();

            return [
                'id' => $r->id, 'nama' => $r->nama, 'gedung' => $r->gedung, 'lantai' => $r->lantai,
                'peruntukan' => $r->peruntukan, 'alamat' => $r->alamat,
                'jumlahLemari' => $lemari->count(), 'terisi' => (int) $lemari->sum('terisi'),
                'lemari' => $lemari->all(),
            ];
        })->all();
    }

    /** Daftar lemari + rak untuk pilihan pada formulir. */
    private function opsiLokasi(array $hierarki): array
    {
        $hasil = [];
        foreach ($hierarki as $ruang) {
            foreach ($ruang['lemari'] as $l) {
                $hasil[] = [
                    'id'    => $l['id'],
                    'label' => $ruang['nama'] . ' • ' . $l['kode'],
                    'raks'  => array_map(fn ($k) => ['id' => $k['id'], 'kode' => $k['kode'], 'sisa' => max(0, $k['kapasitas'] - $k['terisi'])], $l['rak']),
                ];
            }
        }
        return $hasil;
    }

    private function ringkasan(Collection $terisi): array
    {
        $rakTotal  = ArsipRak::count();
        $rakTerisi = $terisi->count();
        $dipinjam  = ArsipFisik::where('status', 'dipinjam');

        return [
            'total'      => ArsipFisik::count(),
            'tersimpan'  => ArsipFisik::where('status', 'tersimpan')->count(),
            'lemari'     => ArsipLemari::count(),
            'map'        => ArsipFisik::whereNotNull('kode_map')->distinct()->count('kode_map'),
            'ruang'      => ArsipRuang::count(),
            'rakTotal'   => $rakTotal,
            'rakTerisi'  => $rakTerisi,
            'pctRak'     => $rakTotal > 0 ? round($rakTerisi / $rakTotal * 100, 1) : 0,
            'dipinjam'   => (clone $dipinjam)->count(),
            'jatuhTempo' => (clone $dipinjam)->whereDate('jatuh_tempo', '<', today())->count(),
            'belum'      => ArsipFisik::whereNull('arsip_rak_id')->count(),
            'antrean'    => ArsipFisik::where('status', 'antrean')->count(),
            'perhatian'  => ArsipFisik::where('kondisi', 'perhatian')->count(),
            'sinkron'    => now()->locale('id')->translatedFormat('H:i') . ' WIB',
        ];
    }

    /** Data panel "Detail Arsip Terpilih" (JSON untuk JavaScript). */
    private function detail(ArsipFisik $a, Collection $terisi, Collection $log): array
    {
        $rak   = $a->rak;
        $lem   = $rak ? $rak->lemari : null;
        $ruang = $lem ? $lem->ruang : null;
        $s     = $a->siswa;
        $al    = $a->alumni;
        $meta  = self::DOKUMEN[$a->jenis] ?? self::DOKUMEN_ALUMNI[$a->jenis] ?? ['Pendukung', 'Dokumen pendukung'];
        $fmt   = fn ($t) => $t ? $t->locale('id')->translatedFormat('d M Y') : null;

        return [
            'id'          => $a->id,
            'kode'        => $a->kode_arsip,
            'status'      => $a->status,
            'statusLabel' => $rak ? (ArsipFisik::STATUS[$a->status] ?? $a->status) : 'Belum Ditata',
            'kondisi'     => $a->kondisi,
            'kondisiLabel'=> ArsipFisik::KONDISI[$a->kondisi] ?? $a->kondisi,
            'keterangan'  => $a->keterangan,
            'jenis'       => $a->jenis,
            'kategori'    => $meta[0],
            'ket'         => $meta[1],
            'siswa'       => $s ? ['id' => $s->id, 'nama' => $s->nama, 'nis' => $s->nis, 'kelas' => $s->kelas, 'angkatan' => $s->tahun_masuk, 'ini' => $this->inisial($s->nama)]
                : ($al ? ['id' => null, 'nama' => $al->nama, 'nis' => $al->nis, 'kelas' => $al->kelas_terakhir, 'angkatan' => $al->tahun_lulus, 'ini' => $this->inisial($al->nama), 'alumni' => true] : null),
            'alumni'      => $al ? ['id' => $al->id, 'url' => route('alumni', ['id' => $al->id])] : null,
            'map'         => $a->kode_map,
            'lokasi'      => $rak ? [
                'ruang' => $ruang->nama, 'alamat' => $ruang->alamat, 'lemari' => $lem->kode, 'lemariKet' => $lem->keterangan,
                'lemariId' => $lem->id, 'rak' => $rak->kode, 'rakId' => $rak->id,
                'terisi' => (int) ($terisi[$rak->id] ?? 0), 'kapasitas' => $rak->kapasitas,
                'ringkas' => implode(' • ', array_filter([$lem->kode, $rak->kode, $a->kode_map])),
            ] : null,
            'pinjam'      => $a->status === 'dipinjam' ? [
                'oleh' => $a->peminjam, 'keperluan' => $a->keperluan,
                'tanggal' => $fmt($a->tanggal_pinjam), 'jatuhTempo' => $fmt($a->jatuh_tempo),
                'lewat' => $a->jatuh_tempo ? $a->jatuh_tempo->lt(today()) : false,
            ] : null,
            'log'         => $log->take(5)->map(fn ($l) => [
                'aksi' => $l->aksi, 'ket' => $l->keterangan, 'oleh' => $l->petugas,
                'waktu' => $l->created_at->locale('id')->translatedFormat('d M Y, H:i'),
            ])->values()->all(),
            'qr'          => route('arsip.fisik', ['pilih' => $a->id]),
            'urlDigital'  => $s ? route('arsip.digital', ['q' => $s->nis, 'jenis' => $a->jenis]) : null,
            'urlProfil'   => $s ? route('siswa.detail', ['id' => $s->id]) : null,
            'urlKelengkapan' => $s ? route('kelengkapan.dokumen', ['q' => $s->nis, 'pilih' => $s->id]) : null,
        ];
    }

    private function persen(int $n, int $kapasitas): int
    {
        return $kapasitas > 0 ? (int) round($n / $kapasitas * 100) : 0;
    }

    private function tingkat(int $pct): string
    {
        if ($pct > self::BATAS_KRITIS) return 'kritis';
        return $pct >= self::BATAS_PADAT ? 'padat' : 'stabil';
    }

    private function inisial(string $nama): string
    {
        $p = preg_split('/\s+/', trim($nama));
        return mb_strtoupper(mb_substr($p[0], 0, 1) . (isset($p[1]) ? mb_substr($p[1], 0, 1) : ''));
    }

    private function tahun(SiswaAktif $s): int
    {
        return preg_match('/^\d{4}$/', (string) $s->tahun_masuk) ? (int) $s->tahun_masuk : (int) now()->year;
    }

    /** Kode arsip berurutan per tahun, contoh: ARS-2026-0001. */
    private function kodeBaru(int $tahun): string
    {
        $awal = "ARS-{$tahun}-";
        $akhir = ArsipFisik::where('kode_arsip', 'like', $awal . '%')->orderByDesc('kode_arsip')->value('kode_arsip');
        $n = $akhir ? ((int) substr($akhir, -4)) + 1 : 1;

        return $awal . str_pad((string) $n, 4, '0', STR_PAD_LEFT);
    }

    private function sisaRak(ArsipRak $rak): int
    {
        return max(0, $rak->kapasitas - ArsipFisik::where('arsip_rak_id', $rak->id)->count());
    }

    private function teksLokasi(?ArsipRak $rak, ?string $map): string
    {
        if (! $rak) return 'belum ditentukan';
        $rak->loadMissing('lemari.ruang');

        return implode(' • ', array_filter([$rak->lemari->ruang->nama, $rak->lemari->kode, $rak->kode, $map]));
    }

    private function catat(ArsipFisik $a, string $aksi, string $keterangan): void
    {
        ArsipFisikLog::create([
            'arsip_fisik_id' => $a->id, 'aksi' => $aksi, 'keterangan' => $keterangan,
            'petugas' => optional(auth()->user())->name ?? 'Admin',
        ]);
    }
}