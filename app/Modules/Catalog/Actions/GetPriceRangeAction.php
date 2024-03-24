<?php

namespace App\Modules\Catalog\Actions;

use App\Modules\Currencies\CurrencyService;
use App\Modules\Products\ValueObjects\Price;
use Illuminate\Database\Eloquent\Builder;

class GetPriceRangeAction
{
    public static function run(Builder $db_query): \stdClass
    {
        $price_range = new \stdClass();
        $price_range->min = '';
        $price_range->max = '';
        $price_range->symbol = CurrencyService::$cur_currency->symbol;
        $price_range->is_precedes = CurrencyService::$cur_currency->symbol_precedes;

        $skus = $db_query->get();

        $prices = [];
        foreach ($skus as $sku) {
            $prices[] = Price::from($sku->final_price, $sku->currency_id)->converted;
        }

        if (count($prices)) {
            $curr_id = CurrencyService::$cur_currency->id;
            $price_range->min = Price::from(min($prices), $curr_id)->formatted;
            $price_range->max = Price::from(max($prices), $curr_id)->formatted;
        }

        return $price_range;
    }
}