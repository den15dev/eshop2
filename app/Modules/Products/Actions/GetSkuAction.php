<?php

namespace App\Modules\Products\Actions;

use App\Modules\Products\Models\Sku;

class GetSkuAction
{
    public static function run(int $id): Sku
    {
        $sku = Sku::join('products', 'skus.product_id', 'products.id')
            ->join('brands', 'products.brand_id', 'brands.id')
            ->joinPromos()
            ->select(
                'skus.*',
                'products.category_id',
                'brands.name AS brand_name',
                'brands.slug AS brand_slug',
                'promos.id as promo_id',
                'promos.name as promo_name',
                'promos.slug as promo_slug',
            )
            ->where('skus.id', $id)
            ->with('specifications')
            ->withCount(['reviews as reviews_count' => function ($query) {
                $query->whereNotNull('reviews.pros')
                    ->orWhereNotNull('reviews.cons')
                    ->orWhereNotNull('reviews.comnt');
            }])
            ->get()
            ->first();

        foreach ($sku->specifications as $spec) {
            $value = $spec->pivot->spec_value;
            $value = $value === 'да' ? 'есть' : $value;
            $value = preg_replace('/^\[(.+)]$/', '$1', $value);
            $units_str = $spec->units ? ' ' . $spec->units : '';

            $spec->value = $value;
            $spec->units_str = $units_str;
        }

        return $sku;
    }
}