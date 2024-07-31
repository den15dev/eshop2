<?php

namespace App\Admin\Dashboard\Actions;

use App\Admin\Dashboard\DashboardService;
use App\Modules\Categories\CategoryService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetSkusAddedCountAction
{
    public static function run(string|int|null $year, ?int $category_id): array
    {
        $query = DB::table('skus')
            ->join('products', 'products.id', 'skus.product_id')
            ->selectRaw('COUNT(skus.id) AS result')
            ->selectRaw('DATE_TRUNC(\'month\', skus.created_at) AS month_date');

        $query = $year
            ? $query->whereYear('skus.created_at', '=', $year)
            : $query->where('skus.created_at', '>=', Carbon::now()->subYear());

        if ($category_id) {
            $leaf_category_ids = DashboardService::getLeafCategoryIds($category_id, CategoryService::getAll());
            $query = $query->whereIn('products.category_id', $leaf_category_ids);
        }

        $counted = $query->groupByRaw('month_date')
            ->orderBy('month_date')
            ->get();

        return DashboardService::buildData($counted, $year, __('admin/dashboard.skus_added'));
    }
}