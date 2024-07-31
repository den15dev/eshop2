<?php

namespace App\Admin\Dashboard\Actions;

use App\Modules\Categories\CategoryService;
use App\Admin\Dashboard\DashboardService;
use App\Modules\Currencies\Models\Currency;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class GetSalesAmountAction
{
    public static function run(?int $category_id, string $currency_id, string|int|null $year): array
    {
        return $category_id
            ? self::getByCategory($category_id, $currency_id, $year)
            : self::getAll($currency_id, $year);
    }


    public static function getAll(string $currency_id, string|int|null $year): array
    {
        $out_rate = Currency::firstWhere('id', $currency_id)->exchange_rate;
        $order_rate = 'SELECT exchange_rate FROM currencies WHERE currencies.id = orders.currency_id';

        $query = DB::table('orders')->selectRaw('DATE_TRUNC(\'month\', created_at) AS month_date')
            ->selectRaw('SUM(items_cost * (' . $order_rate . ') / ' . $out_rate . ') filter (WHERE status != \'cancelled\') AS result');

        return self::getAndBuildData($query, $year);
    }


    public static function getByCategory(int $category_id, string $currency_id, string|int|null $year): array
    {
        $out_rate = Currency::firstWhere('id', $currency_id)->exchange_rate;
        $order_rate = 'SELECT exchange_rate FROM currencies WHERE currencies.id = orders.currency_id';

        $category_filter = $category_id
            ? ' AND order_items.id IN (' . self::filterOrderItemsByCategory($category_id) . ')'
            : '';

        $count_statement = 'COALESCE(SUM(price * quantity * (' . $order_rate . ') / ' . $out_rate . ')
                filter (WHERE orders.status != \'cancelled\'' . $category_filter . '), 0) AS result';

        $query = DB::table('order_items')
            ->join('orders', 'orders.id', 'order_items.order_id')
            ->selectRaw('DATE_TRUNC(\'month\', created_at) AS month_date')
            ->selectRaw($count_statement);

        return self::getAndBuildData($query, $year);
    }


    private static function getAndBuildData(Builder $query, string|int|null $year): array
    {
        $query = $year
            ? $query->whereYear('created_at', '=', $year)
            : $query->where('created_at', '>=', Carbon::now()->subYear());

        $counted = $query->groupByRaw('month_date')
            ->orderBy('month_date')
            ->get();

        foreach ($counted as $month_result) {
            $month_result->result = round(floatval($month_result->result), 2);
        }

        return DashboardService::buildData($counted, $year, __('admin/dashboard.sales_amount'));
    }


    private static function filterOrderItemsByCategory(int $category_id): string
    {
        $leaf_category_ids = '(' . implode(',', DashboardService::getLeafCategoryIds($category_id, CategoryService::getAll())) . ')';

        return 'SELECT oi.id FROM order_items oi
                JOIN skus ON oi.sku_id = skus.id
                JOIN products p ON skus.product_id = p.id
                WHERE p.category_id IN ' . $leaf_category_ids . '
                GROUP BY oi.id
                ORDER BY oi.id';
    }
}