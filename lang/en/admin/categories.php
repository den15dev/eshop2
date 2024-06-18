<?php

return [
    'categories' => 'Categories',
    'editing_category' => 'Editing a category',
    'creating_category' => 'Creating a category',
    'edit_category' => 'Edit the category',
    'add_child' => 'Add a child category',
    'add_root' => 'Add a root category',
    'delete_category' => 'Delete this category',

    'main_note' => 'The maximum category nesting level is 4. Each category can contain either child categories or products. Only 3 and 4 level categories can contain products. Categories containing products cannot contain child categories, and vice versa. Categories containing products also contain a set of specifications for those products, which can be added and modified when editing the category.',

    'name' => 'Name',
    'parent_note' => 'There should be no products in the new parent category. If it contains specifications, they will be removed. If the moved category itself has products, only a level 2 or 3 category can become its parent.',
    'change_order' => 'Order of child categories',
    'order_note' => 'Drag to change the order.',
    'image' => 'Image',
    'image_note' => 'The image will be fit into a square and reduced to 230x230 px. The resulting empty areas will be filled with white. The minimum resolution on any side is 230 px, the maximum is 5000 px.',
    'root' => 'Catalog root',
    'create_specs_note' => 'Product specifications are added after creating a category, when editing it.',

    'category_info' => 'Category information',
    'sku_num' => 'Number of SKUs',
    'no_sku' => 'There are no SKUs in this category.',
    'parent_category' => 'Parent category',
    'child_categories' => 'Child categories',
    'children_sku_num' => 'Number of SKUs in child categories',
    'no_children' => 'There are no child categories.',

    'delete_warning' => 'Only an empty category can be deleted. If the category contained products, all its specifications will also be permanently deleted along with it.',

    'messages' => [
        'image_saved' => 'The image has been saved',
        'category_moved' => 'The category moved to ":name"',
        'order_changed' => 'The order has been changed',
        'category_created' => 'The new category ":name" created',
        'not_empty' => 'The category is not empty, deletion cancelled.',
        'deleted' => 'The ":name" category has been removed.',
    ]
];
