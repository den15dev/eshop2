<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProtectFromAdminDemoEditing
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->user()->isAdmin()) {
            return $next($request);
        }

        abort(403);
    }
}
