<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;

/** Data JSON untuk halaman Data Calon Siswa (hanya membaca, tidak mengubah apa pun). */
class PendaftaranDataController extends Controller
{
    public function index()
    {
        $data = Pendaftaran::orderByDesc('id')->get()->map(function ($p) {
            $jk  = strtoupper(substr((string) $p->jk, 0, 1));
            $age = $p->tgl ? $p->tgl->age : 15;
            return [
                'id'     => $p->id,
                'reg'    => $p->no_registrasi ?: 'DRAFT-' . $p->id,
                'name'   => $p->nama ?: '(Tanpa nama)',
                'sex'    => $jk === 'P' ? 'P' : 'L',
                'nisn'   => $p->nisn ?: '-',
                'nik'    => $p->nik ?: '-',
                'school' => $p->sek ?: '-',
                'jalur'  => $p->jalur ?: 'Reguler',
                'age'    => $age,
                'g'      => 1,
                'st'     => ['T' => 'T', 'P' => 'P'][$p->status_verifikasi ?? 'M'] ?? 'M',   // dari hasil Verifikasi Berkas
                'sel'    => ['L' => 'Lolos', 'C' => 'Cadangan', 'X' => 'Tidak Lolos'][$p->status_seleksi ?? 'M'] ?? 'Belum',   // dari hasil Status & Seleksi
                'date'   => optional($p->created_at)->format('Y-m-d') ?: date('Y-m-d'),
            ];
        });

        return response()->json(['ok' => true, 'data' => $data]);
    }
}