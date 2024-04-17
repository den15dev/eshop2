<?php

declare(strict_types=1);

return [
    'orders' => 'Orders',
    'order_num' => 'Order #:num',
    'num' => '#:num',
    'created_at' => 'Created at',
    'status' => 'Status',
    'payment_status' => 'Payment status',
    'payment_method' => 'Payment method',
    'delivery_method' => 'Delivery method',
    'delivery_address' => 'Delivery address',
    'store_address' => 'Store address',
    'product_id' => 'Product ID',
    'price' => 'Price',
    'quantity' => 'Quantity',
    'total' => 'Total',
    'no_orders' => 'You haven\'t place any orders yet',

    'statuses' => [
        'new' => 'new',
        'accepted' => 'accepted',
        'ready' => 'ready for pickup',
        'sent' => 'sent',
        'completed' => 'completed',
        'cancelled' => 'cancelled',
    ],

    'payment_statuses' => [
        'paid' => 'paid',
        'not_paid' => 'not paid',
        'pending' => 'pending',
    ],

    'payment_methods' => [
        'online' => 'bank card online',
        'courier_card' => 'bank card to courier',
        'courier_cash' => 'cash to courier',
        'shop' => 'pay at store',
    ],

    'delivery_methods' => [
        'delivery' => 'delivery',
        'self-delivery' => 'self-delivery',
    ],

    'new_created' => 'Order #:num has been created successfully',
    'new_message' => 'Please wait for a manager call to conform a shipping cost and confirm the order.<br>You can find the details about all your orders in the :link section.',
];
