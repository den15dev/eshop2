<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Favorites\FavoriteService;
use App\Modules\Products\RecentlyViewedService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function __construct(
        private readonly FavoriteService $favoriteService
    ){}


    public function index(
        Request $request,
        RecentlyViewedService $recentlyViewedService,
    ): View {
        $fav_query = $this->favoriteService->getFavoriteSkus();
        $skus = $fav_query->paginate(15);

        $rv_cookie = $request->cookie(RecentlyViewedService::COOKIE);
        $recently_viewed = $recentlyViewedService->get($rv_cookie);

        return view('site.pages.favorites', compact(
            'skus',
            'recently_viewed'
        ));
    }


    public function store(Request $request): JsonResponse
    {
        $response = $this->favoriteService->updateFavorites(intval($request->id));

        return response()->json($response);
    }
}
