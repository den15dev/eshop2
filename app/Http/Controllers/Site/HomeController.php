<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Products\ProductService;
use App\Modules\Promos\PromoService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(
        PromoService $promoService,
        ProductService $productService
    ): View {
        $is_login_page = session()->has('login_page');
        $new_password = session()->has('new_password') ? session('new_password') : null;

        $promos = $promoService->getBanners();

        $skus_discounted = $productService->getDiscounted();
        $skus_latest = $productService->getLatest();
        $skus_popular = $productService->getPopular();

        return view('site.pages.home', compact(
            'is_login_page',
            'new_password',
            'promos',
            'skus_discounted',
            'skus_latest',
            'skus_popular',
        ));
    }
}
