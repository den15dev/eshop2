<?php

namespace App\Http\Middleware;

use App\Modules\Currencies\CurrencyService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrency
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currencies = CurrencyService::getAll();

        $cookie_curr_id = $request->cookie('curr');

        if ($cookie_curr_id && $currencies->contains('id', $cookie_curr_id)) {
            CurrencyService::setCurrency($cookie_curr_id);
        } else {
            $lang = app()->getLocale();
            $curr_id = $currencies->firstWhere('language_id', $lang)?->id;
            if ($curr_id) {
                CurrencyService::setCurrency($curr_id);
            }
        }

        return $next($request);
    }
}
