<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\CatalogService;
use App\Modules\Catalog\FilterService;
use App\Modules\Categories\CategoryService;
use App\Modules\Products\ProductService;
use App\Modules\Products\RecentlyViewedService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(
        Request $request,
        CategoryService $categoryService,
        CatalogService $catalogService,
        FilterService $filterService,
        RecentlyViewedService $recentlyViewedService,
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

        $db_query = $filterService->buildFilteredQuery($category->id, $request->query());
        $db_query = $filterService->sortQuery($db_query, $prefs->sorting_active);

        $price_range = $filterService->getPriceRange($db_query);
        $filter_brands = $filterService->getBrandsByCategory($category->id, $request->query('brands'));
        $filter_specs = $filterService->getSpecs($category->id, $request->query('specs'));

        $products = $db_query->paginate($prefs->per_page_num);

        $rv_cookie = $request->cookie(RecentlyViewedService::COOKIE);
        $recently_viewed = $recentlyViewedService->get($rv_cookie);

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
