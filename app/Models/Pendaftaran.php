<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    /** Nomor urut pertama (melanjutkan REG-2026-0006 yang tampil di halaman). */
    public const NOMOR_AWAL = 6;

    /** Kolom isian formulir (sama dengan key pada form di halaman). */
    public const FIELD = [
        'nama', 'nisn', 'nik', 'jk', 'agama', 'tempat', 'tgl', 'hp', 'email',
        'alamat', 'desa', 'kec', 'kab', 'prov', 'pos',
        'sek', 'lulus', 'jalur', 'minat',
        'ayah', 'ibu', 'kerja', 'hpo', 'wali',
    ];

    /** Isian wajib (dipakai menghitung persentase kelengkapan). */
    public const WAJIB = [
        'nama', 'nisn', 'nik', 'jk', 'agama', 'tempat', 'tgl', 'hp',
        'alamat', 'desa', 'kec', 'kab', 'prov',
        'sek', 'lulus', 'jalur',
        'ayah', 'ibu', 'hpo',
    ];

    protected $fillable = [
        ...self::FIELD,
        'no_registrasi', 'status', 'foto_path', 'dokumen', 'progres',
        'kelengkapan', 'dibuat_oleh', 'diubah_oleh',
    ];

    protected $casts = [
        'tgl'      => 'date',
        'dokumen'  => 'array',
        'progres'  => 'array',
    ];

    /** Membuat nomor registrasi berikutnya, contoh: REG-2026-0006. */
    public static function nomorBerikutnya(): string
    {
        $prefix   = 'REG-' . now()->format('Y') . '-';
        $terakhir = static::where('no_registrasi', 'like', $prefix . '%')->max('no_registrasi');
        $urut     = $terakhir ? ((int) substr($terakhir, -4)) + 1 : self::NOMOR_AWAL;

        return $prefix . str_pad((string) max($urut, self::NOMOR_AWAL), 4, '0', STR_PAD_LEFT);
    }
}