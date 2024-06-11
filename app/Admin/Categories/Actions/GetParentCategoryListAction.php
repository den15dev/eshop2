<?php

namespace App\Admin\Categories\Actions;

use Illuminate\Support\Collection;

class GetParentCategoryListAction
{
    public static function run(Collection $categories, int $current_id): Collection
    {
        foreach ($categories as $cat) {
            $cat->has_children = $categories->contains('parent_id', $cat->id);
            $cat->can_be_parent = !$cat->sku_num_all;
        }

        $cur_category = $categories->firstWhere('id', $current_id);
        $cur_category->can_be_parent = false;

        if ($cur_category->sku_num_all) {
            foreach ($categories as $cat) {
                $cat->can_be_parent = $cat->can_be_parent && ($cat->level === 2 || $cat->level === 3);
            }

        } elseif ($cur_category->has_children) {
            // Check if the category has grandchildren
            $children = $categories->where('parent_id', $current_id);
            $has_grandchildren = false;
            foreach ($children as $child) {
                if ($child->has_children) {
                    $has_grandchildren = true;
                    break;
                }
            }

            foreach ($categories as $cat) {
                $cat->can_be_parent = $cat->can_be_parent && (($cat->level === 2 && !$has_grandchildren) || $cat->level === 1);
            }

        } else {
            foreach ($categories as $cat) {
                $cat->can_be_parent = $cat->can_be_parent && $cat->level < 4;
            }
        }

        return $categories;
    }
}