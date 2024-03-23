<?php

namespace App\Modules\Catalog\Actions;

use App\Modules\Brands\Models\Brand;
use Illuminate\Database\Eloquent\Builder;

class GetBrandsAction
{
    public static function run(string $where_left, string $where_op, string $where_right, ?array $checked)
    {
        $brands = Brand::join('products', 'brands.id', 'products.brand_id')
            ->join('skus', 'products.id', 'skus.product_id')
            ->selectRaw('brands.id, brands.name, count(skus.id) as skus_num')
            ->groupBy('brands.id')
            ->where($where_left, $where_op, $where_right)
            ->whereDate('skus.available_from', '<=', now())
            ->where(function (Builder $builder) {
                $builder->whereDate('skus.available_until', '>', now())
                    ->orWhereNull('skus.available_until');
            })
            ->orderBy('brands.name')
            ->get();

        foreach ($brands as $brand) {
            $brand->is_checked = $checked && in_array($brand->id, $checked);
        }

        return $brands;
    }
}