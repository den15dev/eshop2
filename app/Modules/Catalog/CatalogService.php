<?php

namespace App\Modules\Catalog;

use App\Modules\Catalog\Enums\ProductSorting;
use Illuminate\Support\Collection;

class CatalogService
{
    public const PREF_COOKIE = 'catalog_prefs';


    public function getPreferences(?string $pref_cookie): \stdClass
    {
        $catalog_prefs_arr = $pref_cookie ? json_decode($pref_cookie) : [ProductSorting::New->value, 12, 1];

        $sorting_list = $this->getProductSorting($catalog_prefs_arr[0]);
        $per_page_list = $this->getProductsPerPage(intval($catalog_prefs_arr[1]));

        $prefs = new \stdClass();
        $prefs->sorting = $sorting_list;
        $prefs->sorting_active = $sorting_list->firstWhere('is_active', true);

        $prefs->per_page = $per_page_list;
        $prefs->per_page_num = $per_page_list->firstWhere('is_active', true)->num;

        $prefs->layout = intval($catalog_prefs_arr[2]);

        return $prefs;
    }


    public function getProductSorting(string $current_sorting): Collection
    {
        $current_case = ProductSorting::tryFrom($current_sorting) ?? ProductSorting::New;

        $list = new Collection([]);

        foreach (ProductSorting::cases() as $case) {
            $sorting_obj = new \stdClass();
            $sorting_obj->sorting = $case->value;
            $sorting_obj->description = ProductSorting::getDescription($case);
            $sorting_obj->is_active = $case === $current_case;

            $list->push($sorting_obj);
        }

        return $list;
    }


    public function getProductsPerPage(int $current_num): Collection
    {
        $per_page_arr = [12, 24, 36, 48];

        if (!in_array($current_num, $per_page_arr)) {
            $current_num = 12;
        }

        $per_page = new Collection([]);
        foreach ($per_page_arr as $num) {
            $per_page_obj = new \stdClass();
            $per_page_obj->num = $num;
            $per_page_obj->is_active = $num === $current_num;

            $per_page->push($per_page_obj);
        }

        return $per_page;
    }
}