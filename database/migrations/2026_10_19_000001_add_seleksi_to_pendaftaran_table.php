<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Menambah kolom hasil seleksi dan tabel log seleksi. Migration lama tidak diubah. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pendaftaran', function (Blueprint $t) {
            if (! Schema::hasColumn('pendaftaran', 'status_seleksi')) {
                $t->string('status_seleksi', 1)->default('M')->index();   // M | D | L | C | X
            }
            if (! Schema::hasColumn('pendaftaran', 'nilai_rapor')) {
                $t->decimal('nilai_rapor', 5, 2)->nullable();
            }
            if (! Schema::hasColumn('pendaftaran', 'zonasi')) {
                $t->unsignedTinyInteger('zonasi')->nullable();
            }
            if (! Schema::hasColumn('pendaftaran', 'catatan_seleksi')) {
                $t->text('catatan_seleksi')->nullable();
            }
            if (! Schema::hasColumn('pendaftaran', 'seleksi_terkunci')) {
                $t->boolean('seleksi_terkunci')->default(false);
            }
            if (! Schema::hasColumn('pendaftaran', 'diseleksi_oleh')) {
                $t->foreignId('diseleksi_oleh')->nullable()->constrained('users')->nullOnDelete();
            }
            if (! Schema::hasColumn('pendaftaran', 'diseleksi_at')) {
                $t->timestamp('diseleksi_at')->nullable();
            }
        });

        if (! Schema::hasTable('seleksi_log')) {
            Schema::create('seleksi_log', function (Blueprint $t) {
                $t->id();
                $t->foreignId('pendaftaran_id')->nullable()->constrained('pendaftaran')->nullOnDelete();
                $t->text('isi');
                $t->string('warna', 9)->default('#64748b');
                $t->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $t->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('seleksi_log');

        Schema::table('pendaftaran', function (Blueprint $t) {
            if (Schema::hasColumn('pendaftaran', 'diseleksi_oleh')) {
                $t->dropForeign(['diseleksi_oleh']);
            }
            $t->dropColumn(array_filter(
                ['status_seleksi', 'nilai_rapor', 'zonasi', 'catatan_seleksi', 'seleksi_terkunci', 'diseleksi_oleh', 'diseleksi_at'],
                fn ($c) => Schema::hasColumn('pendaftaran', $c)
            ));
        });
    }
};