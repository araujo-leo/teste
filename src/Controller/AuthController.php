<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Middleware\AuthMiddleware;

class AuthController extends BaseController
{
    public function register() :array
    {
        $data = $this->getJsonInput();

        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            $this->jsonResponse([
                'success'=> false,
                'error' => 'Name, email and password are required'
            ], 400);
        }

        try{
            $user = UserModel::register($data['name'], $data['email'], $data['password']);
            if($user) {
                $this->jsonResponse([
                    'success' => true,
                    'message' => 'User registered successfully'
                ], 201);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Registration failed'
                ], 500);
            }
        }catch (\Exception $e){
            $this->jsonResponse(['error' => 'Registration failed: ' . $e->getMessage()], 500);
        }
    }

    public function login() :array
    {
        $data = $this->getJsonInput();

        if (empty($data['email']) || empty($data['password'])) {
            $this->jsonResponse([
                'success'=> false,
                'error' => 'Email and password are required'
            ], 400);
        }

        try{
            $token = UserModel::login($data['email'], $data['password']);
            if($token) {
                $this->jsonResponse([
                    'success' => true,
                    'token' => $token,
                    'message' => 'Login successful'
                ], 200);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Invalid email or password'
                ], 401);
            }
        }catch (\Exception $e){
            $this->jsonResponse(['error' => 'Login failed: ' . $e->getMessage()], 500);
        }
    }

    public function me(): void
    {
        $user = AuthMiddleware::require();

        $this->jsonResponse([
            'success' => true,
            'user' => [
                'id' => $user['user_id'],
                'name' => $user['name'],
                'email' => $user['email']
            ]
        ], 200);
    }
}