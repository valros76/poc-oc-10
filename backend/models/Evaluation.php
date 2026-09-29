<?php
namespace Models;

use PDO;
use PDOStatement;

class Evaluation {
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

    public function create(int $prospectId, int $scoreVisibilite, int $formuleRecommandeeId): ?int {
        // Remplacement de NOW() par CURRENT_TIMESTAMP (compatible MariaDB & SQLite)
        $sql = "INSERT INTO evaluation (prospect_id, score_visibilite, formule_recommandee_id, date_creation) 
                VALUES (:prospect_id, :score, :formule_id, CURRENT_TIMESTAMP)";

        $req = $this->db->prepare($sql);
        if (!$req) {
            $this->logError('Evaluation::create (prepare)', $this->db);
            return null;
        }

        $req->bindValue(':prospect_id', $prospectId, PDO::PARAM_INT);
        $req->bindValue(':score', $scoreVisibilite, PDO::PARAM_INT);
        $req->bindValue(':formule_id', $formuleRecommandeeId, PDO::PARAM_INT);

        if (!$req->execute()) {
            $this->logError('Evaluation::create (execute)', $req);
            return null;
        }

        return (int) $this->db->lastInsertId();
    }

    public function findByProspectId(int $prospectId): array {
        $sql = "SELECT e.id, e.score_visibilite, e.date_creation, f.nom AS formule_nom, f.description AS formule_description
                FROM evaluation e
                JOIN formule f ON e.formule_recommandee_id = f.id
                WHERE e.prospect_id = :prospect_id
                ORDER BY e.date_creation DESC";

        $req = $this->db->prepare($sql);
        if (!$req) {
            $this->logError('Evaluation::findByProspectId (prepare)', $this->db);
            return [];
        }

        $req->bindValue(':prospect_id', $prospectId, PDO::PARAM_INT);

        if (!$req->execute()) {
            $this->logError('Evaluation::findByProspectId (execute)', $req);
            return [];
        }

        return $req->fetchAll() ?: [];
    }
}