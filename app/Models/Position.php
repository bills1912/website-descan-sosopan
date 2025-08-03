<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    //
    public function positionPimpinan()
    {
        return $this->belongsTo(PimpinanOrganisasiDesa::class, 'posisi', 'posisi');
    }

    public function positionAnggota()
    {
        return $this->belongsTo(AnggotaOrganisasiDesa::class, 'posisi', 'posisi');
    }

    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
