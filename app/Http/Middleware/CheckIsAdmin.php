<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.admin_demo') || Auth::user()?->isAdmin()) {
            return $next($request);
        }

        abort(404);
    }
}
