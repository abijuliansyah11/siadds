<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CalonSiswaController extends Controller
{
    /* ============================================================
       INDEX — daftar + pencarian + statistik KPI
       ============================================================ */
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));

        $query = CalonSiswa::query();

        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $w->where('reg', 'like', "%{$q}%")
                  ->orWhere('nama', 'like', "%{$q}%")
                  ->orWhere('nisn', 'like', "%{$q}%")
                  ->orWhere('asal_sekolah', 'like', "%{$q}%")
                  ->orWhere('jalur', 'like', "%{$q}%");
            });
        }

        $data = $query->orderByDesc('created_at')->get();

        // Statistik KPI dari database
        $stats = [
            'total'     => CalonSiswa::count(),
            'terverif'  => CalonSiswa::where('status_berkas', 'T')->count(),
            'menunggu'  => CalonSiswa::where('status_berkas', 'M')->count(),
            'ditolak'   => CalonSiswa::where('status_berkas', 'R')->count(),
            'perbaikan' => CalonSiswa::where('status_berkas', 'P')->count(),
            'kapasitas' => 160,
        ];
        $stats['lolos'] = $stats['terverif'];

        if ($request->wantsJson()) {
            return response()->json([
                'ok'    => true,
                'data'  => $data,
                'stats' => $stats,
                'q'     => $q,
            ]);
        }

        return view('penerimaan', compact('data', 'stats', 'q'));
    }

    /* ============================================================
       STORE — simpan data baru
       ============================================================ */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reg'           => ['required', 'string', 'max:30', 'unique:calon_siswa,reg'],
            'nama'          => ['required', 'string', 'min:3', 'max:100'],
            'nisn'          => ['required', 'digits:10', 'unique:calon_siswa,nisn'],
            'asal_sekolah'  => ['required', 'string', 'max:150'],
            'jalur'         => ['required', Rule::in(['Reguler', 'Prestasi', 'Afirmasi'])],
            'tanggal_masuk' => ['required', 'date'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'status_berkas' => ['required', Rule::in(['T', 'M', 'P', 'R'])],
        ]);

        $item = CalonSiswa::create($validated);

        return response()->json([
            'ok'      => true,
            'message' => 'Data calon siswa berhasil disimpan.',
            'data'    => $item,
        ]);
    }

    /* ============================================================
       UPDATE — ubah data
       ============================================================ */
    public function update(Request $request, $id)
    {
        $item = CalonSiswa::findOrFail($id);

        $validated = $request->validate([
            'reg'           => ['required', 'string', 'max:30', Rule::unique('calon_siswa', 'reg')->ignore($item->id)],
            'nama'          => ['required', 'string', 'min:3', 'max:100'],
            'nisn'          => ['required', 'digits:10', Rule::unique('calon_siswa', 'nisn')->ignore($item->id)],
            'asal_sekolah'  => ['required', 'string', 'max:150'],
            'jalur'         => ['required', Rule::in(['Reguler', 'Prestasi', 'Afirmasi'])],
            'tanggal_masuk' => ['required', 'date'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'status_berkas' => ['required', Rule::in(['T', 'M', 'P', 'R'])],
        ]);

        $item->update($validated);

        return response()->json([
            'ok'      => true,
            'message' => 'Data berhasil diperbarui.',
            'data'    => $item->fresh(),
        ]);
    }

    /* ============================================================
       DESTROY — hapus data
       ============================================================ */
    public function destroy($id)
    {
        $item = CalonSiswa::findOrFail($id);
        $item->delete();

        return response()->json([
            'ok'      => true,
            'message' => 'Data berhasil dihapus.',
        ]);
    }

    /* ============================================================
       EXPORT — CSV / XLS / PDF
       ============================================================ */
    public function export(Request $request, $format = 'csv')
    {
        $data = CalonSiswa::orderByDesc('created_at')->get();

        $rows = [
            ['No. Registrasi', 'Nama', 'NISN', 'Asal Sekolah', 'Jalur', 'Status', 'Tgl Masuk'],
        ];
        foreach ($data as $d) {
            $rows[] = [
                $d->reg,
                $d->nama,
                $d->nisn,
                $d->asal_sekolah,
                $d->jalur,
                $d->status_label,
                optional($d->tanggal_masuk)->format('Y-m-d'),
            ];
        }

        $filename = 'laporan-ppdb-' . date('Ymd-His');

        if ($format === 'csv') {
            $csv = "\xEF\xBB\xBF";
            foreach ($rows as $r) {
                $csv .= implode(',', array_map(fn ($c) => '"' . str_replace('"', '""', $c) . '"', $r)) . "\n";
            }
            return response($csv, 200, [
                'Content-Type'        => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
            ]);
        }

        if ($format === 'xls') {
            $html  = '<html><head><meta charset="utf-8"></head><body><table border="1">';
            $html .= '<tr style="background:#0f7a4f;color:#fff;font-weight:bold">';
            $html .= implode('', array_map(fn ($h) => "<th>{$h}</th>", $rows[0])) . '</tr>';
            foreach (array_slice($rows, 1) as $r) {
                $html .= '<tr>' . implode('', array_map(fn ($c) => '<td>' . e($c) . '</td>', $r)) . '</tr>';
            }
            $html .= '</table></body></html>';

            return response($html, 200, [
                'Content-Type'        => 'application/vnd.ms-excel',
                'Content-Disposition' => "attachment; filename=\"{$filename}.xls\"",
            ]);
        }

        // PDF → gunakan view printable
        return view('penerimaan-export-pdf', compact('data', 'filename'));
    }
}