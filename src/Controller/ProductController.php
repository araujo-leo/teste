<?php

namespace App\Controller;

use App\Model\ProductModel;

class ProductController extends BaseController
{
    public function index() :array
    {
        $products = ProductModel::getAll();

        if(empty($products)) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'No products found'
            ], 404);
        }

        return $this->jsonResponse([
            'success' => true,
            'data' => $products
        ]);
    }
    public function create() :array
    {
        $data = $this->getJsonInput();

        if(empty($data['internal_code']) || empty($data['name']) || empty($data['description']) || empty($data['price']) || empty($data['status'])) {
            $this->jsonResponse([
                'success'=> false,
                'error' => 'Internal code, name, description, price and status are required'
            ], 400);
        }

        try {
            $product = ProductModel::create($data['internal_code'], $data['name'], $data['description'], $data['price'], $data['status']);
            if(!$product) {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Failed to create product'
                ], 500);
            }

            return $this->jsonResponse([
                'success' => true,
                'message' => 'Product created successfully'
            ], 201);
        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to create product: ' . $e->getMessage()], 500);
        }
    }
}