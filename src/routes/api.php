<?php

use App\Controller\AuthController;
use App\Controller\ProductController;
use App\Controller\SupplierController;


$router->post('/api/register', [AuthController::class, 'register']);
$router->post('/api/login', [AuthController::class, 'login']);

$router->get('/api/me', [AuthController::class, 'me']);

$router->get('/api/suppliers', [SupplierController::class, 'index']);
$router->post('/api/supplier', [SupplierController::class, 'create']);
$router->put('/api/supplier/{id}', [SupplierController::class, 'update']);

$router->get('/api/products', [ProductController::class, 'index']);
$router->post('/api/product', [ProductController::class, 'create']);

