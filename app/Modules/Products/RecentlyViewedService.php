<?php

namespace App\Modules\Products;

use App\Modules\Products\Models\Sku;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Database\Query\JoinClause;

class RecentlyViewedService
{
    public const COOKIE = 'viewed';
    private const LIMIT = 10;


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

        $order_stmt = match (env('DB_CONNECTION')) {
            'pgsql' => 'ARRAY_POSITION(ARRAY[' . implode(', ', $ids) . '], skus.id)',
            'mysql' => 'FIELD(skus.id, ' . implode(', ', $ids) . ')',
        };

        return Sku::join('products', 'skus.product_id', 'products.id')
            ->leftJoin('promos', function (JoinClause $join) {
                $current_date = date('Y-m-d H:i:s');
                $join->on('skus.promo_id', '=', 'promos.id')
                    ->whereDate('promos.starts_at', '<=', $current_date)
                    ->whereDate('promos.ends_at', '>=', $current_date);
            })
            ->select(
                'skus.id',
                'skus.name',
                'skus.slug',
                'products.category_id',
                'skus.short_descr',
                'skus.currency_id',
                'skus.price',
                'skus.discount_prc',
                'skus.final_price',
                'skus.rating',
                'skus.vote_num',
                'promos.id as promo_id',
                'promos.name as promo_name',
                'promos.slug as promo_slug',
            )
            ->whereIn('skus.id', $ids)
            ->orderByRaw($order_stmt)
            ->get();
    }


    public function update(?string $cookie, int $sku_id): array
    {
        if (!$cookie) return [$sku_id];

        $ids = json_decode($cookie);

        if (!in_array($sku_id, $ids)) {
            array_unshift($ids, $sku_id);
            $ids = array_slice($ids, 0, self::LIMIT);
        }

        return $ids;
    }
}