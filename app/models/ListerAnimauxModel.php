<?php

namespace app\models;

use Flight;

class ListerAnimauxModel 
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllAnimaux() {
        $query = $this->db->prepare("SELECT * FROM Animaux");
        $query->execute();
        return $query->fetchAll();
    }

    public function poidsInitial($idAnimaux){
        $allAnimaux = $this->getAllAnimaux();
        $poidInit = 0;
        for ($i=0; $i < count($allAnimaux); $i++) { 
            if($allAnimaux[$i]['idAnimaux'] == $idAnimaux){
                $poidInit = $allAnimaux[$i]['poidsInitial'];
            }
        }
        return $poidInit;
    }

    public function poidsMinimum($idAnimaux){
        $allAnimaux = $this->getAllAnimaux();
        $poidInit = 0;
        for ($i=0; $i < count($allAnimaux); $i++) { 
            if($allAnimaux[$i]['idAnimaux'] == $idAnimaux){
                $poidInit = $allAnimaux[$i]['poidsMin'];
            }
        }
        return $poidInit;
    }

    public function poidsMaximum($idAnimaux){
        $allAnimaux = $this->getAllAnimaux();
        $poidInit = 0;
        for ($i=0; $i < count($allAnimaux); $i++) { 
            if($allAnimaux[$i]['idAnimaux'] == $idAnimaux){
                $poidInit = $allAnimaux[$i]['poidsMax'];
            }
        }
        return $poidInit;
    }

    public function pourcentagePertePoids($idAnimaux){
        $allAnimaux = $this->getAllAnimaux();
        $poidInit = 0;
        for ($i=0; $i < count($allAnimaux); $i++) { 
            if($allAnimaux[$i]['idAnimaux'] == $idAnimaux){
                $poidInit = $allAnimaux[$i]['pourcentagePertePoidsParJour'];
            }
        }
        return $poidInit;
    }

    public function prixDeVenteKg($idAnimaux){
        $allAnimaux = $this->getAllAnimaux();
        $poidInit = 0;
        for ($i=0; $i < count($allAnimaux); $i++) { 
            if($allAnimaux[$i]['idAnimaux'] == $idAnimaux){
                $poidInit = $allAnimaux[$i]['prixVenteParKg'];
            }
        }
        return $poidInit;
    }

    public function getNbJourSansMangerAvantMourir($idAnimaux){
        $allAnimaux = $this->getAllAnimaux();
        $poidInit = 0;
        for ($i=0; $i < count($allAnimaux); $i++) { 
            if($allAnimaux[$i]['idAnimaux'] == $idAnimaux){
                $poidInit = $allAnimaux[$i]['nbJourSansMangerAvantMourir'];
            }
        }
        return $poidInit;
    }
}