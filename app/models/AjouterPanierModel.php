<?php

namespace app\models;

use Flight;

class AjouterPanierModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function checkAchat($prix, $id) {
        $query = "SELECT * FROM noel_utilisateur WHERE idUtilisateur = ?";
        $stmt = $this->db->fetchAll($query, [$id]);
        $reponse = array();
        $argentActuel = $stmt[0]['argent'];
    
        if ($argentActuel < $prix) {

            $argentNeccessaire = abs($argentActuel - $prix);
            array_push($reponse, "<p style='color: red;'>Votre solde est insuffisant (".$argentActuel."€)</p>");
            array_push($reponse, $argentNeccessaire);
            return $reponse;
        } else {
            $nouveauSolde = $argentActuel - $prix;
    
            $updateArgent = "UPDATE noel_utilisateur SET argent = :nouveauSolde WHERE idUtilisateur = :id";
            $stmt = $this->db->prepare($updateArgent);
            $stmt->execute([
                ':nouveauSolde' => $nouveauSolde,
                ':id' => $id
            ]);
            array_push($reponse, "<p>Achat réussi, solde restant : ".$nouveauSolde." €</p>");
            array_push($reponse, $nouveauSolde);
            return $reponse;
        }
    }
    
    
    
}

?>