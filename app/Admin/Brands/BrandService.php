<?php

namespace App\Admin\Brands;

use App\Admin\IndexTable\IndexTableService;
use App\Modules\Brands\Models\Brand;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BrandService
{
    public const TABLE_NAME = 'brands';
    public const COLUMNS_COOKIE = 'cls_brands';
    public const ROW_LINKS = false;


    public function buildIndexQuery(array $query, IndexTableService $tableService): Builder
    {
        $db_query = Brand::select(
            'id',
            'name',
            'slug',
            'created_at',
        );

        if (isset($query['search'])) {
            $db_query = $tableService->constrainBySearchStr($db_query, $query['search']);
        }

        return isset($query['sort'])
            ? $tableService->orderQuery($db_query, $query)
            : $db_query->orderByDesc('brands.id');
    }


    public function getPageState($query): \stdClass
    {
        $state = new \stdClass();

        $state->search = $query['search'] ?? null;
        $state->sort = $query['sort'] ?? null;
        $state->order = $query['order'] ?? null;

        return $state;
    }


    public function renameImage(string $old_slug, string $new_slug): void
    {
        if ($new_slug !== $old_slug) {
            $dir = Storage::disk('images')->path(Brand::IMG_DIR);
            $image_path = self::getImagePath($old_slug);

            if ($image_path) {
                $ext = pathinfo($image_path, PATHINFO_EXTENSION);
                rename($dir . '/' . $old_slug . '.' . $ext, $dir . '/' . $new_slug . '.' . $ext);
            }
        }
    }


    public function saveImage(string $slug, UploadedFile $file): void
    {
        $dir = Storage::disk('images')->path(Brand::IMG_DIR);

        if (is_dir($dir)) {
            $image_path = self::getImagePath($slug);
            if ($image_path) {
                unlink($image_path);
            }
        } else {
            mkdir($dir);
        }

        $ext = $file->extension();
        $file->storeAs('images/' . Brand::IMG_DIR, $slug . '.' . $ext);
    }


    private static function getImagePath(string $slug): string|bool
    {
        $dir = Storage::disk('images')->path(Brand::IMG_DIR);
        $images = glob($dir . '/' . $slug . '.*');

        if (gettype($images) === 'array' && count($images)) {
            return $images[0];
        }

        return false;
    }


    public function deleteImage(string $slug): void
    {
        $image_path = self::getImagePath($slug);
        if ($image_path) {
            unlink($image_path);
        }
    }
}