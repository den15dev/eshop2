<?php

return [
    'orders' => 'Заказы',
    'order_managing' => 'Управление заказом',

    'statuses' => [
        'new' => 'Новые',
        'accepted' => 'Принятые',
        'ready' => 'Готовые',
        'sent' => 'Отправленные',
        'completed' => 'Завершённые',
        'cancelled' => 'Отменённые',
    ],

    'columns' => [
        'id' => 'ID',
        'status' => 'Статус',
        'user_id' => 'ID пользователя',
        'name' => 'Имя пользователя',
        'phone' => 'Телефон',
        'email' => 'Email',
        'language_id' => 'Язык',
        'delivery_method' => 'Тип доставки',
        'payment_method' => 'Тип платежа',
        'payment_status' => 'Статус платежа',
        'delivery_address' => 'Адрес доставки',
        'shop_name' => 'Магазин',
        'currency_id' => 'Валюта',
        'items_cost' => 'Стоимость товаров',
        'shipping_cost' => 'Стоимость доставки',
        'total_cost' => 'Общая стоимость',
        'paid_at' => 'Дата платежа',
        'completed_at' => 'Дата завершения',
        'created_at' => 'Дата создания',
        'updated_at' => 'Дата обновления',
    ],

    'status_buttons' => [
        'accept' => 'Принять',
        'sent' => 'Отправлен',
        'ready' => 'Готов к выдаче',
        'complete' => 'Завершить',
        'cancel' => 'Отменить',
        'cancelled' => 'Заказ отменён',
        'completed' => 'Заказ завершён',
    ],

    'messages' => [
        'status_updated' => 'Статус заказа №:id изменён на ":status"',
        'order_cancelled' => 'Заказ №:id отменён.',
    ],
];
