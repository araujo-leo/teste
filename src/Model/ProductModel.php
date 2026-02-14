<?php

namespace App\Model;

use App\Config\Database;

class ProductModel
{
    public static function getAll() :array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM products";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getById(int $id): ?array
    {
        $pdo = Database::getConnection();

        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $result ?: null;
    }
    public static function create(string $code,string $name,string $description,float $price,string $status) :bool
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO products (internal_code, name, description, price, status) VALUES (:code, :name, :description, :price, :status)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':code', $code);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':status', $status);

        return $stmt->execute();
    }

    public static function update(int $id,string $code,string $name,string $description,float $price,string $status) :bool
    {
        $pdo = Database::getConnection();
        $sql = "UPDATE products SET  internal_code = :code, name = :name, description = :description, price = :price, status = :status WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':code', $code);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':price', $price);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    public static function existsByInternalCode(string $code, ?int $excludeId = null) :bool
    {
        $pdo = Database::getConnection();

        if ($excludeId !== null) {
            $sql = "SELECT COUNT(*) FROM products WHERE internal_code = :code AND id != :excludeId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':code', $code);
            $stmt->bindValue(':excludeId', $excludeId, \PDO::PARAM_INT);
        } else {
            $sql = "SELECT COUNT(*) FROM products WHERE internal_code = :code";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':code', $code);
        }

        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
    
}