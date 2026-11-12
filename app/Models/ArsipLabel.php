<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArsipLabel extends Model
{
    protected $table = 'arsip_label';

    protected $fillable = [
        'arsip_fisik_id', 'status', 'template', 'ukuran', 'qty',
        'dibuat_oleh', 'dicetak_oleh', 'dicetak_at',
    ];

    protected $casts = ['dicetak_at' => 'datetime'];

    /** Label status label pada riwayat. */
    public const STATUS = [
        'dibuat'  => 'Dibuat',
        'siap'    => 'Siap Cetak',
        'selesai' => 'Selesai',
    ];

    public function arsip(): BelongsTo
    {
        return $this->belongsTo(ArsipFisik::class, 'arsip_fisik_id');
    }
}