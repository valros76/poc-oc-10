<?php
namespace Utils;

class Response {
    public static function json(array|object $data, int $status = 200): void {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);

        // En production, on stoppe l'exécution pour éviter les fuites de buffer.
        // En test unitaire, on évite le exit pour ne pas couper Xdebug.
        $isTesting = isset($_ENV['PHPUNIT_RUNNING']) || getenv('PHPUNIT_RUNNING') === '1';
        
        if (!$isTesting) {
            exit;
        }
    }
}