<?php

namespace app\controllers;

use app\models\AlimentationModel;
use app\models\ArgentModel;
use Exception;
use Flight;

class AlimentationController {

    public function __construct() {
        
    }

    public function listAlimentations() {
        $alimentModel = new AlimentationModel(Flight::db());
        $alimentations = $alimentModel->getAll(); // Récupération des aliments
    
        if (!$alimentations) {
            $alimentations = []; 
        }
    
        Flight::render('listAlimentation', ['alimentations' => $alimentations]);
    }
    


    public function afficherAchats() {
        $achatModel = new AlimentationModel(Flight::db());
        $achats = $achatModel->getAchats();
    
        Flight::render('alimentationAcheter', ['achats' => $achats]);
    }
    

    public function afficherFormulaireAchat() {
        $alimentModel = new AlimentationModel(Flight::db());
    
        $idAlimentation = Flight::request()->query['idAlimentation'] ?? null;
    
        if (!$idAlimentation || !is_numeric($idAlimentation)) {
            Flight::redirect(BASE_URL . '/listAlimentation'); 
            exit;
        }
    
        $aliment = $alimentModel->getAlimentationById($idAlimentation);
    
        if (!$aliment) {
            Flight::redirect(BASE_URL . '/listAlimentation'); 
            exit;
        }
    
        error_log('Aliment récupéré : ' . print_r($aliment, true));
    
        Flight::render('achatAlimentationFormulaire', ['aliment' => $aliment]);
    }
    

    public function validerAchat() {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $idAlimentation = intval($_GET['idAlimentation']);
            $quantite = intval($_GET['quantite']);
    
            $alimentModel = new AlimentationModel(Flight::db());
            $capitalModel = new ArgentModel(Flight::db());
    
            $aliment = $alimentModel->getAlimentationById($idAlimentation);
            
            if (!$aliment) {
                Flight::redirect(BASE_URL . '/listAlimentation');
                exit;
            }
    
            $prixTotal = $aliment['prix'] * $quantite;
    
            $capitalDisponible = $capitalModel->getMontant();
    
           
    
            if ($capitalDisponible < $prixTotal) {
                $montantManquant = $prixTotal - $capitalDisponible;
                Flight::render('erreurFond', [
                    'message' => 'Fonds insuffisants',
                    'montantManquant' => $montantManquant,
                    'aliment' => $aliment, 
                    'quantite' => $quantite
                ]);
                return; // Arrêter l'exécution
            }
            
            try {
                $capitalModel->deduireMontant($prixTotal);
                
                $dateAchat = date('Y-m-d H:i:s');
                $alimentModel->acheterAliment($idAlimentation, $quantite, $dateAchat);
                
    
                 Flight::redirect(BASE_URL .'/alimentationAcheter');
            } catch (Exception $e) {
                Flight::render('erreurFond', [
                    'message' => 'Erreur lors de l\'achat : ' . $e->getMessage()
                ]);
            }
        }
    }
}

    
