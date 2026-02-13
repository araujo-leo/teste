<?php

namespace App\Model;

use App\Config\Database;

class SupplierModel
{
    public static function getAll() :?array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM suppliers";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getById(int $id): ?array
    {
        $pdo = Database::getConnection();

        $sql = "SELECT * FROM suppliers WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public static function create(string $cnpj, string $name, string $email, string $phone, string $status) :bool
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

    public static function update(int $id,string $cnpj,string $companyName,string $email,string $phone,string $status) :bool
    {
        $pdo = Database::getConnection();
        $sql = "UPDATE suppliers SET cnpj = :cnpj, company_name = :companyName, email = :email, phone = :phone, status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cnpj', $cnpj);
        $stmt->bindValue(':companyName', $companyName);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':phone', $phone);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function exists(?string $cnpj = null, ?string $email = null): bool
    {
        $pdo = Database::getConnection();

        $conditions = [];
        $params = [];

        if ($cnpj !== null) {
            $conditions[] = 'cnpj = :cnpj';
            $params[':cnpj'] = $cnpj;
        }

        if ($email !== null) {
            $conditions[] = 'email = :email';
            $params[':email'] = $email;
        }

        if (empty($conditions)) {
            return false;
        }

        $sql = "SELECT 1 FROM suppliers WHERE " . implode(' OR ', $conditions) . " LIMIT 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return (bool) $stmt->fetchColumn();
    }
}