<?php

namespace App\Modules\Cart\Actions;

use App\Modules\Products\Models\Sku;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetSkuCostsAction
{
    public static function run(array $cart): Collection
    {
        $ids = [];
        foreach ($cart as $cart_item) {
            $ids[] = $cart_item[0];
        }

        $skus = Sku::joinActivePromos()
            ->select(
                'skus.id',
                'skus.currency_id',
                'skus.price',
                DB::raw(Sku::DISCOUNT . ' as discount'),
            )
            ->whereIn('skus.id', $ids)
            ->orderByRaw(order_by_array($ids))
            ->active()
            ->get();

        return CalculateCostsAction::run($skus, $cart);
    }
}