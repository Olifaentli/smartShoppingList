<?php

namespace App\Model;

class ListItem
{
    private int $id;
    private int $listId;
    private string $name;
    private int $amount;
    private string $unit;

    public function __construct(int $id, int $listId, string $name, int $amount, string $unit)
    {
        $this->id = $id;
        $this->listId = $listId;
        $this->name = $name;
        $this->amount = $amount;
        $this->unit = $unit;
    }

    public function getId(): int { return $this->id; }
    public function getListId(): int { return $this->listId; }
    public function getName(): string { return $this->name; }
    public function getAmount(): int { return $this->amount; }
    public function getUnit(): string { return $this->unit; }

    public function setName(string $name): void { $this->name = $name; }
    public function setAmount(int $amount): void { $this->amount = $amount; }
    public function setUnit(string $unit): void { $this->unit = $unit; }
}