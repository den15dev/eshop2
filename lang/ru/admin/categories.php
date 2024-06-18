<?php

return [
    'categories' => 'Категории',
    'editing_category' => 'Редактирование категории',
    'creating_category' => 'Создание категории',
    'edit_category' => 'Редактировать категорию',
    'add_child' => 'Добавить дочернюю категорию',
    'add_root' => 'Добавить корневую категорию',
    'delete_category' => 'Удалить эту категорию',

    'main_note' => 'Максимальный уровень вложенности категорий — 4. Каждая категория может содержать либо дочерние категории, либо товары. Только категории 3 и 4 уровней могут содержать товары. Категории, содержащие товары, не могут содержать дочерние категории, и наоборот. Категории, содержащие товары, также содержат набор спецификаций для этих товаров, которые можно добавлять и изменять при редактировании категории.',

    'name' => 'Наименование',
    'parent_note' => 'В новой родительской категории не должно быть товаров. Если она содержит спецификации, они будут удалены. Если переносимая категория сама имеет товары, её родителем может стать только категория 2 или 3 уровня.',
    'change_order' => 'Порядок дочерних категорий',
    'order_note' => 'Перетащите, чтобы изменить порядок.',
    'image' => 'Изображение',
    'image_note' => 'Изображение будет вписано в квадрат и уменьшено до 230x230 px. Образовавшиеся пустые области будут залиты белым цветом. Минимальное разрешение по любой из сторон 230 px, максимальное — 5000 px.',
    'root' => 'Корень каталога',
    'create_specs_note' => 'Характеристики товаров добавляются после создания категории, при её редактировании.',

    'category_info' => 'Информация о категории',
    'sku_num' => 'Количество SKU',
    'no_sku' => 'В данной категории нет SKU.',
    'parent_category' => 'Родительская категория',
    'child_categories' => 'Дочерние категории',
    'children_sku_num' => 'Количество SKU в дочерних категориях',
    'no_children' => 'Дочерние категории отсутствуют.',

    'delete_warning' => 'Удалить можно только пустую категорию. Если категория содержала товары, вместе с ней также будут безвозвратно удалены все её характеристики.',

    'messages' => [
        'image_saved' => 'Изображение сохранено',
        'category_moved' => 'Категория перенесена в ":name"',
        'order_changed' => 'Порядок изменён',
        'category_created' => 'Новая категория ":name" создана',
        'not_empty' => 'Категория не пуста, удаление отменено.',
        'deleted' => 'Категория ":name" удалена.',
    ]
];
