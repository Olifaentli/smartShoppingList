<?php

namespace App\Utils;

use App\Controller\ListController;
use App\Controller\RegisterController;
use App\Controller\LoginController;
use App\Controller\HomeController;
use App\Controller\ShoppinglistController;
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

        $this->controllers['register'] = new RegisterController($this->db, $this->strings);
        $this->controllers['login']    = new LoginController($userRepo, $this->strings);
        $this->controllers['home']     = new HomeController();
        $this->controllers['shoppinglist'] = new ShoppinglistController();
        $this->controllers['list'] = new ListController();
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