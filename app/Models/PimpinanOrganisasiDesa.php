<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PimpinanOrganisasiDesa extends Model
{
    //
    public function anggotaOrganisasiDesa()
    {
        return $this->hasMany(AnggotaOrganisasiDesa::class);
    }
    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
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
            return asset('storage/organisasi/pimpinan/' . $this->foto);
        }
        return asset('assets/images/default-avatar.png');
    }

    /**
     * Scope untuk filter berdasarkan organisasi
     */
    public function scopeByOrganisasi($query, $organisasi)
    {
        return $query->where('organisasi', $organisasi);
    }

    /**
     * Scope untuk filter berdasarkan posisi
     */
    public function scopeByPosisi($query, $posisi)
    {
        return $query->where('posisi', $posisi);
    }

    /**
     * Boot method untuk event handling
     */
    protected static function boot()
    {
        parent::boot();

        // Event saat model dibuat atau diupdate
        static::saving(function ($model) {
            // Normalisasi nama organisasi
            if ($model->organisasi) {
                $model->organisasi = trim($model->organisasi);
            }
        });
    }
}
