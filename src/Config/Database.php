<?php
namespace App\Config;

use PDO;
use PDOException;

class Database {
    private static $instance = null;

    public static function getConnection() {
        if (!self::$instance) {
            try {
                $host = $_ENV['DB_HOST'];
                $db   = $_ENV['DB_DATABASE'];
                $user = $_ENV['DB_USERNAME'];
                $pass = $_ENV['DB_PASSWORD'];

                $dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";

                self::$instance = new PDO($dsn, $user, $pass);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro BD: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}