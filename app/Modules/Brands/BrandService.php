<?php

namespace App\Modules\Brands;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BrandService
{
    public static function getTempBrands(): Collection
    {
        $number = 5;
        $brands = new Collection();

        $names = [
            'AMD',
            'Intel',
            'Gigabyte',
            'Super Flower',
            'ASUS',
        ];

        for ($i = 0; $i < $number; $i++) {
            $brand = new \stdClass();

            $brand->id = $i + 1;
            $brand->name = $names[$i];
            $brand->slug = str($names[$i])->slug()->value();
            $brand->url = route('brand', [$brand->slug]);
            $brand->image_url = asset('storage/images/brands/' . $brand->id . '/' . $brand->slug . '.svg');

            $brands->push($brand);
        }

        return $brands;
    }


    public function getSomeBrands(int|array $ids): Collection
    {
        $tempBrands = self::getTempBrands();
        $tempNum = $tempBrands->count();

        $count = is_array($ids) ? count($ids) : $ids;

        $brands = new Collection();
        for ($i = 0; $i < $count; $i++) {
            $brand = $tempBrands[$i % $tempNum];
            if (is_array($ids)) {
                $brand->id = $ids[$i];
                $brand->url = route('brand', [$brand->category_slug, $brand->slug . '-' . $ids[$i]]);
            }
            $brands->push($brand);
        }

        return $brands;
    }


    public function getBrand(string $slug): \stdClass
    {
        $tempBrands = self::getTempBrands();

        $brand = $tempBrands->firstWhere('slug', $slug);
        $brand->description = fake()->realText(600);

        return $brand;
    }


    public function getBrandCategories(int $brand_id): Collection
    {
        /*return DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->selectRaw('categories.name, categories.slug, count(*) as products_total')
            ->where('brand_id', $brand_id)
            ->groupBy('category_id')
            ->get();*/

        $brand_categories = new Collection();

        $category_arr = [
            [
                'name' => 'CPU',
                'slug' => 'cpu',
            ],
            [
                'name' => 'Webcams',
                'slug' => 'webcams',
            ],
            [
                'name' => 'Laptop backpacks',
                'slug' => 'laptop-backpacks',
            ],
        ];

        foreach ($category_arr as $category) {
            $cat = new \stdClass();
            $cat->name = $category['name'];
            $cat->slug = $category['slug'];
            $cat->level = 2;
            $cat->product_count = fake()->numberBetween(5, 300);
            $brand_categories->push($cat);
        }

        return $brand_categories;
    }
}