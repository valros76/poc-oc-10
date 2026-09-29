<?php
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use Models\Prospect;
use PDO;

class ProspectModelTest extends TestCase {
    private PDO $pdo;
    private Prospect $prospectModel;

    protected function setUp(): void {
        // Connexion BDD de test en mémoire (ou paramètres .env.test)
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        
        // Création du schéma SQLite temporaire
        $this->pdo->exec("
            CREATE TABLE prospect (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nom_etablissement VARCHAR(255) NOT NULL,
                type_hebergement VARCHAR(100),
                url_actuelle VARCHAR(255),
                email VARCHAR(255) NOT NULL
            )
        ");

        $this->prospectModel = new Prospect($this->pdo);
    }

    public function testCreateProspectReturnsLastInsertId(): void {
        $id = $this->prospectModel->create(
            "Gîte du Moulin",
            "contact@moulin.fr",
            "https://moulin.fr",
            "Gîte"
        );

        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);
    }

    public function testFindByEmailReturnsCorrectData(): void {
        $email = "test@domaine.fr";
        $this->prospectModel->create("Chambre Hôte", $email, null, "Chambre d'hôtes");

        $prospect = $this->prospectModel->findByEmail($email);

        $this->assertIsArray($prospect);
        $this->assertEquals("Chambre Hôte", $prospect['nom_etablissement']);
        $this->assertEquals($email, $prospect['email']);
    }

    public function testFindByEmailReturnsNullIfNotFound(): void {
        $prospect = $this->prospectModel->findByEmail("inconnu@domaine.fr");
        $this->assertNull($prospect);
    }
}