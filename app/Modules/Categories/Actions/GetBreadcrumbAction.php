<?php

namespace App\Modules\Categories\Actions;

use App\Modules\Categories\Models\Category;
use Illuminate\Support\Collection;

class GetBreadcrumbAction
{
    public static function run(
        Category $category,
        Collection $categories,
        bool $last_is_current
    ): \stdClass {
        $breadcrumb = new \stdClass();
        $breadcrumb->last_is_current = $last_is_current;
        $parts = new Collection();

        $current_part = new \stdClass();
        $current_part->url = route('catalog', $category->slug);
        $current_part->text = $category->name;
        $parts->push($current_part);

        $parent_id = $category->parent_id;
        while ($parent_id) {
            $parent = $categories->firstWhere('id', $parent_id);
            $parent_id = 0;
            if ($parent) {
                $part = new \stdClass();
                $part->url = route('catalog', $parent->slug);
                $part->text = $parent->name;
                $parts->push($part);
                $parent_id = $parent->parent_id;
            }
        }

        $breadcrumb->parts = $parts->reverse();

        return $breadcrumb;
    }
}