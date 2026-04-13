<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    // Hubungkan District ke Cooperation melalui Village
    public function cooperations(): HasManyThrough
    {
        return $this->hasManyThrough(
            Cooperation::class, 
            Village::class,
            'district_id', // Foreign key di tabel villages
            'village_id',  // Foreign key di tabel cooperations
            'id',          // Local key di tabel districts
            'id'           // Local key di tabel villages
        );
    }
}
