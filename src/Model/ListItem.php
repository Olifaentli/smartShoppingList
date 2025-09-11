<?php

namespace App\Model;

class ListItem
{
    public function __construct(
        private int $listId,
        private string $name,
        private int $amount,
        private string $unit,
        private ?string $comment,
        private bool $isChecked = false,
        private ?int $id = null,
    ) {

    }

    public function getId(): ?int { return $this->id; }
    public function getListId(): int { return $this->listId; }
    public function getName(): string { return $this->name; }
    public function getAmount(): int { return $this->amount; }
    public function getUnit(): string { return $this->unit; }
    public function getComment(): ?string { return $this->comment; }
    public function isChecked(): bool { return $this->isChecked; }

    public function setChecked(bool $checked): void {
        $this->isChecked = $checked;
    }
}
