<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Log\LogService;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class LogController extends Controller
{
    public function index(): View
    {
        $log = LogService::getLog();

        return view('admin.pages.logs', compact('log'));
    }
}
