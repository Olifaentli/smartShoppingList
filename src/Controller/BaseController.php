<?php

namespace App\Controller;

use App\Model\User;
use App\Repo\UserRepo;

class BaseController
{

    protected UserRepo $userRepo;

    protected array $strings;

    public function __construct(UserRepo $userRepo, array $strings)
    {
        $this->userRepo = $userRepo;
        $this->strings = $strings;
    }

    public function getCurrentUser(): ?User
    {
        if (isset($_SESSION['user_id'])) {
            return $this->userRepo->getUserById($_SESSION['user_id']);
        }
        return null;
    }

    public function translate(string $key): string
    {
        return $this->strings[$key] ?? $key;
    }

    protected function getRequestedAction(): ?string
    {
        return $_REQUEST['action'];
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }
    protected function renderError(string $msg): void
    {
        echo "<p class='message-error'>".$this->translate($msg)."</p>";
    }

}