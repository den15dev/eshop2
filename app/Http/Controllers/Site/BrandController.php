<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Brands\BrandService;
use App\Modules\Categories\CategoryService;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function show(
        BrandService $brandService,
        CategoryService $categoryService,
        string $slug,
    ): View {
        $brand = $brandService->getBrand($slug);
        abort_unless((bool) $brand, 404);

        $brand_categories = $categoryService->getCategoriesByBrand($brand->id);

        return view('site.pages.brand', compact(
            'brand',
            'brand_categories',
        ));
    }
}
