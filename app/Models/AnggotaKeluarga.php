<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KepalaKeluarga;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnggotaKeluarga extends Model
{
    //
    public function familyLeader(): BelongsTo
    {
        return $this->belongsTo(KepalaKeluarga::class);
    }

    // add fillable
    protected $fillable = [];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
