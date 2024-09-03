<?php

namespace Tests\Feature\Site;

use App\Modules\Shops\Models\Shop;
use Tests\TestCase;


class ShopTest extends TestCase
{
    public function test_shops_page(): void
    {
        $shops = Shop::select('id', 'name')->get();
        $names = $shops->pluck('name')->toArray();

        $response = $this->get(route('stores'));

        $response->assertStatus(200);
        $response->assertSeeText($names);
    }
}
