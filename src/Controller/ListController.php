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

    public function create(): void
    {
        session_start();

        $name = trim($_POST['name'] ?? '');
        $userId = $_SESSION['user_id'] ?? null;

        if ($name && $userId) {
            try {
                $this->repo->create($name, $userId);
                header("Location: index.php?controller=shoppinglist&action=template");
                exit;
            } catch (\PDOException $e) {
                echo "<p class='error'>Fehler: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        } else {
            $errorMsg = $this->strings['missing_list_name_or_user'];
            echo "<p class='error'>" . htmlspecialchars($errorMsg) . "</p>";
        }
    }
}