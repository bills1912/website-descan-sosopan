<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DaftarProdukHukum extends Model
{
    //
    public function kategoriProdukHukum()
    {
        return $this->belongsTo(KategoriProdukHukum::class);
    }

    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
