<?php

namespace App\Controller;

use App\Core\View;
use App\Model\Log;

class ErrorController extends BaseController
{
    private function isAjaxRequest(): bool
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        return strpos($uri, '/api') === 0;
    }

    public function notFound(): string
    {
        if($this->isAjaxRequest()) {
           $this->jsonResponse([
                'success' => false,
                'error'  => 'Resource not found'
           ], 404);
        }
        http_response_code(404);
        return View::render('errors/404');
    }

    public function internalServerError(\Throwable $e): string
    {
        if($this->isAjaxRequest()) {
            $this->jsonResponse([
                'success' => false,
                'error'  => $e ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }

        if ($e) {
            error_log($e->getMessage());
        }

        http_response_code(500);
        return View::render('errors/500', ['error' => $e ? $e->getMessage() : 'Unknown error']);
    }
}