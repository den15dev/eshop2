<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Products\ProductService;
use App\Modules\Shops\ShopService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $products = ProductService::getSomeProducts(3);


        $total = new \stdClass();
        $sum = 0;
        $final_sum = 0;
        $is_discounted = false;
        foreach ($products as $product) {
            $sum += $product->price;
            if ($product->discount_prc) {
                $is_discounted = true;
                $final_sum += $product->price * (100 - $product->discount_prc)/100;
            } else {
                $final_sum += $product->price;
            }
        }

        $total->final_sum = number_format($final_sum, 0, ',', ' ');
        $total->sum = $is_discounted ? number_format($sum, 0, ',', ' ') : null;


        $user = Auth::user();

        $shops = ShopService::getSomeShops();


        return view('site.pages.cart', compact(
            'products',
            'total',
            'user',
            'shops',
        ));
    }
}
