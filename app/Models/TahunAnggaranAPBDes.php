<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\DataAnggaranAPBDes;

class TahunAnggaranAPBDes extends Model
{
    //
    public function dataAnggaranAPBDes(): HasMany
    {
        return $this->hasMany(DataAnggaranAPBDes::class, 'tahun_anggaran_id', 'id');
    }

    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get data anggaran untuk tahun ini (single record)
     */
    public function getDataAnggaranAttribute()
    {
        return $this->dataAnggaranAPBDes()->first();
    }

    /**
     * Get tahun dalam format yang lebih readable
     */
    public function getTahunFormatAttribute()
    {
        return 'Tahun ' . $this->tahun;
    }

    /**
     * Check if this year has anggaran data
     */
    public function hasAnggaranData()
    {
        return $this->dataAnggaranAPBDes()->exists();
    }

    /**
     * Get total pendapatan untuk tahun ini
     */
    public function getTotalPendapatanRencanaAttribute()
    {
        $dataAnggaran = $this->dataAnggaran;
        return $dataAnggaran ? $dataAnggaran->total_pendapatan_rencana : 0;
    }

    /**
     * Get total pendapatan realisasi untuk tahun ini
     */
    public function getTotalPendapatanRealisasiAttribute()
    {
        $dataAnggaran = $this->dataAnggaran;
        return $dataAnggaran ? $dataAnggaran->total_pendapatan_realisasi : 0;
    }

    /**
     * Get total belanja untuk tahun ini
     */
    public function getTotalBelanjaRencanaAttribute()
    {
        $dataAnggaran = $this->dataAnggaran;
        return $dataAnggaran ? $dataAnggaran->total_belanja_rencana : 0;
    }

    /**
     * Get total belanja realisasi untuk tahun ini
     */
    public function getTotalBelanjaRealisasiAttribute()
    {
        $dataAnggaran = $this->dataAnggaran;
        return $dataAnggaran ? $dataAnggaran->total_belanja_realisasi : 0;
    }

    /**
     * Get saldo anggaran untuk tahun ini
     */
    public function getSaldoAnggaranRencanaAttribute()
    {
        $dataAnggaran = $this->dataAnggaran;
        return $dataAnggaran ? $dataAnggaran->saldo_anggaran_rencana : 0;
    }

    /**
     * Get saldo anggaran realisasi untuk tahun ini
     */
    public function getSaldoAnggaranRealisasiAttribute()
    {
        $dataAnggaran = $this->dataAnggaran;
        return $dataAnggaran ? $dataAnggaran->saldo_anggaran_realisasi : 0;
    }

    /**
     * Scope untuk mengurutkan berdasarkan tahun terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('tahun', 'desc');
    }

    /**
     * Scope untuk mengurutkan berdasarkan tahun terlama
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('tahun', 'asc');
    }

    /**
     * Scope untuk mencari berdasarkan tahun
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('tahun', $year);
    }

    /**
     * Scope untuk tahun yang memiliki data anggaran
     */
    public function scopeWithAnggaranData($query)
    {
        return $query->whereHas('dataAnggaranAPBDes');
    }

    /**
     * Scope untuk tahun yang tidak memiliki data anggaran
     */
    public function scopeWithoutAnggaranData($query)
    {
        return $query->whereDoesntHave('dataAnggaranAPBDes');
    }

    /**
     * Scope untuk eager load data anggaran
     */
    public function scopeWithDataAnggaran($query)
    {
        return $query->with('dataAnggaranAPBDes');
    }

    /**
     * Get years range for dropdown/selection
     */
    public static function getAvailableYears()
    {
        return self::orderBy('tahun', 'desc')->pluck('tahun')->toArray();
    }

    /**
     * Get current year or latest available year
     */
    public static function getCurrentYear()
    {
        $currentYear = date('Y');
        $availableYear = self::where('tahun', $currentYear)->first();

        if ($availableYear) {
            return $availableYear;
        }

        return self::latest()->first();
    }

    /**
     * Create new tahun anggaran with validation
     */
    public static function createTahunAnggaran($tahun, $namaPetugasKeuangan = null)
    {
        // Check if year already exists
        if (self::where('tahun', $tahun)->exists()) {
            throw new \Exception("Tahun anggaran {$tahun} sudah ada");
        }

        // Validate year format
        if (!preg_match('/^\d{4}$/', $tahun)) {
            throw new \Exception("Format tahun tidak valid");
        }

        return self::create([
            'tahun' => $tahun,
            'nama_petugas_keuangan' => $namaPetugasKeuangan
        ]);
    }
}
