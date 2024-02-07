<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Languages\LanguageService;
use App\Modules\Products\ProductService;
use App\Modules\Promos\Models\Promo;
use App\Modules\Promos\PromoService;
use Illuminate\View\View;

class PromoController extends Controller
{
    public function show(
        PromoService $promoService,
        ProductService $productService,
        string $promo_slug_id
    ): View {
        $slug_id = parse_slug($promo_slug_id);
        $promo_id = $slug_id[1];
        $promo_slug = $slug_id[0];

        $promo = Promo::where('id', $promo_id)
            ->where('slug', $promo_slug)
            ->first();

        abort_if(!$promo, 404);

        $promo->images = $promoService->getBannerImages($promo->id, $promo->slug);

        $products = $productService->getSomeProducts(8);

        return view('site.pages.promo', compact(
            'promo',
            'products'
        ));
    }
}
