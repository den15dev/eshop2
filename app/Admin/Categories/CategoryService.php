<?php

namespace App\Admin\Categories;

use Illuminate\Support\Collection;

class CategoryService
{
    public function getAllChildrenIds(int $category_id, Collection $categories): array
    {
        static $children = [];

        $has_children = false;
        foreach ($categories as $child) {
            if ($child->parent_id === $category_id) {
                $has_children = true;
                $this->getAllChildrenIds($child->id, $categories);
            }
        }

        if (!$has_children) {
            $children[] = $category_id;
        }

        return $children;
    }
}