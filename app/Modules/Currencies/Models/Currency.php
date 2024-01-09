<?php

namespace App\Modules\Currencies\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Currency extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];


    public static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget('currencies');
        });

        static::updated(function (self $model) {
            Cache::forget('currencies');
        });

        static::deleted(function (self $model) {
            Cache::forget('currencies');
        });
    }
}
