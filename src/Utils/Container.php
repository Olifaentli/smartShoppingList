<?php

namespace App\Utils;

use App\Controller\ListController;
use App\Controller\RegisterController;
use App\Controller\LoginController;
use App\Controller\HomeController;
use App\Controller\ListOverviewController;
use App\Repo\ListItemRepo;
use App\Repo\ShoppingListRepo;
use App\Repo\UserRepo;

class Container {
    private array $controllers = [];
    private DB $db;
    private array $strings;

    public function __construct() {
        $this->db = new DB();

        $this->strings = require __DIR__ . '/../Lang/de.php';

        $this->registerControllers();
    }

    private function registerControllers(): void {
        $userRepo = new UserRepo($this->db);
        $shoppingListRepo = new ShoppingListRepo($this->db);
        $listItemRepo = new ListItemRepo($this->db);

        $this->controllers['register'] = new RegisterController($userRepo, $this->strings);
        $this->controllers['login']    = new LoginController($userRepo, $this->strings);
        $this->controllers['home']     = new HomeController();
        $this->controllers['listoverview'] = new ListOverviewController($shoppingListRepo);
        $this->controllers['list']     = new ListController($shoppingListRepo, $listItemRepo ,$this->strings);
    }

    public function getController(string $name): ?object {
        return $this->controllers[$name] ?? null;
    }

    public function getDb(): DB {
        return $this->db;
    }

    public function getStrings(): array {
        return $this->strings;
    }
}