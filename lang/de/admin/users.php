<?php

return [
    'users' => 'Benutzer',
    'user_managing' => 'Verwalten des Benutzers',

    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'email' => 'Email',
        'email_verified_at' => 'Email überprüft',
        'phone' => 'Telefon',
        'address' => 'Adresse',
        'role' => 'Status',
        'is_active' => 'Verboten',
        'create_at' => 'Hergestellt in',
        'updated_at' => 'Aktualisiert am',
    ],

    'checkboxes' => [
        'banned' => 'Verboten',
        'admins' => 'Admins',
    ],

    'role_buttons' => [
        'admin' => 'Machen Sie einen Administrator',
        'user' => 'Machen Sie einen Benutzer',
    ],

    'messages' => [
        'role_updated' => 'Der Status des Benutzers :name wurde in ":role" geändert.',
    ],
];
