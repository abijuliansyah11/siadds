<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Menambah kolom hasil verifikasi berkas. Migration lama tidak diubah. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $t) {
            if (! Schema::hasColumn('pendaftaran', 'verifikasi')) {
                $t->json('verifikasi')->nullable();                       // status tiap dokumen + log
            }
            if (! Schema::hasColumn('pendaftaran', 'status_verifikasi')) {
                $t->string('status_verifikasi', 1)->default('M')->index(); // M | S | T | P
            }
            if (! Schema::hasColumn('pendaftaran', 'diverifikasi_oleh')) {
                $t->foreignId('diverifikasi_oleh')->nullable()->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('pendaftaran', 'diverifikasi_at')) {
                $t->timestamp('diverifikasi_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('pendaftaran', function (Blueprint $t) {
            if (Schema::hasColumn('pendaftaran', 'diverifikasi_oleh')) {
                $t->dropForeign(['diverifikasi_oleh']);
            }
            $t->dropColumn(array_filter(
                ['verifikasi', 'status_verifikasi', 'diverifikasi_oleh', 'diverifikasi_at'],
                fn ($c) => Schema::hasColumn('pendaftaran', $c)
            ));
        });
    }
};