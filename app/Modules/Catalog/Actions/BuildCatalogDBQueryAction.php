<?php

namespace App\Modules\Catalog\Actions;

use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QBuilder;

class BuildCatalogDBQueryAction
{
    public static function run(int $category_id, array $query_arr): Builder
    {
        $db_query = Sku::join('products', 'skus.product_id', 'products.id')
            ->joinActivePromos()
            ->when(isset($query_arr['specs']), function (Builder $query) {
                $query->join('sku_specification AS ss', 'skus.id', 'ss.sku_id');
            })
            ->selectForCards()
            ->where('products.category_id', $category_id)
            ->filterByBrands($query_arr)
            ->filterByPrice($query_arr);

        if (isset($query_arr['specs'])) {
            $specs = $query_arr['specs'];
            $lang = app()->getLocale();

            $db_query = $db_query->whereIn('skus.id', function (QBuilder $query) use ($specs, $lang) {
                $query->select('ss.sku_id');

                foreach ($specs as $key => $value_list) {
                    if ($key === array_key_first($specs)) {
                        $query->where('ss.specification_id', $key)->whereIn('spec_value->' . $lang, $value_list);
                    } else {
                        $query->orWhere('ss.specification_id', $key)->whereIn('spec_value->' . $lang, $value_list);
                    }
                }
            });
        }

        return $db_query->active();
    }

}