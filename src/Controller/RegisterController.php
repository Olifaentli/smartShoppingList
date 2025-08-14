<?php
namespace App\Controller;

use App\Utils\Config;
use App\Utils\DB;
use PDO;
use PDOException;

class RegisterController {
    private PDO $pdo;
    private array $strings;

    public function __construct(DB $db, array $strings) {
        $this->pdo = $db->getInstance();
        $this->strings = $strings;
    }

    public function template(): void {
        include __DIR__ . '/../Templates/register.php';
    }

    public function register(): void {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if ($email && $password !== '') {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                $stmt = $this->pdo->prepare(
                    "INSERT INTO " . Config::DB_TABLE_USERS . " (email, password) VALUES (:email, :password)"
                );
                $stmt->execute([
                    ':email'    => $email,
                    ':password' => $hashedPassword
                ]);

                header("Location: index.php?controller=login&action=template&success=1");
                exit;
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') {
                    $error = "Diese E-Mail ist bereits registriert.";
                } else {
                    $error = "Fehler bei der Registrierung: " . htmlspecialchars($e->getMessage());
                }
            }
        } else {
            $error = "Bitte gib eine gültige E-Mail und ein Passwort ein.";
        }

        include __DIR__ . '/../Templates/register.php';
    }
}
