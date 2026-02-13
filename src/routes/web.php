<?php
use App\Core\Router;

use App\Controller\AuthController;

$router->get('/', [\App\Controller\ProductController::class, 'indexPage']);
$router->get('/login', [AuthController::class, 'loginPage']);
$router->get('/register', [AuthController::class, 'registerPage']);




