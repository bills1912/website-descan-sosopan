<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataAnggaranAPBDes extends Model
{
    //
    public function tahunAnggaranAPBDes(): BelongsTo
    {
        return $this->belongsTo(TahunAnggaranAPBDes::class);
    }

    public function tahunAnggaran(): BelongsTo
    {
        return $this->tahunAnggaranAPBDes();
    }

    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        // Pendapatan Asli Desa
        'hasil_usaha_rencana' => 'decimal:2',
        'hasil_usaha_realisasi' => 'decimal:2',
        'hasil_usaha_sisa' => 'decimal:2',
        'hasil_aset_rencana' => 'decimal:2',
        'hasil_aset_realisasi' => 'decimal:2',
        'hasil_aset_sisa' => 'decimal:2',
        'swadaya_rencana' => 'decimal:2',
        'swadaya_realisasi' => 'decimal:2',
        'swadaya_sisa' => 'decimal:2',
        // Pendapatan Transfer
        'dana_desa_rencana' => 'decimal:2',
        'dana_desa_realisasi' => 'decimal:2',
        'dana_desa_sisa' => 'decimal:2',
        'bagi_hasil_pajak_rencana' => 'decimal:2',
        'bagi_hasil_pajak_realisasi' => 'decimal:2',
        'bagi_hasil_pajak_sisa' => 'decimal:2',
        'alokasi_dana_desa_rencana' => 'decimal:2',
        'alokasi_dana_desa_realisasi' => 'decimal:2',
        'alokasi_dana_desa_sisa' => 'decimal:2',
        'bantuan_keuangan_kab_rencana' => 'decimal:2',
        'bantuan_keuangan_kab_realisasi' => 'decimal:2',
        'bantuan_keuangan_kab_sisa' => 'decimal:2',
        'bantuan_keuangan_prov_rencana' => 'decimal:2',
        'bantuan_keuangan_prov_realisasi' => 'decimal:2',
        'bantuan_keuangan_prov_sisa' => 'decimal:2',
        // Pendapatan Lain-lain
        'hibah_rencana' => 'decimal:2',
        'hibah_realisasi' => 'decimal:2',
        'hibah_sisa' => 'decimal:2',
        'sumbangan_pihak_ketiga_rencana' => 'decimal:2',
        'sumbangan_pihak_ketiga_realisasi' => 'decimal:2',
        'sumbangan_pihak_ketiga_sisa' => 'decimal:2',
        'pendapatan_lain_rencana' => 'decimal:2',
        'pendapatan_lain_realisasi' => 'decimal:2',
        'pendapatan_lain_sisa' => 'decimal:2',
        // Belanja Desa
        'penyelenggaraan_pemerintahan_desa_rencana' => 'decimal:2',
        'penyelenggaraan_pemerintahan_desa_realisasi' => 'decimal:2',
        'penyelenggaraan_pemerintahan_desa_sisa' => 'decimal:2',
        'pelaksanaan_pembangunan_desa_rencana' => 'decimal:2',
        'pelaksanaan_pembangunan_desa_realisasi' => 'decimal:2',
        'pelaksanaan_pembangunan_desa_sisa' => 'decimal:2',
        'pembinaan_kemasyarakatan_desa_rencana' => 'decimal:2',
        'pembinaan_kemasyarakatan_desa_realisasi' => 'decimal:2',
        'pembinaan_kemasyarakatan_desa_sisa' => 'decimal:2',
        'pemberdayaan_masyarakat_desa_rencana' => 'decimal:2',
        'pemberdayaan_masyarakat_desa_realisasi' => 'decimal:2',
        'pemberdayaan_masyarakat_desa_sisa' => 'decimal:2',
        'belanja_tak_terduga_rencana' => 'decimal:2',
        'belanja_tak_terduga_realisasi' => 'decimal:2',
        'belanja_tak_terduga_sisa' => 'decimal:2',
        // Pembiayaan
        'silpa_rencana' => 'decimal:2',
        'silpa_realisasi' => 'decimal:2',
        'silpa_sisa' => 'decimal:2',
        'pencairan_dana_cadangan_rencana' => 'decimal:2',
        'pencairan_dana_cadangan_realisasi' => 'decimal:2',
        'pencairan_dana_cadangan_sisa' => 'decimal:2',
        'hasil_penjualan_kekayaan_rencana' => 'decimal:2',
        'hasil_penjualan_kekayaan_realisasi' => 'decimal:2',
        'hasil_penjualan_kekayaan_sisa' => 'decimal:2',
        'pembentukan_dana_cadangan_rencana' => 'decimal:2',
        'pembentukan_dana_cadangan_realisasi' => 'decimal:2',
        'pembentukan_dana_cadangan_sisa' => 'decimal:2',
        'penyertaan_modal_desa_rencana' => 'decimal:2',
        'penyertaan_modal_desa_realisasi' => 'decimal:2',
        'penyertaan_modal_desa_sisa' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get total pendapatan asli desa realisasi
     */
    public function getTotalPendapatanAsliDesaRealisasiAttribute()
    {
        return ($this->hasil_usaha_realisasi ?? 0) + 
               ($this->hasil_aset_realisasi ?? 0) + 
               ($this->swadaya_realisasi ?? 0);
    }

    /**
     * Get total pendapatan transfer rencana
     */
    public function getTotalPendapatanTransferRencanaAttribute()
    {
        return ($this->dana_desa_rencana ?? 0) + 
               ($this->bagi_hasil_pajak_rencana ?? 0) + 
               ($this->alokasi_dana_desa_rencana ?? 0) +
               ($this->bantuan_keuangan_kab_rencana ?? 0) + 
               ($this->bantuan_keuangan_prov_rencana ?? 0);
    }

    /**
     * Get total pendapatan transfer realisasi
     */
    public function getTotalPendapatanTransferRealisasiAttribute()
    {
        return ($this->dana_desa_realisasi ?? 0) + 
               ($this->bagi_hasil_pajak_realisasi ?? 0) + 
               ($this->alokasi_dana_desa_realisasi ?? 0) +
               ($this->bantuan_keuangan_kab_realisasi ?? 0) + 
               ($this->bantuan_keuangan_prov_realisasi ?? 0);
    }

    /**
     * Get total pendapatan lain-lain rencana
     */
    public function getTotalPendapatanLainRencanaAttribute()
    {
        return ($this->hibah_rencana ?? 0) + 
               ($this->sumbangan_pihak_ketiga_rencana ?? 0) + 
               ($this->pendapatan_lain_rencana ?? 0);
    }

    /**
     * Get total pendapatan lain-lain realisasi
     */
    public function getTotalPendapatanLainRealisasiAttribute()
    {
        return ($this->hibah_realisasi ?? 0) + 
               ($this->sumbangan_pihak_ketiga_realisasi ?? 0) + 
               ($this->pendapatan_lain_realisasi ?? 0);
    }

    /**
     * Get total pendapatan rencana
     */
    public function getTotalPendapatanRencanaAttribute()
    {
        return $this->total_pendapatan_asli_desa_rencana + 
               $this->total_pendapatan_transfer_rencana + 
               $this->total_pendapatan_lain_rencana;
    }

    /**
     * Get total pendapatan realisasi
     */
    public function getTotalPendapatanRealisasiAttribute()
    {
        return $this->total_pendapatan_asli_desa_realisasi + 
               $this->total_pendapatan_transfer_realisasi + 
               $this->total_pendapatan_lain_realisasi;
    }

    /**
     * Get total belanja rencana
     */
    public function getTotalBelanjaRencanaAttribute()
    {
        return ($this->penyelenggaraan_pemerintahan_desa_rencana ?? 0) + 
               ($this->pelaksanaan_pembangunan_desa_rencana ?? 0) +
               ($this->pembinaan_kemasyarakatan_desa_rencana ?? 0) + 
               ($this->pemberdayaan_masyarakat_desa_rencana ?? 0) +
               ($this->belanja_tak_terduga_rencana ?? 0);
    }

    /**
     * Get total belanja realisasi
     */
    public function getTotalBelanjaRealisasiAttribute()
    {
        return ($this->penyelenggaraan_pemerintahan_desa_realisasi ?? 0) + 
               ($this->pelaksanaan_pembangunan_desa_realisasi ?? 0) +
               ($this->pembinaan_kemasyarakatan_desa_realisasi ?? 0) + 
               ($this->pemberdayaan_masyarakat_desa_realisasi ?? 0) +
               ($this->belanja_tak_terduga_realisasi ?? 0);
    }

    /**
     * Get total penerimaan pembiayaan rencana
     */
    public function getTotalPenerimaanPembiayaanRencanaAttribute()
    {
        return ($this->silpa_rencana ?? 0) + 
               ($this->pencairan_dana_cadangan_rencana ?? 0) + 
               ($this->hasil_penjualan_kekayaan_rencana ?? 0);
    }

    /**
     * Get total penerimaan pembiayaan realisasi
     */
    public function getTotalPenerimaanPembiayaanRealisasiAttribute()
    {
        return ($this->silpa_realisasi ?? 0) + 
               ($this->pencairan_dana_cadangan_realisasi ?? 0) + 
               ($this->hasil_penjualan_kekayaan_realisasi ?? 0);
    }

    /**
     * Get total pengeluaran pembiayaan rencana
     */
    public function getTotalPengeluaranPembiayaanRencanaAttribute()
    {
        return ($this->pembentukan_dana_cadangan_rencana ?? 0) + 
               ($this->penyertaan_modal_desa_rencana ?? 0);
    }

    /**
     * Get total pengeluaran pembiayaan realisasi
     */
    public function getTotalPengeluaranPembiayaanRealisasiAttribute()
    {
        return ($this->pembentukan_dana_cadangan_realisasi ?? 0) + 
               ($this->penyertaan_modal_desa_realisasi ?? 0);
    }

    /**
     * Get total pembiayaan rencana (penerimaan - pengeluaran)
     */
    public function getTotalPembiayaanRencanaAttribute()
    {
        return $this->total_penerimaan_pembiayaan_rencana - $this->total_pengeluaran_pembiayaan_rencana;
    }

    /**
     * Get total pembiayaan realisasi (penerimaan - pengeluaran)
     */
    public function getTotalPembiayaanRealisasiAttribute()
    {
        return $this->total_penerimaan_pembiayaan_realisasi - $this->total_pengeluaran_pembiayaan_realisasi;
    }

    /**
     * Get saldo anggaran rencana (Pendapatan - Belanja + Pembiayaan)
     */
    public function getSaldoAnggaranRencanaAttribute()
    {
        return $this->total_pendapatan_rencana - $this->total_belanja_rencana + $this->total_pembiayaan_rencana;
    }

    /**
     * Get saldo anggaran realisasi (Pendapatan - Belanja + Pembiayaan)
     */
    public function getSaldoAnggaranRealisasiAttribute()
    {
        return $this->total_pendapatan_realisasi - $this->total_belanja_realisasi + $this->total_pembiayaan_realisasi;
    }

    /**
     * Scope untuk mencari berdasarkan tahun anggaran
     */
    public function scopeByYear($query, $year)
    {
        return $query->whereHas('tahunAnggaranAPBDes', function ($q) use ($year) {
            $q->where('tahun', $year);
        });
    }

    /**
     * Scope untuk data dengan relasi tahun anggaran
     */
    public function scopeWithTahunAnggaran($query)
    {
        return $query->with('tahunAnggaranAPBDes');
    }
}
