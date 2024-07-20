<?php

return [
    'users' => 'Users',
    'user_managing' => 'Managing the user',

    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'email' => 'Email',
        'email_verified_at' => 'Email verified',
        'phone' => 'Phone',
        'address' => 'Address',
        'role' => 'Status',
        'is_active' => 'Banned',
        'create_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],

    'checkboxes' => [
        'banned' => 'Banned',
        'admins' => 'Admins',
    ],

    'role_buttons' => [
        'admin' => 'Make an admin',
        'user' => 'Make a user',
    ],

    'messages' => [
        'role_updated' => 'The status of the user :name has been changed to ":role"',
    ],
];
