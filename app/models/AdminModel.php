<?php

namespace app\models;

use Exception;

class AdminModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function authAdmin($nom_agent, $prenom_agent) {
        $query = "SELECT * FROM Agent WHERE nom_agent = ? and prenom_agent = ?";
        $result = $this->db->fetchAll($query, [$nom_agent, $prenom_agent]);
        if(count($result) > 0){
            return TRUE;
        }
        return FALSE;
    }

    public function getAgentByNom($nom_agent, $prenom_agent) {
        $query = "SELECT * FROM Agent WHERE nom_agent = ? AND prenom_agent = ?";
        $result = $this->db->fetchAll($query, [$nom_agent, $prenom_agent]);
        return $result;
    }
    
    
}