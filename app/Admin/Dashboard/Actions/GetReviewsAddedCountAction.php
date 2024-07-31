<?php

namespace App\Admin\Dashboard\Actions;

use App\Admin\Dashboard\DashboardService;
use App\Modules\Categories\CategoryService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetReviewsAddedCountAction
{
    public static function run(string|int|null $year, ?int $category_id): array
    {
        $query = DB::table('reviews')
            ->join('skus', 'skus.id', 'reviews.sku_id')
            ->join('products', 'products.id', 'skus.product_id')
            ->selectRaw('COUNT(reviews.id) AS result')
            ->selectRaw('DATE_TRUNC(\'month\', reviews.created_at) AS month_date');

        $query = $year
            ? $query->whereYear('reviews.created_at', '=', $year)
            : $query->where('reviews.created_at', '>=', Carbon::now()->subYear());

        if ($category_id) {
            $leaf_category_ids = DashboardService::getLeafCategoryIds($category_id, CategoryService::getAll());
            $query = $query->whereIn('products.category_id', $leaf_category_ids);
        }

        $counted = $query->groupByRaw('month_date')
            ->orderBy('month_date')
            ->get();

        return DashboardService::buildData($counted, $year, __('admin/dashboard.reviews_added'));
    }
}