<?php

namespace App\Modules\Cart\Actions;

use App\Modules\Cart\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class UpdateCartAction
{
    public static function run(int $sku_id, int $sku_qty, array $cart, bool $get_cost): \stdClass
    {
        $user_id = Auth::id();

        $response = new \stdClass();
        $response->auth = (bool) $user_id;

        $is_in_cart = false;
        foreach ($cart as &$cart_item) {
            if ($cart_item[0] === $sku_id) {
                $cart_item[1] = $sku_qty;
                $is_in_cart = true;
                break;
            }
        }
        if (!$is_in_cart) $cart[] = [$sku_id, $sku_qty];
        $cart = array_values(array_filter($cart, fn($cart_item) => $cart_item[1] > 0));
        $response->cart = $cart;

        $response->item = null;
        $response->total = null;
        if ($get_cost) {
            $skus = GetSkuCostsAction::run($cart);
            $response->item = $skus->firstWhere('id', $sku_id);
            $response->total = GetTotalCostAction::run($skus);
        }

        if (!$user_id) return $response;

        if ($sku_qty) {
            CartItem::updateOrCreate(
                ['user_id' => $user_id, 'sku_id' => $sku_id],
                ['quantity' => $sku_qty]
            );
        } else {
            CartItem::where('user_id', $user_id)
                ->where('sku_id', $sku_id)
                ->delete();
        }

        $response->cart = $cart;

        return $response;
    }
}