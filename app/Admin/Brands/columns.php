<?php

use App\Admin\Brands\ColumnFormatter;

return [
    [
        'id' => 'id',
        'search_field' => 'brands.id',
        'order_by' => 'brands.id',
        'is_default' => true,
    ],
    [
        'id' => 'name',
        'search_field' => 'brands.name',
        'order_by' => 'brands.name',
        'is_default' => true,
        'format' => new ColumnFormatter('nameLink'),
    ],
    [
        'id' => 'image',
        'show_name' => false,
        'is_default' => true,
        'format' => new ColumnFormatter('imageLink'),
    ],
    [
        'id' => 'created_at',
        'order_by' => 'brands.created_at',
    ],
];
