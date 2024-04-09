<?php

namespace App\Http\Middleware;

use App\Modules\Cart\CartService;
use App\Modules\Favorites\FavoriteService;
use App\Modules\Orders\OrderService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class MoveUserDataFromCookies
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly FavoriteService $favoriteService,
        private readonly OrderService $orderService,
    ){}

    /**
     * During authentication or registering, if the user
     * has a cart, favorites, or orders in his cookies,
     * move all this data into the database and remove
     * that cookies.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Auth::check()) {
            $cartCookie = $request->cookie(CartService::COOKIE);
            if ($cartCookie) {
                $this->cartService->moveCartFromCookie(json_decode($cartCookie));
                Cookie::expire(CartService::COOKIE);
            }

            $favoritesCookie = $request->cookie(FavoriteService::COOKIE);
            if ($favoritesCookie) {
                $this->favoriteService->moveFavoritesFromCookie(json_decode($favoritesCookie));
                Cookie::expire(FavoriteService::COOKIE);
            }

            $ordersCookie = $request->cookie(OrderService::COOKIE);
            if ($ordersCookie) {
                $this->orderService->moveOrdersFromCookie(json_decode($ordersCookie));
                Cookie::expire(OrderService::COOKIE);
            }
        }

        return $response;
    }
}
