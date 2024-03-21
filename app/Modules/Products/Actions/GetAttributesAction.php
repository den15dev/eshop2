<?php

namespace App\Modules\Products\Actions;

use App\Modules\Products\Models\Attribute;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Variant;
use Illuminate\Support\Collection;

class GetAttributesAction
{
    public static function run(int $product_id, int $sku_id): Collection
    {
        $product = self::getProduct($product_id);

        $attributes = new Collection();

        foreach ($product->attributes as $attr) {
            $attribute = new Attribute();
            $attribute->id = $attr->id;
            $attribute->name = $attr->name;

            $current_variant = new Variant();
            foreach ($attr->variants as $var) {
                foreach ($var->skus as $sku) {
                    if ($sku->id === $sku_id) {
                        $current_variant->id = $var->id;
                        $current_variant->name = $var->name;
                        $current_variant->url = null;
                        $current_variant->is_current = true;
                    }
                }
            }
            $attribute->cur_variant = $current_variant;

            $variant_list = new Collection();

            foreach ($attr->variants as $var) {
                if ($var->id === $current_variant->id) {
                    $variant = $current_variant;

                } else {
                    $variant = new Variant();
                    $variant->id = $var->id;
                    $variant->name = $var->name;
                    $variant->url = null;
                    $variant->is_current = false;

                    // Search a sku in other attributes where current $sku_id is presented
                    foreach ($var->skus as $sku) {
                        $match_count = 0;
                        foreach ($product->attributes as $search_attr) {
                            if ($search_attr->id !== $attr->id) {
                                foreach ($search_attr->variants as $search_var) {
                                    if ($search_var->skus->contains('id', $sku->id) &&
                                        $search_var->skus->contains('id', $sku_id)) {
                                        $match_count++;
                                    }
                                }
                            }
                        }

                        if ($match_count === (count($product->attributes) - 1)) {
                            $variant->url = route('product', [$product->category_slug, $sku->slug . '-' . $sku->id]);
                        }
                    }
                }

                $variant_list->push($variant);
            }

            $variant_list = $variant_list->sortBy('name');

            $attribute->variant_list = $variant_list;
            $attributes->push($attribute);
        }

        return $attributes;
    }


    private static function getProduct(int $product_id): Product
    {
        return Product::join('categories', 'products.category_id', 'categories.id')
            ->select(
                'products.id',
                'products.category_id',
                'categories.slug AS category_slug',
            )
            ->where('products.id', $product_id)
            ->with('attributes.variants.skus:id,slug')
            ->get()
            ->first();
    }
}