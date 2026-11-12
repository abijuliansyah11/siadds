<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa_aktif', function (Blueprint $table) {
            if (! Schema::hasColumn('siswa_aktif', 'nik'))           $table->string('nik', 16)->nullable()->unique();
            if (! Schema::hasColumn('siswa_aktif', 'tempat_lahir'))  $table->string('tempat_lahir', 60)->nullable();
            if (! Schema::hasColumn('siswa_aktif', 'tanggal_lahir')) $table->date('tanggal_lahir')->nullable();
            if (! Schema::hasColumn('siswa_aktif', 'alamat'))        $table->text('alamat')->nullable();
            if (! Schema::hasColumn('siswa_aktif', 'asal_sekolah'))  $table->string('asal_sekolah', 150)->nullable();
            if (! Schema::hasColumn('siswa_aktif', 'nama_ayah'))     $table->string('nama_ayah', 100)->nullable();
            if (! Schema::hasColumn('siswa_aktif', 'nama_ibu'))      $table->string('nama_ibu', 100)->nullable();
            if (! Schema::hasColumn('siswa_aktif', 'no_hp_wali'))    $table->string('no_hp_wali', 20)->nullable();
            if (! Schema::hasColumn('siswa_aktif', 'ruang_arsip'))   $table->string('ruang_arsip', 100)->nullable();
            if (! Schema::hasColumn('siswa_aktif', 'lemari'))        $table->string('lemari', 40)->nullable();
            if (! Schema::hasColumn('siswa_aktif', 'rak'))           $table->string('rak', 20)->nullable();
            if (! Schema::hasColumn('siswa_aktif', 'kode_map'))      $table->string('kode_map', 40)->nullable();
        });

        Schema::table('siswa_dokumen', function (Blueprint $table) {
            if (! Schema::hasColumn('siswa_dokumen', 'path')) $table->string('path')->nullable();
        });
    }

    public function down(): void
    {
        // Sengaja dikosongkan agar data siswa tidak hilang saat rollback.
    }
};