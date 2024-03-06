<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Models\Post;
use App\Models\Event;
use App\Models\Report;
use App\Models\Review;
use App\Models\Handyman;
use App\Models\YardSale;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    // Client, Handyman, Admin, SuperAdmin
    const CLIENT = 1;
    const HANDYMAN = 2;
    const ADMIN = 3;
    const SUPER_ADMIN = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'location',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'integer',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return ($this->role == User::ADMIN) || ($this->role == User::SUPER_ADMIN);
    }

    public function handyman(): HasOne
    {
        return $this->hasOne(Handyman::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function yardSales(): HasMany
    {
        return $this->hasMany(YardSale::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
