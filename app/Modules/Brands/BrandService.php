<?php

namespace App\Modules\Brands;

use Illuminate\Database\Eloquent\Collection;

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


    public function getOneBrand(int $id): \stdClass
    {
        $tempBrands = self::getTempBrands();
        $tempNum = $tempBrands->count();
        $inner_id = ($id - 1) % $tempNum + 1;

        $brand = $tempBrands->firstWhere('id', $inner_id);
        $brand->description = fake()->realText(300);

        return $tempBrands->firstWhere('id', $inner_id);
    }
}