<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkuController extends Controller
{
    public function edit(int $id): View
    {
        $sku = Sku::find($id);

        return view('admin.pages.skus.edit', compact('sku'));
    }


    public function create(): View
    {
        return view('admin.pages.skus.create');
    }
}
