<?php

namespace App\Modules\Cart\Actions;

use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class GetCartSkusAction
{
    public function run(array $cart): Collection
    {
        $ids = [];
        foreach ($cart as $cart_item) {
            $ids[] = $cart_item[0];
        }

        $skus = Sku::join('products', 'skus.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->joinActivePromos()
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'products.category_id',
                'categories.slug as category_slug',
                'skus.short_descr',
                'skus.currency_id',
                'skus.price',
                DB::raw(Sku::DISCOUNT . ' as discount'),
            )
            ->whereIn('skus.id', $ids)
            ->when(count($ids), function (EBuilder $query) use ($ids) {
                $query->orderByRaw(order_by_array($ids, 'skus.id'));
            })
            ->active()
            ->get();

        return CalculateCostsAction::run($skus, $cart);
    }
}
