<?php

namespace App\Repo;

use App\Model\User;
use App\Utils\Config;
use App\Utils\DB;
use PDO;
use PDOException;

class UserRepo extends DB
{
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    public function getUserByEmail(string $email): ?User
    {
        $pdo = $this->db->getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . Config::DB_TABLE_USERS . " WHERE email = :email");
        $stmt->execute([':email' => $email]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new User($row['id'], $row['email'], $row['password']);
        }

        return null;
    }

    public function createUser(string $email, string $password): bool
    {
        $pdo = $this->db->getInstance();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare(
                "INSERT INTO " . Config::DB_TABLE_USERS . " (email, password) VALUES (:email, :password)"
            );
            return $stmt->execute([
                ':email'    => $email,
                ':password' => $hashedPassword
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                return false;
            }
            throw $e;
        }
    }
}