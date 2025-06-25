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
    
    
    
       
}
