<?php

namespace App\Modules\Categories\Actions;

use Illuminate\Support\Collection;

class GetChildrenAction
{
    public static function run(
        int $category_id,
        Collection $categories
    ): ?Collection {
        $children = new Collection();

        foreach ($categories as $child) {
            if ($child->parent_id === $category_id) {
                $children->push($child);
            }
        }

        return $children->count() ? $children->sortBy('sort') : null;
    }
}