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
        $lists = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $lists[] = new ShoppingList($row['id'], $row['name']);
        }

        return $lists;
    }

    public function getListById(int $id): ?ShoppingList
    {
        $pdo = $this->db->getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . Config::DB_TABLE_LISTS . " WHERE id = :id");
        $stmt->execute([':id' => $id]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new ShoppingList($row['id'], $row['name']);
        }

        return null;
    }

    public function create(string $name): bool
    {
        $pdo = $this->db->getInstance();
        $stmt = $pdo->prepare("INSERT INTO " . Config::DB_TABLE_LISTS . " (name) VALUES (:name)");
        return $stmt->execute([':name' => $name]);
    }
}