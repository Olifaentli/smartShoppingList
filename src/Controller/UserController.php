<?php
namespace App\Controller;

use App\Repo\UserRepo;

class UserController extends BaseController
{
    public function template(): void
    {
        $user = $this->getCurrentUser();
        include __DIR__ . '/../Templates/user_view.php';
    }

    public function update(): void
    {
        session_start();
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: index.php?controller=login&action=template');
            exit;
        }

        $user = $this->userRepo->getUserById($userId);
        if (!$user) {
            $_SESSION['user_message'] = "<div class='message-error'>Unbekannter Benutzer.</div>";
            header('Location: index.php?controller=user&action=template');
            exit;
        }

        $email           = trim($_POST['email'] ?? '');
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword     = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $errors = [];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Bitte gib eine gültige E-Mail-Adresse ein.';
        }

        $wantsPasswordChange = $newPassword !== '' || $confirmPassword !== '';
        if ($wantsPasswordChange) {
            if ($newPassword !== $confirmPassword) {
                $errors[] = 'Die neuen Passwörter stimmen nicht überein.';
            }

            $currentHash = method_exists($user, 'getPassword') ? $user->getPassword() : ($user->getPassword() ?? null);
            if (!$currentPassword || !$currentHash || !password_verify($currentPassword, $currentHash)) {
                $errors[] = 'Aktuelles Passwort ist falsch.';
            }
        }

        if ($errors) {
            $_SESSION['user_message'] = "<div class='message-error'>" . implode('<br>', array_map('htmlspecialchars', $errors)) . "</div>";
            header('Location: index.php?controller=user&action=template');
            exit;
        }

        $user->setEmail($email);

        if ($wantsPasswordChange) {
            $user->setPassword($newPassword);
        }
        $this->userRepo->update($user);

        $_SESSION['user_message'] = "<div class='message-success'>Profil erfolgreich aktualisiert.</div>";

        header('Location: index.php?controller=user&action=template');
        exit;
    }
}
