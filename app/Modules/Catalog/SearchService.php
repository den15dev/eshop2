<?php

namespace App\Modules\Catalog;

use App\Modules\Brands\Models\Brand;
use App\Modules\Products\Models\Sku;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SearchService
{
    private const SKU_LIMIT = 6;
    private const BRAND_LIMIT = 3;


    public function countDropdownProductResults(string $search_query): \stdClass
    {
        $total = new \stdClass();

        $total->brands = Brand::where('name', 'ilike', '%' . $search_query . '%')
            ->count();

        $total->skus = Sku::where('name->' . app()->getLocale(), 'ilike', '%' . $search_query . '%')
            ->active()
            ->count();

        return $total;
    }


    public function getDropdownSkus(string $search_query): Collection
    {
        return Sku::join('products', 'skus.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->joinActivePromos()
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'skus.code',
                'products.category_id',
                'categories.slug as category_slug',
                'skus.currency_id',
                'skus.price',
                DB::raw(Sku::DISCOUNT . ' as discount'),
            )
            ->where('skus.name->' . app()->getLocale(), 'ilike', '%' . $search_query . '%')
            ->active()
            ->limit(self::SKU_LIMIT)
            ->get();
    }


    public function getDropdownBrands(string $search_query): Collection
    {
        return Brand::select(
                'id',
                'name',
                'slug',
            )
            ->where('name', 'ilike', '%' . $search_query . '%')
            ->limit(self::BRAND_LIMIT)
            ->get();
    }
}
