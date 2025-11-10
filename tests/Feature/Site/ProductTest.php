<?php

namespace Tests\Feature\Site;

use App\Modules\Products\Models\Sku;
use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_product_page(): void
    {
        $sku = Sku::join('products', 'products.id', 'skus.product_id')
            ->join('categories', 'categories.id', 'products.category_id')
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'skus.code',
                'categories.slug as category_slug',
            )
            ->inRandomOrder()
            ->first();

        $response = $this->get($sku->url);

        $response->assertStatus(200);
        $response->assertSeeText($sku->name);
        $response->assertSeeText(__('product.sku_code'));
        $response->assertSeeText(__('product.description'));
    }
}
