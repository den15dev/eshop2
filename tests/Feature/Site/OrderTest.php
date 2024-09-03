<?php

namespace Tests\Feature\Site;

use App\Modules\Cart\CartService;
use App\Modules\Cart\Models\CartItem;
use App\Modules\Orders\Enums\DeliveryMethod;
use App\Modules\Orders\Enums\PaymentMethod;
use App\Modules\Orders\Models\Order;
use App\Modules\Orders\Models\OrderItem;
use App\Modules\Orders\OrderService;
use App\Modules\Products\Models\Sku;
use App\Modules\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseTransactions;


    public function test_guest_can_make_an_order(): void
    {
        $skus = $this->getSkus(3);
        $cart = $this->getCart($skus);

        $email = 'johndoe2@mail.com';
        $order_data = [
            'name' => 'John Doe 2',
            'phone' => '85673986377',
            'email' => $email,
            'delivery_address' => '25739 Rogahn Mountains Apt. 199',
            'payment_method' => PaymentMethod::CourierCard->value,
            'delivery_method' => DeliveryMethod::Delivery->value,
        ];

        $response = $this->withUnencryptedCookie(CartService::COOKIE, json_encode($cart))
            ->from(route('cart'))
            ->post(route('orders.store'), $order_data);

        $order = Order::firstWhere('email', $email);

        $this->assertDatabaseHas('orders', $order_data);

        foreach ($cart as $cart_item) {
            $this->assertDatabaseHas('order_items', [
                'order_id' => $order->id,
                'sku_id' => $cart_item[0],
                'quantity' => $cart_item[1],
            ]);
        }

        $response->assertRedirect(route('orders.new', $order->id));

        $response = $this->withCookie(OrderService::COOKIE, json_encode([$order->id]))
            ->get(route('orders.new', $order->id));

        $response->assertStatus(200);
        $response->assertSeeText(substr(__('orders.new_message'), 0, 20));
    }


    public function test_authed_user_can_make_an_order(): void
    {
        $skus = $this->getSkus(3);
        $cart = $this->getCart($skus);
        $buyer = User::inRandomOrder()->first();

        foreach ($cart as $cart_item) {
            CartItem::create([
                'sku_id' => $cart_item[0],
                'user_id' => $buyer->id,
                'quantity' => $cart_item[1],
            ]);
        }

        $email = 'johndoe3@mail.com';
        $order_data = [
            'name' => 'John Doe 3',
            'phone' => '85673986378',
            'email' => $email,
            'shop_id' => 3,
            'payment_method' => PaymentMethod::Shop->value,
            'delivery_method' => DeliveryMethod::SelfDelivery->value,
        ];

        $response = $this->actingAs($buyer)
            ->from(route('cart'))
            ->post(route('orders.store'), $order_data);

        $order = Order::firstWhere('email', $email);

        $this->assertDatabaseHas('orders', $order_data);

        foreach ($cart as $cart_item) {
            $this->assertDatabaseHas('order_items', [
                'order_id' => $order->id,
                'sku_id' => $cart_item[0],
                'quantity' => $cart_item[1],
            ]);

            $this->assertDatabaseMissing('cart_items', [
                'sku_id' => $cart_item[0],
                'user_id' => $buyer->id,
                'quantity' => $cart_item[1],
            ]);
        }

        $response->assertRedirect(route('orders.new', $order->id));

        $response = $this->get(route('orders.new', $order->id));

        $response->assertStatus(200);
        $response->assertSeeText(substr(__('orders.new_message'), 0, 20));
    }


    public function test_orders_page(): void
    {
        $orders = Order::newFactory()
            ->count(3)
            ->has(
                OrderItem::newFactory()->count(3)
            )
            ->create([
                'delivery_method' => DeliveryMethod::Delivery->value,
                'delivery_address' => fake()->address(),
            ]);

        $orders_arr = $orders->pluck('id')->toArray();

        $response = $this->withCookie(OrderService::COOKIE, json_encode($orders_arr))
            ->get(route('orders'));

        $response->assertStatus(200);

        $addresses = $orders->pluck('delivery_address')->toArray();
        $response->assertSeeText($addresses);
    }


    private function getSkus(int $num): Collection
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
            ->limit($num)
            ->get();
    }


    private function getCart(Collection $skus): array
    {
        $cart = [];
        $cart[] = [$skus[0]->id, 1];
        $cart[] = [$skus[1]->id, 2];
        $cart[] = [$skus[2]->id, 3];

        return $cart;
    }
}
