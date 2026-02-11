<?php

namespace App\Middleware;

use App\Model\UserModel;

class AuthMiddleware
{
    public static function check(): ?array
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;

        if (!$authHeader) {
            return null;
        }

        $token = str_replace('Bearer ', '', $authHeader);

        return UserModel::validateToken($token);
    }

    public static function require(): array
    {
        $user = self::check();

        if (!$user) {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'error' => 'Unauthorized - Token invalid or not provided'
            ]);
            exit;
        }

        return $user;
    }
}
