<?php

namespace App\Modules\Categories\Models;

use App\Modules\Images\ImageService;
use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];
    protected $guarded = [];
    const IMG_DIR = 'categories';
    const IMG_SIZE = 230;


    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function specifications(): HasMany
    {
        return $this->hasMany(Specification::class);
    }


    public static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget('categories');
        });

        static::updated(function (self $model) {
            Cache::forget('categories');
        });

        static::deleted(function (self $model) {
            Cache::forget('categories');
        });
    }


    public function scopeWhereSkuIsActive(Builder $query): void
    {
        $query->whereDate('skus.available_from', '<=', now())
            ->where(function (Builder $builder) {
                $builder->whereDate('skus.available_until', '>', now())
                    ->orWhereNull('skus.available_until');
            });
    }


    public function getImagePathAttribute(): string
    {
        return Storage::disk('images')->path(self::IMG_DIR . '/' . $this->slug . '.jpg');
    }


    public function getImageUrlAttribute(): string
    {
        return get_image(self::IMG_DIR . '/' . $this->slug . '.jpg', 230);
    }
}
