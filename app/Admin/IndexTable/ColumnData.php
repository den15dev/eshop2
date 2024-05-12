<?php

namespace App\Admin\IndexTable;

use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\Lang;

class ColumnData
{
    public string $id = '';
    public ?string $name = null;
    public bool $show_name = true;
    public ?string $class_list = null;
    public null|string|Expression $order_by = null;
    public ?string $sort_order = null;
    public ?string $search_field = null;
    public ?object $format = null;
    public bool $is_default = false;


    public function __construct(string $table_name, array $column_data)
    {
        foreach ($column_data as $key => $val) {
            $this->$key = $val;
        }

        if (Lang::has('admin/' . $table_name . '.columns.' . $column_data['id'])) {
            $this->name = __('admin/' . $table_name . '.columns.' . $column_data['id']);
        }
    }


    public static function fromArray(string $table_name, array $column_data): self
    {
        return new self($table_name, $column_data);
    }
}