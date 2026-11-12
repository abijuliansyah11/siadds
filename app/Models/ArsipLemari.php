<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArsipLemari extends Model
{
    protected $table = 'arsip_lemari';

    protected $fillable = ['arsip_ruang_id', 'kode', 'keterangan'];

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(ArsipRuang::class, 'arsip_ruang_id');
    }

    public function rak(): HasMany
    {
        return $this->hasMany(ArsipRak::class, 'arsip_lemari_id');
    }
}