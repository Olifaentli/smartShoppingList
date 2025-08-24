<?php

namespace App\Controller;

use App\Repo\ShoppingListRepo;

class ListOverviewController
{
    private ShoppingListRepo $shoppingListRepo;

    public function __construct(ShoppingListRepo $shoppingListRepo)
    {
        $this->shoppingListRepo = $shoppingListRepo;
    }

    public function index(): void
    {
        $lists = $this->shoppingListRepo->getAll();
        include __DIR__ . '/../Templates/list_overview.php';
    }
}