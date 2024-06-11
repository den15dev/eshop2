<?php

namespace App\Modules\Products\Actions;

use App\Modules\Products\Models\Sku;
use Illuminate\Support\Facades\DB;

class GetSkuAction
{
    public static function run(int $id): ?Sku
    {
        $sku = Sku::join('products', 'skus.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->join('brands', 'products.brand_id', 'brands.id')
            ->joinActivePromos()
            ->select(
                'skus.id',
                'skus.product_id',
                'skus.name',
                'skus.slug',
                'skus.sku',
                'skus.short_descr',
                'skus.description',
                'skus.currency_id',
                'skus.price',
                DB::raw(Sku::DISCOUNT . ' as discount'),
                'skus.rating',
                'skus.vote_num',
                'skus.images',
                'skus.available_from',
                'skus.available_until',
                'skus.promo_id',
                'products.category_id',
                'categories.slug as category_slug',
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

        if ($sku) {
            foreach ($sku->specifications as $spec) {
                $value = $spec->pivot->spec_value;
                $value = $value === 'да' ? 'есть' : $value;
                $value = preg_replace('/^\[(.+)]$/', '$1', $value);
                $units_str = $spec->units ? ' ' . $spec->units : '';

                $spec->value = $value;
                $spec->units_str = $units_str;
            }
        }

        return $sku;
    }
}