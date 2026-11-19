<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExistingCooperativeImage extends Model
{
    protected $guarded = [];

    public function existingCooperative(): BelongsTo
    {
        return $this->belongsTo(ExistingCooperative::class);
    }
}
