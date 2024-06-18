<?php

return [
    'categories' => 'Kategorien',
    'editing_category' => 'Bearbeiten einer Kategorie',
    'creating_category' => 'Eine Kategorie erstellen',
    'edit_category' => 'Bearbeiten Sie die Kategorie',
    'add_child' => 'Fügen Sie eine untergeordnete Kategorie hinzu',
    'add_root' => 'Fügen Sie eine Stammkategorie hinzu',
    'delete_category' => 'Diese Kategorie löschen',

    'main_note' => 'Die maximale Kategorieverschachtelungsebene beträgt 4. Jede Kategorie kann entweder untergeordnete Kategorien oder Produkte enthalten. Nur Kategorien der Ebenen 3 und 4 können Produkte enthalten. Kategorien, die Produkte enthalten, dürfen keine untergeordneten Kategorien enthalten und umgekehrt. Kategorien, die Produkte enthalten, enthalten auch eine Reihe von Spezifikationen für diese Produkte, die beim Bearbeiten der Kategorie hinzugefügt und geändert werden können.',

    'name' => 'Name',
    'parent_note' => 'In der neuen übergeordneten Kategorie sollten keine Produkte vorhanden sein. Wenn es Spezifikationen enthält, werden diese entfernt. Wenn die verschobene Kategorie selbst Produkte enthält, kann nur eine Kategorie der Ebene 2 oder 3 ihr übergeordnetes Element werden.',
    'change_order' => 'Reihenfolge der untergeordneten Kategorien',
    'order_note' => 'Ziehen Sie, um die Reihenfolge zu ändern.',
    'image' => 'Bild',
    'image_note' => 'Das Bild wird in ein Quadrat eingepasst und auf 230x230 Pixel verkleinert. Die entstehenden leeren Bereiche werden mit Weiß gefüllt. Die minimale Auflösung auf jeder Seite beträgt 230 px, die maximale 5000 px.',
    'root' => 'Katalogstamm',
    'create_specs_note' => 'Produktspezifikationen werden nach dem Erstellen einer Kategorie beim Bearbeiten hinzugefügt.',

    'category_info' => 'Kategorieinformationen',
    'sku_num' => 'Anzahl der SKUs',
    'no_sku' => 'In dieser Kategorie gibt es keine SKUs',
    'parent_category' => 'Eltern-Kategorie',
    'child_categories' => 'Untergeordnete Kategorien',
    'children_sku_num' => 'Anzahl der SKUs in untergeordneten Kategorien',
    'no_children' => 'Es gibt keine untergeordneten Kategorien.',

    'delete_warning' => 'Es kann nur eine leere Kategorie gelöscht werden. Wenn die Kategorie Produkte enthielt, werden auch alle zugehörigen Spezifikationen dauerhaft gelöscht.',

    'messages' => [
        'image_saved' => 'Das Bild wurde gespeichert',
        'category_moved' => 'Die Kategorie wurde nach „:name“ verschoben',
        'order_changed' => 'Die Reihenfolge wurde geändert',
        'category_created' => 'Die neue Kategorie „:name“ wurde erstellt',
        'not_empty' => 'Die Kategorie ist nicht leer, Löschung abgebrochen.',
        'deleted' => 'Die Kategorie „:name“ wurde entfernt.',
    ]
];
