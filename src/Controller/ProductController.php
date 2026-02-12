<?php

namespace App\Controller;

use App\Model\ProductModel;

class ProductController extends BaseController
{
    public function index() :array
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


}