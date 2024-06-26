<?php

namespace App\Modules\Categories;

use App\Modules\Categories\Actions\GetBreadcrumbAction;
use App\Modules\Categories\Actions\BuildCategoryTreeAction;
use App\Modules\Categories\Actions\GetChildrenAction;
use App\Modules\Categories\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    private static ?Collection $categories = null;


    public static function getAll(): Collection
    {
        if (self::$categories === null) {
            self::$categories = Cache::rememberForever('categories', function () {
                $sku_active_filter = 'WHERE skus.available_from <= NOW() AND (skus.available_until > NOW() OR skus.available_until IS NULL)';

                $categories = Category::leftJoin('products', 'products.category_id', 'categories.id')
                    ->leftJoin('skus', 'skus.product_id', 'products.id')
                    ->select('categories.*')
                    ->selectRaw('count(skus.id) AS sku_num_all')
                    ->selectRaw('count(skus.id) filter (' . $sku_active_filter . ') AS sku_num')
                    ->groupBy('categories.id')
                    ->orderBy('categories.id')
                    ->get();

                return self::countChildrenSkus($categories);
            });
        }

        return self::$categories;
    }


    /**
     * 'sku_num' means only active skus.
     * 'sku_num_all' means all skus including inactive.
     */
    private static function countChildrenSkus(Collection $categories): Collection
    {
        foreach ($categories as $category) {
            $cur_category = $category;
            $parent_id = $cur_category->parent_id;

            $prod_self_all = $cur_category->sku_num_all;
            $prod_self = $cur_category->sku_num;
            $cur_category->sku_num_children_all ??= 0;
            $cur_category->sku_num_children ??= 0;

            while ($parent_id) {
                $parent = $categories->firstWhere('id', $cur_category->parent_id);
                $parent->sku_num_children_all += $prod_self_all;
                $parent->sku_num_children += $prod_self;

                $cur_category = $parent;
                $parent_id = $cur_category->parent_id;
            }
        }

        return $categories;
    }


    public function getCategoryBySlug(string $category_slug): ?Category
    {
        return self::getAll()->firstWhere('slug', $category_slug);
    }


    /**
     * Build a multidimensional array with nested subcategories
     * from a Collection of categories.
     */
    public function buildCategoryTree(): array
    {
        return BuildCategoryTreeAction::run(self::getAll());
    }


    /**
     * Get children categories, each with 'product_count' property.
     */
    public function getChildren(int $category_id): ?Collection
    {
        return GetChildrenAction::run(
            $category_id,
            self::getAll()
        );
    }


    /**
     * Get categories where active SKUs of specific brand present.
     * For Brand page.
     */
    public function getCategoriesByBrand(int $brand_id): Collection
    {
        return Category::join('products', 'categories.id', 'products.category_id')
            ->join('skus', 'products.id', 'skus.product_id')
            ->select(
                'categories.id',
                'categories.name',
                'categories.slug',
            )
            ->selectRaw('count(skus.id) AS sku_num')
            ->where('products.brand_id', $brand_id)
            ->whereSkuIsActive()
            ->groupBy('categories.id')
            ->get();
    }


    /**
     * Get a breadcrumb object consisting of 2 properties:
     * 'last_as_url' - is current category should be shown as a link
     * or as an active category;
     * 'parts' - a collection of objects, each with 2 properties:
     * 'url' and 'text'.
     */
    public function getBreadcrumb(Category $category, bool $last_is_current): \stdClass
    {
        return GetBreadcrumbAction::run(
            $category,
            self::getAll(),
            $last_is_current
        );
    }
}