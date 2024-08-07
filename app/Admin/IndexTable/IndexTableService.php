<?php

namespace App\Admin\IndexTable;

use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IndexTableService
{
    public const PER_PAGE_COOKIE = 'tbl_perpage';
    public static int $per_page = 10;
    public static string $table_name;
    public static array $columns;


    public function initTable(string $table_name, ?array $query = null): void
    {
        self::$table_name = $table_name;

        $columns = include_once __DIR__ . '/../' . mb_ucfirst($table_name) . '/columns.php';

        if (isset($query['sort'])) {
            foreach ($columns as &$column) {
                if ($column['id'] === $query['sort']) {
                    $column['sort_order'] = $query['order'];
                    break;
                }
            }
        }

        self::$columns = $columns;
    }


    public function getCurrentColumns(?array $column_prefs): Collection
    {
        $column_prefs = $this->getColumnPrefs($column_prefs);
        $columns_out = new Collection();

        foreach (self::$columns as $index => $column) {
            if (in_array($index, $column_prefs)) {
                $col = ColumnData::fromArray(self::$table_name, $column);
                $columns_out->push($col);
            }
        }

        return $columns_out;
    }


    public function getColumnList(?array $column_prefs): Collection
    {
        $column_prefs = $this->getColumnPrefs($column_prefs);
        $list = new Collection();

        foreach (self::$columns as $index => $column) {
            $col = new \stdClass();
            $col->id = $column['id'];
            $col->input_id = Str::camel('col_' . $column['id']);
            $col->index = $index;
            $col->name = __('admin/' . self::$table_name . '.columns.' . $column['id']);
            $col->is_checked = in_array($index, $column_prefs);

            $list->push($col);
        }

        return $list;
    }


    private function getColumnPrefs(?array $column_prefs): array
    {
        if (!$column_prefs) {
            $column_prefs = [];
            foreach (self::$columns as $index => $column) {
                if ((isset($column['is_default']) && $column['is_default'])) {
                    $column_prefs[] = $index;
                }
            }
        }

        return $column_prefs;
    }


    public static function getPerPageList(): Collection
    {
        $per_page_array = [10, 20, 30];
        $list = new Collection();

        foreach ($per_page_array as $item) {
            $pp_obj = new \stdClass();
            $pp_obj->num = $item;
            $pp_obj->is_active = $item === self::$per_page;

            $list->push($pp_obj);
        }

        return $list;
    }


    public function constrainBySearchStr(EBuilder $db_query, string $search_str): EBuilder
    {
        if (!empty($search_str)) {
            $db_query = $db_query->where(function (EBuilder $query) use ($search_str) {

                foreach (self::$columns as $key => $column) {
                    if (isset($column['search_field'])) {
                        $search_field = $column['search_field'];
                        $pattern = mb_strlen($search_str) === 1 ? $search_str : '%' . $search_str . '%';

                        if ($key) {
                            $query = $query->orWhere($search_field, 'ilike', $pattern);
                        } else {
                            $query = $query->where($search_field, 'ilike', $pattern);
                        }
                    }
                }
            });
        }

        return $db_query;
    }


    public function orderQuery(EBuilder $db_query, $query): EBuilder
    {
        $order_by = null;
        foreach (self::$columns as $column) {
            if ($column['id'] === $query['sort']) {
                $order_by = $column['order_by'];
                break;
            }
        }

        return $order_by ? $db_query->orderBy($order_by, $query['order']) : $db_query;
    }
}