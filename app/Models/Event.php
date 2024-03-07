<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    const VIRTUAL = 1;
    const IN_PERSON = 2;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'date_and_time',
        'event_type',
        'rsvp_list',
    ];

    protected $casts = [
        'date_and_time' => 'datetime',
        'event_type' => 'integer',
        // 'rsvp_list' => 'array',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
