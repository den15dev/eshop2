<?php

namespace App\Admin\IndexTable;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class IndexTableService
{
    public const PER_PAGE_COOKIE = 'tbl_perpage';
    public static int $per_page = 10;


    public function getCurrentColumns(array $columns, ?array $column_prefs): Collection
    {
        $column_prefs = $this->getColumnPrefs($columns, $column_prefs);
        $columns_out = new Collection();

        foreach ($columns as $index => $column) {
            if (in_array($index, $column_prefs)) {
                $col = ColumnData::fromArray($column);
                $columns_out->push($col);
            }
        }

        return $columns_out;
    }


    public function getColumnList(array $columns, ?array $column_prefs): Collection
    {
        $column_prefs = $this->getColumnPrefs($columns, $column_prefs);
        $list = new Collection();

        foreach ($columns as $index => $column) {
            $col = new \stdClass();
            $col->id = $column['id'];
            $col->input_id = Str::camel('col_' . $column['id']);
            $col->index = $index;
            $col->name = __('admin/products.columns.' . $column['id']);
            $col->is_checked = in_array($index, $column_prefs);

            $list->push($col);
        }

        return $list;
    }


    private function getColumnPrefs(array $columns, ?array $column_prefs): array
    {
        if (!$column_prefs) {
            $column_prefs = [];
            foreach ($columns as $index => $column) {
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


    public function constrainBySearchStr(Builder $db_query, string $search_str, array $columns): Builder
    {
        if (!empty($search_str)) {
            $db_query = $db_query->where(function (Builder $query) use ($columns, $search_str) {

                foreach ($columns as $key => $column) {
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
}