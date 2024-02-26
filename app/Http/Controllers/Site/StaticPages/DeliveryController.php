<?php

namespace App\Http\Controllers\Site\StaticPages;

use App\Http\Controllers\Controller;
use App\Modules\StaticPages\Models\StaticPage;
use Illuminate\View\View;

class DeliveryController extends Controller
{
    public function __invoke(StaticPage $staticPage): View
    {
        $params = $staticPage->getParams('delivery');

        return view('site.pages.static.delivery', compact('params'));
    }
}
