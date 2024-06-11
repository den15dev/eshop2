<?php

namespace App\Admin\Products\Actions;

use App\Modules\Currencies\CurrencyService;
use App\Modules\Products\ValueObjects\Price;
use App\Modules\Promos\Models\Promo;

class GetSkuFinalPricesAction
{
    public static function run(
        string $price,
        string $currency_id,
        ?int $sku_discount,
        ?int $promo_id
    ): \stdClass
    {
        $promo_discount = 0;
        $suffix = '%';

        if ($promo_id) {
            $promo = Promo::select(
                    'id',
                    'name',
                    'discount',
                    'starts_at',
                    'ends_at'
                )
                ->firstWhere('id', $promo_id);

            if ($promo) {
                if ($promo->status === 'active') $promo_discount = $promo->discount;

                if ($promo->status === 'scheduled' && !$sku_discount) {
                    $suffix = '% (' . $promo->discount . '% ' . __('admin/skus.promo_status.from') . ' ' . $promo->starts_at->isoFormat('D MMMM YYYY') . ')';
                }
            }
        }

        $discount = $sku_discount ?: $promo_discount;

        $prices = new \stdClass();
        $prices->discount = $discount . $suffix;

        $currencies = CurrencyService::getAll();
        $price = str_replace(',', '.', $price);
        $final_price = bcmul($price, (100 - $discount) / 100);

        foreach ($currencies as $currency) {
            $id = $currency->id;
            $prices->$id = Price::from($final_price, $currency_id, $id)->formatted_full;
        }

        return $prices;
    }
}