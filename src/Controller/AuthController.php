<?php

namespace App\Controller;

use App\Core\View;
use App\Model\UserModel;
use App\Middleware\AuthMiddleware;

class AuthController extends BaseController
{
    public function loginPage() :string
    {
        return View::render("auth/login");
    }
    public function register() :void
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

    public function login() :void
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
                    'user' => UserModel::findByEmail($data['email']),
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