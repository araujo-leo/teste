<?php

namespace App\Model;

use App\Config\Database;
use PDOException;

class Log
{
    public static function save(string $level, string $url, float $time, ?string $method = null, ?int $statusCode = null): bool
    {
        try {
            $pdo = Database::getConnection();

            $method = $method ?? $_SERVER['REQUEST_METHOD'];
            $statusCode = $statusCode ?? http_response_code();

            $sql = "INSERT INTO logs_api (levelLog, requestUrlLog, methodRequestLog, statusCodeLog, responseTime) 
                    VALUES (:level, :url, :method, :status, :time)";

            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':level', $level);
            $stmt->bindValue(':url', $url);
            $stmt->bindValue(':method', $method);
            $stmt->bindValue(':status', $statusCode);
            $stmt->bindValue(':time', $time);

            return $stmt->execute();

        } catch (PDOException $e) {
            error_log("Erro ao salvar log no banco: " . $e->getMessage());
            return false;
        }
    }
}