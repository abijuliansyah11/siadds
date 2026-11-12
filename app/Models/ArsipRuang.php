<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArsipRuang extends Model
{
    protected $table = 'arsip_ruang';

    protected $fillable = ['nama', 'gedung', 'lantai', 'peruntukan'];

    public function lemari(): HasMany
    {
        return $this->hasMany(ArsipLemari::class, 'arsip_ruang_id');
    }

    /** Contoh: "Gedung A, Ruang Tata Usaha, Lt. 1" */
    public function getAlamatAttribute(): string
    {
        return implode(', ', array_filter([
            $this->gedung,
            $this->nama,
            $this->lantai ? 'Lt. ' . $this->lantai : null,
        ]));
    }
}