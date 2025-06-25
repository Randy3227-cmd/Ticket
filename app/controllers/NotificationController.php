<?php

namespace app\controllers;
use app\models\NotificationModel;
use Exception;
use Flight;

class NotificationController {
    
    public function __construct() {
        
    }
    public function notification(){
        $id_client = Flight::session('id_client');
        $notificationModel = new NotificationModel(Flight::db());
        $notifications = $notificationModel->notification($id_client);
        Flight::render('client/notification.php', ['notifications' => $notifications]);
    }

    public function supprimer(){
        $id = Flight::request()->query['id'] ?? null;
        $notificationModel = new NotificationModel(Flight::db());
        $success = $notificationModel->supprimer($id);
        if ($success) {
            Flight::redirect(BASE_URL . '/notification');
        } else {
            Flight::render('error.php', ['message' => 'Erreur lors de la suppression de la notification.']);
        }
    }
    
    
    
       
}
