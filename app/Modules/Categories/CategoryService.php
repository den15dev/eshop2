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
     */
    public function getBreadcrumb(Category $category, bool $last_is_current): \stdClass
    {
        return GetBreadcrumbAction::run(
            $category,
            self::getAll(),
            $last_is_current
        );
    }


    public static function getSpecs(?int $category_id): Collection
    {
        $specs = new Collection();

        if (!$category_id) return $specs;

        $specs_data = [
            ['Серия', null, 1],
            ['Модель', null, 2],
            ['Сокет', null, 3],
            ['Год релиза', null, 4],
            ['Ядро', null, 5],
            ['Техпроцесс', null, 6],
            ['Общее количество ядер', null, 7],
            ['Максимальное число потоков', null, 8],
            ['Количество производительных ядер', null, 9],
            ['Количество энергоэффективных ядер', null, 10],
            ['Объем кэша L2', 'МБ', 11],
            ['Объем кэша L3', 'МБ', 12],
            ['Базовая частота процессора', 'ГГц', 13],
            ['Максимальная частота в турбо режиме', 'ГГц', 14],
            ['Свободный множитель', null, 15],
            ['Тип памяти', null, 16],
            ['Максимально поддерживаемый объем памяти', 'ГБ', 17],
            ['Количество каналов', null, 18],
            ['Максимальная частота оперативной памяти', 'МГц', 19],
            ['Поддержка режима ECC', null, 20],
            ['Тепловыделение (TDP)', 'Вт', 21],
            ['Максимальная температура процессора', '°C', 22],
            ['Система охлаждения в комплекте', null, 23],
            ['Интегрированное графическое ядро', null, 24],
            ['Встроенный контроллер PCI Express', null, 25],
            ['Число линий PCI Express', null, 26],
        ];

        foreach ($specs_data as $index => $spec) {
            $spec_obj = new \stdClass();
            $spec_obj->id = $index + 1;
            $spec_obj->name = $spec[0];
            $spec_obj->units = $spec[1];
            $spec_obj->sort = $spec[2];
            $specs->push($spec_obj);
        }

        return $specs->sortBy('sort');
    }
}