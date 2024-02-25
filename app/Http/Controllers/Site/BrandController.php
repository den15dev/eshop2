<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Brands\BrandService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function show(
        BrandService $brandService,
        string $slug,
    ): View {
        $brand = $brandService->getBrand($slug);

        $brand_categories = $brandService->getBrandCategories($brand->id);

        return view('site.pages.brand', compact(
            'brand',
            'brand_categories',
        ));
    }
}
