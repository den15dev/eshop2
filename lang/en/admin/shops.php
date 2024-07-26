<?php

return [
    'shops' => 'Stores',
    'add_shop' => 'Add a store',
    'adding_shop' => 'Adding a store',
    'editing_shop' => 'Editing a store',
    'delete_shop' => 'Delete this store',

    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'address' => 'Address',
        'opening_hours' => 'Opening hours',
        'is_active' => 'Is active',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],

    'orders_num' => 'Number of orders',
    'is_active' => 'Active',
    'is_active_note' => 'The store is not visible to users if it is inactive.',
    'name' => 'Name',
    'sort' => 'Sort order',
    'sort_note' => 'Total stores: :num',
    'address' => 'Address',
    'location' => 'Map coordinates',
    'location_note' => 'Format: latitude, longitude, for example: 55.82362, 37.49649. You can get it from :link.',
    'location_note_link_text' => 'here',
    'opening_hours' => 'Opening hours',
    'opening_hours_note' => 'Each day of the week should be on a separate line, the first day is Monday. Hours are written after a colon and must be separated by a hyphen, for example: Mon: 9-20. Only integer numbers are allowed, no minutes. If it\'s a weekend, leave an empty space.',
    'info' => 'Information',

    'checkboxes' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],

    'delete_note' => 'This store cannot be deleted because there are orders that already was made there. Instead of deleting, you can make this store inactive.',

    'messages' => [
        'shop_added' => 'The store ":name" has been added',
        'deleted' => 'The store ":name" has been deleted',
        'now_active' => 'The store now is active',
        'now_inactive' => 'The store now is not active',
    ]
];