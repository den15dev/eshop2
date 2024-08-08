<?php

use App\Admin\Brands\BrandColumnFormatter;

return [
    [
        'id' => 'id',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'brands.id',
        'search_field' => 'brands.id',
        'format' => null,
        'is_default' => true,
    ],
    [
        'id' => 'name',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'brands.name',
        'search_field' => 'brands.name',
        'format' => null,
        'is_default' => true,
    ],
    [
        'id' => 'image',
        'show_name' => false,
        'class_list' => null,
        'order_by' => null,
        'search_field' => null,
        'format' => new BrandColumnFormatter('brandImage'),
        'is_default' => true,
    ],
    [
        'id' => 'created_at',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'brands.created_at',
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
];
