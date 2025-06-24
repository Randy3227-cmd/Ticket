<?php

namespace app\controllers;
use app\models\DemandeTicketModel;
use Exception;
use Flight;

class DemandeTicketController {

    public function __construct() {
        
    }

    public function findAll() {
        $demandeTicketModel = new DemandeTicketModel(Flight::db());
        $demandes = $demandeTicketModel->findAll();

        if (!$demandes) {
            $demandes = [];
        }

        $data = [
            'page' => 'demandes',
            'demandes' => $demandes
        ];

        Flight::render('admin/template.php', $data);
    }

    public function findAllById() {
        $demandeTicketModel = new DemandeTicketModel(Flight::db());
        $demandes = $demandeTicketModel->findAllById();

        if (!$demandes) {
            $demandes = [];
        }

        $data = [
            'demandes' => $demandes,
            'page' => 'demandes'
        ];

        Flight::render('client/template.php', $data);
    }

    public function create() {
        $data = Flight::request()->data;

        $id_client = Flight::session('id_client');
        $sujet = $data['sujet'] ?? null;
        $message = $data['message'] ?? null;

        // Vérification des champs requis
        if (empty($id_client) || empty($sujet) || empty($message)) {
            Flight::redirect('create_demande?error=Tous les champs sont requis');
            return;
        }

        $demandeTicketModel = new DemandeTicketModel(Flight::db());

        try {
            $success = $demandeTicketModel->save($sujet, $message);
            if ($success) {
                Flight::redirect('create?success=Demande créée avec succès');
            } else {
                Flight::redirect('create_demande?error=Erreur lors de la création de la demande');
            }
        } catch (Exception $e) {
            Flight::redirect(BASE_URL . '/client/demandes?error=' . urlencode($e->getMessage()));
        }
    }

    public function form() {
        // Vérification si l'utilisateur est connecté
        if (!Flight::session('id_client')) {
            Flight::redirect('login?error=Veuillez vous connecter pour créer une demande');
            return;
        }

        $data = [
            'page' => 'form',
        ];
        Flight::render('client/template.php', $data);
    }

}