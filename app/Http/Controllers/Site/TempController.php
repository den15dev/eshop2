<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Modules\Languages\Models\Language;
use App\Modules\Temp_JsonbTest\Models\JsonbProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TempController extends Controller
{
    public function temp(): View
    {
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



//        return view('site.pages.temp_for_delete.temp');

        return view('site.pages.temp_for_delete.jsonb-test', compact(
            'products_jsonb',
            'products_flat',
            'search_str',
            'locale',
        ));
    }
}
