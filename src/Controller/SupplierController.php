<?php

namespace App\Controller;

use App\Core\View;
use App\Model\SupplierModel;

class SupplierController extends BaseController
{
    public function suppliersPage() :string
    {
        return View::render('suppliers/index');
    }
    public function index() :void
    {
        $suppliers = SupplierModel::getAll();

        if(empty($suppliers)) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'No suppliers found'
            ], 404);
        }

        $this->jsonResponse([
            'success' => true,
            'data' => $suppliers
        ]);
    }
    public function create() :void
    {
        $data = $this->getJsonInput();

        if (empty($data['cnpj']) || empty($data['company_name']) || empty($data['email']) || empty($data['phone']) || empty($data['status'])) {
            $this->jsonResponse([
                'success'=> false,
                'error' => 'CNPJ, company name, email and phone are required'
            ], 400);
        }

        $this->validateData($data['cnpj'], $data['email'], $data['status']);

        try{
            $supplier = SupplierModel::create($data['cnpj'], $data['company_name'], $data['email'], $data['phone'], $data['status']);
            if($supplier) {
                $this->jsonResponse([
                    'success' => true,
                    'message' => 'Supplier created successfully'
                ], 201);
            } else {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Failed to create supplier'
                ], 500);
            }
        }catch (\Exception $e){
            $this->jsonResponse(['error' => 'Failed to create supplier: ' . $e->getMessage()], 500);
        }
    }

    public function update(int $id) :void
    {
        $data = $this->getJsonInput();

        $currentSupplier = SupplierModel::getById($id);

        if (!$currentSupplier) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Supplier not found'
            ], 404);
        }

        $cnpj = $data['cnpj'] ?? $currentSupplier['cnpj'];
        $companyName = $data['company_name'] ?? $currentSupplier['company_name'];
        $email = $data['email'] ?? $currentSupplier['email'];
        $phone = $data['phone'] ?? $currentSupplier['phone'];
        $status = $data['status'] ?? $currentSupplier['status'];

        $this->validateData($cnpj, $email, $status);

        try {
            $updated = SupplierModel::update($id, $cnpj, $companyName, $email, $phone, $status);
            if(!$updated){
                $this->jsonResponse([
                    'success'  => false,
                    'message' => 'Failed to update supplier'
                ]);
            }

            $this->jsonResponse([
                'success' => true,
                'message' => 'Supplier updated successfully'
            ]);
        } catch (\Exception $e) {
            $this->jsonResponse([
                'success' => false,
                'message' => 'Error updating supplier: ' . $e->getMessage()
            ], 500);
        }
    }

    private function validateData(?string $cnpj = null, ?string $email = null, ?string $status = null): void
    {
        if ($cnpj !== null && strlen($cnpj) !== 18) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Invalid CNPJ format.'
            ], 400);
        }

        if ($email !== null && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Invalid email format'
            ], 400);
        }

        if ($status !== null && !in_array($status, ['active', 'inactive'])) {
            $this->jsonResponse([
                'success' => false,
                'error' => 'Status must be either active or inactive'
            ], 400);
        }

        if ($cnpj !== null || $email !== null) {
            if (SupplierModel::exists($cnpj, $email)) {
                $this->jsonResponse([
                    'success' => false,
                    'error' => 'Supplier already exists'
                ], 409);
            }
        }
    }

}