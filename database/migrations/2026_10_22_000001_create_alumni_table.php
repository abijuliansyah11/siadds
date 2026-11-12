<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('alumni')) {
            Schema::create('alumni', function (Blueprint $table) {
                $table->id();
                $table->string('nis', 20)->unique();
                $table->string('nisn', 10)->unique();
                $table->string('nama', 100)->index();
                $table->string('panggilan', 50)->nullable();
                $table->char('jenis_kelamin', 1);                       // L / P
                $table->string('nik', 16)->nullable();
                $table->string('kelas_terakhir', 10)->index();          // mis. XII-A
                $table->string('jurusan', 80)->nullable();              // mis. MIPA 1
                $table->unsignedSmallInteger('tahun_masuk');
                $table->unsignedSmallInteger('tahun_lulus')->index();
                $table->unsignedSmallInteger('angkatan')->nullable();
                $table->date('tanggal_kelulusan')->nullable();
                $table->string('nomor_ijazah', 40)->nullable()->unique();
                $table->string('nomor_skl', 60)->nullable();
                $table->decimal('rata_rata', 5, 2)->nullable();
                $table->text('prestasi')->nullable();
                $table->string('foto')->nullable();
                $table->string('status_ijazah', 15)->default('tersimpan')->index(); // diambil / tersimpan / menunggu
                $table->date('tanggal_pengambilan')->nullable();
                $table->string('diambil_oleh', 100)->nullable();
                $table->string('ruang_arsip', 100)->nullable();
                $table->string('lemari', 40)->nullable();
                $table->string('rak', 20)->nullable();
                $table->string('kode_map', 40)->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('alumni_dokumen')) {
            Schema::create('alumni_dokumen', function (Blueprint $table) {
                $table->id();
                $table->foreignId('alumni_id')->constrained('alumni')->cascadeOnDelete();
                $table->string('jenis', 60);
                $table->string('nama_file', 150);
                $table->string('ukuran', 20)->nullable();
                $table->string('status', 15)->default('valid');
                $table->string('path')->nullable();
                $table->string('diunggah_oleh', 100)->nullable();
                $table->date('tanggal_unggah')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('alumni_dokumen');
        Schema::dropIfExists('alumni');
    }
};