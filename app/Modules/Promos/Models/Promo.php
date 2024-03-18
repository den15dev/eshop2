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
}
