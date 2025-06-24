<?php

namespace app\models;

use Exception;

class DiscussionModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getMessage($id_client) {
        $query = "SELECT * FROM Discussion WHERE id_client = ? order by date_creation";
        return $this->db->fetchAll($query, [$id_client]);
    }

    public function sendMessageToAgent($id_client, $message){
        try {
            $query = "INSERT INTO Discussion (id_client, id_agent, date_creation, messages) VALUES (?,NULL,now(),?)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id_client,$message]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function sendMessageToClient($id_agent, $id_client, $message){
        try {
            $query = "INSERT INTO Discussion (id_client, id_agent, date_creation, messages) VALUES (?,?,now(),?)";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id_client,$id_agent,$message]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}

