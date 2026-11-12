<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArsipFisik extends Model
{
    protected $table = 'arsip_fisik';

    protected $fillable = [
        'siswa_aktif_id', 'alumni_id', 'jenis', 'kode_arsip', 'arsip_rak_id', 'kode_map',
        'kondisi', 'status', 'keterangan',
        'peminjam', 'keperluan', 'tanggal_pinjam', 'jatuh_tempo',
    ];

    protected $casts = ['tanggal_pinjam' => 'date', 'jatuh_tempo' => 'date'];

    /** Label kondisi fisik dokumen. */
    public const KONDISI = [
        'baik'      => 'Baik',
        'perhatian' => 'Perhatian',
        'rusak'     => 'Rusak',
        'belum'     => 'Belum Dicek',
    ];

    /** Label status keberadaan dokumen. */
    public const STATUS = [
        'tersimpan' => 'Tersimpan Sah',
        'dipinjam'  => 'Dipinjam',
        'antrean'   => 'Antrean Meja TU',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(SiswaAktif::class, 'siswa_aktif_id');
    }

    /** Pemilik arsip bila dokumen milik alumni (siswa_aktif_id kosong). */
    public function alumni(): BelongsTo
    {
        return $this->belongsTo(Alumni::class, 'alumni_id');
    }

    public function rak(): BelongsTo
    {
        return $this->belongsTo(ArsipRak::class, 'arsip_rak_id');
    }

    public function log(): HasMany
    {
        return $this->hasMany(ArsipFisikLog::class, 'arsip_fisik_id');
    }
}