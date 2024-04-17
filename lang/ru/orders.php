<?php

declare(strict_types=1);

return [
    'orders' => 'Заказы',
    'order_num' => 'Заказ №:num',
    'num' => '№:num',
    'created_at' => 'Дата создания',
    'status' => 'Статус',
    'payment_status' => 'Статус оплаты',
    'payment_method' => 'Способ оплаты',
    'delivery_method' => 'Способ получения',
    'delivery_address' => 'Адрес доставки',
    'store_address' => 'Адрес магазина',
    'product_id' => 'Код товара',
    'price' => 'Цена',
    'quantity' => 'Количество',
    'total' => 'Стоимость',
    'no_orders' => 'Вы ещё не оформили ни одного заказа',

    'statuses' => [
        'new' => 'новый',
        'accepted' => 'принят',
        'ready' => 'готов к выдаче',
        'sent' => 'отправлен',
        'completed' => 'завершён',
        'cancelled' => 'отменён',
    ],

    'payment_statuses' => [
        'paid' => 'оплачен',
        'not_paid' => 'не оплачен',
        'pending' => 'ожидание подтверждения',
    ],

    'payment_methods' => [
        'online' => 'картой онлайн',
        'courier_card' => 'картой курьеру',
        'courier_cash' => 'наличными курьеру',
        'shop' => 'картой или наличными в магазине',
    ],

    'delivery_methods' => [
        'delivery' => 'доставка',
        'self-delivery' => 'самовывоз',
    ],

    'new_created' => 'Заказ №:num успешно создан',
    'new_message' => 'Пожалуйста, дождитесь звонка сотрудника, чтобы уточнить стоимость доставки и подтвердить заказ.<br>Информацию обо всех ваших заказах можно посмотреть в разделе :link.',
];
