<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Commodity extends Model
{
    protected $fillable = [
        'name',
        'description',
        'is_active',
        'image',
    ];

    protected static function booted()
    {
        // Otomatis isi slug saat data baru dibuat
        static::creating(function ($plant) {
            $plant->slug = Str::slug($plant->name);
        });

        // Otomatis update slug jika nama tanaman diubah
        static::updating(function ($plant) {
            $plant->slug = Str::slug($plant->name);
        });
    }
}
