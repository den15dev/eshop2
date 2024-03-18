<?php

namespace App\Http\Middleware;

use App\Modules\Catalog\ComparisonService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetComparisonData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $comparisonCookie = $request->cookie(ComparisonService::COOKIE);

        if ($comparisonCookie) {
            ComparisonService::set(json_decode($comparisonCookie));
        }

        return $next($request);
    }
}
