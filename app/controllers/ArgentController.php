<?php

namespace app\controllers;

use app\models\ArgentModel;
use Exception;
use Flight;

class ArgentController {

    public function __construct() {
       
    }

public function showMontant() {
    $argentModel = new ArgentModel(Flight::db());

    $montant = $argentModel->getMontant();

    $data = [
        'montant' => $montant, 
        'message' => $montant ? 'Montant récupéré avec succès.' : 'Aucun montant trouvé.'
    ];

    Flight::render('argent', $data);
}


    public function afficherFormulaire() {
        Flight::render('depotArgent');
    }

    public function depotArgent() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $valeur = intval($_POST['valeur']);
            
            try {
                $capitalModel = new ArgentModel(Flight::db());
                
                $capitalModel->addCapital($valeur);
                
                Flight::redirect(BASE_URL . '/listAlimentation');
            } catch (Exception $e) {
                Flight::render('erreur', [
                    'message' => 'Erreur lors du dépôt : ' . $e->getMessage()
                ]);
            }
        } else {
            Flight::render('/depotArgent');
        }
    }
}