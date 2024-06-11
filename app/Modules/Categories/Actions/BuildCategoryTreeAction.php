<?php

namespace App\Modules\Categories\Actions;

use Illuminate\Support\Collection;

class BuildCategoryTreeAction
{
    /**
     * Build a multidimensional array with nested subcategories
     * from a Collection of categories.
     *
     * @param Collection $categories
     * @return array
     */
    public static function run(Collection $categories): array
    {
        $out_arr = [];
        static $level = 0;
        static $parent_id = 0;

        foreach ($categories as $cat) {
            $level++;
            if ($cat->level === 1 || $level > 1) {
                if ($cat->parent_id === $parent_id) {
                    $cat_data = [
                        'id' => $cat->id,
                        'name' => $cat->name,
                        'slug' => $cat->slug,
                        'level' => $cat->level,
                        'sort' => $cat->sort,
                        'product_count' => $cat->sku_num_children ?: $cat->sku_num,
                        'product_count_all' => $cat->sku_num_children_all ?: $cat->sku_num_all,
                    ];

                    $parent_id = $cat->id;
                    $children_arr = self::run($categories);
                    $parent_id = $cat->parent_id;

                    if (count($children_arr)) {
                        $cat_data['subcategories'] = $children_arr;
                    }

                    $out_arr[] = $cat_data;
                }
            }
            $level--;
        }

        usort($out_arr, fn($a, $b) => $a['sort'] - $b['sort']);

        return $out_arr;
    }
}