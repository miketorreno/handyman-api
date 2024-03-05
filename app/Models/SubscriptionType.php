<?php

namespace App\Models;

use App\Models\Handyman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubscriptionType extends Model
{
    use HasFactory;

    const FREE = 1;
    const FEATURED = 2;
    const PREMIUM = 3;

    protected $fillable = [
        'name',
        'benefits',
        'price',
        'duration',
    ];

    protected $casts = [
        'price' => 'integer',
    ];

    public function handymen(): HasMany
    {
        return $this->hasMany(Handyman::class);
    }
}
