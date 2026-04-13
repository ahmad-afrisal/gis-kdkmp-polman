<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BussinessAssistant extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

   

    public function cooperations()
    {
        return $this->hasMany(Cooperation::class, 'bussiness_assistant_id');
    }

    /**
     * Mendapatkan semua data absensi untuk Business Assistant ini.
     */
    public function onlineAttendances(): HasMany
    {
        return $this->hasMany(OnlineAttendance::class, 'bussiness_assistant_id');
    }
}
