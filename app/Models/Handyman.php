<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Handyman extends User
{
    use HasFactory, SoftDeletes;

    const TYPE_INDIVIDUAL = 1;
    const TYPE_GROUP = 2;

    const APPROVAL_PENDING = 1;
    const APPROVAL_APPROVED = 2;
    const APPROVAL_REJECTED = 3;

    protected $fillable = [
        'user_id',
        'image_id',
        'service_id',
        'category_id',
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
        'approval_status',
        'banned_at',
    ];

    protected $casts = [
        'avg_rating' => 'decimal:1',
        'hidden' => 'bool',
        'group_type' => 'integer',
        'approval_status' => 'integer',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
