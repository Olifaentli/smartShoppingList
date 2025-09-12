<?php

namespace App\Controller;

use App\Exceptions\UserException;
use App\Model\User;

class RegisterController extends BaseController
{
    public function template(): void {
        include __DIR__ . '/../Templates/register.php';
    }

    public function register(): void {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $errorMessage = null;

        try {
            $newUser = new User($email, $password, null, true);
            $this->userRepo->create($newUser);
        } catch (\Exception $exception) {
            if ($exception instanceof UserException) {
                $errorMessage = $exception->getUserMessage();
            } else {
                throw $exception;
            }
        }

        if (!$errorMessage) {
            $_SESSION['user_message'] = "<div class='message-success'>".$this->translate('register_success')."</div>";
            header("Location: index.php?controller=login&action=template");
            exit;
        }

        include __DIR__ . '/../Templates/register.php';
    }
}