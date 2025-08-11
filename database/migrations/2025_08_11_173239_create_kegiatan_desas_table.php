<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kegiatan_desas', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kegiatan')->nullable();
            $table->string('jenis_kegiatan')->nullable();
            $table->text('deskripsi_kegiatan')->nullable();
            $table->string('tanggal_kegiatan')->nullable();
            $table->string('lokasi_kegiatan')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_desas');
    }
};
