<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlumniDokumen extends Model
{
    protected $table = 'alumni_dokumen';

    protected $fillable = [
        'alumni_id', 'jenis', 'nama_file', 'ukuran', 'status', 'path', 'diunggah_oleh', 'tanggal_unggah',
    ];

    protected $casts = ['tanggal_unggah' => 'date'];

    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }
}