<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Products\FavoriteService;
use App\Modules\Products\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(
        FavoriteService $favoriteService,
        ProductService $productService,
    ): View {
        $products = $favoriteService->getFavoriteProducts();

        $recently_viewed_ids = [3, 9, 17, 18, 21, 25, 27, 28];
        $recently_viewed = $productService->getRecentlyViewed($recently_viewed_ids);

        return view('site.pages.favorites', compact(
            'products',
            'recently_viewed'
        ));
    }


    public function store(Request $request): JsonResponse
    {
        $user_id = Auth::id();
        $product_id = intval($request->id);

        return response()->json([
            'auth' => (bool) $user_id,
            'num' => FavoriteService::count(),
        ]);
    }
}
