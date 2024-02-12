<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'path',
        'caption',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
