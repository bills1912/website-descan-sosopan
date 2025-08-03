<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProdukHukum extends Model
{
    //
    public function daftarProdukHukums()
    {
        return $this->hasMany(DaftarProdukHukum::class);
    }

    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
