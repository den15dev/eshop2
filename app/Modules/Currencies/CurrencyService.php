<?php

namespace App\Modules\Currencies;

use App\Modules\Currencies\Actions\UpdateCurrencyRatesAction;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Currencies\Sources\Source;
use App\Modules\Currencies\Sources\SourceEnum;
use App\Modules\Currencies\Sources\SourceFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CurrencyService
{
    public const COOKIE = 'curr';

    public const RATE_SUBQUERY = '(SELECT currencies.exchange_rate FROM currencies where skus.currency_id = currencies.id)';

    /**
     * Current preferred currency.
     * In admin panel, it is null.
     */
    private static ?Currency $cur_currency = null;

    /**
     * All currencies will be stored here.
     */
    private static ?Collection $currencies = null;


    /**
     * Get all currencies and store them in static property.
     */
    public static function getAll(): Collection
    {
        if (self::$currencies === null) {
            $db_currencies = Cache::rememberForever('currencies', function () {
                return Currency::all();
            });

            self::$currencies = $db_currencies->count() ? $db_currencies : self::createDefault();
        }

        return self::$currencies;
    }


    /**
     * Create default currency collection
     * in case a database is empty.
     */
    private static function createDefault(): Collection
    {
        return new Collection([
            (new Currency())->fill([
                'id' => 'usd',
                'name' => '{"en":"United States Dollar"}',
                'symbol' => '$',
                'symbol_precedes' => true,
                'thousands_sep' => ',',
                'decimal_sep' => '.',
                'language_id' => 'en',
            ])
        ]);
    }


    /**
     * Get current currency.
     */
    public static function getCurrent(): Currency
    {
        if (self::$cur_currency === null) self::setCurrency();

        return self::$cur_currency;
    }


    /**
     * Set current currency.
     */
    public static function setCurrency(?string $currency_id = null): void
    {
        $currencies = self::getAll();

        if (!$currency_id || $currencies->doesntContain('id', $currency_id)) {
            $lang = app()->getLocale();
            $currency_id = $currencies->firstWhere('language_id', $lang)?->id ?? 'usd';
        }

        // Move preferred currency to the beginning of the collection
        self::$currencies = self::$currencies->sortBy(fn($item) => $item->id !== $currency_id);

        self::$cur_currency = self::getAll()->firstWhere('id', $currency_id);
    }


    public function getSource(SourceEnum $source): Source
    {
        return SourceFactory::make($source);
    }

    public function updateRates(): UpdateCurrencyRatesAction
    {
        return app(UpdateCurrencyRatesAction::class);
    }
}
