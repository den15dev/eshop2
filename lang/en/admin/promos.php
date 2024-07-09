<?php

return [
    'promos' => 'Promos',
    'add_promo' => 'Add promo',
    'adding_promo' => 'Adding promo',
    'editing_promo' => 'Editing promo',
    'delete_promo' => 'Delete this promo',

    'status' => [
        'ended' => 'The promo ended :term',
        'active' => 'The promo is currently active',
        'scheduled' => 'The promo will start in :term',
    ],

    'starts_at' => 'Start date',
    'starts_at_sample' => 'Example: 2024-07-23',
    'ends_at' => 'End date',
    'ends_at_sample' => 'Example: 2024-08-23',
    'name' => 'Title',
    'discount' => 'Discount',
    'discount_note' => 'Promo discount applies to all SKUs that do not have an individual discount. Individual discounts set separately for SKUs will take precedence.',
    'description' => 'Description',
    'image' => 'Image',
    'image_note' => 'Banner size should be 1296x500 px',
    'products' => 'SKUs included in this promo',
    'no_products' => 'No SKUs are included in this promo.',
    'sku_discount' => 'Ind. discount',
    'add_ids' => 'Add SKUs',
    'add_ids_note' => 'Enter the products\' IDs you want to add to the promo, separated by commas and dashes. For example: 14,38,41-47,62',

    'delete_promo_warning' => 'Along with the promo, all its images for all languages will be removed.',

    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'image' => 'Image',
        'discount' => 'Discount',
        'starts_at' => 'Starts at',
        'ends_at' => 'Ends at',
        'created_at' => 'Created at',
    ],

    'messages' => [
        'images_updated' => 'The images have been updated',
        'skus_added' => ':num SKU have been added',
        'promo_added' => 'The promo ":name" has been added',
        'deleted' => 'The promo ":name" has been deleted',
    ]
];