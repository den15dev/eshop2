<?php

namespace App\Admin\Orders;

use App\Admin\IndexTable\IndexTableService;
use App\Modules\Orders\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class OrderService
{
    public const TABLE_NAME = 'orders';
    public const COLUMNS_COOKIE = 'cls_orders';
    public const ROW_LINKS = true;


    public function buildIndexQuery(array $query, IndexTableService $tableService): Builder
    {
        $db_query = Order::leftJoin('shops', 'orders.shop_id', 'shops.id')
            ->select(
                'orders.*',
                'shops.name->' . app()->getLocale() . ' as shop_name',
            );

        if (isset($query['search'])) {
            $db_query = $tableService->constrainBySearchStr($db_query, $query['search']);
        }

        return isset($query['sort'])
            ? $tableService->orderQuery($db_query, $query)
            : $db_query->orderByDesc('orders.id');
    }


    public function getPageState($query): \stdClass
    {
        $state = new \stdClass();

        $state->search = $query['search'] ?? null;
        $state->sort = $query['sort'] ?? null;
        $state->order = $query['order'] ?? null;

        return $state;
    }
}