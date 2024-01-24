<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Products\ProductService;
use App\Modules\Promos\PromoService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(PromoService $promoService): View
    {
        $promos = $promoService->getBanners();

        $is_login_page = session()->has('login_page');

        $products = ProductService::getSomeProducts(8);

        $popular_products = ProductService::getSomeProducts(8);

        return view('site.pages.home', compact(
            'is_login_page',
            'promos',
            'products',
            'popular_products',
        ));
    }
}
