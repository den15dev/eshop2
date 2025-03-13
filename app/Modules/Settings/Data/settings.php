<?php

use App\Modules\Settings\Enums\DataType;

return [
    [
        'id' => 'allow_registration',
        'name' => [
            'en' => 'Allow user registration',
            'ru' => 'Разрешить регистрацию пользователей',
            'de' => 'Benutzerregistrierung zulassen',
        ],
        'data_type' => DataType::Boolean,
        'val' => 'true',
        'description' => [
            'en' => 'Allows or forbids users to register on the website.',
            'ru' => 'Разрешает или запрещает пользователям регистрироваться на сайте.',
            'de' => 'Ermöglicht oder verbietet Benutzer, sich auf der Website zu registrieren.',
        ],
    ],

    [
        'id' => 'catalog_per_page',
        'name' => [
            'en' => 'Number of items shown per page in the catalog',
            'ru' => 'Количество товаров, показываемых на одну страницу в каталоге',
            'de' => 'Anzahl der pro Seite angezeigten Elemente im Katalog',
        ],
        'data_type' => DataType::Array,
        'val' => [12,24,36,48],
    ],

    [
        'id' => 'carousel_items_num',
        'name' => [
            'en' => 'Maximum number of items in carousels',
            'ru' => 'Максимальное количество карточек товаров в каруселях',
            'de' => 'Maximale Anzahl von Artikeln in Karussells',
        ],
        'data_type' => DataType::Integer,
        'val' => 10,
    ],
];
