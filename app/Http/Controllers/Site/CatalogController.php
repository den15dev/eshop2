<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Support\Collection;

class CatalogController extends Controller
{
    public function index(string $category)
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

        $price_range = ['12 499', '56 499'];

        $brand_names = [
            'AMD',
            'Intel',
            'Nvidia',
            'Gigabyte'
        ];

        $brands = new Collection([]);

        foreach ($brand_names as $ind => $name) {
            $brand = new \stdClass();
            $brand->id = $ind;
            $brand->name = $name;
            $brand->product_num = rand(2, 40);
            $brands->push($brand);
        }

//        $def_lang = Language::where('id', 'ru')->first();

        return view('site.pages.catalog', compact('filter_specs', 'price_range', 'brands'));
    }
}
