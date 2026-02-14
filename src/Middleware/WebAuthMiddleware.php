<?php

namespace App\Middleware;

use App\Model\UserModel;

class WebAuthMiddleware
{
    public static function require(): array
    {
        $token = $_COOKIE['auth_token'] ?? $_GET['token'] ?? null;

        if (!$token) {
            header('Location: /login');
            exit;
        }
        $user = UserModel::validateToken($token);

        if (!$user) {
            header('Location: /login');
            exit;
        }

        if (!isset($user['isAdmin']) || $user['isAdmin'] != 1) {
            header('Location: /login');
            exit;
        }

        return $user;
    }
}
