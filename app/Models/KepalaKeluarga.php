<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\AnggotaKeluarga;

class KepalaKeluarga extends Model
{
    //
    public function familyMembers(): HasMany
    {
        return $this->hasMany(AnggotaKeluarga::class);
    }
    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];


}
