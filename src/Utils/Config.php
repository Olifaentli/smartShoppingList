<?php

namespace App\Utils;

class Config {

    // Routing Defaults
    public const DEFAULT_CONTROLLER = 'home';

    // Datenbank Tabellen
    public const DB_TABLE_USERS = 'users';
    const DB_TABLE_LISTS = 'shopping_lists';
    const DB_TABLE_ITEMS = 'list_items';

    const DB_TABLE_LISTS_USERS = 'shopping_list_user';

    // Sonstige technische Defaults
    const DEFAULT_ACTION_REGISTER = 'register';

    const PUBLIC_CONTROLLERS = ['home', 'login', 'register'];
}