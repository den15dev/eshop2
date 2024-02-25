<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Categories\CategoryService;
use App\Modules\Products\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(
        CategoryService $categoryService,
        ProductService $productService,
        string $category_slug,
        string $product_slug_id
    ): View {

        $category = $categoryService->getCategoryBySlug($category_slug);
        abort_if(!$category, 404);
        $breadcrumb = $categoryService->getBreadcrumb($category, false);

        $slug_id = parse_slug($product_slug_id);
        $product_id = $slug_id[1];
        $product_slug = $slug_id[0];

        $product = $productService->getProduct($product_id);

        $recently_viewed_ids = [3, 9, 17, 18, 21, 25, 27, 28];
        $recently_viewed = $productService->getRecentlyViewed($recently_viewed_ids);


        return view('site.pages.product', compact(
            'breadcrumb',
            'product',
            'recently_viewed',
        ));
    }
}
