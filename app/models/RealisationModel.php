<?php

namespace app\models;

use Exception;

class RealisationModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function create($dateRealisation, $montant, $idType, $idRubrique, $idDepartement) {
        try {
            $query = "INSERT INTO Realisation (dateRealisation, montant, idType, idRubrique, idDepartement) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$dateRealisation, $montant, $idType, $idRubrique, $idDepartement]);
        } catch (Exception $e) {
            error_log("Erreur lors de la création de la réalisation : " . $e->getMessage());
            return false;
        }
    }

    public function findAll() {
        $query = "SELECT r.*, t.typeName, ru.rubrique, f.departement
                  FROM Realisation r 
                  JOIN Type t ON r.idType = t.idType
                  JOIN Rubrique ru ON r.idRubrique = ru.idRubrique
                  JOIN departement f ON r.idDepartement = f.idDepartement";
        return $this->db->fetchAll($query);
    }

    public function getById($idRealisation) {
        $query = "SELECT * FROM Realisation WHERE idRealisation = ?";
        return $this->db->fetch($query, [$idRealisation]);
    }

    public function getByDate($dateMonth){
        $query = "SELECT * FROM Realisation WHERE dateRealisation = ?";
        return $this->db->fetch($query, [$dateMonth]);
    }

    public function update($idRealisation, $dateRealisation, $montant, $idType, $idRubrique, $idDepartement) {
        try {
            $query = "UPDATE Realisation SET dateRealisation = ?, montant = ?, idType = ?, idRubrique = ?, idDepartement = ? WHERE idRealisation = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$dateRealisation, $montant, $idType, $idRubrique, $idRealisation, $idDepartement]);
        } catch (Exception $e) {
            error_log("Erreur lors de la mise à jour de la réalisation : " . $e->getMessage());
            return false;
        }
    }

    public function delete($idRealisation) {
        try {
            $query = "DELETE FROM Realisation WHERE idRealisation = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$idRealisation]);
        } catch (Exception $e) {
            error_log("Erreur lors de la suppression de la réalisation : " . $e->getMessage());
            return false;
        }
    }
    
}

