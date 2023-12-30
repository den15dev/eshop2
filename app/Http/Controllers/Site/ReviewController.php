<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        return view('site.pages.reviews');
    }
}
