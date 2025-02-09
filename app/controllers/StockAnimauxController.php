<?php
namespace app\controllers;

session_start();
use app\models\StockAnimauxModel;
use app\models\ListerAnimauxModel;
use app\models\AcheterAnimauxModel;
use app\models\SituationModel;

use DateTime;

use Flight;

class StockAnimauxController {
    public function getStock() {
        try {
            $stockModel = new StockAnimauxModel(Flight::db());
            $animauxModel = new ListerAnimauxModel(Flight::db());

            $animaux = $animauxModel->getAllAnimaux();

            $stockAnimaux = [];
            foreach ($animaux as $animal) {
                $stock = $stockModel->compterStockAnimaux($animal['idAnimaux']);
                $animal['stock'] = $stock;
                $stockAnimaux[] = $animal;
            }

            Flight::render('stock', ['stockAnimaux' => $stockAnimaux]);
        } catch (\Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    private function getPoidActuel($idAnimaux){
        $listAnimaux = new ListerAnimauxModel(Flight::db());
        $situationModel = new SituationModel(Flight::db());
        $dateReference = '2025-02-03'; 
        
        $dateToday = date('Y-m-d'); 
        
        $date1 = new DateTime($dateReference);
        $date2 = new DateTime($dateToday);
        $daysDifference = $date2->diff($date1)->days; 
    
        $poidsInitial = $listAnimaux->poidsInitial($idAnimaux);
        $poidsMin = $listAnimaux->poidsMinimum($idAnimaux);
        $poidsMax = $listAnimaux->poidsMaximum($idAnimaux);
        $pourcentageGain = $situationModel->getPourcentageGainAnimaux($idAnimaux);
        $pourcentagePerte = $listAnimaux->pourcentagePertePoids($idAnimaux);
        $stock = $situationModel->getStockAliment($idAnimaux);
        
        $actualPoids = $poidsInitial;
        
        for ($i = 0; $i < $daysDifference; $i++) { 
            if ($stock > 0) {
                $actualPoids += $poidsInitial * $pourcentageGain;
                $stock--;
            } else {
                $actualPoids -= $poidsInitial * $pourcentagePerte;
            }
    
            if ($actualPoids <= $poidsMin) {
                $actualPoids = $poidsMin;
                break;
            } elseif ($actualPoids >= $poidsMax) {
                $actualPoids = $poidsMax;
                break;
            }
        }
        return $actualPoids;
    }
    

    public function acheterAnimal() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idAnimaux = filter_input(INPUT_POST, 'idAnimaux', FILTER_VALIDATE_INT);
            $prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT);
            $prix *= $this->getPoidActuel($idAnimaux);
    
            if (!$idAnimaux || !$prix) {
                Flight::json(['error' => 'Données invalides'], 400);
                return;
            }
    
            try {
                $stockModel = new StockAnimauxModel(Flight::db());
                $achatModel = new AcheterAnimauxModel(Flight::db());
    
                $stock = $stockModel->compterStockAnimaux($idAnimaux);
                if ($stock <= 0) {
                    Flight::json(['error' => 'Stock épuisé'], 400);
                    return;
                } //fafana
    
                if (!$achatModel->verifierCapitalSuffisant($prix)) {
                    Flight::json(['error' => 'Capital insuffisant'], 400);
                    return;
                }
    
                $stockModel->reduireStockAnimaux($idAnimaux); //fafan
                $achatModel->reduireCapital($prix);
                $idAchat = $achatModel->ajouterAchatAnimaux($idAnimaux);
    
                Flight::redirect(BASE_URL .'/achetes'); 
            } catch (\Exception $e) {
                Flight::redirect('/stock?error=' . urlencode($e->getMessage()));
            }
        } else {
            Flight::json(['error' => 'Méthode non autorisée'], 405);
        }
    }

    public function vendreAnimal() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $idAnimauxAchete = filter_input(INPUT_POST, 'idAnimaux', FILTER_VALIDATE_INT);
            $prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT);

                        if (!$idAnimauxAchete || !$prix) {
                Flight::json(['error' => 'Données invalides', 'id' => $idAnimauxAchete, 'prix' => $prix], 400);
                return;
            }

            try {
                $achatModel = new AcheterAnimauxModel(Flight::db());
                
               
                $query = Flight::db()->prepare("
                    SELECT aa.idAnimaux, a.prixVenteParKg 
                    FROM animauxAchete aa
                    JOIN Animaux a ON aa.idAnimaux = a.idAnimaux
                    WHERE aa.idAnimauxAchete = :idAnimauxAchete
                ");
                $query->execute([':idAnimauxAchete' => $idAnimauxAchete]);
                $animalInfo = $query->fetch();

                if (!$animalInfo) {
                    Flight::json(['error' => 'Animal non trouvé'], 404);
                    return;
                }

                
                $poidsActuel = $this->getPoidActuel($animalInfo['idAnimaux']);
                $montantVente = $poidsActuel * $animalInfo['prixVenteParKg'];

                
                $achatModel->ajouterCapital($montantVente);
                $achatModel->suppressionAchat($idAnimauxAchete);

                Flight::redirect(BASE_URL . '/achetes');
            } catch (\Exception $e) {
                Flight::json(['error' => $e->getMessage()], 500);
            }
        } else {
            Flight::json(['error' => 'Méthode non autorisée'], 405);
        }

    }
    
    
}