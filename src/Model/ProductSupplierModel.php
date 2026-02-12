<?php

namespace App\Model;

use App\Config\Database;

class ProductSupplierModel
{
    public static function create(int $productId, int $supplierId): bool
    {
        $pdo = Database::getConnection();

        $sql = "INSERT INTO supplier_products (product_id, supplier_id) VALUES (:product_id, :supplier_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':product_id', $productId, \PDO::PARAM_INT);
        $stmt->bindValue(':supplier_id', $supplierId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function exists(int $productId, int $supplierId): bool
    {
        $pdo = Database::getConnection();
        $sql = "SELECT COUNT(*) FROM supplier_products WHERE product_id = :product_id AND supplier_id = :supplier_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':product_id', $productId, \PDO::PARAM_INT);
        $stmt->bindValue(':supplier_id', $supplierId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }
    public static function getSuppliersByProduct(int $productId): array
    {
        $pdo = Database::getConnection();
        $sql = "
            SELECT 
                s.id,
                s.cnpj,
                s.company_name,
                s.email,
                s.phone,
                s.status,
                sp.id as link_id,
                sp.created_at as linked_at
            FROM suppliers s
            INNER JOIN supplier_products sp ON s.id = sp.supplier_id
            WHERE sp.product_id = :product_id
            ORDER BY s.company_name ASC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':product_id', $productId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getProductsBySupplier(int $supplierId): array
    {
        $pdo = Database::getConnection();
        $sql = "
            SELECT 
                p.id,
                p.internal_code,
                p.name,
                p.description,
                p.price,
                p.status,
                sp.id as link_id,
                sp.created_at as linked_at
            FROM products p
            INNER JOIN supplier_products sp ON p.id = sp.product_id
            WHERE sp.supplier_id = :supplier_id
            ORDER BY p.name ASC
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':supplier_id', $supplierId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function delete(int $productId, int $supplierId): bool
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM supplier_products WHERE product_id = :product_id AND supplier_id = :supplier_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':product_id', $productId, \PDO::PARAM_INT);
        $stmt->bindValue(':supplier_id', $supplierId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function deleteById(int $linkId): bool
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM supplier_products WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $linkId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function deleteAllByProduct(int $productId): bool
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM supplier_products WHERE product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':product_id', $productId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function deleteAllBySupplier(int $supplierId): bool
    {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM supplier_products WHERE supplier_id = :supplier_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':supplier_id', $supplierId, \PDO::PARAM_INT);

        return $stmt->execute();
    }

    public static function countSuppliersByProduct(int $productId): int
    {
        $pdo = Database::getConnection();
        $sql = "SELECT COUNT(*) FROM supplier_products WHERE product_id = :product_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':product_id', $productId, \PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }

    public static function countProductsBySupplier(int $supplierId): int
    {
        $pdo = Database::getConnection();
        $sql = "SELECT COUNT(*) FROM supplier_products WHERE supplier_id = :supplier_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':supplier_id', $supplierId, \PDO::PARAM_INT);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}
