<?php

return [
    'categories' => 'Categories',
    'editing_category' => 'Editing a category',
    'creating_category' => 'Creating a category',
    'edit_category' => 'Edit the category',
    'add_child' => 'Add a child category',
    'add_root' => 'Add a root category',

    'name' => 'Name',
    'slug_note' => 'Slug is used in links and must be unique. Only Latin characters, numbers and hyphens are allowed.',
    'parent_note' => 'There should be no products in the new parent category. If it contains specifications, they will be removed. If the moved category itself has products, only a level 2 or 3 category can become its parent.',
    'change_order' => 'Order of child categories',
    'order_note' => 'Drag to change the order.',
    'image' => 'Image',
    'image_note' => 'The image will be fit into a square and reduced to 230x230 px. The resulting empty areas will be filled with white. The minimum resolution on any side is 230 px, the maximum is 5000 px.',
    'specs' => [
        'name' => 'Name',
        'units' => 'Units',
        'order' => 'Order number',
    ],

    'category_info' => 'Category information',
    'sku_num' => 'Number of SKUs',
    'no_sku' => 'There are no SKUs in this category.',
    'parent_category' => 'Parent category',
    'child_categories' => 'Child categories',
    'children_sku_num' => 'Number of SKUs in child categories',
    'no_children' => 'There are no child categories.',

    'messages' => [
        'spec_updated' => 'The specification has been updated',
        'spec_deleted' => 'The specification has been deleted',
        'image_saved' => 'The image has been saved',
        'category_moved' => 'The category moved to ":name"',
        'order_changed' => 'The order has been changed',
    ]
];
