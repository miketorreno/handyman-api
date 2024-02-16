<?php

namespace App\Models;

use App\Models\Service;
use App\Models\Handyman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'category',
        'description',
        'hidden',
    ];

    protected $casts = [
        'hidden' => 'bool',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function handymen(): BelongsToMany
    {
        return $this->belongsToMany(Handyman::class);
    }
}
