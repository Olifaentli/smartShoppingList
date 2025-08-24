<?php

namespace App\Controller;
use App\Repo\ListItemRepo;
use App\Repo\ShoppingListRepo;

class ListController {
    private ShoppingListRepo $shoppingListRepo;
    private ListItemRepo $itemRepo;
    private array $strings;

    public function __construct(ShoppingListRepo $shoppingListRepo, ListItemRepo $itemRepo, array $strings)
    {
        $this->shoppingListRepo = $shoppingListRepo;
        $this->itemRepo = $itemRepo;
        $this->strings = $strings;
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
                $this->shoppingListRepo->create($name, $userId);
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

    public function detail(): void
    {
        $listId = $_GET['list_id'] ?? null;

        if (!$listId) {
            $errorMsg = $this->strings['no_list_error'];
            echo "<p class='error'>" . htmlspecialchars($errorMsg) . "</p>";
            return;
        }

        $list = $this->shoppingListRepo->getById((int) $listId);
        $items = $this->itemRepo->getItemsByListId((int) $listId);

        include __DIR__ . '/../Templates/list_detail.php';
    }
}