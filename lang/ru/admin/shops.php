<?php

return [
    'shops' => 'Магазины',
    'add_shop' => 'Добавить магазин',
    'adding_shop' => 'Добавление магазина',
    'editing_shop' => 'Редактирование магазина',
    'delete_shop' => 'Удалить этот магазин',

    'columns' => [
        'id' => 'ID',
        'name' => 'Название',
        'address' => 'Адрес',
        'opening_hours' => 'Часы работы',
        'is_active' => 'Активен',
        'created_at' => 'Дата добавления',
        'updated_at' => 'Дата изменения',
    ],

    'orders_num' => 'Количество заказов',
    'is_active' => 'Активный',
    'is_active_note' => 'Магазин не виден покупателям, если он не активен.',
    'name' => 'Название',
    'sort' => 'Порядок в списке',
    'sort_note' => 'Всего магазинов: :num',
    'address' => 'Адрес',
    'location' => 'Координаты на карте',
    'location_note' => 'Формат: широта, долгота, например: 55.82362, 37.49649. Можно определить :link.',
    'location_note_link_text' => 'здесь',
    'opening_hours' => 'Часы работы',
    'opening_hours_note' => 'Каждый день недели должен быть на отдельной строке, первый день — понедельник. Часы пишутся после двоеточия и должны разделяться между собой дефисом, например: Пн: 9-20. Допустимы только целые числа, без минут. Если выходной, оставляем пустое место.',
    'info' => 'Информация',

    'checkboxes' => [
        'active' => 'Активные',
        'inactive' => 'Не активные',
    ],

    'delete_note' => 'Этот магазин нельзя удалить, т.к. в нём уже были сделаны заказы. Вместо удаления вы можете сделать магазин неактивным.',

    'messages' => [
        'shop_added' => 'Магазин ":name" добавлен',
        'deleted' => 'Магазин ":name" удалён',
        'now_active' => 'Магазин теперь активен',
        'now_inactive' => 'Магазин теперь не активен',
    ]
];