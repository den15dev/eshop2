<?php

namespace App\Modules\Cart;

use App\Modules\Cart\Actions\GetCartSkusAction;
use App\Modules\Cart\Actions\GetTotalCostAction;
use App\Modules\Cart\Actions\UpdateCartAction;
use App\Modules\Cart\Models\CartItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CartService
{
    public const COOKIE = 'cart';
    private static ?array $cart = null;


    public function __construct(
        private readonly UpdateCartAction $updateCartAction,
        private readonly GetCartSkusAction $getCartSkusAction
    ){}


    public static function setCart(?string $cookie): void
    {
        $user_id = Auth::id();

        if ($user_id) {
            $cart = [];
            $cart_items = CartItem::where('user_id', $user_id)
                ->orderBy('created_at')
                ->get();

            foreach ($cart_items as $cart_item) {
                $cart[] = [
                    $cart_item->sku_id,
                    $cart_item->quantity,
                ];
            }

            self::$cart = $cart;

        } else if ($cookie) {
            self::$cart = json_decode($cookie);

        } else {
            self::$cart = [];
        }
    }


    public static function getCart(): array
    {
        return self::$cart;
    }


    public function updateCart(int $sku_id, int $sku_qty, bool $get_cost): \stdClass
    {
        return $this->updateCartAction->run($sku_id, $sku_qty, self::getCart(), $get_cost);
    }


    public function clearCart(): \stdClass
    {
        $user_id = Auth::id();

        $response = new \stdClass();
        $response->auth = (bool) $user_id;

        if ($user_id) {
            CartItem::where('user_id', $user_id)->delete();
        }

        $response->error_message = null;

        return $response;
    }


    public function getCartSkus(): Collection
    {
        return $this->getCartSkusAction->run(self::getCart());
    }


    public function getTotalCost(Collection $skus): \stdClass
    {
        return GetTotalCostAction::run($skus);
    }


    public function moveCartFromCookie(array $cart): void
    {
        if (count($cart)) {
            $user_id = Auth::id();

            foreach ($cart as $cart_item) {
                CartItem::updateOrCreate(
                    ['user_id' => $user_id, 'sku_id' => intval($cart_item[0])],
                    ['quantity' => intval($cart_item[1])]
                );
            }
        }
    }
}