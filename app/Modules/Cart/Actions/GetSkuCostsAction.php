<?php

namespace App\Modules\Cart\Actions;

use App\Modules\Products\Models\Sku;
use Illuminate\Support\Collection;

class GetSkuCostsAction
{
    public static function run(array $cart): Collection
    {
        $ids = [];
        foreach ($cart as $cart_item) {
            $ids[] = $cart_item[0];
        }

        $order_stmt = match (env('DB_CONNECTION')) {
            'pgsql' => 'ARRAY_POSITION(ARRAY[' . implode(', ', $ids) . '], skus.id)',
            'mysql' => 'FIELD(skus.id, ' . implode(', ', $ids) . ')',
        };

        $skus = Sku::select(
                'id',
                'currency_id',
                'price',
                'discount_prc',
                'final_price',
            )
            ->whereIn('skus.id', $ids)
            ->orderByRaw($order_stmt)
            ->active()
            ->get();

        return CalculateCostsAction::run($skus, $cart);
    }
}