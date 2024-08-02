<?php

namespace App\Http\Middleware;

use App\Admin\IndexTable\IndexTableService;
use App\Modules\Common\CommonService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetAdminData
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $excluded = ['admin.translations'];
        $route = $request->route()->getName();

        if (!in_array($route, $excluded)) {
            $per_page_cookie = $request->cookie(IndexTableService::PER_PAGE_COOKIE);
            if ($per_page_cookie) {
                IndexTableService::$per_page = intval($per_page_cookie);
            }
        }

        $tz = $request->cookie('tz');
        if (isValidTimezoneId($tz)) CommonService::$timezone = $tz;

        return $next($request);
    }
}
