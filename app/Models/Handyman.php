<?php

namespace App\Models;

use App\Models\User;
use App\Models\Quote;
use App\Models\Review;
use App\Models\Service;
use App\Models\Category;
use App\Models\SubscriptionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Handyman extends User
{
    use HasFactory, SoftDeletes;

    const INDIVIDUAL = 1;
    const GROUP = 2;

    const PENDING = 1;
    const APPROVED = 2;
    const REJECTED = 3;

    protected $fillable = [
        'user_id',
        'image_id',
        'subscription_type_id',
        'about',
        'tools',
        'membership_level',
        'reputation_score',
        'avg_rating',
        'experience',
        'hire_count',
        'group_type',
        'group_members',
        'certifications',
        'languages',
        'contact',
        'approval_status',
        'banned_at',
    ];

    protected $casts = [
        'avg_rating' => 'decimal:1',
        'hidden' => 'boolean',
        'reputation_score' => 'integer',
        'hire_count' => 'integer',
        'group_type' => 'integer',
        'approval_status' => 'integer',
        // 'tools' => 'array',
        // 'group_members' => 'array',
        // 'certifications' => 'array',
        // 'languages' => 'array',
        // 'contact' => 'array',
        'banned_at' => 'datetime',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function quotes(): HasMany
    {
        return $this->hasMany(Quote::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function subscriptionType(): BelongsTo
    {
        return $this->belongsTo(SubscriptionType::class);
    }

    // public function reports(): MorphMany
    // {
    //     return $this->morphMany(Reports::class, 'reportable');
    // }
}
