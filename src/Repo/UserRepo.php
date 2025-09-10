<?php

namespace App\Repo;

use App\Exceptions\UserException;
use App\Model\User;
use App\Utils\Config;
use App\Utils\DB;
use PDO;

class UserRepo extends DB
{
    private DB $db;

    private array $strings;

    public function __construct(DB $db, array $strings)
    {
        $this->db = $db;
        $this->strings = $strings;
    }

    public function getUserByEmail(string $email): ?User
    {
        $pdo = $this->db->getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . Config::DB_TABLE_USERS . " WHERE email = :email");
        $stmt->execute([':email' => $email]);

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $this->mapRowToUser($row);
        }

        return null;
    }

    public function create(User $user): User
    {
        if (!$user->getPassword()) {
            throw new \InvalidArgumentException("Password cannot be empty");
        }
        if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email");
        }
        if ($user->getId()) {
            throw new \InvalidArgumentException("User already has an ID" );
        }
        if ($this->getUserByEmail($user->getEmail())) {
            throw new UserException('email_exists');
        }

        $pdo = $this->db->getInstance();

        $stmt = $pdo->prepare(
            "INSERT INTO " . Config::DB_TABLE_USERS . " (email, password) VALUES (:email, :password)"
        );

        $result = $stmt->execute([
            ':email'    => $user->getEmail(),
            ':password' => $user->getPassword(),
        ]);
        if (!$result) {
            throw new \RuntimeException("Failed to create user");
        }
        $userId = (int)$pdo->lastInsertId();
        $user = $this->getUserById($userId);
        if (!$user) {
            throw new \RuntimeException("Failed to retrieve created user");
        }
        return $user;
    }

    public function update(User $user): User
    {
        if (!$user->getId()) {
            throw new \InvalidArgumentException("User must have an ID to be updated");
        }
        if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email");
        }

        // Check if email is already taken by another user
        $existingUser = $this->getUserByEmail($user->getEmail());
        if ($existingUser && $existingUser->getId() !== $user->getId()) {
            throw new UserException($this->strings['email_exists']);
        }

        $pdo = $this->db->getInstance();

        $stmt = $pdo->prepare(
            "UPDATE " . Config::DB_TABLE_USERS . " 
         SET email = :email, password = :password 
         WHERE id = :id"
        );

        $result = $stmt->execute([
            ':email'    => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':id'       => $user->getId(),
        ]);

        if (!$result) {
            throw new \RuntimeException("Failed to update user");
        }

        // Return fresh user object from DB
        $updatedUser = $this->getUserById($user->getId());
        if (!$updatedUser) {
            throw new \RuntimeException("Failed to retrieve updated user");
        }

        return $updatedUser;
    }


    public function getUserById(int $userId): ?User
    {
        $pdo = $this->db->getInstance();
        $stmt = $pdo->prepare("SELECT * FROM " . Config::DB_TABLE_USERS . " WHERE id = :id");
        $stmt->execute([':id' => $userId]);


        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $this->mapRowToUser($row);
        }

        return null;
    }

    private function mapRowToUser(array $row): User
    {
        return new User($row['email'], $row['password'], (int)$row['id']);
    }
}