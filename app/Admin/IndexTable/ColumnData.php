<?php

namespace App\Admin\IndexTable;

use Illuminate\Support\Facades\Lang;

class ColumnData
{
    public string $id = '';
    public ?string $name = null;
    public bool $show_name = true;
    public ?string $class_list = null;
    public ?string $order_by = null;
    public ?string $sort_order = null;
    public ?string $search_field = null;
    public ?object $format = null;
    public bool $is_default = false;


    public function __construct(array $column_data)
    {
        foreach ($column_data as $key => $val) {
            $this->$key = $val;
        }

        if (Lang::has('admin/products.columns.' . $column_data['id'])) {
            $this->name = __('admin/products.columns.' . $column_data['id']);
        }
    }


    public static function fromArray(array $column_data): self
    {
        return new self($column_data);
    }
}