<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\StaticPages\Models\StaticPage;
use Illuminate\View\View;

class DeliveryController extends Controller
{
    public function __invoke(StaticPage $staticPage): View
    {
        $params = $staticPage->getParams('delivery');

        return view('site.pages.delivery', compact('params'));
    }
}
