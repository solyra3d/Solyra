<?php
/**
 * SOLYRA - Front Controller
 * Todas as requisições passam por aqui
 */

// Charset global
header('Content-Type: text/html; charset=UTF-8');
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');

// Define o diretório raiz do projeto
define('ROOT_PATH', dirname(__DIR__));

// Autoload simples
spl_autoload_register(function ($class) {
    $paths = [
        ROOT_PATH . '/core/',
        ROOT_PATH . '/app/Controllers/',
        ROOT_PATH . '/app/Controllers/Admin/',
        ROOT_PATH . '/app/Models/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Carregar configurações
$config = require ROOT_PATH . '/config/app.php';
$dbConfig = require ROOT_PATH . '/config/database.php';

// Carregar helpers
require_once ROOT_PATH . '/app/Helpers/helpers.php';
require_once ROOT_PATH . '/app/Helpers/seo.php';

// Iniciar sessão
Session::start();

// Inicializar banco de dados
Database::init($dbConfig);

// Carregar e executar rotas
$router = new Router();
require ROOT_PATH . '/config/routes.php';
$router->dispatch();
