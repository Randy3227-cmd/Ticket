<?php

namespace app\models;

use Exception;

class EvaluationModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function evaluate($id_client, $id_agent, $note, $commentaires, $id_ticket) {
        try {
            $check = $this->db->prepare("SELECT id_note FROM notes WHERE id_client = ? AND id_agent = ? AND id_ticket = ?");
            $check->execute([$id_client, $id_agent, $id_ticket]);
            $existingNote = $check->fetch();
    
            if ($existingNote) {
                $query = "UPDATE notes SET note = ?, date_note = NOW(), commentaires = ? WHERE id_note = ?";
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$note, $commentaires, $existingNote['id_note']]);
            } else {
                $query = "INSERT INTO notes (id_client, id_agent, note, date_note, commentaires, id_ticket) VALUES (?, ?, ?, NOW(), ?, ?)";
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$id_client, $id_agent, $note, $commentaires, $id_ticket]);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}

