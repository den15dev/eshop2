<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\ComparisonService;
use App\Modules\Products\RecentlyViewedService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComparisonController extends Controller
{
    public function __construct(
        private readonly ComparisonService $comparisonService,
    ) {}

    public function index(
        Request $request,
        RecentlyViewedService $recentlyViewedService,
    ): View {
        $comparison_skus = $this->comparisonService->getPageSkus();
        $specs = $this->comparisonService->getPageSpecs();

        $rv_cookie = $request->cookie(RecentlyViewedService::COOKIE);
        $recently_viewed = $recentlyViewedService->get($rv_cookie);

        return view('site.pages.comparison', compact(
            'comparison_skus',
            'specs',
            'recently_viewed',
        ));
    }


    public function popup(): View
    {
        $comparisonData = ComparisonService::get();
        $comparison_skus = $this->comparisonService->getPopupSkus();
        $is_popup_collapsed = $comparisonData?->is_popup_collapsed;

        return view('site.includes.comparison-popup', compact(
            'is_popup_collapsed',
            'comparison_skus',
        ));
    }
}
