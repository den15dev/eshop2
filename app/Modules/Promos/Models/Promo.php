<?php

namespace App\Modules\Promos\Models;

use Illuminate\Database\Eloquent\Model;
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
