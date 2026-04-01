<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormEleven extends Model
{
     protected $guarded = [];

    public function cooperation()
    {
        return $this->belongsTo(Cooperation::class, 'cooperation_id');
    }
}
