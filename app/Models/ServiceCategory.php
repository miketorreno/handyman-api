<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceCategory extends Model
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
}
