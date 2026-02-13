<?php

use App\Controller\AuthController;
use App\Controller\ProductController;
use App\Controller\SupplierController;
use App\Controller\ProductSupplierController;
use App\Middleware\AdminMiddleware;


$router->post('/api/register', [AuthController::class, 'register']);
$router->post('/api/login', [AuthController::class, 'login']);

$router->get('/api/me', [AuthController::class, 'me']);

$router->get('/api/suppliers', [SupplierController::class, 'index']);
$router->post('/api/supplier', [SupplierController::class, 'create'], [AdminMiddleware::class]);
$router->put('/api/supplier/{id}', [SupplierController::class, 'update'], [AdminMiddleware::class]);

$router->get('/api/products', [ProductController::class, 'index']);
$router->post('/api/product', [ProductController::class, 'create'], [AdminMiddleware::class]);
$router->put('/api/product/{id}', [ProductController::class, 'update'], [AdminMiddleware::class]);


$router->post('/api/link-product-supplier', [ProductSupplierController::class, 'linkProductSupplier'], [AdminMiddleware::class]);
$router->get('/api/products/{id}/suppliers', [ProductSupplierController::class, 'getSuppliersByProduct']);

$router->delete('/api/products/{productId}/suppliers/{supplierId}', [ProductSupplierController::class, 'unlinkSupplier'], [AdminMiddleware::class]);
$router->delete('/api/products/{id}/suppliers', [ProductSupplierController::class, 'unlinkAllSuppliers'], [AdminMiddleware::class]);

$router->get('/api/suppliers/{id}/products', [ProductSupplierController::class, 'getProductsBySupplier']);
$router->delete('/api/suppliers/{supplierId}/products', [ProductSupplierController::class, 'unlinkAllProducts'], [AdminMiddleware::class]);
