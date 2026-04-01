<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormEight extends Model
{
        use HasFactory;

    protected $guarded = [];

    public function cooperation()
    {
        return $this->belongsTo(Cooperation::class, 'cooperation_id');
    }

    protected $casts = [
        'store_development' => 'integer',
    ];
}
