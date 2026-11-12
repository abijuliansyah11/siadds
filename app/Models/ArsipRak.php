<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArsipRak extends Model
{
    protected $table = 'arsip_rak';

    protected $fillable = ['arsip_lemari_id', 'kode', 'kapasitas'];

    public function lemari(): BelongsTo
    {
        return $this->belongsTo(ArsipLemari::class, 'arsip_lemari_id');
    }

    public function arsip(): HasMany
    {
        return $this->hasMany(ArsipFisik::class, 'arsip_rak_id');
    }

    /** Sisa tempat pada rak ini. */
    public function sisa(): int
    {
        return max(0, $this->kapasitas - $this->arsip()->count());
    }
}