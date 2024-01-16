<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Products\ProductService;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        /*
         * $out = DB::table('product_specification')
            ->whereIn('spec_value->ru', ['нет', 'DDR4'])
            ->get();
        */

        $is_login_page = session()->has('login_page');

        $products = ProductService::getSomeProducts(8);

        $popular_products = ProductService::getSomeProducts(8);


        return view('site.pages.home', compact(
            'is_login_page',
            'products',
            'popular_products',
        ));
    }
}
