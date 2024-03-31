<?php

namespace App\Modules\Cart\Actions;

use App\Modules\Products\ValueObjects\Price;
use Illuminate\Support\Collection;

class CalculateCostsAction
{
    public static function run(Collection $skus, array $cart): Collection
    {
        foreach ($skus as $sku) {
            $qty = 0;
            foreach ($cart as $cart_item) {
                if ($sku->id === $cart_item[0]) {
                    $qty = $cart_item[1];
                    break;
                }
            }
            $sku->quantity = $qty;

            $price = Price::from($sku->price, $sku->currency_id);
            $sku->price_converted = $price->converted;
            $sku->price_formatted = $price->formatted_full;

            $final_price = Price::from($sku->final_price, $sku->currency_id);
            $sku->final_price_converted = $final_price->converted;
            $sku->final_price_formatted = $final_price->formatted_full;

            $cost = Price::from(bcmul($sku->price_converted, $qty));
            $sku->cost = $cost->converted;
            $sku->cost_formatted = $cost->formatted_full;

            $final_cost = Price::from(bcmul($sku->final_price_converted, $qty));
            $sku->final_cost = $final_cost->converted;
            $sku->final_cost_formatted = $final_cost->formatted_full;
        }

        return $skus;
    }
}