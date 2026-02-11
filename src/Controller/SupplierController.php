<?php

namespace App\Controller;

use App\Model\SupplierModel;

class SupplierController extends BaseController
{
    public function index() :array
    {
        $suppliers = SupplierModel::getAll();
        return $this->jsonResponse([
            'success' => true,
            'data' => $suppliers
        ]);
    }
    public function create() :array
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
}