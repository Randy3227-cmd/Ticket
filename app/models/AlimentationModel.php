<?php

namespace app\models;

use Flight;
use Exception;

class AlimentationModel{

    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM Alimentation";
        return $this->db->fetchAll($query); 
    }
    
    
    public function acheterAliment($idAlimentation, $quantite, $dateAchat) {
        try {
            
            // Préparez la requête d'insertion
            $query = "INSERT INTO AchatAlimentation (idAlimentation, dateAchat, quantite) VALUES (?, ?, ?)";
            
            // Exécutez la requête
            $stmt = $this->db->prepare($query);
            $result = $stmt->execute([$idAlimentation, $dateAchat, $quantite]);
            
            // Vérifiez si l'insertion a réussi
            if ($result === false) {
                throw new Exception("Échec de l'enregistrement de l'achat");
            }
            
            return true;
        } catch (Exception $e) {
            // Loggez l'erreur
            error_log('Erreur lors de l\'achat de l\'alimentation : ' . $e->getMessage());
            return false;
        }
    }
    

    public function getAchats() {
        $query = "
            SELECT a.aliment, a.prix, a.imageAlimentation, ach.quantite, (a.prix * ach.quantite) AS totalPrix
            FROM AchatAlimentation ach
            JOIN Alimentation a ON ach.idAlimentation = a.idAlimentation
        ";
        return $this->db->fetchAll($query);
    }
    

    public function getAlimentationById($idAlimentation) {
        $query = "SELECT * FROM Alimentation WHERE idAlimentation = ?";
        
        try {
            // Utilisez fetchAll qui retourne un tableau de résultats
            $result = $this->db->fetchAll($query, [$idAlimentation]);
            
            // Vérifiez si un résultat a été trouvé
            if (empty($result)) {
                return null;
            }
            
            // Retournez le premier élément du tableau (qui devrait être l'aliment recherché)
            return $result[0];
        } catch (Exception $e) {
            // Loggez l'erreur
            error_log('Erreur lors de la récupération de l\'alimentation : ' . $e->getMessage());
            return null;
        }
    }

    
    
    
        
}
