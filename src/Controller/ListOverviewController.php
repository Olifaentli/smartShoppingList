<?php

namespace App\Controller;

use App\Repo\ShoppingListRepo;
use App\Repo\UserRepo;

class ListOverviewController extends BaseController
{
    private ShoppingListRepo $shoppingListRepo;

    public function __construct(UserRepo $userRepo, array $strings, ShoppingListRepo $shoppingListRepo)
    {
        parent::__construct($userRepo, $strings);
        $this->shoppingListRepo = $shoppingListRepo;
    }

    public function template(): void
    {
        $lists = $this->shoppingListRepo->getAll();
        include __DIR__ . '/../Templates/list_overview.php';
    }
}