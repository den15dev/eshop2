<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Categories\CategoryService;
use App\Modules\Products\ComparisonService;
use App\Modules\Products\ProductService;
use Illuminate\View\View;

class ComparisonController extends Controller
{
    public function __construct(
        private readonly ComparisonService $comparisonService,
    ) {}

    public function index(
        CategoryService $categoryService,
        ProductService $productService,
    ): View {
        $comparisonData = ComparisonService::get();
        $comparison_products = $this->comparisonService->getPageProducts();

        $specs = $categoryService->getSpecs($comparisonData?->category_id);

        $recently_viewed_ids = [3, 9, 17, 18, 21, 25, 27, 28];
        $recently_viewed = $productService->getRecentlyViewed($recently_viewed_ids);

        return view('site.pages.comparison', compact(
            'comparison_products',
            'specs',
            'recently_viewed',
        ));
    }


    public function popup(): View
    {
        $comparisonData = ComparisonService::get();
        $comparison_products = $this->comparisonService->getPopupProducts();
        $is_popup_collapsed = $comparisonData?->is_popup_collapsed;

        return view('site.includes.comparison-popup', compact(
            'is_popup_collapsed',
            'comparison_products',
        ));
    }
}
