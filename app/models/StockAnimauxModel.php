<?php
namespace app\models;

use Flight;

class StockAnimauxModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function reduireStockAnimaux($idAnimaux) {
        try {
            $query = $this->db->prepare("DELETE FROM StockAnimaux WHERE idAnimaux = :idAnimaux LIMIT 1");
            $query->execute([':idAnimaux' => $idAnimaux]);
            return $query->rowCount() > 0;
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la réduction du stock : " . $e->getMessage());
        }
    }

    public function compterStockAnimaux($idAnimaux) {
        try {
            $query = $this->db->prepare("SELECT COUNT(*) as stock FROM StockAnimaux WHERE idAnimaux = :idAnimaux");
            $query->execute([':idAnimaux' => $idAnimaux]);
            $result = $query->fetch();
            return $result['stock'];
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors du comptage du stock : " . $e->getMessage());
        }
    }
}