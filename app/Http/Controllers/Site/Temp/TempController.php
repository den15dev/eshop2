<?php

namespace App\Http\Controllers\Site\Temp;

use App\Http\Controllers\Controller;
use App\Modules\Languages\Models\Language;
//use App\Modules\Temp_JsonbTest\Models\JsonbProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TempController extends Controller
{
    public function temp(): View
    {
        /*
        $search_str = 'fff';
        $locale = app()->getLocale();

        $firstQuery = Language::select('id')->first();

        $products_jsonb = JsonbProduct::select('id', 'name', 'slug', 'price', 'short_descr')
            ->where('name->' . $locale, 'ilike', '%' . $search_str . '%')
            ->limit(6)
            ->get();

        $products_flat = DB::table('flat_product_translations')
            ->join('flat_products', 'flat_product_id', '=', 'flat_products.id')
            ->selectRaw('flat_products.id, slug, price, name, short_descr')
            ->where('language_id', $locale)
            ->where('name', 'like', '%' . $search_str . '%')
            ->limit(6)
            ->get();
        */

        $str_orig = '{"name":"Процессор AMD Ryzen 9 7950X BOX","brand":{"name":"AMD","image":""},"short_descr":"AM5, 16 x 4.5 ГГц, L2 - 16 МБ, L3 - 64 МБ, 2 х DDR5-5200 МГц, AMD Radeon Graphics, TDP 170 Вт","description":"Процессор AMD Ryzen 9 7950X поддерживает работу с интерфейсом PCI-E 5.0, который открывает широкие возможности для использования высокоскоростных комплектующих в сборке. Благодаря интегрированному графическому ядру AMD Radeon Graphics не нужно приобретать отдельную видеокарту в рабочую станцию. Оно хорошо справится с обработкой и отображением на экране монитора нересурсоемкой графики. Высокая производительность в сочетании с тепловыделением, не превышающим 170 Вт, обеспечена 5-нанометровым техпроцессом.\nПроцессор AMD Ryzen 9 7950X использует для подключения к материнской плате востребованный сокет AM5. Поддерживается до 128 ГБ оперативной памяти для создания мощной компьютерной системы, которая гарантирует эффективную работу в многозадачном режиме и при запуске ресурсоемкого софта. Поддержка режима ECC позволит использовать чипсет в серверах с ОЗУ, имеющей технологию коррекции ошибок.","attributes":[{"name":"Комплектация:","variants":[{"name":"OEM","id":"v-0-0","is_current":false},{"name":"BOX","id":"v-0-1","is_current":true}]}],"specs":[{"name":"Гарантия продавца","value":"12 мес.","units":null},{"name":"Страна-производитель","value":"Китай","units":null},{"name":"Модель","value":"AMD Ryzen 9 7950X","units":null},{"name":"Сокет","value":"AM5","units":null},{"name":"Код производителя","value":"[100-100000514WOF]","units":null},{"name":"Год релиза","value":"2022","units":null},{"name":"Система охлаждения в комплекте","value":"нет","units":null},{"name":"Термоинтерфейс в комплекте","value":"нет","units":null},{"name":"Общее количество ядер","value":"16","units":null},{"name":"Количество производительных ядер","value":"16","units":null},{"name":"Количество энергоэффективных ядер","value":"нет","units":null},{"name":"Максимальное число потоков","value":"32","units":null},{"name":"Объем кэша L2","value":"16","units":"МБ"},{"name":"Объем кэша L3","value":"64","units":"МБ"},{"name":"Техпроцесс","value":"TSMC 5nm FinFET","units":null},{"name":"Ядро","value":"AMD Raphael","units":null},{"name":"Базовая частота процессора","value":"4.5","units":"ГГц"},{"name":"Максимальная частота в турбо режиме","value":"5.7","units":"ГГц"},{"name":"Базовая частота энергоэффективных ядер","value":"нет","units":null},{"name":"Частота в турбо режиме энергоэффективных ядер","value":"нет","units":null},{"name":"Свободный множитель","value":"да","units":null},{"name":"Тип памяти","value":"DDR5","units":null},{"name":"Максимально поддерживаемый объем памяти","value":"128","units":"ГБ"},{"name":"Количество каналов","value":"2","units":null},{"name":"Частота оперативной памяти","value":"DDR5-5200","units":null},{"name":"Поддержка режима ECC","value":"да","units":null},{"name":"Тепловыделение (TDP)","value":"170","units":"Вт"},{"name":"Базовое тепловыделение","value":"170","units":"Вт"},{"name":"Максимальная температура процессора","value":"95","units":"°C"},{"name":"Интегрированное графическое ядро","value":"да","units":null},{"name":"Модель графического процессора","value":"AMD Radeon Graphics","units":null},{"name":"Максимальная частота графического ядра","value":"2200","units":"МГц"},{"name":"Встроенный контроллер PCI Express","value":"PCI-E 5.0","units":null},{"name":"Число линий PCI Express","value":"24 шт","units":null},{"name":"Технология виртуализации","value":"да","units":null},{"name":"Особенности, дополнительно","value":"поддержка AMD EXPO","units":null}]}';

        /*$tr = new GoogleTranslate();
        $tr->setSource('ru');
        $tr->setTarget('en');*/

//        $str_en = $tr->translate($str_orig);

        $str_en = 'Turned off';


//        return view('site.pages.temp_for_delete.temp');

        return view('site.pages.temp_for_delete.temp', compact(
            'str_orig',
            'str_en',
        ));
    }
}
