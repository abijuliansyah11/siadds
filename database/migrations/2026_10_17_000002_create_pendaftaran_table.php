<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Dilewati jika tabel sudah ada
        if (Schema::hasTable('pendaftaran')) {
            return;
        }

        Schema::create('pendaftaran', function (Blueprint $t) {
            $t->id();
            $t->string('no_registrasi', 20)->unique();
            $t->string('status', 12)->default('draft')->index(); // draft | terkirim

            // Langkah 1 - Data pribadi
            $t->string('nama', 120)->index();
            $t->string('nisn', 10)->nullable()->unique();
            $t->string('nik', 16)->nullable()->unique();
            $t->char('jk', 1)->nullable();
            $t->string('agama', 20)->nullable();
            $t->string('tempat', 80)->nullable();
            $t->date('tgl')->nullable();
            $t->string('hp', 20)->nullable();
            $t->string('email', 120)->nullable();

            // Langkah 2 - Alamat
            $t->string('alamat', 255)->nullable();
            $t->string('desa', 80)->nullable();
            $t->string('kec', 80)->nullable();
            $t->string('kab', 80)->nullable();
            $t->string('prov', 80)->nullable();
            $t->string('pos', 5)->nullable();

            // Langkah 3 - Pendidikan
            $t->string('sek', 120)->nullable();
            $t->string('lulus', 4)->nullable();
            $t->string('jalur', 20)->nullable();
            $t->string('minat', 20)->nullable();

            // Langkah 4 - Orang tua / wali
            $t->string('ayah', 120)->nullable();
            $t->string('ibu', 120)->nullable();
            $t->string('kerja', 30)->nullable();
            $t->string('hpo', 20)->nullable();
            $t->string('wali', 120)->nullable();

            // Langkah 5 - Dokumen
            $t->string('foto_path')->nullable();
            $t->json('dokumen')->nullable();
            $t->json('progres')->nullable();
            $t->unsignedTinyInteger('kelengkapan')->default(0);

            $t->foreignId('dibuat_oleh')->nullable()->constrained('users')->nullOnDelete();
            $t->foreignId('diubah_oleh')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};