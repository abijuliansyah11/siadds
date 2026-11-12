<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Pencatatan label QR arsip fisik.
 * Satu baris = satu arsip fisik yang sudah dibuatkan label.
 *
 * status : dibuat  = QR sudah dibuat, belum masuk antrean
 *          siap    = masuk antrean cetak
 *          selesai = sudah dikirim ke dialog cetak
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('arsip_label', function (Blueprint $table) {
            $table->id();
            $table->foreignId('arsip_fisik_id')->unique()->constrained('arsip_fisik')->cascadeOnDelete();
            $table->string('status', 20)->default('dibuat')->index();
            $table->string('template', 20)->default('standar');
            $table->string('ukuran', 20)->default('50x30');
            $table->unsignedInteger('qty')->default(0);          // total stiker yang pernah dicetak
            $table->string('dibuat_oleh', 100)->nullable();
            $table->string('dicetak_oleh', 100)->nullable();
            $table->timestamp('dicetak_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('arsip_label');
    }
};