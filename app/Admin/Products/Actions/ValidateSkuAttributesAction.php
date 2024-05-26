<?php

namespace App\Admin\Products\Actions;

use App\Modules\Products\Models\Sku;

class ValidateSkuAttributesAction
{
    public static function run(int $sku_id, int $product_id, array $attributes): bool
    {
        $validated = true;

        $skus = Sku::select('id')
            ->where('product_id', $product_id)
            ->with('variants:id,name,attribute_id')
            ->orderBy('id')
            ->get();

        foreach ($skus as $sku) {
            if ($sku->id !== $sku_id) {
                $sku_attributes = [];
                foreach ($sku->variants as $variant) {
                    $sku_attributes[$variant->attribute_id] = $variant->id;
                }

                if (!count(array_diff($attributes, $sku_attributes))) {
                    $validated = false;
                    break;
                }
            }
        }

        return $validated;
    }
}