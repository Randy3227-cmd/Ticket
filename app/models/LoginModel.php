<?php

namespace app\models;

use Flight;

class LoginModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function checkLogin ($utilisateur, $mdp) {

        $query = "SELECT * FROM noel_utilisateur WHERE nom = ?";
        $stmt = $this->db->fetchAll($query, [ $utilisateur ]);

        if (empty($stmt)) { // Vérifiez si le résultat est vide
            return "<p style = 'color : red '>Utilisateur " . $utilisateur . " introuvable";
        } else if (!empty($stmt)) {
            
            if ( $stmt[0]['mot_de_passe'] != $mdp) {
                return " <p style = 'color : red'>Mot de passe pour " . $utilisateur . " incorrecte";
            } 

            return "login successful";
        }

        return "Login failed";
    }

    public function getIdByNom ($utilisateur, $mdp) {
        $result = 0;
        $query = "SELECT * FROM noel_utilisateur WHERE nom = ? and mot_de_passe = ?";
        $stmt = $this->db->fetchAll($query, [ $utilisateur , $mdp]);
        $result = $stmt[0]['idUtilisateur'];
        return $result;
    }

    
}

?>