<?php

namespace app\models;

use Flight;

class SignModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertuser ($user, $password, $money) {
        $query = "INSERT INTO noel_utilisateur (nom, mot_de_passe, argent) VALUES (?, ?, ?)";
        $stmt = $this->db->runQuery($query, [ $user, $password, $money ]);
    }

}

?>