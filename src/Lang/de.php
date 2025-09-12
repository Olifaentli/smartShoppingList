<?php
return [

    // System- und Fehlermeldungen
    'email_exists'             => 'Diese E-Mail ist bereits registriert.',
    'invalid_input'            => 'Bitte gib eine gültige E-Mail und ein Passwort ein.',
    'login_failed'             => 'Login fehlgeschlagen. Bitte überprüfe deine Zugangsdaten.',
    'register_error'           => 'Fehler bei der Registrierung: ',
    'register_success'         => 'Registrierung erfolgreich! Du kannst dich jetzt einloggen.',
    'missing_list_name_or_user'=> 'Bitte gib einen Namen ein oder logge dich ein.',
    'no_list_error'            => 'Keine Liste gefunden.',
    'copy_success'             => 'Join-Link kopiert!',
    'copy_error'               => 'Konnte den Link nicht kopieren.',
    'confirm_delete'           => 'Liste wirklich löschen?',

    // Allgemein
    'app_name'      => 'SmartShoppingList',
    'logout'        => 'Logout',
    'footer_fun'    => 'Wusstest du? 92 % aller spontanen Einkäufe enthalten Schokolade. Zufall? 😏',

    // Home
    'home_welcome'  => 'Willkommen bei SmartShoppingList!',
    'home_intro'    => 'Deine smarte, KI-gestützte Einkaufsliste mit Stil, Logik und Witz.',
    'feature_ai'    => 'Intelligente Menüvorschläge mit KI',
    'feature_reuse' => 'Resteverwertung auf Knopfdruck',
    'feature_budget'=> 'Budgetfreundlich planen',
    'feature_groups'=> 'Gemeinsame Listen für WG, Familie & Co.',
    'login_now'     => 'Jetzt einloggen',

    // Auth / Login / Registrierung
    'email_label'           => 'E-Mail-Adresse',
    'password_label'        => 'Passwort',

    'register_title'        => 'Registrierung',
    'register_subtitle'     => 'Erstelle dein Konto für die smarte Einkaufsliste.',
    'register_button'       => 'Registrieren',
    'already_have_account'  => 'Schon ein Konto?',
    'login_link'            => 'Jetzt einloggen',
    'fun_fact_register'     => '💡 Wusstest du? Die meisten Leute vergessen Knoblauch auf der Liste 🧄',

    'login_title'           => 'Login',
    'login_subtitle'        => 'Melde dich an, um deine smarte Einkaufsliste zu verwalten.',
    'login_button'          => 'Anmelden',
    'no_account'            => 'Noch keinen Account?',
    'register_link'         => 'Jetzt registrieren',
    'fun_fact_login'        => '🔒 Dein Kühlschrank verrät nichts – deine Daten auch nicht!',

    // Einkaufslisten Übersicht
    'overview_title'        => 'Deine Einkaufslisten',
    'overview_subtitle'     => 'Wähle eine Liste, um sie anzuzeigen oder zu bearbeiten.',
    'no_lists'              => 'Keine Einträge vorhanden.',
    'new_list_button'       => 'Neue Einkaufsliste',
    'ai_generator_button'   => 'KI-Generator',

    // Listen-Details
    'list_items_title'      => 'Einträge',
    'no_items'              => 'Keine Einträge vorhanden.',
    'done_title'            => 'Erledigt',
    'add_item'              => 'Neuen Eintrag hinzufügen',
    'item_name'             => 'Name',
    'item_amount'           => 'Menge',
    'item_unit'             => 'Einheit',
    'item_comment'          => 'Kommentar',
    'unit_none'             => '– keine –',
    'unit_piece'            => 'Stück',
    'unit_kilogram'         => 'Kg',
    'unit_gram'             => 'Gramm',
    'unit_liter'            => 'Liter',
    'unit_milliliter'       => 'ml',
    'unit_centimeter'       => 'cm',
    'unit_meter'            => 'Meter',
    'add_button'            => 'Hinzufügen',
    'back_to_overview'      => 'Zurück zur Übersicht',
    'mark_done'             => 'Als erledigt markieren',

    // Listen-Bearbeitung
    'rename_list_title'     => 'Liste umbenennen',
    'rename_list_subtext'   => 'Ändere den Namen deiner Einkaufsliste.',
    'new_list_name'         => 'Neuer Listenname',
    'save_button'           => 'Speichern',
    'cancel_button'         => 'Abbrechen',
    'open_button'           => 'Öffnen',
    'rename_button'         => 'Umbenennen',
    'delete_button'         => 'Löschen',
    'copy_link'             => 'Link kopieren',

    // Neue Liste
    'new_list_title'        => 'Neue Einkaufsliste',
    'new_list_subtitle'     => 'Erstelle eine neue Liste mit Namen.',
    'list_name_label'       => 'Name',
    'create_list_button'    => 'Liste erstellen',

    // Profil
    'profile_title'             => 'Dein Profil',
    'profile_subtitle'          => 'Verwalte deine E-Mail-Adresse und dein Passwort.',
    'current_password_label'    => 'Aktuelles Passwort',
    'current_password_hint'     => 'zur Bestätigung',
    'new_password_label'        => 'Neues Passwort',
    'new_password_hint'         => 'leer lassen, wenn nicht ändern',
    'confirm_password_label'    => 'Neues Passwort bestätigen',
    'back_to_lists'             => 'Zu den Listen',

    // AI Generator
    'ai_generator_title'        => 'Menü-Generator',
    'ai_generator_subtitle'     => 'Erzeuge eine smarte Einkaufsliste basierend auf deinen Vorgaben.',
    'ai_persons_label'          => 'Anzahl Personen',
    'ai_meals_label'            => 'Anzahl Mahlzeiten',
    'ai_cuisine_label'          => 'Küchenrichtung',
    'ai_cuisine_none'           => 'Keine Präferenz',
    'ai_cuisine_italian'        => 'Italienisch',
    'ai_cuisine_asian'          => 'Asiatisch',
    'ai_cuisine_swiss'          => 'Schweizerisch',
    'ai_cuisine_mexican'        => 'Mexikanisch',
    'ai_budget_label'           => 'Budget (CHF)',
    'ai_budget_placeholder'     => 'z.B. 80',
    'ai_vegetarian'             => 'Vegetarisch',
    'ai_vegan'                  => 'Vegan',
    'ai_allergies_label'        => 'Allergien / Unverträglichkeiten',
    'ai_allergies_placeholder'  => 'z.B. Erdnüsse, Laktose',
    'ai_dislikes_label'         => 'Ausschlüsse',
    'ai_dislikes_placeholder'   => 'z.B. Pilze, Oliven',
    'ai_notes_label'            => 'Zusatzwünsche',
    'ai_notes_placeholder'      => 'z.B. schnell kochbar, 1x ohne Kochen, Reste nutzbar',
    'ai_generate_button'        => 'KI-Menü erstellen',
];
