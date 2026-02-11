<?php

namespace App\Core;

class View
{

    public static function render(string $viewPath, array $data = []): string
    {

        $file = dirname(__DIR__, 2) . "/views/{$viewPath}.php";

        if (!file_exists($file)) {
            return "Erro: View não encontrada em: " . $file;
        }
        ob_start();

        require $file;

        return ob_get_clean();
    }
}