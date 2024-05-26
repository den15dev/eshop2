<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Modules\Categories\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.pages.categories.index');
    }


    public function edit(int $id)
    {
        $category = Category::with('specifications')->find($id);

        return view('admin.pages.categories.edit', compact('category'));
    }
}
