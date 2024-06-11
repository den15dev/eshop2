<?php

namespace App\Admin\Categories;

use App\Admin\Categories\Actions\GetParentCategoryListAction;
use App\Admin\Categories\Actions\UpdateSpecAction;
use App\Modules\Categories\Models\Specification;
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


    public function getParentCategoryList(Collection $categories, int $current_id): Collection
    {
        return GetParentCategoryListAction::run($categories, $current_id);
    }


    public function updateSpec(int $category_id, int $spec_id, array $fields): \stdClass
    {
        return UpdateSpecAction::run($category_id, $spec_id, $fields);
    }


    public function deleteSpec(int $spec_id): \stdClass
    {
        Specification::where('id', $spec_id)->delete();

        $response = new \stdClass();
        $response->message = __('admin/specifications.messages.spec_deleted');

        return $response;
    }
}