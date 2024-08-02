<?php

namespace App\Modules\Promos\Models;

use App\Modules\Common\CommonService;
use App\Modules\Languages\LanguageService;
use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
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

    const IMG_DIR = 'promos';
    const IMG_SIZES = [
        'sm' => 400,
        'md' => 788,
        'lg' => 992,
        'xl' => 1140,
        'xxl' => 1296,
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


    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::createFromDate($value)->tz(CommonService::$timezone),
        );
    }

    protected function startsAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::createFromDate($value)->tz(CommonService::$timezone),
        );
    }

    protected function endsAt(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::createFromDate($value)->tz(CommonService::$timezone),
        );
    }


    public function getUrlAttribute(): string
    {
        return route('promo', $this->slug . '-' . $this->id);
    }


    public function getImagePath(string $size, string $lang): ?string
    {
        return Storage::disk('images')->path(self::IMG_DIR . '/' . $this->id . '/' . $lang . '/' . $this->slug . '_' . $size . '.jpg');
    }


    public function getImageURL(string $size, ?string $lang = null): ?string
    {
        return LanguageService::getImageURL(
            self::IMG_DIR . '/' . $this->id,
            $this->slug . '_' . $size . '.jpg',
            $lang
        );
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
