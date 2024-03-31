<?php

namespace App\Http\Middleware;

use App\Modules\Languages\LanguageService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPreferredLanguage
{
    /**
     * Check and set user preferred language according to:
     * 1. "Lang" cookie;
     * 2. Accept-Language request header.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $languages = LanguageService::getActive();

        $cookie_lang_id = $request->cookie('lang');

        if ($cookie_lang_id && $languages->contains('id', $cookie_lang_id)) {
            $pref_lang_id = $cookie_lang_id;
        } else {
            $pref_lang_id = $request->getPreferredLanguage($languages->pluck('id')->toArray());
        }

        if ($pref_lang_id) {
            LanguageService::setLocale($pref_lang_id);
        }

        return $next($request);
    }
}
