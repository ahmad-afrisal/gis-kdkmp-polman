<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExistingCooperative extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ExistingCooperativeImage::class);
    }
}
