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

    public function getAllForUser(int $userId): array
    {
        $pdo = $this->db->getInstance();

        $sql = "
        SELECT DISTINCT sl.*
        FROM " . Config::DB_TABLE_LISTS . " sl
        INNER JOIN " . Config::DB_TABLE_LISTS_USERS . " slu
            ON slu.list_id = sl.id
        WHERE slu.user_id = :uid
        ORDER BY sl.id DESC
    ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['uid' => $userId]);

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

    public function create(ShoppingList $shoppingList): int
    {
        $pdo = $this->db->getInstance();

        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO " . Config::DB_TABLE_LISTS . " (name, user_id) VALUES (:name, :user_id)");
            $stmt->execute([
                ':name' => $shoppingList->getName(),
                ':user_id' => $shoppingList->getUserId(),
            ]);
            $listId = (int)$pdo->lastInsertId();

            $stmtLink = $pdo->prepare("
            INSERT INTO " . Config::DB_TABLE_LISTS_USERS . " (list_id, user_id)
            VALUES (:list_id, :user_id)
        ");
            $stmtLink->execute([
                ':list_id' => $listId,
                ':user_id' => $shoppingList->getUserId(),
            ]);

            $pdo->commit();
            return $listId;
        } catch (\Exception $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    public function update(ShoppingList $list): void
    {
        $pdo = $this->db->getInstance();
        $stmt = $pdo->prepare("
        UPDATE shopping_lists 
        SET name = :name, updated_at = CURRENT_TIMESTAMP 
        WHERE id = :id
    ");

        $stmt->execute([
            ':name' => $list->getName(),
            ':id'   => $list->getId(),
        ]);
    }

    public function delete(int $id): void
    {
        $pdo = $this->db->getInstance();
        $stmt = $pdo->prepare('DELETE FROM shopping_lists WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }

    public function addMember(int $listId, int $userId): bool
    {
        $pdo = $this->db->getInstance();
        $sql = "INSERT IGNORE INTO " . Config::DB_TABLE_LISTS_USERS . " (list_id, user_id)
            VALUES (:list_id, :user_id)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':list_id' => $listId,
            ':user_id' => $userId,
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