<?php

namespace App\Controller;

use App\Repo\UserRepo;
use App\Utils\Config;
use PDOException;

class RegisterController {
    private UserRepo $userRepo;
    private array $strings;

    public function __construct(UserRepo $userRepo, array $strings)
    {
        $this->userRepo = $userRepo;
        $this->strings = $strings;
    }

    public function template(): void {
        include __DIR__ . '/../Templates/register.php';
    }

    public function register(): void {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $error = '';

        if ($email && $password !== '') {
            $success = $this->userRepo->createUser($email, $password);

            if ($success) {
                header("Location: index.php?controller=login&action=template&success=1");
                exit;
            } else {
                $error = $this->strings['email_exists'];
            }

        } else {
            $error = $this->strings['invalid_input'];
        }

        $message = "<div class='message-error'>{$error}</div>";
        include __DIR__ . '/../Templates/register.php';
    }
}