<?php

return [
    'users' => 'Users',
    'user_managing' => 'Managing the user',
    'role' => 'Status',
    'name' => 'Name',
    'email' => 'Email',
    'verified' => 'verified',
    'not_verified' => 'not verified',
    'registration_date' => 'Registration date',
    'phone' => 'Phone',
    'address' => 'Address',
    'completed_orders' => 'Completed orders',
    'cancelled_orders' => 'Cancelled orders',
    'active_orders' => 'Active orders',
    'reviews_count' => 'Reviews/ratings left',

    'ban' => 'Ban',
    'ban_note' => 'Banned users can\'t leave reviews for products.',

    'delete_user_warning' => 'When deleting a user, his cart, favorites, and notifications will be permanently deleted. His orders and reviews will remain and will have an undefined user ID.',

    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'email' => 'Email',
        'email_verified_at' => 'Email verified',
        'phone' => 'Phone',
        'address' => 'Address',
        'role' => 'Status',
        'is_active' => 'Banned',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],

    'checkboxes' => [
        'banned' => 'Banned',
        'admins' => 'Admins',
    ],

    'buttons' => [
        'admin' => 'Make an admin',
        'user' => 'Make a user',
        'delete' => 'Delete this user',
    ],

    'messages' => [
        'now_admin' => ':name is now an administrator',
        'now_user' => ':name is now a regular user',
        'user_deleted' => 'User :name has been deleted',
        'user_banned' => ':name has been banned',
        'user_unbanned' => ':name has been unbanned',
    ],
];
