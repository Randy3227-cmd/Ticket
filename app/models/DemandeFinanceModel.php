<?php

namespace app\models;

use Exception;

class DemandeFinanceModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($dateDemande, $dateAcceptation, $argentManque) {
        try {
            $query = "INSERT INTO demandeFinance (dateDemande, dateAcceptation, argentManque) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$dateDemande, $dateAcceptation, $argentManque]);
        } catch (Exception $e) {
            error_log("Erreur lors de la création de la catégorie : " . $e->getMessage());
            return false;
        }
    }

    public function findAll() {
        $query = "SELECT * FROM demandeFinance where dateAcceptation is null";
        return $this->db->fetchAll($query);
    }
    public function accept($id) {
        try {
            $query = "UPDATE demandeFinance SET dateAcceptation = NOW() WHERE idDemandeFinance = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            error_log("Erreur lors de l'acceptation de la demande : " . $e->getMessage());
            return false;
        }
    }
    public function refuser($id) {
        try {
            $query = "DELETE FROM demandeFinance WHERE idDemandeFinance = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id]);
        } catch (Exception $e) {
            error_log("Erreur lors de l'acceptation de la demande : " . $e->getMessage());
            return false;
        }
    }
    public function getById($id) {
        $query = "SELECT * FROM demandeFinance WHERE idDemandeFinance = ?";
        return $this->db->fetchAll($query, [$id])[0];
    }
}
