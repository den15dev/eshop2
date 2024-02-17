<?php

namespace App\Modules\Products;

use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    public function __construct(
        private readonly ProductService $productService,
    ) {}


    public function getResultsPage(string $query): Collection
    {
        return $this->productService->getSomeProducts(12);
    }
}