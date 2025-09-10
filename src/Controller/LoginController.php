<?php

namespace App\Controller;

use App\Repo\UserRepo;

class LoginController extends BaseController
{
    public function template(): void
    {
        $message = $_SESSION['login_message'] ?? '';
        unset($_SESSION['login_message']);
        include __DIR__ . '/../Templates/login.php';
    }

    public function login(): void
    {
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

    public function logout(): void
    {
        session_unset();
        session_destroy();
        header("Location: index.php?controller=login&action=template");
        exit;
    }
}
