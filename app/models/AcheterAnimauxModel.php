<?php
namespace app\models;

use Flight;

class AcheterAnimauxModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function verifierCapitalSuffisant($montant) {
        try {
            $query = $this->db->prepare("SELECT valeur FROM Capital LIMIT 1");
            $query->execute();
            $capital = $query->fetch();
            
            return $capital['valeur'] >= $montant;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la vérification du capital : " . $e->getMessage());
        }
    }

    public function reduireCapital($montant) {
        try {
            if($this->verifierCapitalSuffisant($montant)){
                $query = $this->db->prepare("UPDATE Capital SET valeur = valeur - :montant");
                $query->execute([':montant' => $montant]);
            }
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la réduction du capital : " . $e->getMessage());
        }
    }

    public function ajouterAchatAnimaux($idAnimaux) {
        try {
            $query = $this->db->prepare("INSERT INTO animauxAchete (idAnimaux, dateAchat) VALUES (:idAnimaux, CURRENT_DATE)");
            $query->execute([':idAnimaux' => $idAnimaux]);
            return $this->db->lastInsertId();
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'enregistrement de l'achat : " . $e->getMessage());
        }
    }

    public function ajouterCapital($montant) {
        try {
            if($this->verifierCapitalSuffisant($montant)){
                $query = $this->db->prepare("UPDATE Capital SET valeur = valeur + :montant");
                $query->execute([':montant' => $montant]);
            }
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de l'augmentation du capital : " . $e->getMessage());
        }
    }

    public function suppressionAchat($idAnimauxAchete) {
        try {
            $query = $this->db->prepare("DELETE FROM animauxAchete WHERE idAnimauxAchete = :idAnimauxAchete");
            $query->execute([':idAnimauxAchete' => $idAnimauxAchete]);
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la suppression de l'achat : " . $e->getMessage());
        }
    } 

}
