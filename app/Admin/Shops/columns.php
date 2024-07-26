<?php

use App\Admin\Shops\ColumnFormatter;

return [
    [
        'id' => 'id',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'shops.id',
        'search_field' => null,
        'format' => null,
        'is_default' => true,
    ],
    [
        'id' => 'name',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'shops.name',
        'search_field' => 'shops.name',
        'format' => null,
        'is_default' => true,
    ],
    [
        'id' => 'address',
        'show_name' => true,
        'class_list' => 'text-start',
        'order_by' => null,
        'search_field' => 'shops.address',
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'opening_hours',
        'show_name' => true,
        'class_list' => null,
        'order_by' => null,
        'search_field' => null,
        'format' => new ColumnFormatter('openingHours'),
        'is_default' => false,
    ],
    [
        'id' => 'is_active',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'shops.is_active',
        'search_field' => null,
        'format' => new ColumnFormatter('isActive'),
        'is_default' => true,
    ],
    [
        'id' => 'created_at',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'shops.created_at',
        'search_field' => null,
        'format' => null,
        'is_default' => true,
    ],
    [
        'id' => 'updated_at',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'shops.updated_at',
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
];
