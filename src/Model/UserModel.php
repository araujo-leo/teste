<?php

namespace App\Model;

use App\Config\Database;
use Firebase\JWT\JWT;
use PDO;

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

    public static function login(string $email, string $password): ?string
    {
        $pdo = Database::getConnection();

        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return self::generateToken($user);
        }

        return null;
    }

    private static function generateToken(array $user): string
    {
        $secretKey = $_ENV['JWT_SECRET'];
        $issuedAt = time();
        $expirationTime = $issuedAt + (60 * 60 * 24);

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'user_id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'isAdmin' => (int) ($user['isAdmin'] ?? 0)
        ];

        return JWT::encode($payload, $secretKey, 'HS256');
    }

    public static function validateToken(string $token): ?array
    {
        try {
            $secretKey = $_ENV['JWT_SECRET'];
            $decoded = JWT::decode($token, new \Firebase\JWT\Key($secretKey, 'HS256'));
            return (array) $decoded;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function findById(int $id): ?array
    {
        $pdo = Database::getConnection();

        $sql = "SELECT id, name, email, created_at FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public static function findByEmail(string $email): ?array
    {
        $pdo = Database::getConnection();

        $sql = "SELECT id, name, email, created_at FROM users WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }
}