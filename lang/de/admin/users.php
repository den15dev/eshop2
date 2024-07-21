<?php

return [
    'users' => 'Benutzer',
    'user_managing' => 'Verwalten des Benutzers',
    'role' => 'Status',
    'name' => 'Name',
    'email' => 'Email',
    'verified' => 'verifiziert',
    'not_verified' => 'nicht verifiziert',
    'registration_date' => 'Registrierungsdatum',
    'phone' => 'Telefon',
    'address' => 'Adresse',
    'completed_orders' => 'Abgeschlossene Bestellungen',
    'cancelled_orders' => 'Stornierte Bestellungen',
    'active_orders' => 'Aktive Bestellungen',
    'reviews_count' => 'Rezensionen/Bewertungen übrig',

    'ban' => 'Verbot',
    'ban_note' => 'Gesperrte Benutzer können keine Bewertungen für Produkte hinterlassen.',

    'delete_user_warning' => 'Wenn Sie einen Benutzer löschen, werden sein Warenkorb, seine Favoriten und Benachrichtigungen dauerhaft gelöscht. Seine Bestellungen und Bewertungen bleiben bestehen und haben eine unbestimmte Benutzer-ID.',

    'columns' => [
        'id' => 'ID',
        'name' => 'Name',
        'email' => 'Email',
        'email_verified_at' => 'Email überprüft',
        'phone' => 'Telefon',
        'address' => 'Adresse',
        'role' => 'Status',
        'is_active' => 'Verboten',
        'create_at' => 'Hergestellt in',
        'updated_at' => 'Aktualisiert am',
    ],

    'checkboxes' => [
        'banned' => 'Verboten',
        'admins' => 'Admins',
    ],

    'buttons' => [
        'admin' => 'Machen Sie einen Administrator',
        'user' => 'Machen Sie einen Benutzer',
        'delete' => 'Lösche diesen Benutzer',
    ],

    'messages' => [
        'now_admin' => ':name ist jetzt Administrator',
        'now_user' => ':name ist jetzt ein regulärer Benutzer',
        'user_deleted' => 'Benutzer :name wurde gelöscht',
    ],
];
