<?php

namespace App\Admin\Dashboard\Actions;

use App\Admin\Dashboard\DashboardService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetRegisteredUsersCountAction
{
    public static function run(int|null $year): array
    {
        $query = DB::table('users')
            ->selectRaw('COUNT(id) AS result')
            ->selectRaw('DATE_TRUNC(\'month\', created_at) AS month_date');

        $query = $year
            ? $query->whereYear('created_at', '=', $year)
            : $query->where('created_at', '>=', Carbon::now()->subYear());

        $counted = $query->groupByRaw('month_date')
            ->orderBy('month_date')
            ->get();

        return DashboardService::buildData($counted, $year, __('admin/dashboard.users_registered'));
    }
}