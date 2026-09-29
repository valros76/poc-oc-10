<?php
declare(strict_types=1);

// Gestion prioritaire des en-têtes CORS
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    // Ajout explicite de Content-Type et Authorization
    header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 86400");
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit(0);
}

// Maintenant seulement, on charge le reste
require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;
use Core\Router;
use Utils\Response;

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
}

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/config/config.php';

try {
    $router = new Router($pdo);
    require_once __DIR__ . '/routes/api.php';
    
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (\Throwable $e) {
    $isDev = ($_ENV['APP_ENV'] ?? 'production') === 'local';
    
    Response::json([
        'success' => false,
        'error'   => 'Erreur interne du serveur.',
        'details' => $isDev ? $e->getMessage() : null
    ], 500);
}