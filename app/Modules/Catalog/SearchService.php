<?php

namespace App\Modules\Catalog;

use App\Modules\Brands\Models\Brand;
use App\Modules\Products\Models\Sku;
use Illuminate\Support\Collection;

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
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'products.category_id',
                'skus.currency_id',
                'skus.final_price',
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