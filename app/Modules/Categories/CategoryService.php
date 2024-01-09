<?php

namespace App\Modules\Categories;

use App\Modules\Categories\Actions\BuildCategoryTreeAction;
use App\Modules\Categories\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class CategoryService
{
    private static ?Collection $categories = null;


    public static function getAll(): ?Collection
    {
        if (self::$categories === null) {
            self::$categories = Cache::rememberForever('categories', function () {
                return Category::all();
            });
        }

        return self::$categories;
    }


    /**
     * Build a multidimensional array with nested subcategories
     * from a Collection of categories.
     *
     * @return array
     */
    public static function buildCategoryTree(): array
    {
        $product_counts = self::tempCountProducts();

        return BuildCategoryTreeAction::run(self::getAll(), $product_counts);
    }


    // Move this to Product Service class!
    public static function tempCountProducts(): Collection
    {
//        $categories = Product::select('category_id', DB::raw('count(*) as product_count'))->groupBy('category_id')->get();
//        $categories->firstWhere('level', 3)?->product_count;

        $product_counts = new Collection([]);
        $categories = self::getAll();
        foreach ($categories as $category) {
            if ($category->level > 2) {
                $count = new \stdClass();
                $count->category_id = $category->id;
                $count->product_count = fake()->numberBetween(5, 300);
                $product_counts->push($count);
            }
        }

        return $product_counts;
    }
}