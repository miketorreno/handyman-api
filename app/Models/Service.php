<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Handyman;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'hidden',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'hidden' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function handymen(): BelongsToMany
    {
        return $this->belongsToMany(Handyman::class);
    }
}
