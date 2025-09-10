<?php

namespace App\Model;

class User
{
    private ?int $id = null;
    private string $email;
    private string $password;
    private string $createdAt;

    public function __construct(string $email, string $password, $id = null, $clearTextPassword = false)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        if ($clearTextPassword) {
            $this->setPassword($password);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setEmail($email): User
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword($password): User
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->password = $hashedPassword;
        return $this;
    }

}