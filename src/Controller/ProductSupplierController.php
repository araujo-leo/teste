<?php

namespace App\Controller;

use App\Model\ProductSupplierModel;
use App\Model\ProductModel;
use App\Model\SupplierModel;

class ProductSupplierController extends BaseController
{
    public function linkProductSupplier(): void
    {
        $data = $this->getJsonInput();
        if (empty($data['product_id']) || empty($data['supplier_id'])) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'product_id and supplier_id are required'
            ], 400);
        }

        $productId = (int)$data['product_id'];
        $supplierId = (int)$data['supplier_id'];

        $product = ProductModel::getById($productId);
        if (!$product) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Product not found'
            ], 404);
        }

        $supplier = SupplierModel::getById($supplierId);
        if (!$supplier) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Supplier not found'
            ], 404);
        }

        if($supplier['status'] !== 'active') {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Supplier is not active'
            ], 400);
        }

        try {
            $alreadyLinked = ProductSupplierModel::exists($productId, $supplierId);
            if ($alreadyLinked) {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Supplier is already linked to this product'
                ], 400);
            }

            $linked = ProductSupplierModel::create($productId, $supplierId);
            if (!$linked) {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Failed to link supplier to product'
                ], 400);
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Supplier linked to product successfully'
            ], 201);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Failed to link supplier: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getSuppliersByProduct(int $productId): void
    {
        $product = ProductModel::getById($productId);
        if (!$product) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Product not found'
            ], 404);
        }

        $suppliers = ProductSupplierModel::getSuppliersByProduct($productId);
        $this->jsonResponse([
            'success' => true,
            'product' => [
                'id' => $product['id'],
                'name' => $product['name'],
                'internal_code' => $product['internal_code']
            ],
            'suppliers' => $suppliers,
            'total' => count($suppliers)
        ]);
    }

    public function getProductsBySupplier(int $supplierId): void
    {
        $supplier = SupplierModel::getById($supplierId);
        if (!$supplier) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Supplier not found'
            ], 404);
        }

        $products = ProductSupplierModel::getProductsBySupplier($supplierId);

        $this->jsonResponse([
            'success' => true,
            'supplier' => [
                'id' => $supplier['id'],
                'company_name' => $supplier['company_name'],
                'cnpj' => $supplier['cnpj']
            ],
            'products' => $products,
            'total' => count($products)
        ]);
    }

    public function unlinkSupplier(int $productId, int $supplierId): void
    {
        if (!ProductSupplierModel::exists($productId, $supplierId)) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Link not found'
            ], 404);
        }

        try {
            $deleted = ProductSupplierModel::delete($productId, $supplierId);

            if (!$deleted) {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Failed to unlink supplier from product'
                ], 500);
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Supplier unlinked from product successfully'
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Failed to unlink supplier: ' . $e->getMessage()
            ], 500);
        }
    }


    public function unlinkAllSuppliers(int $productId): void
    {
        $product = ProductModel::getById($productId);
        if (!$product) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Product not found'
            ], 404);
        }

        try {
            $count = ProductSupplierModel::countSuppliersByProduct($productId);

            if ($count === 0) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Product has no suppliers linked'
                ], 404);
            }

            $deleted = ProductSupplierModel::deleteAllByProduct($productId);

            if (!$deleted) {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Failed to unlink suppliers'
                ], 500);
            }

            $this->jsonResponse([
                'success' => true,
                'message' => "All suppliers unlinked from product successfully",
                'removed' => $count
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Failed to unlink suppliers: ' . $e->getMessage()
            ], 500);
        }
    }

    public function unlinkAllProducts(int $supplierId): void
    {
        $supplier = SupplierModel::getById($supplierId);
        if (!$supplier) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Supplier not found'
            ], 404);
        }

        try {
            $count = ProductSupplierModel::countProductsBySupplier($supplierId);

            if ($count === 0) {
                $this->jsonResponse([
                    'success' => false,
                    'message' => 'Supplier has no products linked'
                ], 404);
            }

            $deleted = ProductSupplierModel::deleteAllBySupplier($supplierId);

            if (!$deleted) {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Failed to unlink products'
                ], 500);
            }

            $this->jsonResponse([
                'success' => true,
                'message' => "All products unlinked from supplier successfully",
                'removed' => $count
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Failed to unlink products: ' . $e->getMessage()
            ], 500);
        }
    }
}
