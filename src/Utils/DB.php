<?php

namespace App\Utils;

use PDO;
use PDOException;

class DB {
    private PDO $instance;

    public function __construct() {
        $envPath = dirname(__DIR__) . '/.env';
        $env = parse_ini_file($envPath);

        $host = $env['DB_HOST'] ?? 'localhost';
        $db   = $env['DB_NAME'] ?? '';
        $user = $env['DB_USER'] ?? '';
        $pass = $env['DB_PASS'] ?? '';

        try {
            $this->instance = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
            $this->instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Verbindung fehlgeschlagen: " . $e->getMessage());
        }
    }

    public function getInstance(): PDO {
        return $this->instance;
    }
}