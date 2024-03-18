<?php

namespace App\Modules\Catalog;

use App\Modules\Brands\BrandService;
use App\Modules\Products\ProductService;
use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly BrandService $brandService,
    ) {}


    public function getResultsPage(string $search_query): Collection
    {
        return $this->productService->getSomeProducts(12);
    }


    public function countDropdownProductResults(string $search_query): int
    {
        $total = 25;

        /*$total->brands = DB::table('brands')
            ->where('name', 'like', '%' . $search_query . '%')
            ->count();

        $total->products = DB::table('products')
            ->where('name', 'like', '%' . $search_query . '%')
            ->where('is_active', 1)
            ->count();*/

        return $total;
    }
    
    
    public function getDropdownProducts(string $search_query, int $limit): Collection
    {
        return $this->productService->getSomeProducts($limit);
    }


    public function getDropdownBrands(string $search_query, int $limit): Collection
    {
        return $this->brandService->getSomeBrands($limit);
    }
}