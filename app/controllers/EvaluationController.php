<?php

namespace app\controllers;
use app\models\EvaluationModel;
use Exception;
use Flight;

class EvaluationController {
    
    public function __construct() {
        
    }
    public function evaluate(){
        $id_client = Flight::request()->data->id_client;
        $id_agent = Flight::request()->data->id_agent;
        $note = Flight::request()->data->note;
        $commentaire = Flight::request()->data->commentaire;

        if (empty($id_client) || empty($id_agent) || empty($note)) {
            Flight::json(['error' => 'Tous les champs sont obligatoires'], 400);
            return;
        }

        try {
            $evaluationModel = new EvaluationModel(Flight::db());
            $result = $evaluationModel->evaluate($id_client, $id_agent, $note, $commentaire);

            if ($result) {
                Flight::json(['success' => 'Évaluation enregistrée avec succès']);
            } else {
                Flight::json(['error' => 'Échec de l\'enregistrement de l\'évaluation'], 500);
            }
        } catch (Exception $e) {
            Flight::json(['error' => 'Erreur lors de l\'enregistrement de l\'évaluation: ' . $e->getMessage()], 500);
        }
    }
    
    
    
       
}
