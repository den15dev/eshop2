<?php

use App\Admin\Promos\ColumnFormatter;

return [
    [
        'id' => 'id',
        'search_field' => 'promos.id',
        'order_by' => 'promos.id',
        'is_default' => true,
    ],
    [
        'id' => 'image',
        'show_name' => false,
        'is_default' => true,
        'format' => new ColumnFormatter('imageLink'),
    ],
    [
        'id' => 'name',
        'class_list' => 'text-start',
        'search_field' => 'promos.name',
        'order_by' => 'promos.name',
        'is_default' => true,
        'format' => new ColumnFormatter('nameLink'),
    ],
    [
        'id' => 'discount',
        'order_by' => 'promos.discount',
        'format' => new ColumnFormatter('percent'),
    ],
    [
        'id' => 'starts_at',
        'order_by' => 'promos.starts_at',
        'format' => new ColumnFormatter('dateFormat'),
    ],
    [
        'id' => 'ends_at',
        'order_by' => 'promos.ends_at',
        'format' => new ColumnFormatter('dateFormat'),
    ],
    [
        'id' => 'created_at',
        'order_by' => 'promos.created_at',
    ],
];
