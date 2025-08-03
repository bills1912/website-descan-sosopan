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
        Schema::create('daftar_produk_hukums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_produk_hukum_id')->constrained('kategori_produk_hukums')->onDelete('no action');
            $table->string('id_dok')->unique()->nullable();
            $table->string('judul')->nullable();
            $table->string('tahun')->nullable();
            $table->string('ukuran')->nullable();
            $table->string('tipe')->nullable(); // Menambahkan kolom tipe untuk menyimpan jenis produk hukum
            $table->text('deskripsi')->nullable(); // Menyimpan deskripsi produk hukum
            $table->string('dokumen')->nullable(); // Menyimpan path atau URL dokumen produk hukum
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_produk_hukums');
    }
};
