<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSix extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cooperation()
    {
        return $this->belongsTo(Cooperation::class, 'cooperation_id');
    }
}
