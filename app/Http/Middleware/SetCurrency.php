<?php

namespace App\Http\Middleware;

use App\Modules\Currencies\CurrencyService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrency
{
    public function handle(Request $request, Closure $next): Response
    {
        CurrencyService::setCurrency($request->cookie(CurrencyService::COOKIE));

        return $next($request);
    }
}
