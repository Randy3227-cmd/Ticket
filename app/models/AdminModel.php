<?php

namespace app\models;

use Flight;

class AdminModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function listDepot() {
            $query = "SELECT * FROM depot_utilisateur";
            $stmt = $this->db->fetchAll($query);
            return $stmt;
        }

    public function insertCadeau($nom, $categorie, $prix) {
        $query = "INSERT INTO noel_cadeau (Cadeau, imageCadeau, idCategorie, prix) VALUES (?, 'test.png', ?, ?)";
        $stmt = $this->db->runQuery($query, [ $nom, $categorie, $prix]);

        return "Ajouter avec succès";
    }

}
?>