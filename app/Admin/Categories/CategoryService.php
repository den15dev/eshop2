<?php

namespace App\Admin\Categories;

use App\Admin\Categories\Actions\GetParentCategoryListAction;
use App\Admin\Categories\Actions\UpdateSpecAction;
use App\Modules\Categories\Models\Category;
use App\Modules\Categories\Models\Specification;
use App\Modules\Images\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

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


    /**
     * Sort category list to represent a tree in select elements
     */
    public static function sortToTree(Collection $categories): Collection
    {
        static $out = new Collection();
        static $parent_id = 0;

        $children1 = $categories->where('parent_id', $parent_id)->sortBy('sort');
        foreach ($children1 as $child1) {
            $out->push($child1);
            $parent_id = $child1->id;

            self::sortToTree($categories);
        }

        return $out;
    }


    public function getParentCategoryList(Collection $categories, ?int $current_id = null): Collection
    {
        return GetParentCategoryListAction::run($categories, $current_id);
    }


    public function updateSpec(int $category_id, int $spec_id, array $fields): \stdClass
    {
        return UpdateSpecAction::run($category_id, $spec_id, $fields);
    }


    public function storeSpec(int $category_id, array $fields): \stdClass
    {
        $spec = new Specification();
        $spec->category_id = $category_id;
        $name = array_filter($fields['name'], fn ($lang) => !empty($lang));
        $spec->name = $name;
        $units = isset($fields['units'])
            ? array_filter($fields['units'], fn ($lang) => !empty($lang))
            : null;
        $spec->units = $units;
        $spec->sort = $fields['sort'];
        $spec->is_filter = isset($fields['is_filter']) && $fields['is_filter'] === 'on';
        $spec->is_main = isset($fields['is_main']) && $fields['is_main'] === 'on';

        Specification::where('category_id', $category_id)
            ->where('sort', '>=', $fields['sort'])
            ->increment('sort');

        $spec->save();

        $response = new \stdClass();
        $response->message = __('admin/specifications.messages.spec_added');

        return $response;
    }


    public function deleteSpec(int $spec_id): \stdClass
    {
        $spec = Specification::firstWhere('id', $spec_id);
        $category_id = $spec->category_id;
        $order_num = $spec->sort;

        $spec->delete();
        Specification::where('category_id', $category_id)
            ->where('sort', '>', $order_num)
            ->decrement('sort');

        $response = new \stdClass();
        $response->message = __('admin/specifications.messages.spec_deleted');

        return $response;
    }


    public function saveImage(string $slug, UploadedFile $file): void
    {
        $disk = Storage::disk('s3tw');
        $tempDir = Storage::disk('images')->path('temp/' . $slug);

        $sourcePath = $file->path();
        $imageName = $slug . '.jpg';
        $outPath = $tempDir . '/' . $imageName;
        ImageService::saveToSquareFilled($sourcePath, $outPath, Category::IMG_SIZE);

        $remotePath = "eshop/categories/{$imageName}";
        $disk->put($remotePath, file_get_contents($outPath));

        unlink($outPath);
        rmdir($tempDir);
    }


    public function deleteImage(string $slug): void
    {
        $disk = Storage::disk('s3tw');

        $disk->delete("eshop/categories/{$slug}.jpg");
    }
}
