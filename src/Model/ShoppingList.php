<?php

namespace App\Model;

class ShoppingList
{
    private ?int $id;
    private string $name;

    private int $userId;

    public function __construct(string $name, int $userId, ?int $id = null)
    {
        $this->userId = $userId;
        $this->name = $name;
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
}