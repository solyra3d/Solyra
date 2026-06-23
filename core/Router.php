<?php
/**
 * SOLYRA - Router
 * Sistema de rotas com named routes, middlewares e grupos
 */

class Router
{
    private array $routes = [];
    private array $namedRoutes = [];
    private array $groupMiddleware = [];
    private string $groupPrefix = '';
    private ?string $currentMiddleware = null;

    /**
     * Registrar rota GET
     */
    public function get(string $uri, string $controller, string $action, ?string $name = null): self
    {
        return $this->addRoute('GET', $uri, $controller, $action, $name);
    }

    /**
     * Registrar rota POST
     */
    public function post(string $uri, string $controller, string $action, ?string $name = null): self
    {
        return $this->addRoute('POST', $uri, $controller, $action, $name);
    }

    /**
     * Grupo de rotas com prefixo e middleware
     */
    public function group(string $prefix, ?string $middleware, callable $callback): void
    {
        $previousPrefix = $this->groupPrefix;
        $previousMiddleware = $this->currentMiddleware;

        $this->groupPrefix = $previousPrefix . '/' . trim($prefix, '/');
        $this->currentMiddleware = $middleware;

        call_user_func($callback, $this);

        $this->groupPrefix = $previousPrefix;
        $this->currentMiddleware = $previousMiddleware;
    }

    /**
     * Adicionar rota internamente
     */
    private function addRoute(string $method, string $uri, string $controller, string $action, ?string $name = null): self
    {
        $fullUri = $this->groupPrefix . '/' . trim($uri, '/');
        $fullUri = '/' . trim($fullUri, '/');

        $route = [
            'method' => $method,
            'uri' => $fullUri,
            'controller' => $controller,
            'action' => $action,
            'middleware' => $this->currentMiddleware,
            'pattern' => $this->buildPattern($fullUri),
        ];

        $this->routes[] = $route;

        if ($name) {
            $this->namedRoutes[$name] = $fullUri;
        }

        return $this;
    }

    /**
     * Construir regex pattern para a rota
     */
    private function buildPattern(string $uri): string
    {
        $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[a-zA-Z0-9\-_]+)', $uri);
        return '#^' . $pattern . '$#';
    }

    /**
     * Obter URL por nome da rota
     */
    public static function route(string $name, array $params = []): string
    {
        global $router;
        
        if (!isset($router->namedRoutes[$name])) {
            return '/';
        }

        $uri = $router->namedRoutes[$name];
        
        foreach ($params as $key => $value) {
            $uri = str_replace('{' . $key . '}', $value, $uri);
        }

        return $uri;
    }

    /**
     * Despachar a requisição
     */
    public function dispatch(): void
    {
        $uri = $this->getUri();
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['pattern'], $uri, $matches)) {
                // Executar middleware se existir
                if ($route['middleware']) {
                    $this->executeMiddleware($route['middleware']);
                }

                // Extrair parâmetros nomeados
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Instanciar controller e executar action
                $controllerName = $route['controller'];
                $action = $route['action'];

                if (!class_exists($controllerName)) {
                    $this->renderError(500, 'Controller não encontrado: ' . $controllerName);
                    return;
                }

                $controller = new $controllerName();

                if (!method_exists($controller, $action)) {
                    $this->renderError(500, 'Action não encontrada: ' . $action);
                    return;
                }

                call_user_func_array([$controller, $action], $params);
                return;
            }
        }

        // Nenhuma rota encontrada - 404
        $this->renderError(404);
    }

    /**
     * Executar middleware
     */
    private function executeMiddleware(string $middleware): void
    {
        switch ($middleware) {
            case 'auth':
                if (!Auth::check()) {
                    Session::flash('error', 'Acesso negado. Faça login.');
                    redirect('/admin/login');
                }
                break;
            case 'guest':
                if (Auth::check()) {
                    redirect('/admin');
                }
                break;
        }
    }

    /**
     * Renderizar página de erro
     */
    private function renderError(int $code, string $message = ''): void
    {
        http_response_code($code);

        $errorFile = ROOT_PATH . '/app/Views/errors/' . $code . '.php';
        
        if (file_exists($errorFile)) {
            include $errorFile;
        } else {
            echo "<h1>Erro {$code}</h1>";
            if ($code === 404) {
                echo "<p>Página não encontrada.</p>";
            } elseif ($code === 403) {
                echo "<p>Acesso proibido.</p>";
            } else {
                echo "<p>{$message}</p>";
            }
        }
        exit;
    }

    /**
     * Obter URI limpa
     */
    private function getUri(): string
    {
        $uri = $_GET['url'] ?? '';
        $uri = '/' . trim($uri, '/');
        $uri = filter_var($uri, FILTER_SANITIZE_URL);
        return $uri ?: '/';
    }
}
