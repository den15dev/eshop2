<?php

namespace App\Modules\Brands;

use App\Modules\Brands\Models\Brand;

class BrandService
{
    public function getBrand(string $slug): ?Brand
    {
        return Brand::firstWhere('slug', $slug);
    }
}