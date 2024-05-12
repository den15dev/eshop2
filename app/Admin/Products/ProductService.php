<?php

namespace App\Admin\Products;

use App\Admin\IndexTable\IndexTableService;
use App\Admin\Products\Actions\BuildIndexQueryAction;
use App\Modules\Products\Models\Attribute;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Variant;
use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{
    public const TABLE_NAME = 'products';
    public const COLUMNS_COOKIE = 'cls_products';


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
        $state->active = isset($query['chb']['active']) ? $query['chb']['active'] === 'true' : true;
        $state->out_of_stock = isset($query['chb']['out_of_stock']) ? $query['chb']['out_of_stock'] === 'true' : true;
        $state->scheduled = isset($query['chb']['scheduled']) ? $query['chb']['scheduled'] === 'true' : true;
        $state->sort = $query['sort'] ?? null;
        $state->order = $query['order'] ?? null;

        return $state;
    }


    public function moveToCategory(int $product_id, int $category_id): void
    {
        DB::beginTransaction();

        try {
            Product::where('id', $product_id)->update(['category_id' => $category_id]);

            DB::table('sku_specification')
                ->whereIn('sku_id', function (QBuilder $query) use ($product_id) {
                    $query->select('id')
                        ->from('skus')
                        ->where('product_id', $product_id);
                })
                ->delete();

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::channel('events')->info('An exception caught while trying to move the product ' . $product_id . ' to another category: ' . $e->getMessage());
            abort(500);
        }
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
}