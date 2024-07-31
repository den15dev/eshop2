<?php

namespace App\Admin\Dashboard;

use App\Admin\Dashboard\Actions\GetOrdersCountAction;
use App\Admin\Dashboard\Actions\GetRegisteredUsersCountAction;
use App\Admin\Dashboard\Actions\GetReviewsAddedCountAction;
use App\Admin\Dashboard\Actions\GetSalesAmountAction;
use App\Admin\Dashboard\Actions\GetSkusAddedCountAction;
use App\Modules\Categories\Models\Category;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Currencies\Models\Currency;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardService
{
    public static Currency $cur_currency;


    public function __construct()
    {
        if (!isset(self::$cur_currency)) {
            self::$cur_currency = CurrencyService::getAll()->firstWhere('language_id', app()->getLocale());
        }
    }


    public function getCharts(array $query): \stdClass
    {
        $year = $query['period'] ?? null;
        $currency = $query['currency'] ?? self::$cur_currency->id;
        $category = $query['category'] ?? null;

        $charts = new \stdClass();

        $charts->ordersCount = GetOrdersCountAction::run($year, $category);
        $charts->salesAmount = GetSalesAmountAction::run($category, $currency, $year);
        $charts->skusAddedCount = GetSkusAddedCountAction::run($year, $category);
        $charts->registeredUsersCount = GetRegisteredUsersCountAction::run($year);
        $charts->reviewsAddedCount = GetReviewsAddedCountAction::run($year, $category);

        return $charts;
    }


    public static function buildData(Collection $db_counted, string|int|null $year, string $title): array
    {
        $orders_count = [[__('admin/dashboard.month'), $title]];

        $converted = [];
        foreach ($db_counted as $month_result) {
            $month_num = (string) Carbon::parse($month_result->month_date)->month;
            $converted[$month_num] = $month_result->result;
        }

        $start_num = $year ? 1 : Carbon::now()->month + 1;
        $months_num = $year == Carbon::now()->year ? Carbon::now()->month : 12;
        for ($i = 1, $m = $start_num; $i <= $months_num; $i++, $m++) {
            if ($m > 12) $m = 1;

            $m_str = (string) $m;
            $m_word = __('admin/dashboard.months.' . $m_str);
            if (array_key_exists($m_str, $converted)) {
                $orders_count[] = [$m_word, $converted[$m_str]];
            } else {
                $orders_count[] = [$m_word, 0];
            }
        }

        return $orders_count;
    }


    public function getYears(): array
    {
        $last_year = new \stdClass();
        $last_year->text = __('admin/dashboard.last_year');
        $last_year->value = '';

        $years = [$last_year];

        $oldest_year = Category::oldest()->first()->created_at->year;
        $cur_year = now()->year;

        for ($i = $cur_year; $i >= $oldest_year; $i--) {
            $year = new \stdClass();
            $year->text = $i;
            $year->value = $i;
            $years[] = $year;
        }

        return $years;
    }


    public function getCurrencies(): array
    {
        $cur_currency_out = new \stdClass();
        $cur_currency_out->text = strtoupper(self::$cur_currency->id);
        $cur_currency_out->value = '';
        $cur_currency_out->symbol = self::$cur_currency->symbol;
        $currencies = [$cur_currency_out];

        $currencies_all = CurrencyService::getAll();
        foreach ($currencies_all as $curr) {
            if ($curr->id !== self::$cur_currency->id) {
                $currency_out = new \stdClass();
                $currency_out->text = strtoupper($curr->id);
                $currency_out->value = $curr->id;
                $currency_out->symbol = $curr->symbol;
                $currencies[] = $currency_out;
            }
        }

        return $currencies;
    }


    public function getPageState($query): \stdClass
    {
        $state = new \stdClass();

        $state->period = isset($query['period']) ? intval($query['period']) : null;
        $state->category = isset($query['category']) ? intval($query['category']) : null;
        $state->currency = $query['currency'] ?? null;

        return $state;
    }


    public static function getLeafCategoryIds(int $category_id, Collection $categories): array
    {
        static $out_arr = [];
        $children = $categories->where('parent_id', $category_id);

        if ($children->isNotEmpty()) {
            foreach ($children as $child) {
                self::getLeafCategoryIds($child->id, $categories);
            }

        } else {
            $out_arr[] = $category_id;
        }

        return $out_arr;
    }
}