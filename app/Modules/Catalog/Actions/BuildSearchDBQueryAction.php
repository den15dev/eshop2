<?php

namespace App\Modules\Catalog\Actions;

use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Builder;

class BuildSearchDBQueryAction
{
    public static function run(string $search_query, array $query_arr): Builder
    {
        return Sku::getCards()
            ->where('skus.name->' . app()->getLocale(), 'ilike', '%' . $search_query . '%')
            ->filterByBrands($query_arr)
            ->filterByPrice($query_arr);
    }

}