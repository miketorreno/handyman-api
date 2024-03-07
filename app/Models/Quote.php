<?php

namespace App\Models;

use App\Models\User;
use App\Models\Handyman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    const PENDING = 1;
    const ACCEPTED = 2;
    const REJECTED = 3;

    protected $fillable = [
        'user_id',
        'handyman_id',
        'quote_details',
        'price',
        'acceptance_status',
        'requested',
    ];

    protected $casts = [
        'price' => 'integer',
        'acceptance_status' => 'integer',
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
