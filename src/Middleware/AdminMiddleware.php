<?php

namespace App\Middleware;

class AdminMiddleware
{
    public static function require(): array
    {
        $user = AuthMiddleware::require();

        if (!isset($user['isAdmin']) || $user['isAdmin'] != 1) {
            http_response_code(403);
            echo json_encode([
                'success' => false,
                'error' => 'Forbidden - Admin access required'
            ]);
            exit;
        }

        return $user;
    }
}
