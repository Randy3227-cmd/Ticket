<?php
namespace app\controllers;

use app\models\AcheterAnimauxModel;
use Flight;

class AnimauxAcheteController {
    public function getAchats() {
        try {
            $achats = $this->recupererAchats();
            Flight::render('achetes', ['achats' => $achats]);
        } catch (\Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }

    public function recupererAchats() {
        $query = Flight::db()->prepare("
            SELECT aa.idAnimaux, aa.idAnimauxAchete, a.animal, a.imageAnimaux, aa.dateAchat, a.prixVenteParKg, a.poidsMin, a.poidsMax, a.nbJourSansMangerAvantMourir, a.pourcentagePertePoidsParJour, a.poidsInitial
            FROM animauxAchete aa
            JOIN Animaux a ON aa.idAnimaux = a.idAnimaux
            ORDER BY aa.dateAchat DESC
        ");
        $query->execute();
        return $query->fetchAll();
    }
}