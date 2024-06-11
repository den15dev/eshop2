<?php

namespace App\Modules\Promos\Models;

use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Promo extends Model
{
    use HasTranslations;

    public array $translatable = [
        'name',
        'image',
        'description',
    ];

    protected $guarded = [];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
    ];


    public function skus(): HasMany
    {
        return $this->hasMany(Sku::class);
    }


    public static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget('promos');
        });

        static::updated(function (self $model) {
            Cache::forget('promos');
        });

        static::deleted(function (self $model) {
            Cache::forget('promos');
        });
    }


    public function getStatusAttribute(): string
    {
        if ($this->ends_at->isPast()) {
            return 'ended';

        } elseif ($this->starts_at->isPast() && $this->ends_at->isFuture()) {
            return 'active';

        } else {
            return 'scheduled';
        }
    }


    public function getStatusDescriptionAttribute(): string
    {
        return match($this->status) {
            'ended' => __('admin/skus.promo_status.ended') . ' ' . $this->ends_at->isoFormat('D MMMM YYYY'),
            'active' => __('admin/skus.promo_status.active_until') . ' ' . $this->ends_at->isoFormat('D MMMM YYYY'),
            'scheduled' => __('admin/skus.promo_status.will_start') . ' ' . $this->starts_at->isoFormat('D MMMM YYYY'),
        };
    }
}
