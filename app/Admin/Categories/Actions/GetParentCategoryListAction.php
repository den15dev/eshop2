<?php

namespace App\Admin\Categories\Actions;

use App\Admin\Categories\CategoryService as AdmCategoryService;
use App\Modules\Categories\Models\Category;
use App\Modules\Languages\LanguageService;
use Illuminate\Support\Collection;

class GetParentCategoryListAction
{
    public static function run(Collection $categories, ?int $current_id = null): Collection
    {
        $root = null;

        foreach ($categories as $cat) {
            $cat->has_children = $categories->contains('parent_id', $cat->id);
            $cat->can_be_parent = !$cat->sku_num_all && $cat->level !== 4;
        }

        if ($current_id) {
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
        } else {
            $root = new Category();
            $root->id = 0;

            $name = [];
            $languages = LanguageService::getAll();
            foreach ($languages as $lang) {
                $id = $lang->id;
                $name[$id] = __('admin/categories.root', locale: $id);
            }
            $root->name = $name;

            $root->can_be_parent = true;
        }

        $out = AdmCategoryService::sortToTree($categories);
        if ($root) $out->prepend($root);

        return $out;
    }
}