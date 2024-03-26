<?php

namespace App\Modules\Users\Models;

use App\Modules\Cart\Models\CartItem;
use App\Modules\Favorites\Models\Favorite;
use App\Modules\Orders\Models\Order;
use App\Modules\Reviews\Models\Reaction;
use App\Modules\Reviews\Models\Review;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }


    public function isAdmin(): bool
    {
        if ($this->getAttribute('role') === 'admin' || $this->getAttribute('role') === 'boss') {
            return true;
        }
        return false;
    }


    public function isBoss(): bool
    {
        if ($this->getAttribute('role') === 'boss') {
            return true;
        }
        return false;
    }


    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/images/users/' . $this->id . '/' . $this->image . '.jpg') : null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/images/users/' . $this->id . '/' . $this->image . '_thumbnail.jpg') : null;
    }


    public function getRoleStrAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'администратор',
            'boss' => 'главный',
            default => 'пользователь',
        };
    }
}
