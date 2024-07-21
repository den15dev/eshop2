<?php

use App\Admin\Promos\ColumnFormatter;

return [
    [
        'id' => 'id',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'promos.id',
        'search_field' => 'promos.id',
        'format' => null,
        'is_default' => true,
    ],
    [
        'id' => 'image',
        'show_name' => false,
        'class_list' => null,
        'order_by' => null,
        'search_field' => null,
        'format' => new ColumnFormatter('imageLink'),
        'is_default' => true,
    ],
    [
        'id' => 'name',
        'show_name' => true,
        'class_list' => 'text-start',
        'order_by' => 'promos.name',
        'search_field' => 'promos.name',
        'format' => new ColumnFormatter('nameLink'),
        'is_default' => true,
    ],
    [
        'id' => 'discount',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'promos.discount',
        'search_field' => null,
        'format' => new ColumnFormatter('percent'),
        'is_default' => false,
    ],
    [
        'id' => 'starts_at',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'promos.starts_at',
        'search_field' => null,
        'format' => new ColumnFormatter('dateFormat'),
        'is_default' => false,
    ],
    [
        'id' => 'ends_at',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'promos.ends_at',
        'search_field' => null,
        'format' => new ColumnFormatter('dateFormat'),
        'is_default' => false,
    ],
    [
        'id' => 'created_at',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'promos.created_at',
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
];
