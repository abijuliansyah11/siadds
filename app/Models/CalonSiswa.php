<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalonSiswa extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     */
    protected $table = 'calon_siswa';

    /**
     * Kolom yang boleh diisi massal.
     */
    protected $fillable = [
        'reg',
        'nama',
        'nisn',
        'asal_sekolah',
        'jalur',
        'tanggal_masuk',
        'jenis_kelamin',
        'status_berkas',
    ];

    /**
     * Casting tipe data otomatis.
     */
    protected $casts = [
        'tanggal_masuk' => 'date',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    /**
     * Accessor: label status yang mudah dibaca.
     * Pakai: $siswa->status_label
     */
    public function getStatusLabelAttribute(): string
    {
        return [
            'T' => 'Terverifikasi',
            'M' => 'Menunggu',
            'P' => 'Perlu Perbaikan',
            'R' => 'Ditolak',
        ][$this->status_berkas] ?? '-';
    }

    /**
     * Accessor: label jenis kelamin.
     * Pakai: $siswa->jk_label
     */
    public function getJkLabelAttribute(): string
    {
        return $this->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
    }
}