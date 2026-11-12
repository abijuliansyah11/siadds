<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Models\Pendaftaran;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

/**
 * Ubah & hapus data calon siswa (halaman Data Calon Siswa).
 * Yang boleh diubah di sini hanya data identitas dasar. Status berkas diatur di halaman
 * Verifikasi Berkas, dan status seleksi diatur di halaman Status & Seleksi.
 */
class CalonSiswaAksiController extends Controller
{
    public function update(Request $request, int $id): JsonResponse
    {
        $p = Pendaftaran::findOrFail($id);

        $data = $request->validate([
            'nama'  => ['required', 'string', 'min:3', 'max:120'],
            'nisn'  => ['required', 'digits:10', Rule::unique('pendaftaran', 'nisn')->ignore($p->id)],
            'sek'   => ['required', 'string', 'max:120'],
            'jk'    => ['required', Rule::in(['L', 'P'])],
            'jalur' => ['required', Rule::in(['Reguler', 'Prestasi', 'Afirmasi'])],
        ], [
            'required' => ':attribute wajib diisi.',
            'min'      => ':attribute minimal :min karakter.',
            'digits'   => ':attribute harus :digits digit angka.',
            'unique'   => ':attribute sudah terdaftar pada pendaftar lain.',
            'in'       => ':attribute tidak valid.',
        ], [
            'nama' => 'Nama', 'nisn' => 'NISN', 'sek' => 'Asal sekolah', 'jk' => 'Jenis kelamin', 'jalur' => 'Jalur',
        ]);

        // NISN juga tidak boleh dipakai calon siswa lain di daftar penerimaan
        $bentrok = CalonSiswa::where('nisn', $data['nisn'])
            ->where('reg', '!=', (string) $p->no_registrasi)
            ->exists();
        if ($bentrok) {
            return response()->json([
                'ok'      => false,
                'message' => 'NISN sudah terdaftar pada calon siswa lain.',
                'errors'  => ['nisn' => ['NISN sudah terdaftar pada calon siswa lain.']],
            ], 422);
        }

        DB::transaction(function () use ($p, $data) {
            $p->forceFill($data)->save();

            // Samakan salinannya di daftar penerimaan (jika ada)
            CalonSiswa::where('reg', $p->no_registrasi)->update([
                'nama'          => $data['nama'],
                'nisn'          => $data['nisn'],
                'asal_sekolah'  => $data['sek'],
                'jalur'         => $data['jalur'],
                'jenis_kelamin' => $data['jk'],
            ]);
        });

        return response()->json(['ok' => true, 'message' => 'Data calon siswa berhasil diperbarui.']);
    }

    public function destroy(int $id): JsonResponse
    {
        $p = Pendaftaran::findOrFail($id);
        $nama = $p->nama;

        try {
            DB::transaction(function () use ($p) {
                CalonSiswa::where('reg', $p->no_registrasi)->delete();
                $p->delete();
            });
        } catch (QueryException $e) {
            return response()->json([
                'ok'      => false,
                'message' => 'Data tidak dapat dihapus karena masih dipakai oleh data lain.',
            ], 409);
        }

        // Hapus berkas fisik setelah datanya berhasil dihapus
        $paths = [];
        if ($p->foto_path) {
            $paths[] = $p->foto_path;
        }
        $dok = $p->dokumen;
        if (is_string($dok)) {
            $dok = json_decode($dok, true);
        }
        if (is_array($dok)) {
            foreach ($dok as $d) {
                if (! empty($d['path'])) {
                    $paths[] = $d['path'];
                }
            }
        }
        if ($paths) {
            Storage::disk('public')->delete($paths);
        }

        return response()->json(['ok' => true, 'message' => 'Data "' . $nama . '" berhasil dihapus.']);
    }
}