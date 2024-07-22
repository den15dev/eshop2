<?php

return [
    'buttons' => [
        'move' => 'Move',
        'delete' => 'Delete',
    ],

    'products' => [
        'change_category' => 'Are you sure you want to move the product to another category? All specifications of all SKUs of this product will be deleted!',
        'field_must_be_filled' => 'This field must be filled out',
        'delete_attribute' => 'Are you sure you want to remove the attribute? All variants of this attribute will be removed from all SKUs!',
        'delete_variant' => 'Are you sure you want to remove this variant from all SKUs of this product?',
        'delete_product' => 'Are you sure you want to remove this product? Along with it, all its SKUs will be permanently deleted, along with images, specifications, reviews, likes, items in user carts and favorites.',
        'delete_sku' => 'Are you sure you want to delete this SKU? Along with it, its specifications, reviews, likes, positions in user baskets and favorites will be permanently deleted.',
    ],

    'categories' => [
        'delete_spec' => 'Are you sure you want to remove the ":name" specification? The values for this specification will be removed from all SKUs in this category.',
        'delete_category' => 'Are you sure you want to delete the ":name" category? If it contained products, all specifications will also be removed with it.',
    ],

    'brands' => [
        'delete_brand' => 'Are you sure you want to remove the ":name" brand?',
    ],

    'promos' => [
        'delete_promo' => 'Are you sure you want to remove the ":name" promo?',
    ],

    'orders' => [
        'cancel_order' => 'Are you sure you want to cancel this order?',
    ],

    'users' => [
        'make_admin' => 'Are you sure you want to make :name an administrator?',
        'make_user' => 'Are you sure you want to make :name a regular user?',
        'delete_user' => 'Are you sure you want to delete user :name?',
    ],

    'reviews' => [
        'delete_review' => 'Are you sure you want to delete this review?',
    ],
];