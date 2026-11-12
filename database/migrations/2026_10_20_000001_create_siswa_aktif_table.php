<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('siswa_aktif')) {
            Schema::create('siswa_aktif', function (Blueprint $table) {
                $table->id();
                $table->string('nis', 20)->unique();
                $table->string('nisn', 10)->unique();
                $table->string('nama', 100)->index();
                $table->string('panggilan', 50)->nullable();
                $table->char('jenis_kelamin', 1);                 // L / P
                $table->string('kelas', 10)->index();             // mis. X-A, XI-B
                $table->string('rombel', 80)->nullable();         // mis. Peminatan MIPA 1
                $table->unsignedSmallInteger('tahun_masuk')->index();
                $table->date('tanggal_masuk')->nullable();
                $table->string('wali_kelas', 100)->nullable();
                $table->string('nama_orang_tua', 100)->nullable();
                $table->string('foto')->nullable();               // path di storage/public
                $table->string('status', 20)->default('Aktif')->index();
                $table->string('tahun_ajaran', 9)->default('2026/2027');
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('siswa_dokumen')) {
            Schema::create('siswa_dokumen', function (Blueprint $table) {
                $table->id();
                $table->foreignId('siswa_aktif_id')->constrained('siswa_aktif')->cascadeOnDelete();
                $table->string('jenis', 60);                      // mis. Kartu Keluarga (KK)
                $table->string('nama_file', 150);
                $table->string('ukuran', 20)->nullable();
                $table->string('status', 15)->default('valid');   // valid / pending / ditolak
                $table->string('diunggah_oleh', 100)->nullable();
                $table->date('tanggal_unggah')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_dokumen');
        Schema::dropIfExists('siswa_aktif');
    }
};