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
        Schema::create('anggota_organisasi_desas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pimpinan_organisasi_desa_id')
                ->constrained('pimpinan_organisasi_desas')
                ->onDelete('no action');
            $table->string('nama')->nullable();
            $table->string('posisi')->nullable();
            $table->string('periode_awal')->nullable();
            $table->string('periode_akhir')->nullable();
            $table->string('pengalaman')->nullable();
            $table->string('fokus')->nullable();
            $table->string('nomor_telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota_organisasi_desas');
    }
};
