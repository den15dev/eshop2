<?php

namespace App\Http\Middleware;

use App\Modules\Favorites\FavoriteService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetFavorites
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $favoriteCookie = $request->cookie(FavoriteService::COOKIE);

        if ($favoriteCookie) {
            FavoriteService::set(json_decode($favoriteCookie));
        }

        return $next($request);
    }
}
