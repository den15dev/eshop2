<?php

return [
    'adding_sku' => 'Adding a SKU',
    'editing_sku' => 'Editing a SKU',

    'to_product' => 'Product :product',
    'available_from' => 'Sales start date',
    'available_until' => 'Sales end date',
    'available_from_note' => 'Specify date and time from which the SKU should appear in the catalog. For example: "2024-03-14, 23:05". If you leave this field empty, the product will not be placed in the catalog.',
    'available_until_note' => 'Specify date and time from which the SKU should no longer appear in the catalog. For example: "2024-06-14, 23:05". If you do not plan to stop selling, leave this field blank.',
    'general_info' => 'General Information',
    'sku' => 'SKU number',
    'short_descr' => 'Short description',
    'description' => 'Description',
    'price' => 'Base price',
    'currency' => 'Currency',
    'discount' => 'Individual discount, %',
    'discount_note' => 'If you set an individual discount, it will take precedence over the promo discount.',
    'promo_discount' => 'Promo discount',
    'promo_status' => [
        'status' => 'Status',
        'ended' => 'ended',
        'active_until' => 'active until',
        'will_start' => 'will start on',
        'from' => 'from',
    ],
    'promo_not_included' => 'This SKU is not included in promo.',
    'promo' => 'Promo participation',
    'final_discount' => 'Final discount',
    'final_price' => 'Final price',
    'images' => [
        'title' => 'Images',
        'upload_note' => 'The images will be converted to a square and the resulting empty areas will be filled with white. The minimum resolution on any side is 800 px, the maximum is 5000 px.',
    ],

    'delete_sku' => 'Delete this SKU',
    'delete_sku_warning' => 'Along with the SKU, its specifications and images will be permanently deleted, all reviews for it with all likes, the SKU will be removed from all user carts, and in all orders the positions with this SKU will become undefined. If you would like to simply stop the sale of the SKU, enter today\'s date and time 00:00 in the ":available_until" field at the top of this page.',

    'messages' => [
        'attributes_updated' => 'SKU attributes have been successfully updated',
        'images_updated' => 'SKU images have been successfully updated',
        'sku_updated' => 'The SKU data have been successfully updated.',
        'sku_deleted' => 'The SKU ":name" has been successfully removed.',
    ],

    'errors' => [
        'sku_attributes_error' => 'A SKU with these attributes already exists',
    ],
];
