<?php

namespace App\Models;

use App\Models\Handyman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'benefits',
        'price',
        'duration',
    ];

    protected $casts = [
    ];

    public function handymen(): HasMany
    {
        return $this->hasMany(Handyman::class);
    }
}
