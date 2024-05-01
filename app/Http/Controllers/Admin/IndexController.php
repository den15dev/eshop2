<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __invoke(Request $request): View
    {
        $route_suffix = substr($request->route()->getName(), strlen('admin.'));
        $table_name = $request->query('table') ?? $route_suffix;

        return view('admin.pages.' . $table_name . '.index');
    }


    public function search(Request $request): View
    {
        return view('admin.includes.index-table');
    }
}
