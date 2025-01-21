<?php

namespace App\Modules\Catalog\Actions;

use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Support\Facades\DB;

class BuildCatalogDBQueryAction
{
    public static function run(int $category_id, array $query_arr): EBuilder
    {
        $db_query = Sku::join('products', 'skus.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->joinActivePromos()
            ->selectForCards()
            ->where('products.category_id', $category_id)
            ->filterByBrands($query_arr)
            ->filterByPrice($query_arr);

        if (isset($query_arr['specs'])) {
            $db_query = $db_query->whereIn('skus.id', self::getSkuIdsBySpecs($query_arr['specs']));
        }

        return $db_query->active();
    }


    public static function getSkuIdsBySpecs(array $specs): array
    {
        $lang = app()->getLocale();
        $query = DB::table('sku_specification')
            ->select('sku_id');

        foreach ($specs as $key => $value_list) {
            if ($key === array_key_first($specs)) {
                $query->where(function (QBuilder $query) use ($key, $value_list, $lang) {
                    $query->where('specification_id', $key)
                        ->whereIn('spec_value->' . $lang, $value_list);
                });

            } else {
                $query->orWhere(function (QBuilder $query) use ($key, $value_list, $lang) {
                    $query->where('specification_id', $key)
                        ->whereIn('spec_value->' . $lang, $value_list);
                });
            }
        }

        return $query->groupBy('sku_id')
            ->havingRaw('count(sku_id) = ' . count($specs))
            ->get()
            ->pluck('sku_id')
            ->toArray();
    }
}
