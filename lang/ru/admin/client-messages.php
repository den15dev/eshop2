<?php

return [
    'buttons' => [
        'move' => 'Переместить',
        'delete' => 'Удалить',
    ],

    'products' => [
        'change_category' => 'Вы уверены, что хотите переместить товар в другую категорию? Все характеристики всех SKU данного товара будут удалены!',
        'field_must_be_filled' => 'Это поле должно быть заполнено',
        'delete_attribute' => 'Вы уверены, что хотите удалить атрибут? Все варианты данного атрибута будут удалены у всех SKU!',
        'delete_variant' => 'Вы уверены, что хотите удалить этот вариант у всех SKU данного товара?',
        'delete_product' => 'Вы уверены, что хотите удалить этот товар? Вместе с ним будут безвозвратно удалены все его SKU вместе с изображениями, характеристиками, отзывами, лайками, позициями в корзинах пользователей и избранном.',
        'delete_sku' => 'Вы уверены, что хотите удалить эту SKU? Вместе с ней будут безвозвратно удалены её характеристики, отзывы, лайки, позиции в корзинах пользователей и избранном.',
    ],

    'categories' => [
        'delete_spec' => 'Вы уверены, что хотите удалить спецификацию ":name"? Значения данной спецификации будут удалены у всех SKU данной категории.',
        'delete_category' => 'Вы уверены, что хотите удалить категорию ":name"? Если она содержала товары, с ней также будут удалены все характеристики.',
    ],

    'brands' => [
        'delete_brand' => 'Вы уверены, что хотите удалить бренд ":name"?',
    ],

    'promos' => [
        'delete_promo' => 'Вы уверены, что хотите удалить акцию ":name"?',
    ],

    'orders' => [
        'cancel_order' => 'Вы уверены, что хотите отменить этот заказ?',
    ],

    'users' => [
        'make_admin' => 'Вы уверены, что хотите сделать :name администратором?',
        'make_user' => 'Вы уверены, что хотите сделать :name обычным пользователем?',
        'delete_user' => 'Вы уверены, что хотите удалить пользователя :name?',
    ],

    'reviews' => [
        'delete_review' => 'Вы уверены, что хотите удалить этот отзыв?',
    ],

    'shops' => [
        'delete_shop' => 'Вы уверены, что хотите удалить магазин ":name"?',
    ],
];