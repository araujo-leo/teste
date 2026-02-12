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

    public static function getById(int $id) :array
    {
        $pdo = Database::getConnection();
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
    public static function create(int $code,string $name,string $description,float $price,string $status) :bool
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
    
    
}