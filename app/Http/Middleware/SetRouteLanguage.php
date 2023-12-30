<?php

namespace App\Http\Middleware;

use App\Modules\Languages\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetRouteLanguage
{
    private string|null $prefix;
    private string $cur_lang;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->prefix = Language::getRoutePrefix();
        $this->cur_lang = app()->getLocale();

        if (config('app.lang_url_priority')) {
            return $this->handleWithURLPriority($request, $next);
        }
        return $this->handleWithLanguagePriority($request, $next);
    }


    private function handleWithLanguagePriority(Request $request, Closure $next): Response
    {
        if ($this->prefix === $this->cur_lang) {
            return $next($request);
        }

        return $this->redirectToLang($this->cur_lang);
    }


    private function handleWithURLPriority(Request $request, Closure $next): Response
    {
        if ($this->prefix && $this->prefix !== $this->cur_lang) {
            Language::setLocale($this->prefix);
        }

        if (!$this->prefix) {
            return $this->redirectToLang($this->cur_lang);
        }

        return $next($request);
    }


    private function redirectToLang($lang_id)
    {
        $url = str_replace(url('/'), '', url()->current());
        $url = Language::buildURL($url, $lang_id);

        if (session()->has('message')) {
            session()->flash('message', session('message'));
        }

        return redirect($url);
    }
}
