<?php

namespace App\Admin\Dashboard\Actions;

use App\Admin\Dashboard\DashboardService;
use App\Modules\Categories\CategoryService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetOrdersCountAction
{
    public static function run(string|int|null $year, ?int $category_id): array
    {
        $category_filter = $category_id
            ? ' AND id IN (' . self::filterOrdersByCategory($category_id) . ')'
            : '';

        $count_statement = 'COUNT(id) filter (WHERE status != \'cancelled\'' . $category_filter . ') AS result';

        $query = DB::table('orders')->selectRaw('DATE_TRUNC(\'month\', created_at) AS month_date')
            ->selectRaw($count_statement);

        $query = $year
            ? $query->whereYear('created_at', '=', $year)
            : $query->where('created_at', '>=', Carbon::now()->subYear());

        $counted = $query->groupByRaw('month_date')
            ->orderBy('month_date')
            ->get();

        return DashboardService::buildData($counted, $year, __('admin/dashboard.orders_count'));
    }


    private static function filterOrdersByCategory(int $category_id): string
    {
        $leaf_category_ids = '(' . implode(',', DashboardService::getLeafCategoryIds($category_id, CategoryService::getAll())) . ')';

        return 'SELECT orders.id FROM orders
                JOIN order_items oi ON orders.id = oi.order_id
                JOIN skus ON oi.sku_id = skus.id
                JOIN products p ON skus.product_id = p.id
                WHERE p.category_id IN ' . $leaf_category_ids . '
                GROUP BY orders.id
                ORDER BY orders.id';
    }
}