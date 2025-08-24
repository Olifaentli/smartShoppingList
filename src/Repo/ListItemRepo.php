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
            $items[] = new ListItem(
                $row['id'],
                $row['list_id'],
                $row['name'],
                $row['amount'],
                $row['unit'],
                $row['comment'],
                (bool) $row['is_checked']
            );
        }

        return $items;
    }
}
