<?php

namespace App\Controller;

use App\Repo\ShoppingListRepo;
use App\Model\ShoppingList;

class ListController {
    private ShoppingListRepo $repo;

    public function __construct(ShoppingListRepo $repo) {
        $this->repo = $repo;
    }

    public function template(): void {
        include __DIR__ . '/../Templates/new_list.php';
    }

    public function create(): void {
        $name = trim($_POST['name'] ?? '');
        $message = '';

        if ($name !== '') {
            $list = new ShoppingList(null, $name);
            try {
                $this->repo->create($list);
                header("Location: index.php?controller=shoppinglist&action=index");
                exit;
            } catch (\Exception $e) {
                $message = "<div class='message error'>Fehler beim Speichern: " . htmlspecialchars($e->getMessage()) . "</div>";
            }
        } else {
            $message = "<div class='message error'>Bitte gib einen gültigen Listennamen ein.</div>";
        }

        include __DIR__ . '/../Templates/new_list.php';
    }
}