<?php

namespace App\Modules\Currencies\Actions;

use App\Modules\Currencies\Exceptions\CurrencyRateSourceException;
use App\Modules\Currencies\Models\Currency;
use App\Modules\Currencies\Sources\Source;
use Illuminate\Database\Eloquent\Collection;

class UpdateCurrencyRatesAction
{
    public function run(Source $source): Collection
    {
        $source_currencies = Currency::where('source', $source->enum())->get();

        if ($source_currencies->isEmpty()) {
            return $source_currencies;
        }

        $rates = $source->getRates();

        if ($rates->isEmpty()) {
            return $source_currencies;
        }

        foreach ($source_currencies as $currency) {
            $rate = $rates->firstWhere('currency_id', $currency->id);

            if (!$rate) {
                throw new CurrencyRateSourceException('Failed to get exchange rate for ' . $currency->id);
            }

            $currency->update(['exchange_rate' => $rate->value]);
        }

        return $source_currencies;
    }
}