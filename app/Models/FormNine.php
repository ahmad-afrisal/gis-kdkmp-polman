<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormNine extends Model
{
     protected $guarded = [];

    public function cooperation()
    {
        return $this->belongsTo(Cooperation::class, 'cooperation_id');
    }

    protected $casts = [
        'outlet_operations_guide' => 'integer',
    ];
}
