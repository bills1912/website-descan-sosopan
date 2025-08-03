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
        Schema::create('data_anggaran_a_p_b_des', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_anggaran_id')->constrained('tahun_anggaran_a_p_b_des')->onDelete('no action');
            $table->double('hasil_usaha_rencana')->nullable();
            $table->double('hasil_usaha_realisasi')->nullable();
            $table->double('hasil_usaha_sisa')->nullable();
            $table->double('hasil_aset_rencana')->nullable();
            $table->double('hasil_aset_realisasi')->nullable();
            $table->double('hasil_aset_sisa')->nullable();
            $table->double('swadaya_rencana')->nullable();
            $table->double('swadaya_realisasi')->nullable();
            $table->double('swadaya_sisa')->nullable();
            $table->double('dana_desa_rencana')->nullable();
            $table->double('dana_desa_realisasi')->nullable();
            $table->double('dana_desa_sisa')->nullable();
            $table->double('bagi_hasil_pajak_rencana')->nullable();
            $table->double('bagi_hasil_pajak_realisasi')->nullable();
            $table->double('bagi_hasil_pajak_sisa')->nullable();
            $table->double('alokasi_dana_desa_rencana')->nullable();
            $table->double('alokasi_dana_desa_realisasi')->nullable();
            $table->double('alokasi_dana_desa_sisa')->nullable();
            $table->double('bantuan_keuangan_kab_rencana')->nullable();
            $table->double('bantuan_keuangan_kab_realisasi')->nullable();
            $table->double('bantuan_keuangan_kab_sisa')->nullable();
            $table->double('bantuan_keuangan_prov_rencana')->nullable();
            $table->double('bantuan_keuangan_prov_realisasi')->nullable();
            $table->double('bantuan_keuangan_prov_sisa')->nullable();
            $table->double('hibah_rencana')->nullable();
            $table->double('hibah_realisasi')->nullable();
            $table->double('hibah_sisa')->nullable();
            $table->double('sumbangan_pihak_ketiga_rencana')->nullable();
            $table->double('sumbangan_pihak_ketiga_realisasi')->nullable();
            $table->double('sumbangan_pihak_ketiga_sisa')->nullable();
            $table->double('pendapatan_lain_rencana')->nullable();
            $table->double('pendapatan_lain_realisasi')->nullable();
            $table->double('pendapatan_lain_sisa')->nullable();
            $table->double('penyelenggaraan_pemerintahan_desa_rencana')->nullable();
            $table->double('penyelenggaraan_pemerintahan_desa_realisasi')->nullable();
            $table->double('penyelenggaraan_pemerintahan_desa_sisa')->nullable();
            $table->double('pelaksanaan_pembangunan_desa_rencana')->nullable();
            $table->double('pelaksanaan_pembangunan_desa_realisasi')->nullable();
            $table->double('pelaksanaan_pembangunan_desa_sisa')->nullable();
            $table->double('pembinaan_kemasyarakatan_desa_rencana')->nullable();
            $table->double('pembinaan_kemasyarakatan_desa_realisasi')->nullable();
            $table->double('pembinaan_kemasyarakatan_desa_sisa')->nullable();
            $table->double('pemberdayaan_masyarakat_desa_rencana')->nullable();
            $table->double('pemberdayaan_masyarakat_desa_realisasi')->nullable();
            $table->double('pemberdayaan_masyarakat_desa_sisa')->nullable();
            $table->double('belanja_tak_terduga_rencana')->nullable();
            $table->double('belanja_tak_terduga_realisasi')->nullable();
            $table->double('belanja_tak_terduga_sisa')->nullable();
            $table->double('silpa_rencana')->nullable();
            $table->double('silpa_realisasi')->nullable();
            $table->double('silpa_sisa')->nullable();
            $table->double('pencairan_dana_cadangan_rencana')->nullable();
            $table->double('pencairan_dana_cadangan_realisasi')->nullable();
            $table->double('pencairan_dana_cadangan_sisa')->nullable();
            $table->double('hasil_penjualan_kekayaan_rencana')->nullable();
            $table->double('hasil_penjualan_kekayaan_realisasi')->nullable();
            $table->double('hasil_penjualan_kekayaan_sisa')->nullable();
            $table->double('pembentukan_dana_cadangan_rencana')->nullable();
            $table->double('pembentukan_dana_cadangan_realisasi')->nullable();
            $table->double('pembentukan_dana_cadangan_sisa')->nullable();
            $table->double('penyertaan_modal_desa_rencana')->nullable();
            $table->double('penyertaan_modal_desa_realisasi')->nullable();
            $table->double('penyertaan_modal_desa_sisa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_anggaran_a_p_b_des');
    }
};
