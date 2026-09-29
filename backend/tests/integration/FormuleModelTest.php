<?php
namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use Models\Formule;
use PDO;

class FormuleModelTest extends TestCase {
    private PDO $pdo;
    private Formule $formuleModel;

    protected function setUp(): void {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
        
        $this->pdo->exec("
            CREATE TABLE formule (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nom VARCHAR(100) NOT NULL,
                description TEXT
            )
        ");

        $this->pdo->exec("
            INSERT INTO formule (id, nom, description) VALUES 
            (1, 'Essentiel', 'Description Essentiel'),
            (2, 'Réservation directe', 'Description Réservation')
        ");

        $this->formuleModel = new Formule($this->pdo);
    }

    public function testFindByIdReturnsExistingFormule(): void {
        $formule = $this->formuleModel->findById(1);

        $this->assertIsArray($formule);
        $this->assertEquals('Essentiel', $formule['nom']);
    }

    public function testFindByIdReturnsNullForUnknownId(): void {
        $formule = $this->formuleModel->findById(99);

        $this->assertNull($formule);
    }

    public function testFindAllReturnsAllRecords(): void {
        $formules = $this->formuleModel->findAll();

        $this->assertCount(2, $formules);
        $this->assertEquals('Essentiel', $formules[0]['nom']);
        $this->assertEquals('Réservation directe', $formules[1]['nom']);
    }
}