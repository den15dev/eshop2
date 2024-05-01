<?php

use App\Admin\Products\ColumnFormatter;

return [
    [
        'id' => 'id',
        'search_field' => 'skus.id',
        'order_by' => 'skus.id',
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
        'search_field' => 'skus.name->' . app()->getLocale(),
        'order_by' => 'skus.name->' . app()->getLocale(),
        'is_default' => true,
        'format' => new ColumnFormatter('nameLink'),
    ],
    [
        'id' => 'product_id',
        'search_field' => 'skus.product_id',
        'order_by' => 'skus.product_id',
    ],
    [
        'id' => 'product_name',
        'is_default' => true,
        'order_by' => 'products.name->' . app()->getLocale(),
        'format' => new ColumnFormatter('productLink'),
    ],
    [
        'id' => 'sku_count',
    ],
    [
        'id' => 'sku',
        'search_field' => 'skus.sku',
        'order_by' => 'skus.sku',
    ],
    [
        'id' => 'category_name',
        'order_by' => 'categories.name->' . app()->getLocale(),
    ],
    [
        'id' => 'brand_name',
        'order_by' => 'brands.name',
    ],
    [
        'id' => 'currency_id',
        'order_by' => 'skus.currency_id',
    ],
    [
        'id' => 'price',
        'order_by' => 'skus.price',
        'class_list' => 'nowrap',
    ],
    [
        'id' => 'discount_prc',
        'order_by' => 'skus.discount_prc',
    ],
    [
        'id' => 'final_price',
        'class_list' => 'nowrap',
        'is_default' => true,
        'order_by' => 'skus.final_price',
        'format' => new ColumnFormatter('finalPriceFormatted'),
    ],
    [
        'id' => 'rating',
        'order_by' => 'skus.rating',
    ],
    [
        'id' => 'vote_num',
        'order_by' => 'skus.vote_num',
    ],
    [
        'id' => 'available_from',
        'order_by' => 'skus.available_from',
        'format' => new ColumnFormatter('scheduled'),
    ],
    [
        'id' => 'available_until',
        'order_by' => 'skus.available_until',
    ],
    [
        'id' => 'promo_id',
        'order_by' => 'skus.promo_id',
    ],
    [
        'id' => 'promo_name',
        'order_by' => 'promos.name',
    ],
    [
        'id' => 'created_at',
        'order_by' => 'skus.created_at',
    ],
];
