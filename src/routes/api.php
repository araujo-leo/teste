<?php

use App\Controller\AuthController;
use App\Controller\SupplierController;


$router->post('/api/register', [AuthController::class, 'register']);
$router->post('/api/login', [AuthController::class, 'login']);

$router->get('/api/me', [AuthController::class, 'me']);

$router->get('/api/suppliers', [SupplierController::class, 'index']);
$router->post('/api/supplier', [SupplierController::class, 'create']);

