<?php

return [
    'brands' => 'Brands',
    'add_brand' => 'Add brand',
    'adding_brand' => 'Adding a brand',
    'editing_brand' => 'Editing a brand',
    'delete_brand' => 'Delete this brand',

    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'image' => 'Image',
        'created_at' => 'Created at',
    ],

    'name' => 'Name',
    'description' => 'Description',
    'image' => 'Image',
    'product_count' => 'The catalog contains :product_num (:sku_num SKU) of this brand.',
    'product_num' => ':count product|:count products',
    'no_products' => 'The catalog does not contain products of this brand.',

    'image_note' => 'The preferred format is .svg, otherwise it should be .png.',
    'delete_warning' => 'A brand can only be deleted if it has no products.',

    'messages' => [
        'deleted' => 'Brand ":name" has been deleted.',
        'brand_added' => 'New brand ":name" added',
        'not_empty' => 'There are products of this brand, deletion cancelled.',
    ],
];