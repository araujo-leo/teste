<?php

namespace App\Controller;

use App\Model\SupplierModel;

class SupplierController extends BaseController
{
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
}