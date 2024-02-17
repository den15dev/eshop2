<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\CatalogService;
use App\Modules\Catalog\FilterService;
use App\Modules\Categories\CategoryService;
use App\Modules\Products\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(
        Request $request,
        CategoryService $categoryService,
        CatalogService $catalogService,
        FilterService $filterService,
        ProductService $productService,
        string $category_slug
    ): View {
        $category = $categoryService->getCategoryBySlug($category_slug);
        abort_if(!$category, 404);

        $breadcrumb = $categoryService->getBreadcrumb($category, true);

        $children = $categoryService->getChildren($category->id);
        if ($children) {
            return view('site.pages.categories', compact(
                'category',
                'breadcrumb',
                'children'
            ));
        }

        $prefs_cookie = $request->cookie(CatalogService::PREF_COOKIE);
        $prefs = $catalogService->getPreferences($prefs_cookie);


        $price_range = $filterService->getPriceRange();
        $filter_brands = $filterService->getBrandsByCategory($category->id);
        $filter_specs = $filterService->getSpecs($category->id);

        $products = $productService->getCatalogProducts($category, 12);

        $recently_viewed_ids = [3, 9, 17, 18, 21, 25, 27, 28];
        $recently_viewed = $productService->getRecentlyViewed($recently_viewed_ids);


//        Mail::to('dendangler@gmail.com')->send(new SomeHappen());
/*
        session()->flash('message', [
            'type' => 'warning',
            'content' => 'Адрес электронной почты успешно подтверждён.',
            'align' => 'center',
        ]);
*/
        $filters = 'catalog';

        return view('site.pages.catalog', compact(
            'category',
            'category_slug',
            'breadcrumb',
            'prefs',
            'filter_specs',
            'filters',
            'products',
            'recently_viewed',
            'price_range',
            'filter_brands',
        ));
    }
}
