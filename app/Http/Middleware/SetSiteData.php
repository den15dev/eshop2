<?php

namespace App\Http\Middleware;

use App\Modules\Cart\CartService;
use App\Modules\Catalog\ComparisonService;
use App\Modules\Favorites\FavoriteService;
use App\Modules\Orders\OrderService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSiteData
{
    public function handle(Request $request, Closure $next): Response
    {
        $excluded = [
            'translations',
        ];
        $route = $request->route()->getName();

        if (!in_array($route, $excluded)) {
            // Cart
            CartService::setCart($request->cookie(CartService::COOKIE));

            // Orders
            OrderService::setOrderIds($request->cookie(OrderService::COOKIE));

            // Favorites
            FavoriteService::setFavorites($request->cookie(FavoriteService::COOKIE));

            // Comparison
            $comparisonCookie = $request->cookie(ComparisonService::COOKIE);
            if ($comparisonCookie) {
                ComparisonService::set(json_decode($comparisonCookie));
            }
        }

        return $next($request);
    }
}
