<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiswaAktif extends Model
{
    protected $table = 'siswa_aktif';

    protected $fillable = [
        'nis', 'nisn', 'nama', 'panggilan', 'jenis_kelamin', 'kelas', 'rombel',
        'tahun_masuk', 'tanggal_masuk', 'wali_kelas', 'nama_orang_tua',
        'foto', 'status', 'tahun_ajaran',
        'nik', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'asal_sekolah',
        'nama_ayah', 'nama_ibu', 'no_hp_wali', 'ruang_arsip', 'lemari', 'rak', 'kode_map',
    ];

    protected $casts = ['tanggal_masuk' => 'date', 'tanggal_lahir' => 'date'];

    public const DOKUMEN_WAJIB = [
        'Kartu Keluarga (KK)',
        'Akta Kelahiran',
        'Ijazah / SKL MTs',
        'KTP Orang Tua (Ayah & Ibu)',
        'Pas Foto Resmi 3x4',
        'Surat Pernyataan Kesediaan Santri',
    ];

    public const JUMLAH_DOKUMEN_WAJIB = 6;

    public function dokumen(): HasMany
    {
        return $this->hasMany(SiswaDokumen::class, 'siswa_aktif_id');
    }

    public function getFotoUrlAttribute(): string
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }

        return 'https://ui-avatars.com/api/?background=0b2545&color=fff&name=' . urlencode($this->nama);
    }
}