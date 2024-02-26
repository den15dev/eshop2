<?php

namespace App\Http\Controllers\Site\StaticPages;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class WarrantyController extends Controller
{
    public function __invoke(): View
    {
        return view('site.pages.static.warranty');
    }
}
