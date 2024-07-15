<?php

return [
    'orders' => 'Aufträge',
    'order_managing' => 'Auftragsverwaltung',

    'statuses' => [
        'new' => 'Neu',
        'accepted' => 'Akzeptiert',
        'ready' => 'Bereit',
        'sent' => 'Gesendet',
        'completed' => 'Vollendet',
        'cancelled' => 'Abgesagt',
    ],

    'columns' => [
        'id' => 'ID',
        'status' => 'Status',
        'user_id' => 'Benutzer-ID',
        'name' => 'Nutzername',
        'phone' => 'Telefon',
        'email' => 'Email',
        'language_id' => 'Sprache',
        'delivery_method' => 'Versandart',
        'payment_method' => 'Bezahlverfahren',
        'payment_status' => 'Zahlungsstatus',
        'delivery_address' => 'Lieferadresse',
        'shop_name' => 'Speichern',
        'currency_id' => 'Währung',
        'items_cost' => 'Kosten der Artikel',
        'shipping_cost' => 'Versandkosten',
        'total_cost' => 'Gesamtkosten',
        'paid_at' => 'Bezahlt bei',
        'completed_at' => 'Abgeschlossen um',
        'created_at' => 'Hergestellt in',
        'updated_at' => 'Aktualisiert am',
    ],

    'status_buttons' => [
        'accept' => 'Akzeptieren',
        'sent' => 'Gesendet',
        'ready' => 'Abholbereit',
        'complete' => 'Vollständig',
        'cancel' => 'Stornieren',
        'cancelled' => 'Bestellung storniert',
    ],

    'messages' => [
        'status_updated' => 'Der Status der Bestellung :id wurde in ":status" geändert.',
    ],
];
