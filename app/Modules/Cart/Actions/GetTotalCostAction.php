<?php

namespace App\Modules\Cart\Actions;

use App\Modules\Currencies\CurrencyService;
use App\Modules\Products\ValueObjects\Price;
use Illuminate\Support\Collection;

class GetTotalCostAction
{
    public static function run(Collection $skus): \stdClass
    {
        $total = new \stdClass;

        $cost = 0;
        $final_cost = 0;
        foreach ($skus as $sku) {
            $cost = bcadd($cost, $sku->cost);
            $final_cost = bcadd($final_cost, $sku->final_cost);
        }

        $total->final_cost = $final_cost;
        $total->final_cost_formatted = Price::from($final_cost, CurrencyService::getCurrent()->id)->formatted_full;

        if ($final_cost === $cost) {
            $total->cost = null;
            $total->cost_formatted = null;
        } else {
            $total->cost = $cost;
            $total->cost_formatted = Price::from($cost, CurrencyService::getCurrent()->id)->formatted_full;
        }

        return $total;
    }
}
