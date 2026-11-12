<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/** Status & Seleksi: membaca pendaftar "terkirim" dan menyimpan keputusan sidang panitia. */
class SeleksiController extends Controller
{
    private const KUOTA = 160;

    public function index()
    {
        $p    = Pendaftaran::where('status', 'terkirim')->orderBy('id')->get();
        $nama = User::whereIn('id', $p->pluck('diseleksi_oleh')->filter()->unique())->pluck('name', 'id');

        $rows = $p->map(fn ($r) => [
            'id'     => $r->id,
            'reg'    => $r->no_registrasi,
            'name'   => $r->nama,
            'age'    => $r->tgl ? $r->tgl->age : 15,
            'jalur'  => $r->jalur === 'Prestasi' ? 'Prestasi Akademik' : ($r->jalur ?: 'Reguler'),
            'nisn'   => $r->nisn ?: '-',
            'school' => $r->sek ?: '-',
            'b'      => ['T' => 'T', 'P' => 'P'][$r->status_verifikasi ?? 'M'] ?? 'M',
            'sel'    => $r->status_seleksi ?: 'M',
            'score'  => $r->nilai_rapor !== null ? (float) $r->nilai_rapor : 0,
            'zon'    => $r->zonasi ?: 1,
            'ts'     => ($r->diseleksi_at ? Carbon::parse($r->diseleksi_at) : $r->created_at)?->toIso8601String(),
            'off'    => $nama[$r->diseleksi_oleh] ?? 'Panitia PPDB',
            'lock'   => (bool) $r->seleksi_terkunci,
            'note'   => $r->catatan_seleksi ?? '',
        ])->values()->all();

        $logs = DB::table('seleksi_log')->orderByDesc('id')->limit(120)->get()->map(fn ($l) => [
            $l->isi,
            Carbon::parse($l->created_at)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('j F Y, H:i') . ' WIB',
            $l->warna,
        ])->all();

        return view('seleksi', ['sdata' => $rows, 'slogs' => $logs]);
    }

    /** Simpan draft / kunci / buka kunci keputusan satu calon siswa. */
    public function update(Request $request, int $id): JsonResponse
    {
        $p = Pendaftaran::where('status', 'terkirim')->findOrFail($id);

        $d = $request->validate([
            'sel'     => ['required', 'in:M,D,L,C,X'],
            'note'    => ['nullable', 'string', 'max:500'],
            'lock'    => ['required', 'boolean'],
            'score'   => ['nullable', 'numeric', 'between:0,100'],
            'zon'     => ['nullable', 'integer', 'between:1,3'],
            'log'     => ['nullable', 'array', 'max:20'],
            'log.*.h' => ['required', 'string', 'max:1500'],
            'log.*.c' => ['nullable', 'string', 'max:9'],
        ]);

        $lock  = (bool) $d['lock'];
        $score = (float) ($d['score'] ?? 0);
        $note  = trim($d['note'] ?? '');

        if ($lock) {
            if ($p->seleksi_terkunci && $d['sel'] !== $p->status_seleksi) {
                return $this->gagal('Keputusan sudah terkunci. Buka kunci terlebih dahulu.');
            }
            if ($d['sel'] === 'L') {
                if (($p->status_verifikasi ?? 'M') !== 'T') return $this->gagal('Tidak dapat meloloskan: berkas belum terverifikasi.');
                if ($score < 75)                            return $this->gagal('Nilai rapor di bawah batas minimum 75.00.');
                if ($this->jumlahLolos($p->id) >= self::KUOTA) return $this->gagal('Kuota penuh.');
            }
            if ($d['sel'] === 'X' && $note === '') {
                return $this->gagal('Alasan wajib dicatat untuk keputusan Tidak Lolos.');
            }
        }

        $p->forceFill([
            'status_seleksi'   => $d['sel'],
            'nilai_rapor'      => $d['score'] ?? null,
            'zonasi'           => $d['zon'] ?? null,
            'catatan_seleksi'  => $note !== '' ? $note : null,
            'seleksi_terkunci' => $lock,
            'diseleksi_oleh'   => Auth::id(),
            'diseleksi_at'     => now(),
        ])->save();

        $this->catat($p->id, $d['log'] ?? []);

        return response()->json(['ok' => true]);
    }

    /** Tetapkan hasil massal untuk beberapa calon siswa. */
    public function massal(Request $request): JsonResponse
    {
        $d = $request->validate([
            'ids'     => ['required', 'array', 'min:1', 'max:300'],
            'ids.*'   => ['integer'],
            'sel'     => ['required', 'in:M,D,L,C,X'],
            'log'     => ['nullable', 'array', 'max:20'],
            'log.*.h' => ['required', 'string', 'max:1500'],
            'log.*.c' => ['nullable', 'string', 'max:9'],
        ]);

        $lolos = $this->jumlahLolos(0);
        $ok    = [];

        foreach (Pendaftaran::where('status', 'terkirim')->whereIn('id', $d['ids'])->get() as $p) {
            if ($p->seleksi_terkunci) continue;

            if ($d['sel'] === 'L') {
                if (($p->status_verifikasi ?? 'M') !== 'T' || $lolos >= self::KUOTA) continue;
                if ($p->status_seleksi !== 'L') $lolos++;
            }

            $p->forceFill([
                'status_seleksi' => $d['sel'],
                'diseleksi_oleh' => Auth::id(),
                'diseleksi_at'   => now(),
            ])->save();
            $ok[] = $p->id;
        }

        if ($ok) $this->catat(null, $d['log'] ?? []);

        return response()->json(['ok' => true, 'updated' => $ok]);
    }

    /* ------------------------------------------------------------------ */

    private function jumlahLolos(int $kecuali): int
    {
        return Pendaftaran::where('status', 'terkirim')->where('status_seleksi', 'L')->where('id', '!=', $kecuali)->count();
    }

    private function gagal(string $pesan): JsonResponse
    {
        return response()->json(['ok' => false, 'message' => $pesan], 422);
    }

    private function catat(?int $pendaftaranId, array $logs): void
    {
        foreach ($logs as $l) {
            DB::table('seleksi_log')->insert([
                'pendaftaran_id' => $pendaftaranId,
                'isi'            => $this->bersih($l['h']),
                'warna'          => preg_match('/^#[0-9a-fA-F]{3,6}$/', $l['c'] ?? '') ? $l['c'] : '#64748b',
                'user_id'        => Auth::id(),
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
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