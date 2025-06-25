<?php

namespace app\controllers;
use app\models\DiscussionModel;
use app\models\NotificationModel;
use Exception;
use Flight;

class DiscussionController {
    
    public function __construct() {
        
    }
    
    public function getMessage() {
        $discussionModel = new DiscussionModel(Flight::db());
        $messages = $discussionModel->getMessage(Flight::session('id_client'));
    
        if (!$messages) {
            $messages = []; 
        }
        
        Flight::render('client/discussion.php', ['messages' => $messages]);
    }

    public function sendMessageToAgent(){
        $data = Flight::request()->data;
        $message = $data['message'] ?? null;

        $discussionModel = new DiscussionModel(Flight::db());
        $send = $discussionModel->sendMessageToAgent(Flight::session('id_client'), $message);
        $notificationModel = new NotificationModel(Flight::db());
        $notificationModel->sendNotificationToClient(Flight::session('id_client'), 'Votre message e été envoyé');
        $this->getMessage();
    }

    public function sendMessageToClient($id_client){
        $data = Flight::request()->data;
        $message = $data['message'] ?? null;
        $id_agent = Flight::session('id_commercial');
    
        if (!$id_agent) {
            Flight::json(['error' => 'Commercial non connecté'], 403);
            return;
        }
    
        if (!$message || trim($message) === '') {
            Flight::json(['error' => 'Message vide'], 400);
            return;
        }
    
        $discussionModel = new DiscussionModel(Flight::db());
        $success = $discussionModel->sendMessageToClient($id_agent, $id_client, $message);
        $notificationModel = new NotificationModel(Flight::db());
        $notificationModel->sendNotificationToClient($id_agent, 'Vous avez reçu un message de votre agent : '.$message);
        if ($success) {
            Flight::json(['success' => true]);
        } else {
            Flight::json(['error' => 'Erreur base de données'], 500);
        }
    }
    
    public function getMessageByClientId($id_client) {
        $discussionModel = new DiscussionModel(Flight::db());
        $messages = $discussionModel->getMessage($id_client);
    
        if (!$messages) {
            $messages = []; 
        }
        Flight::json([
            'messages' => $messages
        ]);
    }
    
       
}
