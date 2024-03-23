<?php

namespace App\Modules\Catalog\Actions;

use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Builder;

class BuildSearchDBQueryAction
{
    public static function run(string $search_query, array $query_arr): Builder
    {
        $db_query = Sku::join('products', 'skus.product_id', 'products.id')
            ->joinPromos()
            ->selectForCards()
            ->where('skus.name->' . app()->getLocale(), 'ilike', '%' . $search_query . '%')
            ->filterByBrands($query_arr)
            ->filterByPrice($query_arr);

        return $db_query->active();
    }

}