<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {

        /*
         * $out = DB::table('product_specification')
            ->whereIn('spec_value->ru', ['нет', 'DDR4'])
            ->get();
        */



        return view('site.pages.home');
    }
}
