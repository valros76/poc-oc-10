<?php
namespace Models;

use PDO;
use PDOStatement;

class Prospect {
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

    public function create(string $nomEtablissement, string $email, ?string $urlActuelle = null, ?string $typeHebergement = null): ?int {
        $sql = "INSERT INTO prospect (nom_etablissement, type_hebergement, url_actuelle, email) 
                VALUES (:nom, :type, :url, :email)";
        
        $req = $this->db->prepare($sql);
        if (!$req) {
            $this->logError('Prospect::create (prepare)', $this->db);
            return null;
        }

        $req->bindValue(':nom', $nomEtablissement, PDO::PARAM_STR);
        
        if ($typeHebergement !== null) {
            $req->bindValue(':type', $typeHebergement, PDO::PARAM_STR);
        } else {
            $req->bindValue(':type', null, PDO::PARAM_NULL);
        }

        if ($urlActuelle !== null) {
            $req->bindValue(':url', $urlActuelle, PDO::PARAM_STR);
        } else {
            $req->bindValue(':url', null, PDO::PARAM_NULL);
        }

        $req->bindValue(':email', $email, PDO::PARAM_STR);

        if (!$req->execute()) {
            $this->logError('Prospect::create (execute)', $req);
            return null;
        }

        return (int) $this->db->lastInsertId();
    }

    public function findByEmail(string $email): ?array {
        $sql = "SELECT id, nom_etablissement, type_hebergement, url_actuelle, email FROM prospect WHERE email = :email";
        $req = $this->db->prepare($sql);

        if (!$req) {
            $this->logError('Prospect::findByEmail (prepare)', $this->db);
            return null;
        }

        $req->bindValue(':email', $email, PDO::PARAM_STR);

        if (!$req->execute()) {
            $this->logError('Prospect::findByEmail (execute)', $req);
            return null;
        }

        $result = $req->fetch();
        return $result ?: null;
    }
}