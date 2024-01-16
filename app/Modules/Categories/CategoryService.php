<?php

namespace App\Modules\Categories;

use App\Modules\Categories\Actions\GetBreadcrumbAction;
use App\Modules\Categories\Actions\BuildCategoryTreeAction;
use App\Modules\Categories\Actions\GetChildrenAction;
use App\Modules\Categories\Models\Category;
use App\Modules\Products\ProductService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    private static ?Collection $categories = null;

    private ProductService $productService;


    public function __construct() {
        $this->productService = new ProductService();
    }


    public static function getAll(): ?Collection
    {
        if (self::$categories === null) {
            self::$categories = Cache::rememberForever('categories', function () {
                return Category::all();
            });
        }

        return self::$categories;
    }


    public function getCategoryBySlug(string $category_slug): ?Category
    {
        return self::getAll()->firstWhere('slug', $category_slug);
    }


    /**
     * Build a multidimensional array with nested subcategories
     * from a Collection of categories.
     *
     * @return array
     */
    public function buildCategoryTree(): array
    {
        return BuildCategoryTreeAction::run(
            self::getAll(),
            $this->productService->countByCategories()
        );
    }


    /**
     * Get children categories, each with 'product_count' property.
     *
     * @param int $category_id
     * @return Collection|null
     */
    public function getChildren(int $category_id): ?Collection
    {
        return GetChildrenAction::run(
            $category_id,
            self::getAll(),
            $this->productService->countByCategories()
        );
    }


    /**
     * Get a breadcrumb object consisting of 2 properties:
     * 'last_as_url' - is current category should be shown as a link
     * or as an active category;
     * 'parts' - a collection of objects, each with 2 properties:
     * 'url' and 'text'.
     *
     * @param Category $category
     * @param bool $last_is_current
     * @return \stdClass
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