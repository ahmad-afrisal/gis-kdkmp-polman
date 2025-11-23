<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cooperation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function bussinessAssistant()
    {
        return $this->belongsTo(BussinessAssistant::class, 'bussiness_assistant_id');
    }

    public function formTwo()
    {
        return $this->hasOne(FormTwo::class, 'cooperation_id');
    }

    public function formThree()
    {
        return $this->hasOne(FormThree::class, 'cooperation_id');
    }

    public function formFour()
    {
        return $this->hasOne(FormFour::class, 'cooperation_id');
    }

    public function formFives()
    {
        return $this->hasMany(FormFive::class);
    }
}
