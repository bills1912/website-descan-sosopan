<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class KegiatanDesa extends Model
{
    //

    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    protected $casts = [
        'tanggal_kegiatan' => 'date'
    ];

    // Accessor untuk format tanggal
    public function getTanggalKegiatanFormattedAttribute()
    {
        return Carbon::parse($this->tanggal_kegiatan)->format('d M Y');
    }

    // Scope untuk filter berdasarkan jenis
    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis_kegiatan', $jenis);
    }

    // Scope untuk filter berdasarkan tanggal
    public function scopeByDateRange($query, $from, $to)
    {
        return $query->whereBetween('tanggal_kegiatan', [$from, $to]);
    }
}
