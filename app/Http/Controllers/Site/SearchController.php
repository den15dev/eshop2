<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\CatalogService;
use App\Modules\Catalog\FilterService;
use App\Modules\Products\ProductService;
use App\Modules\Products\SearchService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(
        private readonly SearchService $searchService,
        private readonly ProductService $productService,
        private readonly CatalogService $catalogService,
        private readonly FilterService $filterService,
    ) {}


    public function index(Request $request): View
    {
        $search_query = $request->query('query');

        $prefs_cookie = $request->cookie(CatalogService::PREF_COOKIE);
        $prefs = $this->catalogService->getPreferences($prefs_cookie);

        $price_range = $this->filterService->getPriceRange();
        $filter_brands = $this->filterService->getBrandsBySearchQuery($search_query);
        $filter_categories = $this->filterService->getCategoriesBySearchQuery($search_query);

        $products = $this->searchService->getResultsPage($search_query);

        $recently_viewed_ids = [3, 9, 17, 18, 21, 25, 27, 28];
        $recently_viewed = $this->productService->getRecentlyViewed($recently_viewed_ids);

        $filters = 'search';

        return view('site.pages.search', compact(
            'search_query',
            'prefs',
            'price_range',
            'filter_brands',
            'filter_categories',
            'filters',
            'products',
            'recently_viewed',
        ));
    }


    public function autocomplete(Request $request): View
    {
        $query = $request->query('query');

        return view('site.pages.search-autocomplete');
    }
}
