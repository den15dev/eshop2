<?php

namespace App\Modules\Catalog\Actions;

use App\Modules\Categories\Models\Category;
use Illuminate\Support\Collection;

class GetCategoriesAction
{
    public static function run(string $search_query, ?array $checked): Collection
    {
        $categories = Category::join('products', 'products.category_id', 'categories.id')
            ->join('skus', 'skus.product_id', 'products.id')
            ->selectRaw('categories.id, categories.name, count(skus.id) as skus_num')
            ->where('skus.name->' . app()->getLocale(), 'ilike', '%' . $search_query . '%')
            ->groupBy('categories.id')
            ->get();

        foreach ($categories as $category) {
            $category->is_checked = $checked && in_array($category->id, $checked);
        }

        return $categories;
    }
}