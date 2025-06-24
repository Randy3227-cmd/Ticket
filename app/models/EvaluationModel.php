<?php

namespace app\models;

use Exception;

class EvaluationModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function evaluate($id_client, $id_agent, $note) {
        try {
            $check = $this->db->prepare("SELECT id_note FROM notes WHERE id_client = ? AND id_agent = ?");
            $check->execute([$id_client, $id_agent]);
            $existingNote = $check->fetch();
    
            if ($existingNote) {
                $query = "UPDATE notes SET note = ?, date_note = CURDATE() WHERE id_note = ?";
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$note, $existingNote['id_note']]);
            } else {
                $query = "INSERT INTO notes (id_client, id_agent, note, date_note) VALUES (?, ?, ?, CURDATE())";
                $stmt = $this->db->prepare($query);
                return $stmt->execute([$id_client, $id_agent, $note]);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
    
}

