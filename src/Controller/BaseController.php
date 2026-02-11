<?php

namespace App\Controller;

use App\Model\Log;

class BaseController
{
    protected function getJsonInput() : array
    {
        $input = file_get_contents('php://input');
        return json_decode($input, true) ?? [];
    }
    protected function jsonResponse(array $data, int $statusCode = 200) : void
    {
        $endTime = microtime(true);
        $duration = round(($endTime - START_TIME) * 1000, 2);

        $level = $statusCode >= 400 ? 'ERROR' : 'INFO';

        $endpoint = $_SERVER['REQUEST_URI'];

        Log::save($level, "{$endpoint}", $duration);

        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}