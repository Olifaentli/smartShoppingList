<?php

namespace App\Controller;

use App\Exceptions\UserException;
use App\Model\User;
use App\Repo\UserRepo;

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
            $user = $this->userRepo->create($newUser);
        } catch (\Exception $exception) {
            if (!$exception instanceof UserException) {
                throw $exception;
            }
            $errorMessage = $exception->getUserMessage();
        }
        if (!$errorMessage) {
            header("Location: index.php?controller=login&action=template&success=1");
            exit;
        }
        $message = "<div class='message-error'>{$this->translate($errorMessage)}</div>";
        include __DIR__ . '/../Templates/register.php';
    }
}