<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserNotificationController extends Controller
{
    public function index(): View
    {
        return view('site.pages.user-notifications');
    }
}
