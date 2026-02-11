<?php

use App\Controller\AuthController;
use App\Core\Router;
use App\Controller\CharacterController;



$router->post('/api/register', [AuthController::class, 'register']);
$router->post('/api/login', [AuthController::class, 'login']);