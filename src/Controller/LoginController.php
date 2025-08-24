<?php

namespace App\Controller;

use App\Repo\UserRepo;

class LoginController
{
    private UserRepo $userRepo;
    private string $message = '';

    public function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function template(): void
    {
        session_start();
        $message = $_SESSION['login_message'] ?? '';
        unset($_SESSION['login_message']);
        include __DIR__ . '/../Templates/login.php';
    }

    public function login(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (!$email || empty($password)) {
            $_SESSION['login_message'] = '<p class="error">Login fehlgeschlagen. Bitte überprüfe deine Zugangsdaten.</p>';
            header("Location: index.php?controller=login");
            exit;
        }

        $user = $this->userRepo->getUserByEmail($email);

        if ($user && password_verify($password, $user->getPassword())) {
            session_start();
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['email'] = $user->getEmail();

            header("Location: index.php?controller=shoppinglist&action=template");
            exit;
        } else {
            $_SESSION['login_message'] = '<p class="error">Login fehlgeschlagen. Bitte überprüfe deine Zugangsdaten.</p>';
            header("Location: index.php?controller=login");
            exit;
        }
    }
}
