<?php

namespace app\models;

use Exception;

class ClientModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function save($nom_client, $genre, $id_categorie_client) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO client (nom_client, genre, id_categorie_client)
                VALUES (:nom_client, :genre, :id_categorie_client)
            ");
            $stmt->bindParam(':nom_client', $nom_client);
            $stmt->bindParam(':genre', $genre);
            $stmt->bindParam(':id_categorie_client', $id_categorie_client);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Erreur lors de l'enregistrement du client : " . $e->getMessage());
            return false;
        }
    }
    

    public function findAll() {
        $query = "SELECT c.*, cc.nom_categorie_client FROM client c join categorie_client cc on c.id_categorie_client = cc.id_categorie_client";
        return $this->db->fetchAll($query);
    }
    
}
