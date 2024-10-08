<?php

namespace App\Modules\Users\Models;

use App\Modules\Cart\Models\CartItem;
use App\Modules\Common\CommonService;
use App\Modules\Favorites\Models\Favorite;
use App\Modules\Orders\Models\Order;
use App\Modules\Reviews\Models\Reaction;
use App\Modules\Reviews\Models\Review;
use App\Modules\Users\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    const IMG_DIR = 'users';


    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }


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


    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->isBoss();
    }


    public function isBoss(): bool
    {
        return $this->role === 'boss';
    }


    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::createFromDate($value)->tz(CommonService::$timezone),
        );
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
