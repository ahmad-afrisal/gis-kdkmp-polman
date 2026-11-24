<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExistingCooperative extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function cooperativeStatus(): BelongsTo
    {
        return $this->belongsTo(CooperativeStatus::class, 'cooperative_status_id');
    }

    public function businessActivity(): BelongsTo
    {
        return $this->belongsTo(BusinessActivity::class, 'business_activity_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ExistingCooperativeImage::class);
    }
}
