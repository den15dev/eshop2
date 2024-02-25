<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Shops\ShopService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function __construct(
        private readonly ShopService $shopService,
    ) {}


    public function __invoke(): View
    {
        $shops = $this->shopService->getAll();

        $shops_json = $this->shopService->getJSON($shops);

        return view('site.pages.shops', compact(
            'shops',
            'shops_json',
        ));
    }
}
