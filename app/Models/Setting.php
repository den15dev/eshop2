<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations;

    public array $translatable = ['val'];

    protected $fillable = ['name', 'val'];

    private static Collection|Null $settings = null;


    public static function getAll()
    {
        if (self::$settings === null) {
            self::$settings = Cache::rememberForever('settings', function () {
                return self::all();
            });
        }

        return self::$settings;
    }

    public static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget('settings');
        });

        static::deleted(function (self $model) {
            Cache::forget('settings');
        });
    }
}
