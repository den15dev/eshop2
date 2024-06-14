<?php

return [
    'adding_sku' => 'SKU hinzufügen',
    'editing_sku' => 'SKU bearbeiten',

    'to_product' => 'Produkt :product',
    'available_from' => 'Verkaufsstartdatum',
    'available_until' => 'Enddatum des Verkaufs',
    'available_from_note' => 'Geben Sie Datum und Uhrzeit an, ab dem die SKU im Katalog erscheinen soll. Zum Beispiel: „14.03.2024, 23:05“. Wenn Sie dieses Feld leer lassen, wird das Produkt nicht in den Katalog aufgenommen.',
    'available_until_note' => 'Geben Sie Datum und Uhrzeit an, ab dem die SKU nicht mehr im Katalog erscheinen soll. Zum Beispiel: „14.06.2024, 23:05“. Wenn Sie nicht vorhaben, den Verkauf einzustellen, lassen Sie dieses Feld leer.',
    'general_info' => 'Allgemeine Informationen',
    'sku' => 'SKU-Nummer',
    'short_descr' => 'Kurzbeschreibung',
    'description' => 'Beschreibung',
    'price' => 'Grundpreis',
    'currency' => 'Währung',
    'discount' => 'Individueller Rabatt, %',
    'discount_note' => 'Wenn Sie einen individuellen Rabatt festlegen, hat dieser Vorrang vor dem Aktionsrabatt.',
    'promo_discount' => 'Aktionsrabatt',
    'promo_status' => [
        'status' => 'Status',
        'ended' => 'beendet',
        'active_until' => 'aktiv bis',
        'will_start' => 'wird beginnen',
        'from' => 'am',
    ],
    'promo_not_included' => 'Diese SKU ist nicht im Aktion enthalten.',
    'promo' => 'Promo-Teilnahme',
    'final_discount' => 'Endgültiger Rabatt',
    'final_price' => 'Endgültiger Preis',
    'images' => [
        'title' => 'Bilder',
        'order_note' => 'Ziehen Sie, um die Reihenfolge zu ändern.',
        'upload_note' => 'Die Bilder werden in ein Quadrat umgewandelt und die entstehenden leeren Bereiche werden mit Weiß gefüllt. Die minimale Auflösung auf jeder Seite beträgt 800 px, die maximale 5000 px.',
    ],

    'delete_sku' => 'Diese SKU löschen',
    'delete_sku_warning' => 'Zusammen mit der SKU werden ihre Spezifikationen und Bilder dauerhaft gelöscht, alle Bewertungen mit allen „Gefällt mir“-Angaben, die SKU wird aus allen Einkaufswagen der Benutzer entfernt und in allen Bestellungen werden die Positionen mit dieser SKU undefiniert. Wenn Sie den Verkauf der SKU einfach stoppen möchten, geben Sie das heutige Datum und die heutige Uhrzeit 00:00 Uhr in das Feld „:available_until“ oben auf dieser Seite ein.',

    'messages' => [
        'attributes_updated' => 'SKU-Attribute wurden erfolgreich aktualisiert',
        'images_updated' => 'SKU-Bilder wurden erfolgreich aktualisiert',
        'sku_updated' => 'Die SKU-Daten wurden erfolgreich aktualisiert.',
        'sku_deleted' => 'Die SKU ":name" wurde erfolgreich entfernt.',
    ],

    'errors' => [
        'sku_attributes_error' => 'Eine SKU mit diesen Attributen ist bereits vorhanden',
    ],
];
