<?php

return [
    'brands' => 'Marken',
    'add_brand' => 'Marke hinzufügen',
    'adding_brand' => 'Marke hinzufügen',
    'editing_brand' => 'Marke bearbeiten',
    'delete_brand' => 'Diese Marke löschen',

    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'image' => 'Bild',
        'created_at' => 'Hergestellt in',
    ],

    'name' => 'Name',
    'description' => 'Beschreibung',
    'image' => 'Bild',
    'product_count' => 'Der Katalog enthält :product_num (:sku_num SKU) dieser Marke.',
    "product_num" => ":count Produkt|:count Produkte",
    'no_products' => 'Der Katalog enthält keine Produkte dieser Marke.',

    'image_note' => 'Das bevorzugte Format ist .svg, andernfalls sollte es .png sein.',
    'delete_warning' => 'Eine Marke kann nur gelöscht werden, wenn sie keine Produkte enthält.',

    'messages' => [
        'deleted' => 'Marke „:name“ wurde gelöscht.',
        'brand_added' => 'Neue Marke „:name“ hinzugefügt',
        'not_empty' => 'Es gibt Produkte dieser Marke, Löschung rückgängig gemacht.',
    ],
];