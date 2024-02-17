<?php

namespace App\Modules\Catalog;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FilterService
{
    private function getSomeBrands(): Collection
    {
        $brand_names = [
            'AMD',
            'Intel',
            'Nvidia',
            'Gigabyte'
        ];

        $brands = new Collection([]);

        foreach ($brand_names as $ind => $name) {
            $brand = new \stdClass();
            $brand->id = $ind + 1;
            $brand->name = $name;
            $brand->product_num = rand(2, 40);
            $brands->push($brand);
        }

        return $brands;
    }


    private function getSomeCategories(): Collection
    {
        $category_names = [
            'Motherboards',
            'VR Headsets And Covers',
            'Laptop backpacks',
            'Professional And Construction Vacuums',
            'Cables And Adapters',
        ];

        $categories = new Collection([]);

        foreach ($category_names as $ind => $name) {
            $category = new \stdClass();
            $category->id = $ind + 1;
            $category->name = $name;
            $category->product_num = rand(2, 40);
            $categories->push($category);
        }

        return $categories;
    }


    public function getBrandsByCategory(int $category_id): Collection
    {
        return $this->getSomeBrands();
    }


    public function getBrandsBySearchQuery(string $query): Collection
    {
        return $this->getSomeBrands();
    }


    public function getPriceRange(/*Builder $db_query*/): array
    {
        $price_range = ['12 499', '56 499'];

        return $price_range;
    }


    public function getCategoriesBySearchQuery(string $query): Collection
    {
        return $this->getSomeCategories();
    }


    public function getSpecs(int $category_id): Collection
    {
        $spec_names = [
            ['Серия', 5],
            ['Разъём подключения последовательного чтения', 6],
            ['Общее количество ядер', 10],
            ['Тип памяти', 5],
            ['Тепловыделение (TDP)', 8],
        ];

        $spec_val_names = [
            'AMD Ryzen 5',
            'AMD Ryzen 7',
            'AMD Ryzen 9',
            'Intel Core i5',
            'Intel Core i7',
            'Intel Core i9',
            'Nvidia GeForce 3060',
            'Nvidia GeForce 3070',
            'Nvidia GeForce 3080',
            'AMD Radeon 6700',
            'AMD Radeon 6800 XT',
            'AMD Radeon 6900 XTX',
        ];

        $filter_specs = new Collection([]);

        foreach ($spec_names as $ind => $spec_arr) {
            $spec = new \stdClass();
            $spec->name = $spec_arr[0];
            $spec->id = $ind + 1;

            $spec_values = [];
            for ($i = 0; $i < $spec_arr[1]; $i++) {
                $name = $spec_val_names[$i];
                $qty = rand(2, 40);
                $spec_values[$name] = $qty;
            }
            $spec->values = $spec_values;

            $filter_specs->push($spec);
        }

        return $filter_specs;
    }
}