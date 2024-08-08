<?php

use App\Admin\Products\ProductColumnFormatter;
use App\Modules\Currencies\CurrencyService;
use App\Modules\Products\Models\Sku;
use Illuminate\Support\Facades\DB;

return [
    [
        'id' => 'id',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'skus.id',
        'search_field' => 'skus.id',
        'format' => null,
        'is_default' => true,
    ],
    [
        'id' => 'image',
        'show_name' => false,
        'class_list' => null,
        'order_by' => null,
        'search_field' => null,
        'format' => new ProductColumnFormatter('imageLink'),
        'is_default' => true,
    ],
    [
        'id' => 'name',
        'show_name' => true,
        'class_list' => 'text-start',
        'order_by' => 'skus.name->' . app()->getLocale(),
        'search_field' => 'skus.name->' . app()->getLocale(),
        'format' => new ProductColumnFormatter('nameLink'),
        'is_default' => true,
    ],
    [
        'id' => 'product_id',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'skus.product_id',
        'search_field' => 'skus.product_id',
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'product_name',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'products.name->' . app()->getLocale(),
        'search_field' => null,
        'format' => new ProductColumnFormatter('productLink'),
        'is_default' => true,
    ],
    [
        'id' => 'sku_count',
        'show_name' => true,
        'class_list' => null,
        'order_by' => null,
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'sku',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'skus.sku',
        'search_field' => 'skus.sku',
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'category_name',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'categories.name->' . app()->getLocale(),
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'brand_name',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'brands.name',
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'currency_id',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'skus.currency_id',
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'price',
        'show_name' => true,
        'class_list' => 'nowrap',
        'order_by' => 'skus.price',
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'discount',
        'show_name' => true,
        'class_list' => null,
        'order_by' => DB::raw(Sku::DISCOUNT_FILTERED),
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'final_price',
        'show_name' => true,
        'class_list' => 'nowrap',
        'order_by' => DB::raw(Sku::FINAL_PRICE . ' * ' . CurrencyService::RATE_SUBQUERY),
        'search_field' => null,
        'format' => new ProductColumnFormatter('finalPriceFormatted'),
        'is_default' => true,
    ],
    [
        'id' => 'rating',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'skus.rating',
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'vote_num',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'skus.vote_num',
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'available_from',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'skus.available_from',
        'search_field' => null,
        'format' => new ProductColumnFormatter('dateStatus'),
        'is_default' => false,
    ],
    [
        'id' => 'available_until',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'skus.available_until',
        'search_field' => null,
        'format' => new ProductColumnFormatter('dateStatus'),
        'is_default' => false,
    ],
    [
        'id' => 'promo_id',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'skus.promo_id',
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'promo_name',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'promos.name',
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
    [
        'id' => 'created_at',
        'show_name' => true,
        'class_list' => null,
        'order_by' => 'skus.created_at',
        'search_field' => null,
        'format' => null,
        'is_default' => false,
    ],
];
