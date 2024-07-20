<?php

return [
    'users' => 'Пользователи',
    'user_managing' => 'Управление пользователем',

    'columns' => [
        'id' => 'ID',
        'name' => 'Имя',
        'email' => 'Email',
        'email_verified_at' => 'Email подтверждён',
        'phone' => 'Телефон',
        'address' => 'Адрес',
        'role' => 'Статус',
        'is_active' => 'Бан',
        'create_at' => 'Дата создания',
        'updated_at' => 'Дата обновления',
    ],

    'checkboxes' => [
        'banned' => 'Забаненные',
        'admins' => 'Админы',
    ],

    'role_buttons' => [
        'admin' => 'Сделать администратором',
        'user' => 'Сделать пользователем',
    ],

    'messages' => [
        'role_updated' => 'Статус пользователя :name изменён на ":role"',
    ],
];
