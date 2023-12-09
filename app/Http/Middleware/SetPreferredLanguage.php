<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPreferredLanguage
{
    /**
     * Check and set user preferred language according to:
     * 1. "Lang" cookie;
     * 2. Accept-Language request header.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $languages = Language::getActive();

        $cookie_lang_id = $request->cookie('lang');

        if ($cookie_lang_id && $languages->contains('id', $cookie_lang_id)) {
            $pref_lang_id = $cookie_lang_id;
        } else {
            $pref_lang_id = $request->getPreferredLanguage($languages->pluck('id')->toArray());
        }

        if ($pref_lang_id) {
            Language::setLocale($pref_lang_id);
        }

        return $next($request);
    }
}
