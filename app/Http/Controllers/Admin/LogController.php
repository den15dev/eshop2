<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Log\LogService;
use App\Http\Controllers\Controller;
use App\Modules\Common\CommonService;
use Illuminate\View\View;

class LogController extends Controller
{
    public function index(): View
    {
        $log = LogService::getLog();
        $current_time = now()->tz(CommonService::$timezone)->format('H:i:s');

        return view('admin.pages.log', compact(
            'log',
            'current_time',
        ));
    }
}
