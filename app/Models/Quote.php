<?php

namespace App\Models;

use App\Models\Handyman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    const ACCEPTANCE_PENDING = 1;
    const ACCEPTANCE_ACCEPTED = 2;
    const ACCEPTANCE_REJECTED = 3;

    protected $fillable = [
        'user_id',
        'handyman_id',
        'quote_details',
        'price',
        'acceptance_status',
    ];

    protected $casts = [
        'acceptance_status' => 'integer',
    ];

    public function handyman(): BelongsTo
    {
        return $this->belongsTo(Handyman::class);
    }
}
