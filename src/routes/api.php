<?php

use App\Controller\AuthController;
use App\Controller\ProductController;
use App\Controller\SupplierController;
use App\Controller\ProductSupplierController;


$router->post('/api/register', [AuthController::class, 'register']);
$router->post('/api/login', [AuthController::class, 'login']);

$router->get('/api/me', [AuthController::class, 'me']);

$router->get('/api/suppliers', [SupplierController::class, 'index']);
$router->post('/api/supplier', [SupplierController::class, 'create']);
$router->put('/api/supplier/{id}', [SupplierController::class, 'update']);

$router->get('/api/products', [ProductController::class, 'index']);
$router->post('/api/product', [ProductController::class, 'create']);
$router->put('/api/product/{id}', [ProductController::class, 'update']);


$router->post('/api/link-product-supplier', [ProductSupplierController::class, 'linkProductSupplier']);
$router->get('/api/products/{id}/suppliers', [ProductSupplierController::class, 'getSuppliersByProduct']);

$router->delete('/api/products/{productId}/suppliers/{supplierId}', [ProductSupplierController::class, 'unlinkSupplier']);
$router->delete('/api/products/{id}/suppliers', [ProductSupplierController::class, 'unlinkAllSuppliers']);

$router->get('/api/suppliers/{id}/products', [ProductSupplierController::class, 'getProductsBySupplier']);
$router->delete('/api/suppliers/{supplierId}/products', [ProductSupplierController::class, 'unlinkAllProducts']);
