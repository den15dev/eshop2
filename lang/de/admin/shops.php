<?php

return [
    'shops' => 'Shops',
    'add_shop' => 'Fügen Sie einen Shop hinzu',
    'adding_shop' => 'Einen Shop hinzufügen',
    'editing_shop' => 'Bearbeiten eines Shops',
    'delete_shop' => 'Löschen Sie diesen Shop',

    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'address' => 'Adresse',
        'opening_hours' => 'Öffnungszeiten',
        'is_active' => 'Aktiv',
        'created_at' => 'Hergestellt in',
        'updated_at' => 'Aktualisiert am',
    ],

    'orders_num' => 'Anzahl der Bestellungen',
    'is_active' => 'Aktiv',
    'is_active_note' => 'Der Store ist für Benutzer nicht sichtbar, wenn er inaktiv ist.',
    'name' => 'Name',
    'sort' => 'Sortierreihenfolge',
    'sort_note' => 'Gesamtzahl der Filialen: :num',
    'address' => 'Adresse',
    'location' => 'Kartenkoordinaten',
    'location_note' => 'Format: Breitengrad, Längengrad, zum Beispiel: 55.82362, 37.49649. Sie können es :link erhalten.',
    'location_note_link_text' => 'hier',
    'opening_hours' => 'Öffnungszeiten',
    'opening_hours_note' => 'Jeder Wochentag sollte in einer separaten Zeile stehen, der erste Tag ist Montag. Stunden werden nach einem Doppelpunkt geschrieben und müssen durch einen Bindestrich getrennt werden, zum Beispiel: Mo: 9-20. Es sind nur ganze Zahlen erlaubt, keine Minuten. Wenn es ein Wochenende ist, lassen Sie einen leeren Platz.',
    'info' => 'Information',

    'checkboxes' => [
        'active' => 'Aktiv',
        'inactive' => 'Inaktiv',
    ],

    'delete_note' => 'Dieser Shop kann nicht gelöscht werden, da dort bereits Bestellungen getätigt wurden. Anstatt den Shop zu löschen, können Sie ihn auch inaktiv machen.',

    'messages' => [
        'shop_added' => 'Der Shop ":name" wurde hinzugefügt',
        'deleted' => 'Der Shop ":name" wurde gelöscht',
        'now_active' => 'Der Shop ist jetzt aktiv',
        'now_inactive' => 'Der Shop ist derzeit nicht aktiv',
    ]
];