<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArsipFisikLog extends Model
{
    protected $table = 'arsip_fisik_log';

    protected $fillable = ['arsip_fisik_id', 'aksi', 'keterangan', 'petugas'];

    public function arsip(): BelongsTo
    {
        return $this->belongsTo(ArsipFisik::class, 'arsip_fisik_id');
    }
}