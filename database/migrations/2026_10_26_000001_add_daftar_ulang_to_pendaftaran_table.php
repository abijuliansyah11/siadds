<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Menambah kolom daftar ulang & konversi dan tabel log konversi. Migration lama tidak diubah. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $t) {
            if (! Schema::hasColumn('pendaftaran', 'daftar_ulang')) {
                $t->json('daftar_ulang')->nullable();                          // {"sy":[bool x5]}
            }
            if (! Schema::hasColumn('pendaftaran', 'siswa_aktif_id')) {
                $t->unsignedBigInteger('siswa_aktif_id')->nullable()->index(); // terisi setelah dikonversi
            }
            if (! Schema::hasColumn('pendaftaran', 'dikonversi_at')) {
                $t->timestamp('dikonversi_at')->nullable();
            }
        });

        if (! Schema::hasTable('konversi_log')) {
            Schema::create('konversi_log', function (Blueprint $t) {
                $t->id();
                $t->unsignedBigInteger('pendaftaran_id')->nullable()->index();
                $t->text('isi');
                $t->string('warna', 9)->default('#64748b');
                $t->unsignedBigInteger('user_id')->nullable();
                $t->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('konversi_log');

        Schema::table('pendaftaran', function (Blueprint $t) {
            $t->dropColumn(array_filter(
                ['daftar_ulang', 'siswa_aktif_id', 'dikonversi_at'],
                fn ($c) => Schema::hasColumn('pendaftaran', $c)
            ));
        });
    }
};