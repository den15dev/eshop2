<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Shops\ShopService;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function __invoke(ShopService $shopService): View
    {
        $shops = $shopService->getAll();

        $shops_json = $shopService->getJSON($shops);

        return view('site.pages.stores', compact(
            'shops',
            'shops_json',
        ));
    }
}
