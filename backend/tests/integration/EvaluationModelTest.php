<?php
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use Models\Evaluation;
use PDO;

class EvaluationModelTest extends TestCase {
    private PDO $pdo;
    private Evaluation $evaluationModel;
    private int $prospectId;

    protected function setUp(): void {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        
        $this->pdo->exec("
            CREATE TABLE formule (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nom VARCHAR(100) NOT NULL,
                description TEXT
            );
            CREATE TABLE prospect (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nom_etablissement VARCHAR(255) NOT NULL,
                type_hebergement VARCHAR(100),
                url_actuelle VARCHAR(255),
                email VARCHAR(255) NOT NULL
            );
            CREATE TABLE evaluation (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                prospect_id INT NOT NULL,
                score_visibilite INT NOT NULL,
                formule_recommandee_id INT NOT NULL,
                date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
            );
        ");

        $this->pdo->exec("INSERT INTO formule (id, nom, description) VALUES (1, 'Essentiel', 'Desc Essentiel')");
        
        // Laisser SQLite générer l'ID automatiquement et le récupérer
        $this->pdo->exec("INSERT INTO prospect (nom_etablissement, email) VALUES ('Gîte Test', 'test@gite.fr')");
        $this->prospectId = (int) $this->pdo->lastInsertId();

        $this->evaluationModel = new Evaluation($this->pdo);
    }

    public function testCreateEvaluationReturnsLastInsertId(): void {
        $id = $this->evaluationModel->create($this->prospectId, 75, 1);

        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);
    }

    public function testFindByProspectIdReturnsDataWithJoinedFormule(): void {
        $this->evaluationModel->create($this->prospectId, 80, 1);

        $evaluations = $this->evaluationModel->findByProspectId($this->prospectId);

        $this->assertCount(1, $evaluations);
        $this->assertEquals(80, $evaluations[0]['score_visibilite']);
        $this->assertEquals('Essentiel', $evaluations[0]['formule_nom']);
        $this->assertEquals('Desc Essentiel', $evaluations[0]['formule_description']);
    }

    public function testFindByProspectIdReturnsEmptyArrayIfNoMatch(): void {
        $evaluations = $this->evaluationModel->findByProspectId(999);

        $this->assertIsArray($evaluations);
        $this->assertEmpty($evaluations);
    }
}