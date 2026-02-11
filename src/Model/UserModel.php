<?php

namespace App\Model;

use App\Config\Database;

class UserModel
{
    public static function register(string $name, string $email, string $password): bool
    {
        $pdo = Database::getConnection();

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $pdo->prepare($sql);

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', $hashedPassword);

        return $stmt->execute();
    }

    public static function login(string $email, string $password): bool
    {
        $pdo = Database::getConnection();

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }

        return false;
    }
}