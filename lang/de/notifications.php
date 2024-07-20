<?php
return [
    "copyright" => "Elektronikladen. Alle Rechte vorbehalten.",
    "greeting" => "Hallo, :name!",

    "order_sent" => [
        "subject" => "Bestellung #:id wurde versendet.",
        "body" => "Die Bestellung #:id über den Betrag :total_cost_formatted wurde per Lieferdienst an die von Ihnen angegebene Adresse gesendet. Im Abschnitt :orders_link können Sie Informationen zu Bestellungen anzeigen und deren Status verfolgen.",
        "footer" => "Sie haben diese Nachricht erhalten, weil Sie eine Bestellung auf der Website :link aufgegeben haben. Wenn nicht Sie derjenige waren, ignorieren Sie diese Nachricht bitte.",
    ],

    'order_ready' => [
        'subject' => 'Bestellung #:id steht zur Abholung bereit.',
        'body' => 'Die Bestellung #:id für den Betrag :total_cost_formatted liegt zur Abholung bereit, Sie können sie im Geschäft in der :shop_address. Im Abschnitt :orders_link können Sie Informationen zu Bestellungen anzeigen und deren Status verfolgen.',
        "footer" => "Sie haben diese Nachricht erhalten, weil Sie eine Bestellung auf der Website :link aufgegeben haben. Wenn nicht Sie derjenige waren, ignorieren Sie diese Nachricht bitte.",
    ],

    "reset_password" => [
        "body1" => "Sie erhalten diese E-Mail, weil wir eine Anforderung zum Zurücksetzen des Passworts für Ihr Konto erhalten haben.",
        "body2" => "Dieser Link zum Zurücksetzen des Passworts läuft in 60 Minuten ab.",
        "body3" => "Wenn Sie kein Zurücksetzen des Kennworts angefordert haben, ist keine weitere Aktion erforderlich.",
        "body_issues" => "Wenn Sie Probleme beim Klicken auf die Schaltfläche „Passwort zurücksetzen“ haben, kopieren Sie die folgende URL und fügen Sie sie in Ihren Webbrowser ein:",
        "button" => "Passwort zurücksetzen",
        "footer" => "Sie haben diese Nachricht erhalten, weil Sie auf der Website :link eine Kennwortzurücksetzung angefordert haben. Wenn nicht Sie derjenige waren, ignorieren Sie diese Nachricht bitte.",
        "subject" => "Passwortbenachrichtigung zurücksetzen"
    ],

    "signature1" => "Grüße,",
    "signature2" => "Team im Elektronikfachmarkt",

    "verify_email" => [
        "body1" => "Bitte klicken Sie auf die Schaltfläche unten, um Ihre E-Mail-Adresse zu bestätigen.",
        "body2" => "Wenn Sie kein Konto erstellt haben, ist keine weitere Aktion erforderlich.",
        "body_issues" => "Wenn Sie Probleme beim Klicken auf die Schaltfläche „E-Mail-Adresse bestätigen“ haben, kopieren Sie die folgende URL und fügen Sie sie in Ihren Webbrowser ein:",
        "button" => "Email Adresse bestätigen",
        "footer" => "Sie haben diese Nachricht erhalten, weil Sie sich auf der Website :link registriert haben. Wenn nicht Sie es waren, ignorieren Sie diese Nachricht bitte.",
        "subject" => "Email Adresse bestätigen"
    ]
];
