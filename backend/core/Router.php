<?php
namespace Core;

use PDO;
use Utils\Response;

class Router {
    private array $routes = [];
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function get(string $path, string $handler): void {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, string $handler): void {
        $this->addRoute('POST', $path, $handler);
    }

    private function addRoute(string $method, string $path, string $handler): void {
        $this->routes[] = [
            'method'  => $method,
            'path'    => $path,
            'handler' => $handler
        ];
    }

    public function dispatch(string $requestMethod, string $requestUri): void {
        $path = parse_url($requestUri, PHP_URL_PATH);

        // Nettoyage optionnel du préfixe de dossier local si présent
        // Adapte '/poc-oc-10/backend' selon ton chemin exact ou rends-le dynamique
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        if ($scriptName !== '/' && str_starts_with($path, $scriptName)) {
            $path = substr($path, strlen($scriptName));
        }
        $path = '/' . trim($path, '/');
        // Pour s'assurer qu'on compare bien avec un slash initial (ex: /api/audit)
        if ($path === '//') $path = '/';

        foreach ($this->routes as $route) {
            // Normalisation du chemin de la route pour comparaison stricte
            $routePath = '/' . trim($route['path'], '/');

            if ($routePath === $path) {
                if ($route['method'] !== $requestMethod) {
                    Response::json(['success' => false, 'error' => 'Méthode non autorisée.'], 405);
                    return;
                }

                [$controllerName, $method] = explode('@', $route['handler']);

                if (class_exists($controllerName)) {
                    $controller = new $controllerName($this->db);
                    if (method_exists($controller, $method)) {
                        $controller->$method();
                        return;
                    }
                }
            }
        }

        Response::json(['success' => false, 'error' => 'Endpoint introuvable.'], 404);
    }
}