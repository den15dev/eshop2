<?php

return [
    'promos' => 'Promos',
    'add_promo' => 'Promo hinzufügen',
    'adding_promo' => 'Promo hinzugefügt',
    'editing_promo' => 'Promo bearbeiten',
    'delete_promo' => 'Löschen Sie diese Aktion',

    'status' => [
        'ended' => 'Die Aktion endete vor :term',
        'active' => 'Die Aktion ist derzeit aktiv',
        'scheduled' => 'Die Aktion beginnt in :term',
    ],

    'starts_at' => 'Startdatum',
    'starts_at_sample' => 'Beispiel: 2024-07-23',
    'ends_at' => 'Endtermin',
    'ends_at_sample' => 'Beispiel: 2024-08-23',
    'name' => 'Titel',
    'discount' => 'Rabatt',
    'discount_note' => 'Der Aktionsrabatt gilt für alle SKUs, die keinen individuellen Rabatt haben. Für SKUs separat festgelegte Einzelrabatte haben Vorrang.',
    'description' => 'Beschreibung',
    'image' => 'Bild',
    'image_note' => 'Die Bannergröße sollte 1296 x 500 Pixel betragen',
    'products' => 'Von dieser Aktion betroffene SKUs',
    'no_products' => 'In dieser Aktion sind keine SKUs enthalten.',
    'sku_discount' => 'Ind. Rabatt',
    'add_ids' => 'SKUs hinzufügen',
    'add_ids_note' => 'Geben Sie die Produkt-IDs ein, die Sie der Aktion hinzufügen möchten, getrennt durch Kommas und Bindestriche. Beispiel: 14,38,41-47,62',

    'delete_promo_warning' => 'Mit der Aktion werden alle Bilder für alle Sprachen entfernt.',

    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'image' => 'Bild',
        'discount' => 'Rabatt',
        'starts_at' => 'Startet um',
        'ends_at' => 'Endet am',
        'created_at' => 'Hergestellt in',
    ],

    'messages' => [
        'images_updated' => 'Die Bilder wurden aktualisiert',
        'skus_added' => ':num SKUs wurden hinzugefügt',
        'promo_added' => 'Die Promo ":name" wurde hinzugefügt',
        'deleted' => 'Die Promo ":name" wurde gelöscht',
    ]
];