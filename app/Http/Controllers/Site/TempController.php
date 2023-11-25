<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TempController extends Controller
{
    public function temp(): View
    {
        return view('site.pages.temp');
    }
}
