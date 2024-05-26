<?php

namespace App\Admin\Products\Actions;

use Illuminate\Support\Facades\DB;

class UpdateSkuAttributesAction
{
    public static function run (int $sku_id, array $attributes): void
    {
        $variants = DB::table('sku_variant')
            ->where('sku_id', $sku_id)
            ->get();

        $new_variants = array_values($attributes);

        foreach ($variants as $key => $variant) {
            if(!isset($new_variants[$key])) {
                DB::table('sku_variant')
                    ->where('id', $variant->id)
                    ->delete();
            }
        }

        foreach ($new_variants as $key => $variant_id) {
            if (isset($variants[$key])) {
                DB::table('sku_variant')
                    ->where('id', $variants[$key]->id)
                    ->where('sku_id', $variants[$key]->sku_id)
                    ->update(['variant_id' => $variant_id]);
            } else {
                DB::table('sku_variant')->insert(
                    ['sku_id' => $variants[$key]->sku_id, 'variant_id' => $variant_id]
                );
            }
        }
    }
}