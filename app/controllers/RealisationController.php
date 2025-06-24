<?php

namespace app\controllers;
use app\models\RealisationModel;
use app\models\PrevisionModel;
use app\models\DemandeFinanceModel;

use Exception;
use Flight;

class RealisationController {
    
    public function __construct() {
        
    }
    public function ajouter_realisation() {
        header('Content-Type: application/json');
        
        $data = Flight::request()->data;
        $montant = $data['montant'] ?? null;
        $date = date('Y-m-d');
    
        $realisationModel = new RealisationModel(Flight::db());
        $previsionModel = new PrevisionModel(Flight::db());
        $demandeFinanceModel = new DemandeFinanceModel(Flight::db());
    
        if (!$montant) {
            echo json_encode(['success' => false, 'error' => 'Données manquantes']);
            return;
        }
    
        try {
            $prevision = $previsionModel->getByDate2($date);
            $montant2 = $prevision['montant'] ?? 0;
    
            if ($montant > $montant2) {
                $demandeFinanceModel->create($date, NULL, $montant - $montant2);
                echo json_encode(['success' => true, 'message' => 'Demande de financement générée.']);
            } else {
                $success = $realisationModel->create($date, $montant, 1, 1, 6);
                if ($success) {
                    echo json_encode(['success' => true, 'message' => 'Réalisation enregistrée.']);
                } else {
                    echo json_encode(['success' => false, 'error' => 'Erreur lors de l’enregistrement.']);
                }
            }
    
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
    
    
       
}
