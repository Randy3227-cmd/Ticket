<?php

namespace app\models;

use Exception;

class NotificationModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function notification($id_client) {
        $query = "SELECT * FROM notification WHERE id_client = ? order by date_notification";
        return $this->db->fetchAll($query, [$id_client]);
    }

    public function sendNotificationToClient($id_client, $notification){
        try {
            $query = "INSERT INTO notification (id_client, notification, date_notification) VALUES (?,?,now())";
            $stmt = $this->db->prepare($query);
            return $stmt->execute([$id_client,$notification]);
        } catch (Exception $e) {
            throw $e;
        }
    }

}

