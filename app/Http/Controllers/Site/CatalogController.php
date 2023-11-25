<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function index(string $category)
    {
        return view('site.pages.catalog');
    }
}
