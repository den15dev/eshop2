<?php

return [
    'orders' => 'Orders',
    'order_managing' => 'Order managing',
    'order_managing_num' => 'Order #:id managing',

    'statuses' => [
        'new' => 'New',
        'accepted' => 'Accepted',
        'ready' => 'Ready',
        'sent' => 'Sent',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],

    'columns' => [
        'id' => 'ID',
        'status' => 'Status',
        'user_id' => 'User ID',
        'name' => 'User name',
        'phone' => 'Phone',
        'email' => 'Email',
        'language_id' => 'Language',
        'delivery_method' => 'Delivery method',
        'payment_method' => 'Payment method',
        'payment_status' => 'Payment status',
        'delivery_address' => 'Delivery address',
        'shop_name' => 'Store',
        'currency_id' => 'Currency',
        'items_cost' => 'Items\' cost',
        'shipping_cost' => 'Shipping cost',
        'total_cost' => 'Total cost',
        'paid_at' => 'Paid at',
        'completed_at' => 'Completed at',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],

    'status_buttons' => [
        'accept' => 'Accept',
        'sent' => 'Sent',
        'ready' => 'Ready for pickup',
        'complete' => 'Complete',
        'cancel' => 'Cancel',
        'cancelled' => 'Order cancelled',
        'completed' => 'Order completed',
    ],

    'messages' => [
        'status_updated' => 'The order #:id status has been changed to ":status"',
        'order_cancelled' => 'The order #:id has been cancelled.',
    ],
];
