<?php

namespace App\Models;

use App\Models\User;
use App\Models\Handyman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'handyman_id',
        'rating',
        'review',
        'image_id',
        'edited',
        'requested',
    ];

    protected $casts = [
        'rating' => 'integer',
        'edited' => 'boolean',
        'requested' => 'boolean',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function handyman(): BelongsTo
    {
        return $this->belongsTo(Handyman::class);
    }
}
