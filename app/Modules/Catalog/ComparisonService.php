<?php

namespace App\Modules\Catalog;

use App\Modules\Categories\Models\Specification;
use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ComparisonService
{
    public const COOKIE = 'comparison';

    private static ?\stdClass $data = null;


    public static function get(): ?\stdClass
    {
        return self::$data;
    }

    public static function set(?array $cookie_data): void
    {
        if ($cookie_data) {
            $comparisonData = new \stdClass();
            $comparisonData->category_id = $cookie_data[0];
            $comparisonData->sku_ids = $cookie_data[1];
            $comparisonData->is_popup_collapsed = $cookie_data[2];

            self::$data = $comparisonData;
        }
    }


    public function getPopupSkus(): Collection
    {
        if (!self::$data) return new Collection();
        $ids = self::$data->sku_ids;

        return Sku::join('products', 'skus.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'skus.code',
                'products.category_id',
                'categories.slug as category_slug',
            )
            ->whereIn('skus.id', $ids)
            ->orderByRaw(order_by_array($ids, 'skus.id'))
            ->get();
    }


    public function getPageSkus(): Collection
    {
        if (!self::$data) return new Collection();
        $ids = self::$data->sku_ids;

        return Sku::join('products', 'skus.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->joinActivePromos()
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'skus.code',
                'products.category_id',
                'categories.slug as category_slug',
                'skus.currency_id',
                'skus.price',
                DB::raw(Sku::DISCOUNT . ' as discount'),
            )
            ->whereIn('skus.id', $ids)
            ->orderByRaw(order_by_array($ids, 'skus.id'))
            ->get();
    }


    public function getPageSpecs(): Collection
    {
        if (!self::$data) return new Collection();
        $category_id = self::$data->category_id;
        $ids = self::$data->sku_ids;

        return Specification::select(
            'id',
            'name',
            'units',
            'sort',
        )
        ->where('category_id', $category_id)
        ->whereHas('skus', function (Builder $query) use ($ids) {
            $query->whereIn('skus.id', $ids);
        })
        ->with(['skus' => function ($query) use ($ids) {
            $query->select('skus.id')->whereIn('skus.id', $ids);
        }])
        ->orderBy('specifications.sort')
        ->get();
    }
}
