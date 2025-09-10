<?php

namespace App\Controller;
use App\Repo\ListItemRepo;
use App\Repo\ShoppingListRepo;
use App\Model\ShoppingList;
use App\Repo\UserRepo;

class ListController extends BaseController
{
    private ShoppingListRepo $shoppingListRepo;
    private ListItemRepo $itemRepo;

    public function __construct(UserRepo $userRepo, array $strings, ShoppingListRepo $shoppingListRepo, ListItemRepo $itemRepo)
    {
        parent::__construct($userRepo, $strings);
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
                $this->shoppingListRepo->create($newShoppingList = new ShoppingList($name, (int) $userId));
                header("Location: index.php?controller=listoverview&action=template");
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
            $errorMsg = $this->translate('no_list_error');
            echo "<p class='error'>" . htmlspecialchars($errorMsg) . "</p>";
            return;
        }

        $list = $this->shoppingListRepo->getById((int) $listId);
        $items = $this->itemRepo->getItemsByListId((int) $listId);

        include __DIR__ . '/../Templates/list_detail.php';
    }
}