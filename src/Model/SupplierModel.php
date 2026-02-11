<?php

namespace App\Model;

use App\Config\Database;

class SupplierModel
{
    public static function getAll() :array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM suppliers";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public static function create($cnpj, $name, $email, $phone, $status) :bool
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO suppliers (cnpj, company_name, email, phone, status) VALUES (:cnpj, :name, :email, :phone, :status)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cnpj', $cnpj);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':status', $status);

        return $stmt->execute();
    }
}