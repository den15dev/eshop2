<?php

namespace App\Modules\Cart\Actions;

use App\Modules\Cart\Models\CartItem;
use App\Modules\Products\Models\Sku;
use Illuminate\Support\Facades\Auth;

class UpdateCartAction
{
    public function run(int $sku_id, int $sku_qty, array $cart, bool $get_cost): \stdClass
    {
        $user_id = Auth::id();

        $response = new \stdClass();
        $response->auth = (bool) $user_id;
        $response->header_bubble = null;

        $is_in_cart = false;
        foreach ($cart as &$cart_item) {
            if ($cart_item[0] === $sku_id) {
                $cart_item[1] = $sku_qty;
                $is_in_cart = true;
                break;
            }
        }

        if (!$is_in_cart) {
            $cart[] = [$sku_id, $sku_qty];
            $response->header_bubble = $this->getBubbleData($sku_id, $sku_qty);
        }

        $cart = array_values(array_filter($cart, fn($cart_item) => $cart_item[1] > 0));
        $response->cart = $cart;

        $response->item = null;
        $response->total = null;
        if ($get_cost) {
            $sku_costs = GetSkuCostsAction::run($cart);
            $response->item = $sku_costs->firstWhere('id', $sku_id);
            $response->total = GetTotalCostAction::run($sku_costs);
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


    private function getBubbleData(int $sku_id, int $sku_qty): \stdClass
    {
        $sku = Sku::join('products', 'products.id', 'skus.product_id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'products.category_id',
                'categories.slug as category_slug',
            )
            ->firstWhere('skus.id', $sku_id);

        $header_bubble = new \stdClass();
        $header_bubble->url = $sku->url;
        $header_bubble->image_tn = $sku->getImageURL('tn');
        $header_bubble->name = $sku->name;
        $header_bubble->qty = trans_choice('cart.header_bubble.qty', ['count' => $sku_qty]);

        return $header_bubble;
    }
}
