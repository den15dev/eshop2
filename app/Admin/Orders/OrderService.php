<?php

namespace App\Admin\Orders;

use App\Admin\IndexTable\IndexTableService;
use App\Modules\Orders\Enums\OrderStatus;
use App\Modules\Orders\Models\Order;
use Illuminate\Database\Eloquent\Builder as EBuilder;

class OrderService
{
    public const TABLE_NAME = 'orders';
    public const COLUMNS_COOKIE = 'cls_orders';
    public const ROW_LINKS = true; // A whole table row will be a link (every <td> content will be wrapped by <a> tag)
    private static ?int $new_num = null;


    public function buildIndexQuery(array $query, IndexTableService $tableService): EBuilder
    {
        $db_query = Order::leftJoin('shops', 'orders.shop_id', 'shops.id')
            ->select(
                'orders.*',
                'shops.name->' . app()->getLocale() . ' as shop_name',
            );

        if (isset($query['search'])) {
            $db_query = $tableService->constrainBySearchStr($db_query, $query['search']);
        }

        if (isset($query['chb'])) {
            $checkboxes = [];
            foreach ($query['chb'] as $key => $val) {
                $checkboxes[$key] = $val === 'true';
            }

            $db_query = $this->constrainByCheckboxes($db_query, $checkboxes);
        }

        return isset($query['sort'])
            ? $tableService->orderQuery($db_query, $query)
            : $db_query->orderByDesc(self::TABLE_NAME . '.id');
    }


    public function getPageState($query): \stdClass
    {
        $state = new \stdClass();

        $state->search = $query['search'] ?? null;
        $state->new = isset($query['chb']['new']) ? $query['chb']['new'] === 'true' : false;
        $state->ready = isset($query['chb']['ready']) ? $query['chb']['ready'] === 'true' : false;
        $state->cancelled = isset($query['chb']['cancelled']) ? $query['chb']['cancelled'] === 'true' : false;
        $state->sort = $query['sort'] ?? null;
        $state->order = $query['order'] ?? null;

        return $state;
    }


    private function constrainByCheckboxes(EBuilder $db_query, array $checkboxes): EBuilder
    {

        if (isset($checkboxes['new'])) {
            $db_query = $db_query->where('status', 'new');
        }

        if (isset($checkboxes['ready'])) {
            $db_query = $db_query->orWhere('status', 'ready');
        }

        if (isset($checkboxes['cancelled'])) {
            $db_query = $db_query->orWhere('status', 'cancelled');
        }

        return $db_query;
    }


    public static function getNewNum()
    {
        if (self::$new_num === null) {
            self::$new_num = Order::where('status', OrderStatus::New)->count();
        }

        return self::$new_num;
    }
}
