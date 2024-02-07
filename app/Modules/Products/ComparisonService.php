<?php

namespace App\Modules\Products;

use Illuminate\Database\Eloquent\Collection;

class ComparisonService
{
    public const COOKIE = 'comparison';

    private static ?\stdClass $data = null;


    public function __construct(
        private readonly ProductService $productService
    ) {}


    public static function get(): ?\stdClass
    {
        return self::$data;
    }

    public static function set(?array $cookie_data): void
    {
        $comparisonData = null;

        if ($cookie_data) {
            $comparisonData = new \stdClass();
            $comparisonData->category_id = $cookie_data[0];
            $comparisonData->product_ids = $cookie_data[1];
            $comparisonData->is_popup_collapsed = $cookie_data[2];
        }

        self::$data = $comparisonData;
    }


    public function getPopupProducts(): Collection
    {
        $ids = self::$data?->product_ids;

        return $ids ? $this->productService->getSomeProducts($ids) : new Collection();
    }


    public function getPageProducts(): Collection
    {
        $ids = self::$data?->product_ids;

        return $ids ? $this->productService->getSomeProducts($ids)->each(function ($product) {
            $product->specifications = $this->productService->getTempSpecs();
        }) : new Collection();
    }
}