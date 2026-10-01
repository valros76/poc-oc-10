<?php
namespace Models;

use PDO;
use PDOStatement;

class Formule {
    private PDO $db;
    private string $logFile;

    public function __construct(PDO $db) {
        $this->db = $db;
        $this->logFile = __DIR__ . '/../logs/app.log';
    }

    private function logError(string $context, PDOStatement|PDO $source): void {
        $errorInfo = json_encode($source->errorInfo());
        $message = sprintf("[%s] [SQL ERROR] [%s] %s\n", date('Y-m-d H:i:s'), $context, $errorInfo);
        error_log($message, 3, $this->logFile);
    }

    public function findById(int $id): ?array {
        $sql = "SELECT id, nom, description FROM formules WHERE id = :id";
        $req = $this->db->prepare($sql);

        if (!$req) {
            $this->logError('Formule::findById (prepare)', $this->db);
            return null;
        }

        $req->bindValue(':id', $id, PDO::PARAM_INT);

        if (!$req->execute()) {
            $this->logError('Formule::findById (execute)', $req);
            return null;
        }

        $result = $req->fetch();
        return $result ?: null;
    }

    public function findAll(): array {
        $sql = "SELECT id, nom, description FROM formules";
        $req = $this->db->prepare($sql);

        if (!$req) {
            $this->logError('Formule::findAll (prepare)', $this->db);
            return [];
        }

        if (!$req->execute()) {
            $this->logError('Formule::findAll (execute)', $req);
            return [];
        }

        return $req->fetchAll() ?: [];
    }
}