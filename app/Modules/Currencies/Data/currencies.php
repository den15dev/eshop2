<?php

use App\Modules\Currencies\Sources\SourceEnum;

return [
    [
        'id' => 'usd',
        'name' => [
            'en' => 'United States Dollar',
            'ru' => 'Американский доллар',
            'de' => 'US-Dollar',
        ],
        'symbol' => '$',
        'symbol_precedes' => true,
        'thousands_sep' => ',',
        'decimal_sep' => '.',
        'language_id' => 'en',
        'exchange_rate' => 88.9062,
        'source' => SourceEnum::Cbrf,
    ],
    [
        'id' => 'rub',
        'name' => [
            'en' => 'Russian Ruble',
            'ru' => 'Российский рубль',
            'de' => 'Russischer Rubel',
        ],
        'symbol' => '&#8381;',
        'symbol_precedes' => false,
        'thousands_sep' => ' ',
        'decimal_sep' => ',',
        'language_id' => 'ru',
        'exchange_rate' => 1,
        'source' => SourceEnum::Manual,
    ],
    [
        'id' => 'eur',
        'name' => [
            'en' => 'Euro',
            'ru' => 'Евро',
            'de' => 'Euro',
        ],
        'symbol' => '&#8364;',
        'symbol_precedes' => true,
        'thousands_sep' => ',',
        'decimal_sep' => '.',
        'language_id' => 'de',
        'exchange_rate' => 97.839,
        'source' => SourceEnum::Cbrf,
    ],
];
