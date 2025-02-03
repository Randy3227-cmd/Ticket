<?php

namespace app\models;

use Flight;

class DepotModel{

    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function getDepot ($idUser){
        $query = "SELECT * FROM depot_utilisateur WHERE idUtilisateur = ?";
        $stmt = $this->db->fetchAll($query, [ $idUser ]);

        return $stmt[0];    
    }

    public function deleteDepot ($idUser){
        $query = "DELETE FROM depot_utilisateur WHERE idUtilisateur = ?";
        $stmt = $this->db->runQuery($query, [ $idUser ]);
    }

    public function insertDepot ($idUser, $argent){
        $query = "INSERT INTO depot_utilisateur (idUtilisateur, argent) VALUES (?, ?)";
        $stmt = $this->db->runQuery($query, [ $idUser, $argent ]);
    }

    public function getUserMoney($idUser){
        $query = "SELECT argent FROM noel_utilisateur WHERE idUtilisateur = ?";
        $stmt = $this->db->fetchAll($query, [ $idUser ]);

        return $stmt[0];    
    }

    public function updateUserMoney($idUser, $argent){
        $query = "UPDATE noel_utilisateur SET argent = ? WHERE idUtilisateur = ?";
        $stmt = $this->db->runQuery($query, [ $argent, $idUser ]);
    }

}