<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class FormSeven extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cooperation()
    {
        return $this->belongsTo(Cooperation::class, 'cooperation_id');
    }

    public function records()
    {
        return $this->hasMany(RecordFormSeven::class, 'cooperation_id', 'cooperation_id');
    }
}
