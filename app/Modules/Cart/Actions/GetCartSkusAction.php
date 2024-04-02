<?php

namespace App\Modules\Cart\Actions;

use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Support\Collection;

class GetCartSkusAction
{
    public static function run(array $cart): Collection
    {
        $ids = [];
        foreach ($cart as $cart_item) {
            $ids[] = $cart_item[0];
        }

        $skus = Sku::join('products', 'skus.product_id', 'products.id')
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'products.category_id',
                'skus.short_descr',
                'skus.currency_id',
                'skus.price',
                'skus.discount_prc',
                'skus.final_price',
            )
            ->whereIn('skus.id', $ids)
            ->when(count($ids), function (EBuilder $query) use ($ids) {
                $query->orderByRaw(order_by_array($ids));
            })
            ->active()
            ->get();

        return CalculateCostsAction::run($skus, $cart);
    }
}