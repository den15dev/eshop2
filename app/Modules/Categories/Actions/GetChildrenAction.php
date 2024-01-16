<?php

namespace App\Modules\Categories\Actions;

use Illuminate\Database\Eloquent\Collection;

class GetChildrenAction
{
    public static function run(
        int $category_id,
        Collection $categories,
        Collection $product_counts
    ): ?Collection {
        $children = new Collection();

        foreach ($categories as $child) {
            if ($child->parent_id === $category_id) {
                $child->product_count = $product_counts->firstWhere('category_id', $child->id)?->product_count;
                $children->push($child);
            }
        }

        return $children->count() ? $children->sortBy('sort') : null;
    }
}