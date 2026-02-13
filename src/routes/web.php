<?php
use App\Core\Router;

use App\Controller\AuthController;
use \App\Controller\ProductController;

$router->get('/', [\App\Controller\ProductController::class, 'indexPage']);
$router->get('/login', [AuthController::class, 'loginPage']);
$router->get('/register', [AuthController::class, 'registerPage']);
$router->get('/products', [ProductController::class, 'productsPage']);




