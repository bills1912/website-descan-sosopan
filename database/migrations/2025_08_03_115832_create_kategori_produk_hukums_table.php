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
        Schema::create('kategori_produk_hukums', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_prduk_hukum')->nullable();
            $table->text('deskripsi')->nullable(); // Menambahkan kolom jenis_produk_hukum
            $table->string('slug')->unique()->nullable(); // Menambahkan kolom slug untuk kategori produk hukum
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_produk_hukums');
    }
};
