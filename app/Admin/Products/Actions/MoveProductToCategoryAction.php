<?php

namespace App\Admin\Products\Actions;

use App\Modules\Products\Models\Product;
use Illuminate\Database\Query\Builder as QBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MoveProductToCategoryAction
{
    public static function run(int $product_id, int $category_id): void
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
}