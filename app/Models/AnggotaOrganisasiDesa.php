<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaOrganisasiDesa extends Model
{
    //
    public function pimpinanOrganisasiDesa()
    {
        return $this->belongsTo(PimpinanOrganisasiDesa::class);
    }

    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = [
        'pimpinan_organisasi_desa_id' => 'integer',
        'periode_awal' => 'string',
        'periode_akhir' => 'string',
    ];

    /**
     * Accessor untuk mendapatkan periode lengkap
     */
    public function getPeriodeLengkapAttribute()
    {
        if ($this->periode_awal && $this->periode_akhir) {
            return $this->periode_awal . ' - ' . $this->periode_akhir;
        }
        return $this->periode_awal ?? 'Tidak diketahui';
    }

    /**
     * Accessor untuk foto dengan fallback
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            // Jika foto sudah berisi path lengkap
            if (str_starts_with($this->foto, 'http')) {
                return $this->foto;
            }
            // Jika foto hanya nama file
            return asset('storage/organisasi/anggota/' . $this->foto);
        }
        return asset('assets/images/default-avatar.png');
    }

    /**
     * Scope untuk filter berdasarkan posisi
     */
    public function scopeByPosisi($query, $posisi)
    {
        return $query->where('posisi', 'LIKE', '%' . $posisi . '%');
    }

    /**
     * Scope untuk filter berdasarkan pimpinan
     */
    public function scopeByPimpinan($query, $pimpinanId)
    {
        return $query->where('pimpinan_organisasi_desa_id', $pimpinanId);
    }

    /**
     * Scope untuk filter Wakil
     */
    public function scopeWakil($query)
    {
        return $query->where('posisi', 'LIKE', '%wakil%');
    }

    /**
     * Scope untuk filter Sekretaris
     */
    public function scopeSekretaris($query)
    {
        return $query->where('posisi', 'LIKE', '%sekretaris%');
    }

    /**
     * Scope untuk filter Bendahara
     */
    public function scopeBendahara($query)
    {
        return $query->where('posisi', 'LIKE', '%bendahara%');
    }

    /**
     * Scope untuk filter Koordinator/Kepala Urusan
     */
    public function scopeKoordinator($query)
    {
        return $query->where(function ($q) {
            $q->where('posisi', 'LIKE', '%koordinator%')
                ->orWhere('posisi', 'LIKE', '%kepala urusan%')
                ->orWhere('posisi', 'LIKE', '%manajer%')
                ->orWhere('posisi', 'LIKE', '%kepala bagian%')
                ->orWhere('posisi', 'LIKE', '%kepala bidang%');
        });
    }

    /**
     * Scope untuk filter Anggota biasa
     */
    public function scopeAnggotaBiasa($query)
    {
        return $query->where('posisi', 'LIKE', '%anggota%');
    }

    /**
     * Boot method untuk event handling
     */
    protected static function boot()
    {
        parent::boot();

        // Event saat model dibuat atau diupdate
        static::saving(function ($model) {
            // Validasi foreign key
            if ($model->pimpinan_organisasi_desa_id) {
                $pimpinanExists = PimpinanOrganisasiDesa::find($model->pimpinan_organisasi_desa_id);
                if (!$pimpinanExists) {
                    throw new \Exception('Pimpinan organisasi dengan ID ' . $model->pimpinan_organisasi_desa_id . ' tidak ditemukan.');
                }
            }
        });
    }
}
