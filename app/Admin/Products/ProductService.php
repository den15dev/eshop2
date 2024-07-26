<?php

namespace App\Admin\Products;

use App\Admin\IndexTable\IndexTableService;
use App\Admin\Products\Actions\BuildIndexQueryAction;
use App\Admin\Products\Actions\GetSkuFinalPricesAction;
use App\Admin\Products\Actions\MoveProductToCategoryAction;
use App\Admin\Products\Actions\UpdateSkuAttributesAction;
use App\Admin\Products\Actions\ValidateSkuAttributesAction;
use App\Modules\Categories\Models\Specification;
use App\Modules\Images\ImageService;
use App\Modules\Products\Models\Attribute;
use App\Modules\Products\Models\Sku;
use App\Modules\Products\Models\Variant;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public const TABLE_NAME = 'products';
    public const COLUMNS_COOKIE = 'cls_products';
    public const ROW_LINKS = false; // A whole table row will be a link (every <td> content will be wrapped by <a> tag)


    public function __construct(
        private readonly BuildIndexQueryAction $buildIndexQueryAction,
    ){}


    public function buildIndexQuery(
        array $query,
        IndexTableService $tableService,
    ): EBuilder {
        return $this->buildIndexQueryAction->run($query, $tableService);
    }


    public function getPageState($query): \stdClass
    {
        $state = new \stdClass();

        $state->search = $query['search'] ?? null;
        $state->category_id = isset($query['category']) ? intval($query['category']) : null;
        $state->active = isset($query['chb']['active']) ? $query['chb']['active'] === 'true' : false;
        $state->out_of_stock = isset($query['chb']['out_of_stock']) ? $query['chb']['out_of_stock'] === 'true' : false;
        $state->scheduled = isset($query['chb']['scheduled']) ? $query['chb']['scheduled'] === 'true' : false;
        $state->sort = $query['sort'] ?? null;
        $state->order = $query['order'] ?? null;

        return $state;
    }


    public function getSkuMaxNum(Collection $attributes): int
    {
        $max_num = 1;

        foreach ($attributes as $attribute) {
            $max_num = $max_num * $attribute->variants->count();
        }

        return $max_num;
    }


    public function getCategories(Collection $categories): Collection
    {
        foreach ($categories as $category) {
            $category->has_children = $categories->contains('parent_id', $category->id);
        }

        return $categories;
    }


    public function moveProductToCategory(int $product_id, int $category_id): void
    {
        MoveProductToCategoryAction::run($product_id, $category_id);
    }


    public function updateAttribute(int $id, array $fields): void
    {
        Attribute::where('id', $id)->update([
            'name' => json_encode($fields, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);
    }

    public function updateVariant(int $id, array $fields): void
    {
        Variant::where('id', $id)->update([
            'name' => json_encode($fields, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
        ]);
    }

    public function deleteAttribute(int $id): void
    {
        Attribute::where('id', $id)->delete();
    }

    public function deleteVariant(int $id): void
    {
        Variant::where('id', $id)->delete();
    }

    public function createAttribute(int $product_id, array $fields): void
    {
        $attribute = new Attribute();
        $attribute->product_id = $product_id;
        $attribute->name = $fields;
        $attribute->save();
    }

    public function createVariant(int $attribute_id, array $fields): void
    {
        $variant = new Variant();
        $variant->attribute_id = $attribute_id;
        $variant->name = $fields;
        $variant->save();
    }


    public function getSku(int $id): Sku
    {
        return Sku::join('products', 'skus.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->select(
                'skus.*',
                'categories.id as category_id',
                'categories.name as category_name',
                'categories.slug as category_slug',
            )
            ->with('promo')
            ->with('product.attributes.variants:id,attribute_id,name')
            ->with('variants:id,attribute_id,name')
            ->with('specifications:id')
            ->firstWhere('skus.id', $id);
    }


    public function getSkuFinalPrices(
        string $price,
        string $currency_id,
        ?int $sku_discount,
        ?int $promo_id
    ): \stdClass
    {
        return GetSkuFinalPricesAction::run(
            $price,
            $currency_id,
            $sku_discount,
            $promo_id
        );
    }


    public function getCategorySpecs(int $category_id)
    {
        return Specification::select(
                'id',
                'name',
                'units',
                'sort',
                'is_filter',
                'is_main',
            )
            ->where('category_id', $category_id)
            ->orderBy('sort')
            ->get();
    }


    public function validateSkuAttributes(int $sku_id, int $product_id, array $attributes): bool
    {
        return ValidateSkuAttributesAction::run($sku_id, $product_id, $attributes);
    }


    public function updateSkuAttributes(int $sku_id, array $attributes): void
    {
        UpdateSkuAttributesAction::run($sku_id, $attributes);
    }


    public function updateSkuImages(int $id, array $old_images, array $new_images, ?UploadedFile $file): void
    {
        $dir = Storage::disk('images')->path(Sku::IMG_DIR . '/' . $id);

        // Remove unneeded images
        foreach ($old_images as $old_image) {
            if (!in_array($old_image, $new_images)) {
                foreach (Sku::IMG_SIZES as $size => $res) {
                    unlink($dir . '/' . $old_image . '_' . $size . '.jpg');
                }
            }
        }

        if ($file) {
            $new_index = 1;
            while (in_array(sprintf('%02d', $new_index), $new_images)) $new_index++;
            $new_index = sprintf('%02d', $new_index);
            $new_images[] = $new_index;

            $this->saveSkuImage($id, $new_index, $file);
        }

        Sku::firstWhere('id', $id)->update([
            'images' => count($new_images) ? $new_images : null
        ]);
    }


    public function saveSkuImage(int $sku_id, int|string $index, UploadedFile $file): void
    {
        $dir = Storage::disk('images')->path(Sku::IMG_DIR . '/' . $sku_id);
        if (!is_dir($dir)) mkdir($dir);

        $source_path = $file->path();

        foreach (Sku::IMG_SIZES as $size => $res) {
            $out_path = $dir . '/' . sprintf('%02d', $index) . '_' . $size . '.jpg';
            ImageService::saveToSquareFilled($source_path, $out_path, $res);
        }
    }


    public function deleteProductImages(int $product_id): int
    {
        $sku_ids = Sku::select('id')
            ->where('product_id', $product_id)
            ->get()
            ->pluck('id')
            ->all();

        foreach ($sku_ids as $sku_id) {
            $this->deleteSkuImages($sku_id);
        }

        return count($sku_ids);
    }


    public function deleteSkuImages(int $sku_id): void
    {
        $dir = Storage::disk('images')->path(Sku::IMG_DIR . '/' . $sku_id);

        if (is_dir($dir)) {
            $images = array_diff(scandir($dir), ['.', '..']);
            foreach ($images as $img) {
                unlink($dir . '/' . $img);
            }
            rmdir($dir);
        }
    }


    public function updateSkuSpec(int $sku_id, int $spec_id, array $fields): \stdClass
    {
        $existed = DB::table('sku_specification')
            ->where('sku_id', $sku_id)
            ->where('specification_id', $spec_id)
            ->exists();

        if ($existed) {
            Sku::find($sku_id)->specifications()->updateExistingPivot($spec_id, [
                'spec_value' => $fields,
            ]);
        } else {
            Sku::find($sku_id)->specifications()->attach($spec_id, [
                'spec_value' => $fields,
            ]);
        }

        $response = new \stdClass();
        $response->message = __('admin/specifications.messages.spec_updated');

        return $response;
    }


    public function deleteSkuSpec(int $sku_id, int $spec_id): \stdClass
    {
        Sku::find($sku_id)->specifications()->detach($spec_id);

        $response = new \stdClass();
        $response->message = __('admin/specifications.messages.spec_cleared');

        return $response;
    }
}