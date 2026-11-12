<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiswaDokumen extends Model
{
    protected $table = 'siswa_dokumen';

    protected $fillable = [
        'siswa_aktif_id', 'jenis', 'nama_file', 'ukuran',
        'status', 'diunggah_oleh', 'tanggal_unggah', 'path',
    ];

    protected $casts = ['tanggal_unggah' => 'date'];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaAktif::class, 'siswa_aktif_id');
    }
}