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
        Schema::create('tahun_anggaran_a_p_b_des', function (Blueprint $table) {
            $table->id();
            $table->string('tahun', 4)->unique()->comment('Tahun Anggaran APBDes')->nullable();
            $table->string('nama_petugas_keuangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_anggaran_a_p_b_des');
    }
};
