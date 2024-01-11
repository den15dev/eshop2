<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Catalog\CatalogService;
use App\Modules\Catalog\Enums\ProductSorting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CatalogController extends Controller
{
    public function index(
        Request $request,
        CatalogService $catalogService,
        string $category
    ) {
        $catalog_prefs_arr = json_decode($request->cookie(CatalogService::PREF_COOKIE)) ?? [ProductSorting::New->value, 12, 1];

        $sorting_list = $catalogService->getProductSorting($catalog_prefs_arr[0]);
        $per_page_list = $catalogService->getProductsPerPage(intval($catalog_prefs_arr[1]));

        $prefs = new \stdClass();
        $prefs->sorting = $sorting_list;
        $prefs->sorting_active = $sorting_list->firstWhere('is_active', true);
        $prefs->per_page = $per_page_list;
        $prefs->per_page_active = $per_page_list->firstWhere('is_active', true);
        $prefs->layout = intval($catalog_prefs_arr[2]);


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

        $breadcrumb = new \stdClass();
        $breadcrumb->active = true;
        $breadcrumb->parts = [
            ['url' => '#', 'text' => 'Компьютеры и периферия'],
            ['url' => '#', 'text' => 'Крупная бытовая техника'],
            ['url' => '#', 'text' => 'Профессиональные и строительные пылесосы'],
        ];


        $products = new Collection([]);
        $discounts = [0, 0, 5, 10, 0, 0, 0, 5, 0, 5, 0, 10, 0, 0];
        for ($i = 1; $i <= 12; $i++) {
            $product = new \stdClass();
            $product->id = $i;
            $product->name = 'Материнская плата MSI MPG B760I EDGE WIFI DDR4';
            $product->slug = 'processor-amd-ryzen-5-5600x-box';
            $product->category_slug = 'cpu';
            $product->category_id = 6;
            $product->short_descr = 'LGA 1700, 8P x 2.1 ГГц, 8E x 1.5 ГГц, L2 - 24 МБ, L3 - 30 МБ, 2хDDR4, DDR5-5600 МГц, TDP 219 Вт';

            $product->discount_prc = $discounts[$i];
            $product->price = 60490;
            if ($product->discount_prc) {
                $product->final_price = number_format($product->price * (100 - $product->discount_prc)/100, 0, ',', ' ');
            } else {
                $product->final_price = number_format($product->price, 0, ',', ' ');
            }

            $product->rating = 3.85;
            $product->vote_num = 208;

            $products->push($product);
        }


        $recently_viewed = new Collection([]);
        for ($i = 1; $i <= 8; $i++) {
            $product = new \stdClass();
            $product->id = $i;
            $product->name = 'Материнская плата MSI MPG B760I EDGE WIFI DDR4';
            $product->slug = 'processor-amd-ryzen-5-5600x-box';
            $product->category_slug = 'cpu';
            $product->category_id = 6;
            $product->short_descr = 'LGA 1700, 8P x 2.1 ГГц, 8E x 1.5 ГГц, L2 - 24 МБ, L3 - 30 МБ, 2хDDR4, DDR5-5600 МГц, TDP 219 Вт';

            $product->discount_prc = $discounts[$i];
            $product->price = 60490;
            if ($product->discount_prc) {
                $product->final_price = number_format($product->price * (100 - $product->discount_prc)/100, 0, ',', ' ');
            } else {
                $product->final_price = number_format($product->price, 0, ',', ' ');
            }

            $product->rating = 3.85;
            $product->vote_num = 209;

            $recently_viewed->push($product);
        }



//        Mail::to('dendangler@gmail.com')->send(new SomeHappen());
/*
        session()->flash('message', [
            'type' => 'warning',
            'content' => 'Адрес электронной почты успешно подтверждён.',
            'align' => 'center',
        ]);
*/

        return view('site.pages.catalog', compact(
            'breadcrumb',
            'prefs',
            'filter_specs',
            'products',
            'recently_viewed',
            'price_range',
            'brands'
        ));
    }


    public function setLayout(Request $request)
    {
        $validated = $request->validate([
            'sort' => 'required|max:20',
            'per_page' => 'required|numeric',
            'layout' => 'required|numeric',
        ]);

        $prefs = json_encode([
            $validated['sort'],
            $validated['per_page'],
            $validated['layout'],
        ]);

        $cookie = cookie()->forever(CatalogService::PREF_COOKIE, $prefs);

        return back()->withCookie($cookie);
    }
}
