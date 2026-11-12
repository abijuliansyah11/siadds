<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Dilewati jika tabel sudah ada (mis. dibuat manual lewat phpMyAdmin)
        if (Schema::hasTable('calon_siswa')) {
            return;
        }

        Schema::create('calon_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('reg', 30)->unique();          // No. registrasi, mis. REG-2026-0001
            $table->string('nama', 100)->index();
            $table->string('nisn', 10)->unique();
            $table->string('asal_sekolah', 150);
            $table->string('jalur', 20);                  // Reguler / Prestasi / Afirmasi
            $table->date('tanggal_masuk');
            $table->char('jenis_kelamin', 1);             // L / P
            $table->char('status_berkas', 1)->default('M')->index(); // T / M / P / R
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calon_siswa');
    }
};