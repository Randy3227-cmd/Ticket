<?php

namespace app\models;

use Exception;
use DateTime;

class PrevisionModel
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($datePrevision, $montant, $idType, $idRubrique, $idDepartement)
    {
        try {
            $query = "INSERT INTO Prevision (datePrevision, montant, idType, idRubrique, idDepartement) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$datePrevision, $montant, $idType, $idRubrique, $idDepartement]);
        } catch (Exception $e) {
            error_log("Erreur lors de la création de la prévision : " . $e->getMessage());
            return false;
        }
    }

    public function findAll()
    {
        $query = "SELECT p.*, t.typeName, r.rubrique, f.departement 
                  FROM Prevision p 
                  JOIN Type t ON p.idType = t.idType
                  JOIN Rubrique r ON p.idRubrique = r.idRubrique
                  JOIN departement f ON p.idDepartement = f.idDepartement";
        return $this->db->fetchAll($query);
    }

    public function getByDate($dateMonth)
    {
        $query = "SELECT * FROM Prevision WHERE datePrevision = ?";
        return $this->db->fetch($query, [$dateMonth]);
    }

    public function getByDate2($dateMonth)
    {
        $dateObj = new DateTime($dateMonth);
        $month = $dateObj->format('m');
        $year = $dateObj->format('Y');

        $query = "SELECT SUM(Montant) as montant FROM Prevision p JOIN type t ON t.idType = p.idType join categorie c on c.idCategorie = t.idCategorie WHERE MONTH(p.datePrevision) = ? AND YEAR(p.datePrevision) = ? AND c.categorieName = 'Ticket' AND p.idDepartement = 6";
        return $this->db->fetchAll($query, [$month, $year])[0] ?? null;
    }


    public function getById($idPrevision)
    {
        $query = "SELECT * FROM Prevision WHERE idPrevision = ?";
        return $this->db->fetch($query, [$idPrevision]);
    }

    public function update($idPrevision, $datePrevision, $montant, $idType, $idRubrique, $idDepartement)
    {
        try {
            $query = "UPDATE Prevision SET datePrevision = ?, montant = ?, idType = ?, idRubrique = ?, idDepartement = ? WHERE idPrevision = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$datePrevision, $montant, $idType, $idRubrique, $idDepartement, $idPrevision]);
        } catch (Exception $e) {
            error_log("Erreur lors de la mise à jour de la prévision : " . $e->getMessage());
            return false;
        }
    }

    public function delete($idPrevision)
    {
        try {
            $query = "DELETE FROM Prevision WHERE idPrevision = ?";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$idPrevision]);
        } catch (Exception $e) {
            error_log("Erreur lors de la suppression de la prévision : " . $e->getMessage());
            return false;
        }
    }
}
