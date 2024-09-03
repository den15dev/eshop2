<?php

namespace Tests\Feature\Site;

use App\Modules\Catalog\ComparisonService;
use App\Modules\Products\Models\Sku;
use Illuminate\Support\Collection;
use Tests\TestCase;


class ComparisonTest extends TestCase
{
    public function test_comparison_popup_shown(): void
    {
        $skus = $this->getSkus(3);
        $ids = $skus->pluck('id')->toArray();
        $names = $skus->pluck('name')->toArray();
        $comparison_arr = [3, $ids, 0]; // [category id, sku ids, is_collapsed]

        $response = $this->withUnencryptedCookie(ComparisonService::COOKIE, json_encode($comparison_arr))
            ->get('/en');

        $response->assertStatus(200);
        $response->assertSee('comparisonContent');
        $response->assertSeeText($names);
        $response->assertSee(route('comparison'));
    }


    public function test_comparison_page(): void
    {
        $skus = $this->getSkus(3);
        $ids = $skus->pluck('id')->toArray();
        $names = $skus->pluck('name')->toArray();
        $comparison_arr = [3, $ids, 0]; // [category id, sku ids, is_collapsed]

        $response = $this->withUnencryptedCookie(ComparisonService::COOKIE, json_encode($comparison_arr))
            ->get(route('comparison'));

        $response->assertStatus(200);
        $response->assertSeeText($names);
        $response->assertSee('comparison-table');
        $response->assertDontSee('comparisonContent');
    }


    private function getSkus(int $num): Collection
    {
        return Sku::join('products', 'products.id', 'skus.product_id')
            ->join('categories', 'categories.id', 'products.category_id')
            ->select(
                'skus.id',
                'skus.name',
                'skus.currency_id',
                'skus.price',
                'skus.discount',
                'categories.slug as category_slug',
            )
            ->where('categories.slug', 'cpu')
            ->inRandomOrder()
            ->limit($num)
            ->get();
    }
}
