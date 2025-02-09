<?php

namespace app\models;

use Flight;

class SituationModel
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAlimenationAnimaux($idAnimaux){
        $query = "SELECT * FROM Alimentation WHERE idAnimaux = ?";
        $stmt = $this->db->fetchAll($query, [$idAnimaux]);
        return $stmt;
    }


    public function getAnimauxAchete() {
        $query = $this->db->prepare("SELECT * FROM animauxAchete");
        $query->execute();
        return $query->fetchAll();
    }

    public function getStockAliment($idAnimaux) {
        $aliment = $this->getAlimenationAnimaux($idAnimaux);
        if (!empty($aliment)) {
            $idAliment = $aliment[0]['idAliment'];
            $query = "SELECT * FROM AchatAlimentation WHERE idAlimentation = ?";
            $stmt = $this->db->fetchAll($query, [$idAliment]);
            if(!empty($stmt)){
                return $stmt[0]['quantite'];
            }else{
                return 0;
            }
        } else {
            return 0; 
        }
    }

    public function getPourcentageGainAnimaux($idAnimaux){

        $aliment = $this->getAlimenationAnimaux($idAnimaux);
        if(!empty($aliment)){
            $pourcentage = $aliment[0]['pourcentageGain'];
        }else{
            return 0;
        }
        return $pourcentage;
    }


}