<?php

namespace App\Modules\Users\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];


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


    public function getThumbnailAttribute(): ?string
    {
        if ($this->image) {
            $thumbnail_arr = explode('.', $this->image);
            $thumbnail_arr[count($thumbnail_arr) - 2] .= '_thumbnail';
            return $this->id . '/' . implode('.', $thumbnail_arr);
        }
        return null;
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
