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
        Schema::create('report_publication_data', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();
            $table->string('waktu_terbit')->nullable();
            $table->string('deskripsi')->nullable();
            $table->enum('kategori', [
                'annual_report',
                'financial_report',
                'demographic_data',
                'health_data',
                'education_data',
                'economic_data',
                'village_profile',
                'development_report',
                'other'
            ])->default('other');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_publication_data');
    }
};
