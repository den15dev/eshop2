<?php

namespace App\Http\Middleware;

use App\Modules\Cart\CartService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class MoveUserDataFromCookies
{
    public function __construct(
        private readonly CartService $cartService
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
        }

        return $response;
    }
}
