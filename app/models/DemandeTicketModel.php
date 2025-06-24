<?php

namespace app\models;

use Exception;
use Flight;

class DemandeTicketModel
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function save($sujet, $message, $filePath = null)
    {
        $id_client = Flight::session('id_client');
        if (!$id_client) {
            throw new Exception("ID client non trouvé dans la session");
        }

        try {
            $query = "INSERT INTO demande_ticket (id_client, sujet, message, fichier) VALUES (?, ?, ?, ?)";
            return $this->db->runQuery($query, [$id_client, $sujet, $message, $filePath]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findAll()
    {
        $query = "SELECT * FROM demande_ticket JOIN client ON demande_ticket.id_client = client.id_client where status = 0";
        return $this->db->fetchAll($query);
    }

    public function findAllById()
    {
        $id_client = Flight::session('id_client');
        if (!$id_client) {
            throw new Exception("ID client non trouvé dans la session");
        }

        $query = "SELECT * FROM demande_ticket WHERE id_client = ? and status = 0";

        return $this->db->fetchAll($query, [$id_client]);
    }

    public function findById($id)
    {
        $query = "SELECT * FROM demande_ticket WHERE id_demande = ?";
        return $this->db->fetchRow($query, [$id]);
    }

    public function updateStatus($id_demande, $statut)
    {
        $query = "UPDATE demande_ticket SET status = ? WHERE id_demande = ?";
        return $this->db->runQuery($query, [$statut, $id_demande]);
    }

    public function refuse($id_demande)
    {
        $query = "UPDATE demande_ticket SET status = -1 WHERE id_demande = ?";
        return $this->db->runQuery($query, [$id_demande]);
    }
}
