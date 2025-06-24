<?php

namespace app\controllers;
use app\models\CategorieClientModel;
use app\models\ClientModel;
use app\models\DemandeTicketModel;
use app\models\AdminModel;
use app\controllers\TicketController;
use Exception;
use Flight;

class AdminController {

    public function __construct() {
        
    }

    public function login() {
        Flight::render('admin/login.php');
    }

    public function login_process() {
        $data = Flight::request()->data;
        $username = $data['username'] ?? null;
        $mdp = $data['password'] ?? null;

        if (empty($username) || empty($mdp)) {
            Flight::redirect('login?error=Veuillez remplir tous les champs');
            return;
        }

        if ("123" !== $mdp || "admin" !== $username) {
            Flight::redirect('login?error=Identifiants invalides');
            return;
        }

        // Stocker l'ID de l'admin dans la session
        Flight::session('id_admin', 1);

        // Redirection vers la page d'accueil de l'admin
        Flight::redirect('admin_home');
    }

    public function admin_home() {
        Flight::render('admin/template.php');
    }

    public function login_commercial() {
        Flight::render('commercial/login_commercial.php');
    }
    public function auth() {

        $data = Flight::request()->data;
        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;
        if($nom !== "commercial" || $prenom !== "123"){
            Flight::redirect('login?error=Identifiants invalides');
            return;
        }
 
        $clientModel = new ClientModel(Flight::db());
        // Stocker l'ID de l'admin dans la session
        Flight::session('id_commercial', 1);

        Flight::render('commercial/menu.php', ["clients" => $clientModel->findAll()]);

    }

    public function authTicket() {
        $clientModel = new ClientModel(Flight::db());
        $AdminModel = new AdminModel(Flight::db());
        $ticketController = new TicketController();

        $data = Flight::request()->data;
        $nom = $data['nom'] ?? null;
        $prenom = $data['prenom'] ?? null;

        $admin = $AdminModel->getAgentByNom($nom, $prenom);
        $message = "";
        if(!empty($admin)){
            $_SESSION['id_agent'] = $admin[0]['id_agent'];
            $ticketController->findTicketsByExternalAgentId();
        }else{
            Flight::render('commercial/login_commercial.php', ["messages" => "Error"]);
        }

        
    }

    public function accueil() {
        Flight::session('destroy');
        Flight::render('index.php');
    }

}