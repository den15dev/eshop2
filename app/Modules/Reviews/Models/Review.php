<?php

namespace App\Modules\Reviews\Models;

use App\Modules\Common\CommonService;
use App\Modules\Products\Models\Sku;
use App\Modules\Reviews\Enums\TermOfUse;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
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


    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::createFromDate($value)->tz(CommonService::$timezone),
        );
    }

    public function getDateAttribute(): string
    {
        return $this->created_at->isoFormat('D MMMM YYYY, H:mm');
    }

    public function getHumanDateAttribute(): string
    {
        return $this->created_at
            ->tz(CommonService::$timezone)
            ->diffForHumans();
    }

    public function getIsAuthorAttribute(): bool
    {
        return $this->user_id === Auth::id();
    }
}
