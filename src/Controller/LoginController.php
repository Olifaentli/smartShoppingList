<?php

namespace App\Controller;

use App\Repo\UserRepo;

class LoginController
{
    private UserRepo $userRepo;
    private array $strings;

    public function __construct(UserRepo $userRepo, array $strings)
    {
        $this->userRepo = $userRepo;
        $this->strings = $strings;
    }

    public function template(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $message = $_SESSION['login_message'] ?? '';
        unset($_SESSION['login_message']);
        include __DIR__ . '/../Templates/login.php';
    }

    public function login(): void
    {
        session_start();
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $error = '';

        if (!$email || empty($password)) {
            $error = $this->strings['login_failed'];
        } else {
            $user = $this->userRepo->getUserByEmail($email);

            if ($user && password_verify($password, $user->getPassword())) {
                $_SESSION['user_id'] = $user->getId();
                $_SESSION['email'] = $user->getEmail();

                header("Location: index.php?controller=listoverview&action=template");
                exit;
            } else {
                $error = $this->strings['login_failed'];
            }
        }

        $message = "<div class='message-error'>{$error}</div>";
        include __DIR__ . '/../Templates/login.php';
    }
}
