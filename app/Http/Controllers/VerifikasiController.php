<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Pendaftaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

/** Verifikasi Berkas: membaca pendaftar berstatus "terkirim" dan menyimpan hasil pemeriksaan. */
class VerifikasiController extends Controller
{
    public function index()
    {
        $rows = Pendaftaran::where('status', 'terkirim')->orderBy('id')->get()
            ->values()
            ->map(fn ($p, $i) => $this->bentuk($p, $i))
            ->all();

        return view('verifikasi', ['vdata' => $rows]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $p = Pendaftaran::where('status', 'terkirim')->findOrFail($id);

        $data = $request->validate([
            'docs'        => ['required', 'array', 'size:5'],
            'docs.*.st'   => ['required', 'in:v,f,p,r'],
            'docs.*.cat'  => ['nullable', 'string', 'max:200'],
            'docs.*.note' => ['nullable', 'string', 'max:300'],
            'docs.*.int'  => ['nullable', 'string', 'max:300'],
            'ret'         => ['nullable', 'boolean'],
            'log'         => ['nullable', 'array', 'max:60'],
            'log.*.h'     => ['required', 'string', 'max:1500'],
            'log.*.t'     => ['nullable', 'string', 'max:40'],
            'log.*.c'     => ['nullable', 'string', 'max:9'],
            'log.*.i'     => ['nullable', 'string', 'max:8'],
        ]);

        $docs = collect(array_values($data['docs']))->map(fn ($d) => [
            'st'   => $d['st'],
            'cat'  => $d['cat'] ?? '',
            'note' => $d['note'] ?? '',
            'int'  => $d['int'] ?? '',
        ])->all();

        $ret = (bool) ($data['ret'] ?? false);

        $log = collect($data['log'] ?? [])->map(fn ($l) => [
            'h' => $this->bersih($l['h']),
            't' => strip_tags($l['t'] ?? ''),
            'c' => preg_match('/^#[0-9a-fA-F]{3,6}$/', $l['c'] ?? '') ? $l['c'] : '#64748b',
            'i' => strip_tags($l['i'] ?? ''),
        ])->all();

        $status = $this->status($docs, $ret);

        $p->forceFill([
            'verifikasi'        => json_encode(['docs' => $docs, 'ret' => $ret, 'log' => $log], JSON_UNESCAPED_UNICODE),
            'status_verifikasi' => $status,
            'diverifikasi_oleh' => Auth::id(),
            'diverifikasi_at'   => now(),
        ])->save();

        // Samakan status berkas pada daftar calon siswa (dibaca halaman Penerimaan)
        try {
            CalonSiswa::where('reg', $p->no_registrasi)
                ->update(['status_berkas' => $status === 'S' ? 'M' : $status]);
        } catch (Throwable $e) {
            Log::warning('Sinkron status berkas ke calon_siswa gagal: ' . $e->getMessage());
        }

        return response()->json(['ok' => true, 'status' => $status]);
    }

    /* ------------------------------------------------------------------ */

    private function status(array $docs, bool $ret): string
    {
        $st = array_column($docs, 'st');
        if (! array_diff($st, ['v'])) return 'T';   // semua valid
        if ($ret)                      return 'P';   // dikembalikan untuk perbaikan
        if (! array_diff($st, ['p']))  return 'M';   // belum ada yang diperiksa
        return 'S';                                   // sedang diperiksa
    }

    private function bentuk(Pendaftaran $p, int $i): array
    {
        $v   = json_decode((string) ($p->verifikasi ?? ''), true) ?: [];
        $dok = $p->dokumen ?? [];

        $slot = [
            ['Kartu Keluarga (KK)', $dok['kk'] ?? null],
            ['Akta Kelahiran', $dok['akta'] ?? null],
            ['Surat Keterangan Lulus / Ijazah (SKL)', $dok['ijazah'] ?? null],
            ['Pas Foto Formal 3x4', $p->foto_path ? ['name' => basename($p->foto_path), 'path' => $p->foto_path] : null],
            ['Data Formulir Pendaftaran', null],
        ];

        $docs = [];
        foreach ($slot as $j => [$judul, $f]) {
            $s  = $v['docs'][$j] ?? [];
            $st = $s['st'] ?? 'p';
            $docs[] = [
                't'    => $judul,
                'file' => $f ? ($f['name'] ?? basename($f['path'])) : ($j === 4 ? 'Formulir_' . $p->no_registrasi . ' (data isian)' : '(belum diunggah)'),
                'size' => $f ? $this->ukuran($f) : '-',
                'url'  => $f && ! empty($f['path']) ? asset('storage/' . ltrim($f['path'], '/')) : null,
                'st'   => in_array($st, ['v', 'f', 'p', 'r'], true) ? $st : 'p',
                'cat'  => $s['cat'] ?? '',
                'note' => $s['note'] ?? '',
                'int'  => $s['int'] ?? '',
            ];
        }

        $tglDaftar = $p->created_at ? $p->created_at->copy()->locale('id') : null;
        $log = $v['log'] ?? [[
            'h' => 'Sistem SIADDS mencatat pembuatan akun & registrasi tiket PPDB baru<br><span class="mu">Nomor Registrasi resmi diterbitkan: <b>' . e($p->no_registrasi) . '</b></span>',
            't' => $tglDaftar ? $tglDaftar->timezone('Asia/Jakarta')->translatedFormat('j M Y, H:i') . ' WIB' : '-',
            'c' => '#64748b',
            'i' => '⚙',
        ]];

        $kip = ! empty($dok['kip']['path'])
            ? ['name' => $dok['kip']['name'] ?? 'KIP', 'url' => asset('storage/' . ltrim($dok['kip']['path'], '/'))]
            : null;

        return [
            'id'        => $i,                 // indeks array (dipakai halaman)
            'dbid'      => $p->id,
            'reg'       => $p->no_registrasi,
            'name'      => $p->nama,
            'sex'       => $p->jk === 'P' ? 'P' : 'L',
            'jalur'     => $p->jalur ?: 'Reguler',
            'age'       => $p->tgl ? $p->tgl->age : 15,
            'school'    => $p->sek ?: '-',
            'nisn'      => $p->nisn ?: '-',
            'nik'       => $p->nik ?: '-',
            'ret'       => (bool) ($v['ret'] ?? false),
            'tgl_daftar' => $tglDaftar ? $tglDaftar->translatedFormat('j F Y') : '-',
            'docs'      => $docs,
            'log'       => $log,
            'kip'       => $kip,
            'form'      => [
                ['Nama Lengkap', $p->nama],
                ['NISN', $p->nisn],
                ['NIK', $p->nik],
                ['Tempat, Tgl Lahir', trim($p->tempat . ', ' . ($p->tgl ? $p->tgl->format('d-m-Y') : ''), ' ,')],
                ['Jenis Kelamin', $p->jk === 'P' ? 'Perempuan' : 'Laki-laki'],
                ['Agama', $p->agama],
                ['No. HP', $p->hp],
                ['Alamat', implode(', ', array_filter([$p->alamat, $p->desa, $p->kec, $p->kab, $p->prov]))],
                ['Asal Sekolah', $p->sek . ($p->lulus ? ' (Lulus ' . $p->lulus . ')' : '')],
                ['Jalur', $p->jalur],
                ['Nama Ayah', $p->ayah],
                ['Nama Ibu', $p->ibu],
                ['HP Orang Tua', $p->hpo],
                ['Wali', $p->wali],
            ],
        ];
    }

    private function ukuran(array $f): string
    {
        try {
            $b = $f['size'] ?? Storage::disk('public')->size($f['path']);
        } catch (Throwable $e) {
            return '-';
        }
        return $b >= 1048576 ? number_format($b / 1048576, 1) . ' MB' : max(1, (int) round($b / 1024)) . ' KB';
    }

    /** Hanya izinkan <b>, <br>, <span> dengan atribut class="mu" atau style="color:#hex". */
    private function bersih(string $h): string
    {
        $h = strip_tags($h, '<b><br><span>');

        return preg_replace_callback('/<(b|span)\b([^>]*)>/i', function ($m) {
            $ok = [];
            if (str_contains($m[2], 'class="mu"')) {
                $ok[] = 'class="mu"';
            }
            if (preg_match('/style="color:\s*(#[0-9a-fA-F]{3,6})"/', $m[2], $c)) {
                $ok[] = 'style="color:' . $c[1] . '"';
            }
            return '<' . strtolower($m[1]) . ($ok ? ' ' . implode(' ', $ok) : '') . '>';
        }, $h);
    }
}