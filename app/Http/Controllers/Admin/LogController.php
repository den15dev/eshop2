<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Log\LogService;
use App\Http\Controllers\Controller;
use App\Modules\Common\CommonService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LogController extends Controller
{
    public function index(): View
    {
        $log = LogService::getLog();
        $current_time = now()->tz(CommonService::$timezone)->format('H:i:s');
        $is_admin = Auth::user()?->isAdmin();

        return view('admin.pages.log', compact(
            'log',
            'current_time',
            'is_admin',
        ));
    }
}
