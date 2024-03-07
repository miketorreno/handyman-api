<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    const REVIEWED = 1;
    const NOT_REVIEWED = 2;

    protected $fillable = [
        'user_id',
        'reportable_id',
        'reportable_type',
        'reason',
        'report_status',
    ];

    protected $casts = [
        'report_status' => 'integer',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }
}
