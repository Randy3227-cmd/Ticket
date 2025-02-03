<?php

namespace app\models;

use Flight;

class FormulaireModel{

    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    private function addRandomElements($sourceArray, $limit) {
        $limit = min($limit, count($sourceArray));
        shuffle($sourceArray);
        $selectedElements = array_slice($sourceArray, 0, $limit);
        return $selectedElements;
    }

    public function cadeauRandom($nombreFille, $nombreGarcon, $neutre) {
        try {
            $query = "SELECT noel_cadeau.*, noel_categorie.typeCategorie FROM noel_cadeau JOIN noel_categorie ON noel_cadeau.idCategorie = noel_categorie.idCategorie WHERE noel_cadeau.idCategorie = ?";
        
            $stmtFille = $this->db->fetchAll($query, [ 1 ]);
            $stmtGarcon = $this->db->fetchAll($query, [ 2 ]);
            $stmtNeutre = $this->db->fetchAll($query, [ 3 ]);
        
            if(count($stmtFille) >= $nombreFille) {
                $cadeauxFilles = $this->addRandomElements($stmtFille, $nombreFille);
            } else {
                throw new Exception("Not enough gifts for girls");
            }
    
            if(count($stmtGarcon) >= $nombreGarcon) {
                $cadeauxGarcons = $this->addRandomElements($stmtGarcon, $nombreGarcon);
            } else {
                throw new Exception("Not enough gifts for boys");
            }
    
            if(count($stmtNeutre) >= $neutre) {
                $cadeauxNeutres = $this->addRandomElements($stmtNeutre, $neutre);
            } else {
                throw new Exception("Not enough neutral gifts");
            }
    
            return [
                0 => $cadeauxFilles,
                1 => $cadeauxGarcons,
                2 => $cadeauxNeutres
            ];
        
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    
}

?>