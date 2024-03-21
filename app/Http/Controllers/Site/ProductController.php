<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Categories\CategoryService;
use App\Modules\Products\ProductService;
use App\Modules\Products\RecentlyViewedService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(
        Request $request,
        CategoryService $categoryService,
        ProductService $productService,
        RecentlyViewedService $recentlyViewedService,
        string $category_slug,
        string $product_slug_id
    ): View {

        $category = $categoryService->getCategoryBySlug($category_slug);
        abort_if(!$category, 404);
        $breadcrumb = $categoryService->getBreadcrumb($category, false);

        $slug_id = $productService::parseSlug($product_slug_id);
        $sku_id = $slug_id[1];

        $sku = $productService->getSku($sku_id);
        $attributes = $productService->getAttributes($sku->product_id, $sku_id);

        $rv_cookie = $request->cookie(RecentlyViewedService::COOKIE);
        $recently_viewed = $recentlyViewedService->get($rv_cookie, $sku_id);
        $recently_viewed_arr = $recentlyViewedService->update($rv_cookie, $sku_id);
        Cookie::queue(RecentlyViewedService::COOKIE, json_encode($recently_viewed_arr), 1440);

        return view('site.pages.product', compact(
            'breadcrumb',
            'category',
            'sku',
            'attributes',
            'recently_viewed',
        ));
    }
}
