<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Cart\CartService;
use App\Modules\Orders\Enums\DeliveryMethod;
use App\Modules\Orders\Enums\PaymentMethod;
use App\Modules\Products\RecentlyViewedService;
use App\Modules\Shops\ShopService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly ShopService $shopService,
    ) {}

    public function index(
        Request $request,
        RecentlyViewedService $recentlyViewedService
    ): View
    {
        $skus = $this->cartService->getCartSkus();
        $total = $this->cartService->getTotalCost($skus);

        $user = Auth::user();

        $shops = $this->shopService->getShopsForCart();
        $payment_methods = PaymentMethod::class;
        $default_delivery_method = DeliveryMethod::Delivery->value;

        if (count($skus)) {
            $recently_viewed = new Collection();
        } else {
            $rv_cookie = $request->cookie(RecentlyViewedService::COOKIE);
            $recently_viewed = $recentlyViewedService->get($rv_cookie);
        }

        return view('site.pages.cart', compact(
            'skus',
            'total',
            'user',
            'shops',
            'payment_methods',
            'default_delivery_method',
            'recently_viewed',
        ));
    }


    public function update(Request $request): JsonResponse
    {
        $sku_id = intval($request->sku_id);
        $sku_qty = intval($request->sku_qty);
        $get_cost = intval($request->get_cost);

        $response = $this->cartService->updateCart($sku_id, $sku_qty, $get_cost);

        return response()->json($response);
    }


    public function destroy(Request $request): JsonResponse
    {
        if ($request->action === 'clear') {
            $response = $this->cartService->clearCart();
            return response()->json($response);
        }

        $response = new \stdClass();
        $response->error_message = 'Wrong request';
        return response()->json($response);
    }
}
