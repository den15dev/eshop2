<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\CatalogService;
use App\Modules\Catalog\FilterService;
use App\Modules\Catalog\SearchService;
use App\Modules\Products\RecentlyViewedService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __construct(
        private readonly SearchService $searchService,
        private readonly RecentlyViewedService $recentlyViewedService,
        private readonly CatalogService $catalogService,
        private readonly FilterService $filterService,
    ) {}


    public function index(Request $request): View
    {
        $search_query = $request->query('query');

        $prefs_cookie = $request->cookie(CatalogService::PREF_COOKIE);
        $prefs = $this->catalogService->getPreferences($prefs_cookie);

        $db_query = $this->filterService->buildSearchDBQuery($search_query, $request->query());
        $db_query = $this->filterService->sortQuery($db_query, $prefs->sorting_active);

        $filters = 'search';
        $price_range = $this->filterService->getPriceRange($db_query);
        $filter_brands = $this->filterService->getBrandsBySearchQuery($search_query, $request->query('brands'));
        $filter_categories = $this->filterService->getCategories($search_query, $request->query('categories'));
        $filter_reset_url = route('search', ['query' => $search_query]);

        $skus = $db_query->paginate($prefs->per_page_num);

        $rv_cookie = $request->cookie(RecentlyViewedService::COOKIE);
        $recently_viewed = $this->recentlyViewedService->get($rv_cookie);

        return view('site.pages.search', compact(
            'search_query',
            'prefs',
            'filters',
            'price_range',
            'filter_brands',
            'filter_categories',
            'filter_reset_url',
            'skus',
            'recently_viewed',
        ));
    }


    public function dropdown(Request $request): View
    {
        $search_query = $request->query('query');

        $total = $this->searchService->countDropdownProductResults($search_query);
        $brands = $this->searchService->getDropdownBrands($search_query);
        $skus = $this->searchService->getDropdownSkus($search_query);

        return view('site.pages.search-dropdown', compact(
            'search_query',
            'total',
            'brands',
            'skus',
        ));
    }
}
