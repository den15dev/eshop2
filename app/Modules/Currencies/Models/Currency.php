<?php

namespace App\Modules\Currencies\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Currency extends Model
{
    use HasTranslations;

    public array $translatable = ['name'];

    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];

    public static string $pref_currency = 'usd';

    private static Collection|null $currencies = null;

    private static array $currencies_default = [
        'id' => 'usd',
        'name' => '{"en":"United States Dollar","ru":"Американский доллар","de":"US-Dollar"}',
    ];


    public static function getAll()
    {
        if (self::$currencies === null) {
            $currencies_default = new Collection([(new static)->fill(self::$currencies_default)]);

            $db_currencies = Cache::rememberForever('currencies', function () {
                return self::all();
            });

            self::$currencies = $db_currencies->count() ? $db_currencies : $currencies_default;
        }

        return self::$currencies;
    }

    public static function booted(): void
    {
        static::saved(function (self $model) {
            Cache::forget('currencies');
        });

        static::deleted(function (self $model) {
            Cache::forget('currencies');
        });
    }


    public static function sortCurrency(string $pref_currency_id): void
    {
        if (self::$currencies !== null) {
            self::$currencies = self::$currencies->sortBy(fn($item) => $item->id !== $pref_currency_id);
        }
    }


    public static function setCurrency($currency_id): void
    {
        self::sortCurrency($currency_id);
        self::$pref_currency = $currency_id;
    }
}
