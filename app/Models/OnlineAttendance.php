<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnlineAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];


    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
    ];

    /**
     * Mendapatkan data Business Assistant yang memiliki absensi ini.
     */
    public function bussinessAssistant(): BelongsTo
    {
        return $this->belongsTo(BussinessAssistant::class, 'bussiness_assistant_id');
    }

}
