<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumni extends Model
{
    protected $table = 'alumni';

    protected $fillable = [
        'nis', 'nisn', 'nama', 'panggilan', 'jenis_kelamin', 'nik', 'kelas_terakhir', 'jurusan',
        'tahun_masuk', 'tahun_lulus', 'angkatan', 'tanggal_kelulusan', 'nomor_ijazah', 'nomor_skl',
        'rata_rata', 'prestasi', 'foto', 'status_ijazah', 'tanggal_pengambilan', 'diambil_oleh',
        'ruang_arsip', 'lemari', 'rak', 'kode_map',
    ];

    protected $casts = [
        'tanggal_kelulusan'   => 'date',
        'tanggal_pengambilan' => 'date',
        'rata_rata'           => 'float',
    ];

    /** Enam dokumen kelulusan yang wajib diarsipkan. */
    public const DOKUMEN = [
        ['key' => 'ijazah',    'label' => 'Ijazah Madrasah Asli',            'short' => 'Ijazah',       'badge' => 'Resmi',          'icon' => 'file'],
        ['key' => 'skl',       'label' => 'Surat Ket. Lulus (SKL)',          'short' => 'SKL',          'badge' => 'Terbit',         'icon' => 'check'],
        ['key' => 'transkrip', 'label' => 'Transkrip Nilai Akademik',        'short' => 'Transkrip',    'badge' => 'Lengkap',        'icon' => 'chart'],
        ['key' => 'akta',      'label' => 'Akta Kelahiran & KK',             'short' => 'Akta/KK',      'badge' => 'Valid',          'icon' => 'users'],
        ['key' => 'foto',      'label' => 'Pasfoto Wisuda 3x4 (Cap 3 Jari)', 'short' => 'Cap 3 Jari',  'badge' => 'Cap Selesai',    'icon' => 'user'],
        ['key' => 'berita',    'label' => 'Berita Acara & Tanda Terima',     'short' => 'Berita Acara', 'badge' => 'Ditandatangani', 'icon' => 'folder'],
    ];

    public function dokumen(): HasMany
    {
        return $this->hasMany(AlumniDokumen::class, 'alumni_id');
    }

    public static function romawi(int $n): string
    {
        $peta = ['M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1];
        $hasil = '';
        foreach ($peta as $simbol => $nilai) {
            while ($n >= $nilai) {
                $hasil .= $simbol;
                $n -= $nilai;
            }
        }

        return $hasil !== '' ? $hasil : '-';
    }
}