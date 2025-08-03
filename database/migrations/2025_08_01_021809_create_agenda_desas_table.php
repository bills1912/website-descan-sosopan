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
        Schema::create('agenda_desas', function (Blueprint $table) {
            $table->id();
            $table->string('judul_kegiatan')->nullable();
            $table->date('tanggal_kegiatan')->nullable();
            $table->string('waktu_mulai_kegiatan')->nullable();
            $table->string('waktu_selesai_kegiatan')->nullable();
            $table->string('tempat_kegiatan')->nullable();
            $table->string('penyelenggara')->nullable();
            $table->string('peserta')->nullable();
            $table->string('tipe kegiatan')->nullable(); // Assuming 'tipe_kegiatan' is a string type
            $table->text('deskripsi_kegiatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agenda_desas');
    }
};
