<?php

namespace Tests\Feature\Site;

use App\Modules\Cart\CartService;
use App\Modules\Products\Models\Sku;
use App\Modules\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CartTest extends TestCase
{
    use DatabaseTransactions;


    public function test_guest_can_add_new_sku_to_cart(): void
    {
        $sku = $this->getSku();
        $qty = 3;
        $cart = [[$sku->id, $qty]];
        $cart_data = [
            'sku_id' => $sku->id,
            'sku_qty' => $qty,
            'get_cost' => true,
        ];

        $response = $this->postJson(route('cart.update'), $cart_data);

        $response->assertStatus(200);
        $response->assertJson([
            'auth' => false,
            'cart' => $cart,
        ]);
    }


    public function test_authed_user_can_add_new_sku_to_cart(): void
    {
        $sku = $this->getSku();
        $qty = 3;
        $cart = [[$sku->id, $qty]];
        $cart_data = [
            'sku_id' => $sku->id,
            'sku_qty' => $qty,
            'get_cost' => true,
        ];
        $buyer = User::inRandomOrder()->first();

        $response = $this->actingAs($buyer)
            ->postJson(route('cart.update'), $cart_data);

        $response->assertStatus(200);
        $response->assertJson([
            'auth' => true,
            'cart' => $cart,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'sku_id' => $sku->id,
            'user_id' => $buyer->id,
            'quantity' => $qty,
        ]);
    }


    public function test_cart_costs_calculate_correctly(): void
    {
        Sku::firstWhere('id', 1)->update([
            'currency_id' => 'rub',
            'price' => 5000,
            'discount' => null,
            'promo_id' => null,
        ]);
        Sku::firstWhere('id', 2)->update([
            'currency_id' => 'eur',
            'price' => 400,
            'discount' => 5,
            'promo_id' => null,
        ]);
        Sku::firstWhere('id', 3)->update([
            'currency_id' => 'usd',
            'price' => 200,
            'discount' => null,
            'promo_id' => null,
        ]);

        $cart = [
            [1, 4],
            [2, 2],
            [3, 1],
        ];

        $cart_data = [
            'sku_id' => 2,
            'sku_qty' => 3,
            'get_cost' => true,
        ];

        $response = $this->disableCookieEncryption()
            ->withCookie(CartService::COOKIE, json_encode($cart))
            ->post(route('cart.update'), $cart_data);

        $response->assertStatus(200);

        $cart[1][1]++;
        // usd-rub: 88,9062
        // eur-rub: 97,839
        $response->assertJson([
            'auth' => false,
            'cart' => $cart,
            'item' => [
                'id' => 2,
                'currency_id' => 'eur',
                'price' => '400.00',
                'discount' => 5,
                'quantity' => 3,
                'price_converted' => '440.18',
                'price_formatted' => '$440.18',
                'cost' => '1320.54',
                'cost_formatted' => '$1,320.54',
                'final_price_converted' => '418.18',
                'final_price_formatted' => '$418.18',
                'final_cost' => '1254.54',
                'final_cost_formatted' => '$1,254.54',
            ],
            'total' => [
                'cost' => '1745.46',
                'cost_formatted' => '$1,745.46',
                'final_cost' => '1679.46',
                'final_cost_formatted' => '$1,679.46',
            ]
        ]);
    }


    private function getSku(): Sku
    {
        return Sku::select(
                'id',
                'name',
                'currency_id',
                'price',
                'discount',
            )
            ->with('promo:id,discount')
            ->inRandomOrder()
            ->first();
    }
}
