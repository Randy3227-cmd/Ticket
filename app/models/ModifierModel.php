<?php

namespace app\models;

use Flight;

class ModifierModel {

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function modifierProduit ($idProducts) {
        $products = array();

        for ($i = 0; $i < count($idProducts); $i++) {
            $products[$i] = self::getProduct($idProducts[$i]);
            $idCategory = self::getProductCategory($idProducts[$i]);
            $newProduct = self::getRandomProduct($idCategory);

            $products[$i] = $newProduct;
        }

        return $products;
    }

    public function getProduct($idProduct) {
        $query = "SELECT * FROM noel_cadeau WHERE idCadeau = ?";
        $stmt = $this->db->fetchAll($query, [ $idProduct ]);

        return $stmt;    
    }

    public function getProductCategory ($idProduct) {
        $query = "SELECT idCategorie FROM noel_cadeau WHERE idCadeau = ?";
        $stmt = $this->db->fetchAll($query, [ $idProduct ]);

        return $stmt[0]['idCategorie'];
    }

    public function getRandomProduct ($idCategory) {

        $query = "SELECT noel_cadeau.*, noel_categorie.typeCategorie FROM noel_cadeau JOIN noel_categorie ON noel_cadeau.idCategorie = noel_categorie.idCategorie WHERE noel_cadeau.idCategorie = ? ORDER BY RAND() LIMIT 1;";
        $stmt = $this->db->fetchAll($query, [ $idCategory ]);

        return $stmt[0];
    }

}