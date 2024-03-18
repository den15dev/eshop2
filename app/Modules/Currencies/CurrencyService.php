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
    /**
     * Current preferred currency.
     */
    public static Currency $cur_currency;

    /**
     * All currencies will be stored here.
     *
     * @var Collection|null
     */
    private static ?Collection $currencies = null;


    /**
     * Get all currencies and store them in static property.
     *
     * @return Collection
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
     *
     * @return Collection
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
     * For convenience, move preferred currency
     * to the beginning of the collection.
     *
     * @param string $pref_currency_id
     * @return void
     */
    public static function sortCurrency(string $pref_currency_id): void
    {
        if (self::$currencies !== null) {
            self::$currencies = self::$currencies->sortBy(fn($item) => $item->id !== $pref_currency_id);
        }
    }


    public static function setCurrency($currency_id): void
    {
        self::sortCurrency($currency_id);
        self::$cur_currency = self::$currencies->firstWhere('id', $currency_id);
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