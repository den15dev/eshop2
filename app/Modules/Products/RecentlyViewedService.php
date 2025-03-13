<?php

namespace App\Modules\Products;

use App\Modules\Products\Models\Sku;
use App\Modules\Settings\SettingService;
use Illuminate\Database\Eloquent\Collection as ECollection;

class RecentlyViewedService
{
    public const COOKIE = 'viewed';


    public function get(?string $cookie, int $exclude_id = 0): ECollection
    {
        if (!$cookie) return new ECollection();

        $ids = json_decode($cookie);

        if ($exclude_id) {
            $ids = array_values(array_filter($ids, function ($e) use ($exclude_id) {
                return $e !== $exclude_id;
            }));
        }

        if (!count($ids)) return new ECollection();

        return Sku::join('products', 'skus.product_id', 'products.id')
            ->join('categories', 'products.category_id', 'categories.id')
            ->joinActivePromos()
            ->selectForCards()
            ->whereIn('skus.id', $ids)
            ->orderByRaw(order_by_array($ids, 'skus.id'))
            ->get();
    }


    public function update(?string $cookie, int $sku_id): array
    {
        if (!$cookie) return [$sku_id];

        $ids = json_decode($cookie);

        if (!in_array($sku_id, $ids)) {
            array_unshift($ids, $sku_id);
            $ids = array_slice($ids, 0, SettingService::get('carousel_items_num'));
        }

        return $ids;
    }
}
