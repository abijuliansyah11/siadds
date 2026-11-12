<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Arsip fisik milik alumni.
 * - Menambah kolom alumni_id (boleh kosong) pada arsip_fisik.
 * - siswa_aktif_id dibuat boleh kosong, karena arsip alumni tidak terkait siswa aktif.
 *   (Indeks unik siswa_aktif_id + jenis tetap ada; nilai NULL boleh berulang di MySQL.)
 * - Satu alumni hanya boleh punya satu catatan per jenis dokumen.
 * Data arsip siswa yang sudah ada tidak diubah.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('arsip_fisik')) {
            return;
        }

        if (! Schema::hasColumn('arsip_fisik', 'alumni_id')) {
            Schema::table('arsip_fisik', function (Blueprint $table) {
                $table->unsignedBigInteger('alumni_id')->nullable()->after('siswa_aktif_id')->index();
            });
        }

        if (in_array(DB::connection()->getDriverName(), ['mysql', 'mariadb'], true)) {
            DB::statement('ALTER TABLE arsip_fisik MODIFY siswa_aktif_id BIGINT UNSIGNED NULL');
        } else {
            Schema::table('arsip_fisik', function (Blueprint $table) {
                $table->unsignedBigInteger('siswa_aktif_id')->nullable()->change();
            });
        }

        try {
            Schema::table('arsip_fisik', function (Blueprint $table) {
                $table->unique(['alumni_id', 'jenis'], 'arsip_fisik_alumni_jenis_unique');
            });
        } catch (\Throwable $e) {
            // indeks sudah ada: abaikan
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('arsip_fisik') || ! Schema::hasColumn('arsip_fisik', 'alumni_id')) {
            return;
        }

        DB::table('arsip_fisik')->whereNotNull('alumni_id')->delete();

        Schema::table('arsip_fisik', function (Blueprint $table) {
            $table->dropUnique('arsip_fisik_alumni_jenis_unique');
            $table->dropColumn('alumni_id');
        });
        // Kolom siswa_aktif_id sengaja dibiarkan boleh kosong agar aman.
    }
};