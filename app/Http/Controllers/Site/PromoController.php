<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Promos\PromoService;
use Illuminate\View\View;

class PromoController extends Controller
{
    public function show(
        PromoService $promoService,
        string $promo_slug_id
    ): View {
        $slug_id = parse_slug($promo_slug_id);
        $promo_id = $slug_id[1];
        $promo_slug = $slug_id[0];

        $promo = $promoService->getPromo($promo_id, $promo_slug);
        abort_unless((bool) $promo, 404);

        $skus = $promoService->getPromoSkus($promo_id);

        return view('site.pages.promo', compact(
            'promo',
            'skus',
        ));
    }
}
