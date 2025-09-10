<?php

namespace App\Repo;

use App\Model\ShoppingList;
use App\Utils\Config;
use App\Utils\DB;
use PDO;

class ShoppingListRepo extends DB
{
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $pdo = $this->db->getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . Config::DB_TABLE_LISTS . " ORDER BY id DESC");
        $stmt->execute();

        $lists = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $lists[] = $this->mapRowToShoppingList($row);

        }

        return $lists;
    }

    public function getListById(int $id): ?ShoppingList
    {
        $pdo = $this->db->getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . Config::DB_TABLE_LISTS . " WHERE id = :id");
        $stmt->execute([':id' => $id]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $this->mapRowToShoppingList($row);
        }

        return null;
    }

    public function create(ShoppingList $shoppingList): bool
    {
        $pdo = $this->db->getInstance();
        $stmt = $pdo->prepare("INSERT INTO " . Config::DB_TABLE_LISTS . "(name, user_id) VALUES (:name, :user_id)");
        return $stmt->execute([
            ':name' => $shoppingList->getName(),
            ':user_id' => $shoppingList->getUserId()
        ]);
    }

    private function mapRowToShoppingList(array $row): ShoppingList
    {
        return new ShoppingList(
            $row['name'],
            $row['user_id'],
            $row['id']
        );
    }
}