<?php

namespace app\controllers;

use Flight;

use DateTime;

use app\models\SituationModel;
use app\models\ListerAnimauxModel;

class SituationController {

    public function __construct() {
    }


    public function getPoidsActuel() {
        $date = Flight::request()->data->date;
        $idAnimaux = Flight::request()->data->idAnimaux;
        $listAnimaux = new ListerAnimauxModel(Flight::db());
        $situationModel = new SituationModel(Flight::db());
        $dateToday = '2025-02-03'; 
        
        $date1 = new DateTime($date);
        $date2 = new DateTime($dateToday);
        $daysDifference = $date1->diff($date2)->days; 
    
        $poidsInitial = $listAnimaux->poidsInitial($idAnimaux);
        $poidsMin = $listAnimaux->poidsMinimum($idAnimaux);
        $poidsMax = $listAnimaux->poidsMaximum($idAnimaux);
        $pourcentageGain = $situationModel->getPourcentageGainAnimaux($idAnimaux);
        $pourcentagePerte = $listAnimaux->pourcentagePertePoids($idAnimaux);
        $stock = $situationModel->getStockAliment($idAnimaux);

        $nbJourSansMangerAvantMourir = $listAnimaux->getNbJourSansMangerAvantMourir($idAnimaux);
        
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
    
        if ($date) { 
            Flight::json([
                'success' => true, 
                'date' => $date,
                'actualPoids' => $actualPoids,
                'actualPrix' => $actualPoids * $listAnimaux->prixDeVenteKg($idAnimaux),
                'difference' => $daysDifference 
            ]);
        } else {
            Flight::json(['success' => false, 'message' => 'Date invalide']);
        }
    }
    

    public function getAllAnimaux(){
        $animauxAcheteController = new AnimauxAcheteController(Flight::db());
        $listAnimaux = new ListerAnimauxModel(Flight::db());
        $allAnimaux = $animauxAcheteController->recupererAchats();
        $data = ['animaux' => $allAnimaux];
        Flight::render('situation', $data);
    }
    
}

