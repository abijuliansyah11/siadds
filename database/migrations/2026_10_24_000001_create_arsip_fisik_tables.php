<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Repositori arsip fisik.
 *
 * Hierarki lokasi : arsip_ruang  ->  arsip_lemari  ->  arsip_rak
 * Item arsip      : arsip_fisik  (satu baris = satu dokumen asli milik satu siswa)
 * Jejak aktivitas : arsip_fisik_log
 */
return new class extends Migration
{
    public function up(): void
    {
        /* 1. Ruang arsip ------------------------------------------------ */
        Schema::create('arsip_ruang', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('gedung', 30)->nullable();
            $table->string('lantai', 30)->nullable();
            $table->string('peruntukan', 200)->nullable();
            $table->timestamps();
        });

        /* 2. Lemari ----------------------------------------------------- */
        Schema::create('arsip_lemari', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_ruang_id')->constrained('arsip_ruang')->cascadeOnDelete();
            $table->string('kode', 20);
            $table->string('keterangan', 200)->nullable();
            $table->timestamps();

            $table->unique(['arsip_ruang_id', 'kode']);
        });

        /* 3. Rak -------------------------------------------------------- */
        Schema::create('arsip_rak', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_lemari_id')->constrained('arsip_lemari')->cascadeOnDelete();
            $table->string('kode', 20);
            $table->unsignedSmallInteger('kapasitas')->default(50);
            $table->timestamps();

            $table->unique(['arsip_lemari_id', 'kode']);
        });

        /* 4. Item arsip fisik ------------------------------------------- */
        Schema::create('arsip_fisik', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_aktif_id')->index();
            $table->string('jenis', 100);
            $table->string('kode_arsip', 30)->unique();
            $table->foreignId('arsip_rak_id')->nullable()->constrained('arsip_rak')->nullOnDelete();
            $table->string('kode_map', 30)->nullable();
            $table->string('kondisi', 20)->default('belum');      // baik | perhatian | rusak | belum
            $table->string('status', 20)->default('tersimpan');   // tersimpan | dipinjam | antrean
            $table->text('keterangan')->nullable();
            $table->string('peminjam', 100)->nullable();
            $table->string('keperluan', 200)->nullable();
            $table->date('tanggal_pinjam')->nullable();
            $table->date('jatuh_tempo')->nullable();
            $table->timestamps();

            $table->unique(['siswa_aktif_id', 'jenis']);
            $table->index('status');
            $table->index('kondisi');
        });

        /* 5. Jejak aktivitas -------------------------------------------- */
        Schema::create('arsip_fisik_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_fisik_id')->constrained('arsip_fisik')->cascadeOnDelete();
            $table->string('aksi', 30);          // catat | pindah | pinjam | kembali | kondisi
            $table->text('keterangan')->nullable();
            $table->string('petugas', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip_fisik_log');
        Schema::dropIfExists('arsip_fisik');
        Schema::dropIfExists('arsip_rak');
        Schema::dropIfExists('arsip_lemari');
        Schema::dropIfExists('arsip_ruang');
    }
};