<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa_dokumen', function (Blueprint $table) {
            $table->string('nama_dokumen')->nullable();
            $table->string('nomor_dokumen', 60)->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->text('deskripsi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('siswa_dokumen', function (Blueprint $table) {
            $table->dropColumn(['nama_dokumen', 'nomor_dokumen', 'tanggal_terbit', 'deskripsi']);
        });
    }
};