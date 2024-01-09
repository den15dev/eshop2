<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(string $category_slug, string $product_slug): View
    {
        $breadcrumb = new \stdClass();
        $breadcrumb->active = false;
        $breadcrumb->parts = [
            ['url' => '#', 'text' => 'Компьютеры и периферия'],
            ['url' => '#', 'text' => 'Крупная бытовая техника'],
            ['url' => route('catalog', ['cpu']), 'text' => 'Профессиональные и строительные пылесосы'],
        ];


        $product = new \stdClass();
        $product->id = 38;
        $product->name = 'Материнская плата ASUS TUF GAMING B660M-PLUS WIFI D4';
        $product->slug = 'materinskaia-plata-asus-tuf-gaming-b660m-plus-wifi-d4';
        $product->category_slug = 'cpu';

        $product->discount_prc = 5;
        $product->price = 60490;
        if ($product->discount_prc) {
            $product->final_price = number_format($product->price * (100 - $product->discount_prc)/100, 0, ',', ' ');
        } else {
            $product->final_price = $product->price;
        }
        $product->price = number_format($product->price, 0, ',', ' ');

        $product->rating = 3.85;
        $product->vote_num = 208;

        $product->images = ['01', '02', '03', '04'];


        $specs = new Collection([]);
        $specs_data = [
            ['Серия', 1, 'AMD Ryzen 5', ''],
            ['Модель', 2, '5600X', ''],
            ['Сокет', 3, 'AM4', ''],
            ['Год релиза', 4, '2020', ''],
            ['Ядро', 5, 'AMD Vermeer', ''],
            ['Техпроцесс', 6, 'TSMC 7FF', ''],
            ['Общее количество ядер', 7, '6', ''],
            ['Максимальное число потоков', 8, '12', ''],
            ['Количество производительных ядер', 9, '6', ''],
            ['Количество энергоэффективных ядер', 10, 'нет', ''],
            ['Объем кэша L2', 11, '3', 'МБ'],
            ['Объем кэша L3', 12, '32', 'МБ'],
            ['Базовая частота процессора', 13, '3.7', 'ГГц'],
            ['Максимальная частота в турбо режиме', 14, '4.6', 'ГГц'],
            ['Свободный множитель', 15, 'есть', ''],
            ['Тип памяти', 16, 'DDR4', ''],
            ['Максимально поддерживаемый объем памяти', 17, '128', 'ГБ'],
            ['Количество каналов', 18, '2', ''],
            ['Максимальная частота оперативной памяти', 19, '3200', 'МГц'],
            ['Поддержка режима ECC', 20, 'нет', ''],
            ['Тепловыделение (TDP)', 21, '65', 'Вт'],
            ['Максимальная температура процессора', 22, '95', '°C'],
            ['Система охлаждения в комплекте', 23, 'есть', ''],
            ['Интегрированное графическое ядро', 24, 'нет', ''],
            ['Встроенный контроллер PCI Express', 25, 'PCI-E', '4.0'],
            ['Число линий PCI Express', 26, '20', ''],
        ];
        foreach ($specs_data as $spec) {
            $spec_obj = new \stdClass();
            $spec_obj->name = $spec[0];
            $spec_obj->sort = $spec[1];
            $spec_obj->spec_value = $spec[2];
            $spec_obj->units = $spec[3];
            $specs->push($spec_obj);
        }
        $product->specifications = $specs;


        $discounts = [0, 0, 5, 10, 0, 0, 0, 5, 0, 5, 0, 10, 0, 0];
        $recently_viewed = new Collection([]);
        for ($i = 1; $i <= 8; $i++) {
            $temp_product = new \stdClass();
            $temp_product->id = $i;
            $temp_product->name = 'Материнская плата MSI MPG B760I EDGE WIFI DDR4';
            $temp_product->slug = 'processor-amd-ryzen-5-5600x-box';
            $temp_product->category_slug = 'cpu';
            $temp_product->category_id = 6;
            $temp_product->short_descr = 'LGA 1700, 8P x 2.1 ГГц, 8E x 1.5 ГГц, L2 - 24 МБ, L3 - 30 МБ, 2хDDR4, DDR5-5600 МГц, TDP 219 Вт';

            $temp_product->discount_prc = $discounts[$i];
            $temp_product->price = 60490;
            if ($temp_product->discount_prc) {
                $temp_product->final_price = number_format($temp_product->price * (100 - $temp_product->discount_prc)/100, 0, ',', ' ');
            } else {
                $temp_product->final_price = $temp_product->price;
            }
            $temp_product->price = number_format($temp_product->price, 0, ',', ' ');

            $temp_product->rating = 3.85;
            $temp_product->vote_num = 208;

            $recently_viewed->push($temp_product);
        }


        return view('site.pages.product', compact(
            'breadcrumb',
            'product',
            'recently_viewed',
        ));
    }
}
