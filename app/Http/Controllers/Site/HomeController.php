<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
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

        $products = new Collection([]);
        for ($i = 1; $i <= 9; $i++) {
            $product = new \stdClass();
            $product->id = $i;
            $product->name = 'Материнская плата MSI MPG B760I EDGE WIFI DDR4';
            $product->slug = 'processor-amd-ryzen-5-5600x-box';
            $product->category_slug = 'cpu';
            $product->category_id = 6;
            $product->short_descr = 'LGA 1700, 8P x 2.1 ГГц, 8E x 1.5 ГГц, L2 - 24 МБ, L3 - 30 МБ, 2хDDR4, DDR5-5600 МГц, TDP 219 Вт';
            $product->discount_prc = '5';
            $product->price = '60490';
            $product->final_price = '57465';
            $product->currency_id = 'rub';
            $product->rating = 3.85;
            $product->vote_num = 208;

            $products->push($product);
        }

        $popular_products = new Collection([]);
        for ($i = 1; $i <= 2; $i++) {
            $product = new \stdClass();
            $product->id = $i;
            $product->name = 'Материнская плата MSI MPG B760I EDGE WIFI DDR4';
            $product->slug = 'processor-amd-ryzen-5-5600x-box';
            $product->category_slug = 'cpu';
            $product->category_id = 6;
            $product->short_descr = 'LGA 1700, 8P x 2.1 ГГц, 8E x 1.5 ГГц, L2 - 24 МБ, L3 - 30 МБ, 2хDDR4, DDR5-5600 МГц, TDP 219 Вт';
            $product->discount_prc = '5';
            $product->price = '60490';
            $product->final_price = '57465';
            $product->rating = 3.85;
            $product->vote_num = 208;

            $popular_products->push($product);
        }

        return view('site.pages.home', compact(
            'is_login_page',
            'products',
            'popular_products',
        ));
    }
}
