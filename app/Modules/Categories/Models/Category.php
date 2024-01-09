<?php

namespace App\Modules\Categories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $guarded = [];


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
}
