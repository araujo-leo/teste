<?php

namespace App\Controller;

use App\Model\ProductModel;

class ProductController extends BaseController
{
    public function index() :void
    {
        $products = ProductModel::getAll();

        if(empty($products)) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'No products found'
            ], 404);
        }

        $this->jsonResponse([
            'success' => true,
            'data' => $products
        ]);
    }
    public function create() :void
    {
        $data = $this->getJsonInput();

        if(empty($data['internal_code']) || empty($data['name']) || empty($data['description']) || empty($data['price']) || empty($data['status'])) {
            $this->jsonResponse([
                'success'=> false,
                'error' => 'Internal code, name, description, price and status are required'
            ], 400);
        }

        $this->validateData($data['price'], $data['status'], $data['internal_code']);

        try {
            $product = ProductModel::create($data['internal_code'], $data['name'], $data['description'], $data['price'], $data['status']);
            if(!$product) {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Failed to create product'
                ], 500);
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Product created successfully'
            ], 201);
        } catch (\Exception $e) {
            $this->jsonResponse(['error' => 'Failed to create product: ' . $e->getMessage()], 500);
        }
    }

    public function update(int $id) :void
    {
        $data = $this->getJsonInput();

        $currentProduct = ProductModel::getById($id);

        if (!$currentProduct) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $code = $data['internal_code'] ?? $currentProduct['internal_code'];
        $name = $data['name'] ?? $currentProduct['name'];
        $description = $data['description'] ?? $currentProduct['description'];
        $price = $data['price'] ?? $currentProduct['price'];
        $status = $data['status'] ?? $currentProduct['status'];

        $this->validateData($price, $status, $code);

        try {
            $updated = ProductModel::update($id,$code, $name, $description, $price, $status);
            if(!$updated){
                $this->jsonResponse([
                    'success'  => false,
                    'message' => 'Failed to update supplier'
                ]);
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Product updated successfully'
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Error updating supplier: ' . $e->getMessage()
            ], 500);
        }
    }

    private function validateData(float $price,string $status, string $code) :void
    {
        if($price <= 0) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Price must be greater than zero'
            ], 400);
        }

        if($status !== 'active' && $status !== 'inactive') {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Status must be either active or inactive'
            ], 400);
        }

        if(ProductModel::existsByInternalCode($code)) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Internal code must be unique'
            ], 400);
        }
    }
}
