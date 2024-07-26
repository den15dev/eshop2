<?php

namespace App\Admin\Shops;

use App\Admin\IndexTable\IndexTableService;
use App\Modules\Shops\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EBuilder;

class ShopService
{
    public const TABLE_NAME = 'shops';
    public const COLUMNS_COOKIE = 'cls_shops';
    public const ROW_LINKS = true; // A whole table row will be a link (every <td> content will be wrapped by <a> tag)


    public function buildIndexQuery(array $query, IndexTableService $tableService): Builder
    {
        $db_query = Shop::select(
            'shops.*',
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
        $state->active = isset($query['chb']['active']) ? $query['chb']['active'] === 'true' : false;
        $state->inactive = isset($query['chb']['inactive']) ? $query['chb']['inactive'] === 'true' : false;
        $state->sort = $query['sort'] ?? null;
        $state->order = $query['order'] ?? null;

        return $state;
    }


    private function constrainByCheckboxes(EBuilder $db_query, array $checkboxes): EBuilder
    {

        if (isset($checkboxes['active'])) {
            $db_query = $db_query->where('is_active', true);
        }

        if (isset($checkboxes['inactive'])) {
            $db_query = $db_query->orWhere('is_active', false);
        }

        return $db_query;
    }


    public function getOpeningHoursForEdit(?array $opening_hours = null): string
    {
        $out_str = '';
        $days = [
            __('stores.weekdays.mo'),
            __('stores.weekdays.tu'),
            __('stores.weekdays.we'),
            __('stores.weekdays.th'),
            __('stores.weekdays.fr'),
            __('stores.weekdays.sa'),
            __('stores.weekdays.su'),
        ];

        if ($opening_hours) {
            foreach ($days as $key => $day) {
                $out_str .= $day . ': ' . implode('-', $opening_hours[$key]) . "\n";
            }
        } else {
            foreach ($days as $day) {
                $out_str .= $day . ': ' . "\n";
            }
        }

        return rtrim($out_str);
    }


    public function parseOpeningHours(string $opening_hours): array
    {
        $opening_hours_arr = [];

        $lines_arr = explode("\n", trim($opening_hours));
        foreach ($lines_arr as $line) {
            $hours_pair = [];
            $time_arr = explode(':', trim($line));
            if (count($time_arr) > 1) {
                $time = trim($time_arr[1]);
                $hours_arr = explode('-', $time);
                if (count($hours_arr) > 1) {
                    $hours_pair = [intval(trim($hours_arr[0])), intval(trim($hours_arr[1]))];
                }
            }

            $opening_hours_arr[] = $hours_pair;
        }

        return $opening_hours_arr;
    }


    public function parseLocation(string $location): array
    {
        $location_arr = explode(',', $location);

        return [floatval(trim($location_arr[0])), floatval(trim($location_arr[1]))];
    }


    public function updateActiveStatus(int $shop_id, bool $is_active): \stdClass
    {
        $shop = Shop::find($shop_id);
        $shop->is_active = $is_active;
        $shop->save();

        $response = new \stdClass();
        $response->shop_id = $shop_id;
        $response->is_active = $is_active;
        $response->message = $is_active
            ? __('admin/shops.messages.now_active')
            : __('admin/shops.messages.now_inactive');

        return $response;
    }


    public function updateOrder(int $sort_new, ?int $sort_old = null, ?int $shop_id = null): int
    {
        $max_sort = Shop::max('sort');
        if ($sort_new === 0) $sort_new = 1;

        if ($shop_id && $sort_old) {
            if ($sort_new !== $sort_old) {
                if ($sort_new > $max_sort) $sort_new = $max_sort;

                if ($sort_new > $sort_old) {
                    Shop::where('sort', '>', $sort_old)
                        ->where('sort', '<=', $sort_new)
                        ->decrement('sort');
                } else {
                    Shop::where('sort', '<', $sort_old)
                        ->where('sort', '>=', $sort_new)
                        ->increment('sort');
                }

                Shop::find($shop_id)->update(['sort' => $sort_new]);
            }

        } else {
            if ($sort_new > $max_sort + 1) $sort_new = $max_sort + 1;

            if ($sort_new <= $max_sort) {
                Shop::where('sort', '>=', $sort_new)
                    ->increment('sort');
            }
        }

        return $sort_new;
    }
}