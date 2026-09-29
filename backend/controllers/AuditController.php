<?php
namespace Controllers;

use PDO;
use Models\Prospect;
use Models\Evaluation;
use Models\Formule;
use Utils\Validator;
use Utils\Response;

class AuditController {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function process(): void {
        // 1. Décodage du JSON entrant
        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);

        if (!is_array($input)) {
            Response::json(['success' => false, 'error' => 'Format JSON invalide.'], 400);
        }

        // 2. Détection Anti-Spam (Honeypot)
        if (!empty($input['website_hp'])) {
            // Faux succès retourné au bot sans écriture BDD
            Response::json([
                'success' => true,
                'message' => 'Évaluation générée avec succès.',
                'data'    => [
                    'audit_id'         => 0,
                    'score_visibilite' => 50,
                    'formule'          => ['id' => 1, 'nom' => 'Essentiel', 'description' => '']
                ]
            ], 201);
        }

        // 3. Traitement et assainissement des champs réels
        $nomEtablissement = Validator::sanitizeString($input['nom_etablissement'] ?? null);
        $email            = Validator::sanitizeEmail($input['email'] ?? null);
        $urlActuelle      = Validator::sanitizeUrl($input['url_actuelle'] ?? null);
        $typeHebergement  = Validator::sanitizeString($input['type_hebergement'] ?? 'Gîte');

        if (empty($nomEtablissement) || !$email) {
            Response::json([
                'success' => false, 
                'error'   => 'Veuillez fournir un nom d\'établissement et une adresse email valide.'
            ], 422);
        }

        // 4. Persistence du prospect
        $prospectModel = new Prospect($this->db);
        $prospectId = $prospectModel->create($nomEtablissement, $email, $urlActuelle, $typeHebergement);

        if (!$prospectId) {
            Response::json(['success' => false, 'error' => 'Erreur lors de l\'enregistrement du prospect.'], 500);
        }

        // 5. Calcul de l'évaluation
        $scoreVisibilite = rand(30, 95);
        $formuleId = match (true) {
            $scoreVisibilite < 50 => 1,
            $scoreVisibilite < 75 => 2,
            default               => 3
        };

        // 6. Persistence de l'évaluation
        $evaluationModel = new Evaluation($this->db);
        $evaluationId = $evaluationModel->create($prospectId, $scoreVisibilite, $formuleId);

        if (!$evaluationId) {
            Response::json(['success' => false, 'error' => 'Erreur lors de l\'enregistrement de l\'évaluation.'], 500);
        }

        // 7. Détails de la formule
        $formuleModel = new Formule($this->db);
        $formuleDetails = $formuleModel->findById($formuleId);

        // 8. Réponse JSON unifiée
        Response::json([
            'success' => true,
            'message' => 'Évaluation générée avec succès.',
            'data'    => [
                'audit_id'         => $evaluationId,
                'score_visibilite' => $scoreVisibilite,
                'formule'          => [
                    'id'          => $formuleDetails['id'] ?? $formuleId,
                    'nom'         => $formuleDetails['nom'] ?? '',
                    'description' => $formuleDetails['description'] ?? ''
                ]
            ]
        ], 201);
    }
}