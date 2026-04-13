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

    public function village()
    {
        return $this->belongsTo(Village::class, 'village_id');
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

    public function formSix()
    {
        return $this->hasOne(FormSix::class, 'cooperation_id');
    }

    public function formSeven()
    {
        return $this->hasOne(FormSeven::class, 'cooperation_id');
    }

    public function formEight()
    {
        return $this->hasOne(FormEight::class, 'cooperation_id');
    }

    public function formNine()
    {
        return $this->hasOne(FormNine::class, 'cooperation_id');
    }

    public function formTen()
    {
        return $this->hasOne(FormTen::class, 'cooperation_id');
    }

    
    public function formElevens()
    {
        return $this->hasMany(FormFive::class);
    }
    

    public function simkopdesCompletenes()
    {
        return $this->hasOne(SimkopdesCompletenes::class, 'cooperation_id');
    }


    public function records()
    {
        return $this->hasMany(RecordFormSeven::class);
    }
}
