<?php

namespace App\Repo;

use App\Model\ListItem;
use App\Utils\Config;
use App\Utils\DB;
use PDO;

class ListItemRepo
{
    private PDO $pdo;

    public function __construct(DB $db)
    {
        $this->pdo = $db->getInstance();
    }

    public function getItemsByListId(int $listId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM " . Config::DB_TABLE_ITEMS . " WHERE list_id = :list_id ORDER BY id DESC");
        $stmt->execute([':list_id' => $listId]);

        $items = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[] = $this->mapRowToListItem($row);
        }

        return $items;
    }

    public function create(\App\Model\ListItem $item): void
    {
        $stmt = $this->pdo->prepare("
        INSERT INTO list_items (name, amount, unit, comment, list_id)
        VALUES (:name, :amount, :unit, :comment, :list_id)
    ");
        $stmt->execute([
            ':name' => $item->getName(),
            ':amount' => $item->getAmount(),
            ':unit' => $item->getUnit(),
            ':comment' => $item->getComment(),
            ':list_id' => $item->getListId(),
        ]);
    }

    public function markChecked(int $itemId, bool $checked = true): void
    {
        $stmt = $this->pdo->prepare("UPDATE list_items SET is_checked = :checked WHERE id = :id");
        $stmt->execute([
            ':checked' => $checked ? 1 : 0,
            ':id' => $itemId
        ]);
    }



    private function mapRowToListItem(array $row): ListItem
    {
        return new ListItem(
            (int) $row['list_id'],
            $row['name'],
            (int) $row['amount'],
            $row['unit'],
            $row['comment'],
            (bool) $row['is_checked'],
            (int) $row['id']
        );
    }
}
