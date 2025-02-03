<?php 

namespace app\models;

use Flight;

class TousLesProduitsModel{

    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function listeProduit(){
        $query = "SELECT * FROM noel_cadeau";
        $stmt = $this->db->fetchAll($query);
        return $stmt;
    }

    public function produitParCategorie($idCategorie){
        $query = "SELECT * FROM noel_cadeau WHERE idCadeau = ?";
        $stmt = $this->db->fetchAll($query, [$idCategorie]);
        return $stmt;
    }
}
?>