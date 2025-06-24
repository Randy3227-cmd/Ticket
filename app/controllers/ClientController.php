<?php

namespace app\controllers;
use app\models\CategorieClientModel;
use app\models\ClientModel;
use Exception;
use Flight;

class ClientController {

    public function __construct() {
        
    }

    public function findAll() {
        $clientModel = new ClientModel(Flight::db());
        $client = $clientModel->findAll();
    
        if (!$client) {
            $client = []; 
        }
    
        Flight::render('client/read.php', ['clients' => $client]);
    }

    public function login() {
        $clientModel = new ClientModel(Flight::db());
        $client = $clientModel->findAll();

        if (!$client) {
            $client = []; 
        }

        Flight::render('client/login.php', ['clients' => $client]);
    }

    public function login_process() {
        $data = Flight::request()->data;
        $id_client = $data['username'] ?? null;


        if (empty($id_client)) {
            Flight::redirect('login?error=Veuillez sélectionner un client');
            return;
        }

        // Stocker l'ID du client dans la session
        Flight::session('id_client', $id_client);

        // Redirection vers la page d'accueil du client
        Flight::redirect('client_home');
    }

    public function client_home() {
        Flight::render('client/template.php');
    }

    public function create() {
        $data = Flight::request()->data;
    
        $nom_client = $data['nom_client'] ?? null;
        $prix_client = $data['prix_client'] ?? null;
        $id_categorie_client = $data['id_categorie_client'] ?? null;
    
        // Vérification des champs requis
        if (empty($nom_client) || empty($prix_client) || empty($id_categorie_client)) {
            Flight::redirect('create_client?error=Tous les champs sont requis');
            return;
        }
    
        $clientModel = new clientModel(Flight::db());
    
        try {
            $success = $clientModel->save($nom_client, $prix_client, $id_categorie_client);
            if ($success) {
                Flight::redirect('client?success=client créé avec succès');
            } else {
                Flight::redirect('create_client?error=Erreur lors de la création du client');
            }
        } catch (Exception $e) {
            Flight::redirect('create_client?error=' . urlencode($e->getMessage()));
        }
    }    

}