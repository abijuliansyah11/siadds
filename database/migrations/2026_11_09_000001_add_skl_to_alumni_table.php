<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Fitur Cetak SKL (Surat Keterangan Lulus) di halaman Cetak Label QR Code.
 * Hanya MENAMBAH kolom/tabel; tidak ada data atau kolom lama yang diubah.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('alumni')) {
            Schema::table('alumni', function (Blueprint $table) {
                if (! Schema::hasColumn('alumni', 'tempat_lahir')) {
                    $table->string('tempat_lahir', 60)->nullable();
                }
                if (! Schema::hasColumn('alumni', 'tanggal_lahir')) {
                    $table->date('tanggal_lahir')->nullable();
                }
                if (! Schema::hasColumn('alumni', 'nama_orang_tua')) {
                    $table->string('nama_orang_tua', 120)->nullable();
                }
                if (! Schema::hasColumn('alumni', 'nilai_skl')) {
                    $table->text('nilai_skl')->nullable();   // JSON: {"peminatan":"..","mapel":[{"k":"A","n":"..","v":89}]}
                }
            });
        }

        if (! Schema::hasTable('skl_pengaturan')) {
            Schema::create('skl_pengaturan', function (Blueprint $table) {
                $table->id();
                $table->string('kunci', 60)->unique();
                $table->text('nilai')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('skl_log')) {
            Schema::create('skl_log', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('alumni_id')->index();
                $table->string('nomor', 60)->nullable();
                $table->string('petugas', 100)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('skl_log');
        Schema::dropIfExists('skl_pengaturan');

        if (Schema::hasTable('alumni')) {
            foreach (['tempat_lahir', 'tanggal_lahir', 'nama_orang_tua', 'nilai_skl'] as $kolom) {
                if (Schema::hasColumn('alumni', $kolom)) {
                    Schema::table('alumni', fn (Blueprint $t) => $t->dropColumn($kolom));
                }
            }
        }
    }
};