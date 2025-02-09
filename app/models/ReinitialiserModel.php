<?php

namespace app\models;

use Flight;

class ReinitialiserModel 
{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function reinitialiserProjet() {
        try {
            $query = $this->db->prepare("TRUNCATE TABLE animauxAchete");
            $query->execute();

            $query = $this->db->prepare("TRUNCATE TABLE StockAnimaux");
            $query->execute();

            $query = $this->db->prepare("
                INSERT INTO StockAnimaux (idAnimaux) 
                SELECT idAnimaux 
                FROM Animaux 
                CROSS JOIN (
                    SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION 
                    SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10
                ) AS nb
            ");
            $query->execute();

            // Réinitialiser le capital
            $query = $this->db->prepare("UPDATE Capital SET valeur = 100000");
            $query->execute();

            return true;

        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la réinitialisation : " . $e->getMessage());
        }
    }
}