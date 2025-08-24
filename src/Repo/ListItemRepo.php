<?php

namespace App\Repo;

use App\Model\ListItem;
use App\Utils\DB;
use PDO;

class ListItemRepo extends DB
{
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getItemsByListId(int $listId): array
    {
        $pdo = $this->db->getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . Config::DB_TABLE_ITEMS . " WHERE list_id = :list_id");
        $stmt->execute([':list_id' => $listId]);

        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = new ListItem(
                $row['id'],
                $row['list_id'],
                $row['name'],
                $row['amount'],
                $row['unit']
            );
        }

        return $items;
    }

    public function addItem(int $listId, string $name, int $amount, string $unit): bool
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO list_items (list_id, name, amount, unit)
            VALUES (:list_id, :name, :amount, :unit)
        ");

        return $stmt->execute([
            ':list_id' => $listId,
            ':name'    => $name,
            ':amount'  => $amount,
            ':unit'    => $unit
        ]);
    }
}