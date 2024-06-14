<?php

return [
    'categories' => 'Kategorien',
    'editing_category' => 'Bearbeiten einer Kategorie',
    'creating_category' => 'Eine Kategorie erstellen',
    'edit_category' => 'Bearbeiten Sie die Kategorie',
    'add_child' => 'Fügen Sie eine untergeordnete Kategorie hinzu',
    'add_root' => 'Fügen Sie eine Stammkategorie hinzu',

    'name' => 'Name',
    'slug_note' => 'Slug wird in Links verwendet und muss eindeutig sein. Es sind nur lateinische Zeichen, Zahlen und Bindestriche erlaubt.',
    'parent_note' => 'In der neuen übergeordneten Kategorie sollten keine Produkte vorhanden sein. Wenn es Spezifikationen enthält, werden diese entfernt. Wenn die verschobene Kategorie selbst Produkte enthält, kann nur eine Kategorie der Ebene 2 oder 3 ihr übergeordnetes Element werden.',
    'change_order' => 'Reihenfolge der untergeordneten Kategorien',
    'order_note' => 'Ziehen Sie, um die Reihenfolge zu ändern.',
    'image' => 'Bild',
    'image_note' => 'Das Bild wird in ein Quadrat eingepasst und auf 230x230 Pixel verkleinert. Die entstehenden leeren Bereiche werden mit Weiß gefüllt. Die minimale Auflösung auf jeder Seite beträgt 230 px, die maximale 5000 px.',
    'specs' => [
        'name' => 'Name',
        'units' => 'Einheiten',
        'order' => 'Bestellnummer',
    ],

    'category_info' => 'Kategorieinformationen',
    'sku_num' => 'Anzahl der SKUs',
    'no_sku' => 'In dieser Kategorie gibt es keine SKUs',
    'parent_category' => 'Eltern-Kategorie',
    'child_categories' => 'Untergeordnete Kategorien',
    'children_sku_num' => 'Anzahl der SKUs in untergeordneten Kategorien',
    'no_children' => 'Es gibt keine untergeordneten Kategorien.',

    'messages' => [
        'spec_updated' => 'Die Spezifikation wurde aktualisiert',
        'spec_deleted' => 'Die Spezifikation wurde gelöscht',
        'image_saved' => 'Das Bild wurde gespeichert',
        'category_moved' => 'Die Kategorie wurde nach „:name“ verschoben',
        'order_changed' => 'Die Reihenfolge wurde geändert',
    ]
];
