<?php
use App\Core\Router;

use App\Controller\AuthController;
use App\Controller\ProductController;
use App\Controller\SupplierController;
use App\Controller\ProductSupplierController;

$router->get('/', [ProductController::class, 'productsPage']);
$router->get('/login', [AuthController::class, 'loginPage']);
$router->get('/register', [AuthController::class, 'registerPage']);
$router->get('/products', [ProductController::class, 'productsPage']);
$router->get('/suppliers', [SupplierController::class, 'suppliersPage']);
$router->get('/links', [ProductSupplierController::class, 'linksPage']);




