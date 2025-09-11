<?php

namespace App\Utils;

use App\Controller\ListController;
use App\Controller\RegisterController;
use App\Controller\LoginController;
use App\Controller\HomeController;
use App\Controller\UserController;
use App\Manager\ShoppingAiManager;
use App\Repo\ListItemRepo;
use App\Repo\ShoppingListRepo;
use App\Repo\UserRepo;

class Container {
    private array $controllers = [];
    private DB $db;
    private array $strings;

    private array $repos = [];

    public function __construct() {
        $this->db = new DB();

        $this->strings = require __DIR__ . '/../Lang/de.php';

        $this->register();
    }

    private function register(): void {
        $userRepo = new UserRepo($this->db, $this->strings);
        $shoppingListRepo = new ShoppingListRepo($this->db);

        $this->repos['user'] = $userRepo;
        $this->repos['shoppingList'] = $shoppingListRepo;

        $listItemRepo = new ListItemRepo($this->db);
        $envPath = dirname(__DIR__) . '/.env';
        $env = parse_ini_file($envPath);
        $shoppingAiManager = new ShoppingAiManager(
            $shoppingListRepo,
            $listItemRepo,
            $env['OPENAI_API_KEY'] ?: null,
        );


        $this->controllers['register'] = new RegisterController($userRepo, $this->strings);
        $this->controllers['login']    = new LoginController($userRepo, $this->strings);
        $this->controllers['user']    = new UserController($userRepo, $this->strings);
        $this->controllers['home']     = new HomeController($userRepo, $this->strings);
        $this->controllers['list']     = new ListController($userRepo, $this->strings, $shoppingListRepo, $listItemRepo, $shoppingAiManager);
    }

    public function getRepo(string $name): ?object {
        return $this->repos[$name] ?? null;
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