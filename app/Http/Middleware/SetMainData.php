<?php

namespace App\Http\Middleware;

use App\Modules\Cart\CartService;
use App\Modules\Catalog\ComparisonService;
use App\Modules\Favorites\FavoriteService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetMainData
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cart
        CartService::setCart($request->cookie(CartService::COOKIE));

        // Favorites
        $favoriteCookie = $request->cookie(FavoriteService::COOKIE);
        if ($favoriteCookie) {
            FavoriteService::set(json_decode($favoriteCookie));
        }

        // Comparison
        $comparisonCookie = $request->cookie(ComparisonService::COOKIE);
        if ($comparisonCookie) {
            ComparisonService::set(json_decode($comparisonCookie));
        }

        return $next($request);
    }
}
