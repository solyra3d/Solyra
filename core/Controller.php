<?php
/**
 * SOLYRA - Base Controller
 * Controller base com renderização de views, redirects e flash messages
 */

class Controller
{
    protected string $layout = 'main';

    /**
     * Renderizar view com layout
     */
    protected function view(string $view, array $data = [], ?string $layout = null): void
    {
        $layout = $layout ?? $this->layout;

        // Extrair dados para a view
        extract($data);

        // Capturar conteúdo da view
        ob_start();
        $viewFile = ROOT_PATH . '/app/Views/' . str_replace('.', '/', $view) . '.php';
        
        if (!file_exists($viewFile)) {
            throw new \Exception("View não encontrada: {$view}");
        }
        
        include $viewFile;
        $content = ob_get_clean();

        // Renderizar dentro do layout
        $layoutFile = ROOT_PATH . '/app/Views/layouts/' . $layout . '.php';
        
        if (file_exists($layoutFile)) {
            include $layoutFile;
        } else {
            echo $content;
        }
    }

    /**
     * Renderizar view sem layout (parcial)
     */
    protected function partial(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = ROOT_PATH . '/app/Views/' . str_replace('.', '/', $view) . '.php';
        
        if (file_exists($viewFile)) {
            include $viewFile;
        }
    }

    /**
     * Retornar JSON
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Validar CSRF Token
     */
    protected function validateCsrf(): void
    {
        $token = $_POST['_csrf_token'] ?? null;
        
        if (!Session::validateCsrfToken($token)) {
            http_response_code(403);
            die('Token de segurança inválido. Recarregue a página.');
        }
    }

    /**
     * Sanitizar input string
     */
    protected function sanitize(string $input): string
    {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Obter input POST sanitizado
     */
    protected function input(string $key, mixed $default = ''): mixed
    {
        $value = $_POST[$key] ?? $default;
        
        if (is_string($value)) {
            return trim($value);
        }
        
        return $value;
    }

    /**
     * Obter input GET sanitizado
     */
    protected function query(string $key, mixed $default = ''): mixed
    {
        $value = $_GET[$key] ?? $default;
        
        if (is_string($value)) {
            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
        }
        
        return $value;
    }

    /**
     * Obter configuração do site
     */
    protected function getSetting(string $key, string $default = ''): string
    {
        static $settings = null;

        if ($settings === null) {
            $rows = Database::fetchAll("SELECT setting_key, setting_value FROM settings");
            $settings = [];
            foreach ($rows as $row) {
                $settings[$row['setting_key']] = $row['setting_value'];
            }
        }

        return $settings[$key] ?? $default;
    }
}
