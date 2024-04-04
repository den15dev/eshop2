<?php

namespace App\Modules\Reviews\Models;

use App\Modules\Products\Models\Sku;
use App\Modules\Reviews\Enums\TermOfUse;
use App\Modules\Reviews\Factories\ReviewFactory;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Review extends Model
{
    protected $guarded = [];

    protected $casts = [
        'term' => TermOfUse::class,
    ];


    protected static function newFactory(): Factory
    {
        return ReviewFactory::new();
    }


    public function sku(): BelongsTo
    {
        return $this->belongsTo(Sku::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(Reaction::class);
    }


    public function getDateAttribute(): string
    {
        return Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY, H:mm');
    }

    public function getHumanDateAttribute(): string
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getIsAuthorAttribute(): bool
    {
        return $this->user_id === Auth::id();
    }
}
