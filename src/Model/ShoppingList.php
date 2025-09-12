<?php

namespace App\Model;

class ShoppingList
{
    private ?int $id;
    private string $name;
    private int $userId;
    private array $members = [];

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

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function isShared(int $currentUserId): bool {
        return count($this->members) > 1 || $this->userId !== $currentUserId;
    }

    public function getMembers(): array {
        return $this->members;
    }

    public function addMember(int $userId): void {
        $this->members[] = $userId;
    }
}