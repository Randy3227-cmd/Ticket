<?php
use app\controllers\CategorieProduitController;
use app\controllers\DemandeFinanceController;
use app\controllers\TicketController;
use flight\Engine;
use flight\net\Router;
use app\controllers\ClientController;
use app\controllers\DemandeTicketController;
use app\controllers\AdminController;
use app\controllers\DiscussionController;

use app\controllers\EvaluationController;
use app\controllers\RealisationController;

use app\controllers\DashboardController;

use app\controllers\NotificationController;

$dashboardController = new DashboardController();       

$clientController = new ClientController();
$demandeTicketController = new DemandeTicketController();
$adminController = new AdminController();
$ticketController = new TicketController();
$discussionController = new DiscussionController();
$evaluationController = new EvaluationController();
$realisationController = new RealisationController();
$notificationController = new NotificationController();

$router->get('/', [$adminController, 'accueil']);
$router->get('/login', [$clientController, 'login']);
$router->post('/login', [$clientController, 'login_process']);
$router->get('/client_home', [$clientController, 'client_home']);
$router->get('/client/tickets', [$ticketController, 'findTicketsByExternalUserId']);
$router->get('/client/demandes', [$demandeTicketController, 'findAllById']);
$router->get('/client/demandes/create', [$demandeTicketController, 'form']);
$router->post('/client/demandes/create', [$demandeTicketController, 'create']);

$router->get('/admin/login', [$adminController, 'login']);
$router->post('/admin/login', [$adminController, 'login_process']);
$router->get('/admin/admin_home', [$adminController, 'admin_home']);
$router->get('/admin/demandes', [$demandeTicketController, 'findAll']);
$router->get('/admin/demandes/create', [$ticketController, 'form']);
$router->post('/admin/demandes/create', [$ticketController, 'create']);
$router->get('/admin/demandes/refuser', [$ticketController, 'refuser']);
$router->get('/admin/tickets', [$ticketController, 'findAll']);

//Randy
$router->get('/discussionClient',[$discussionController, 'getMessage']);
$router->post('/sendMessage',[$discussionController, 'sendMessageToAgent']);
$router->get('/login_commercial',[$adminController, 'login_commercial']);
$router->post('/auth_commercial',[$adminController, 'auth']);
$router->post('/auth_ticket',[$adminController, 'authTicket']);
$router->post('/sendMessageToClient/@id', [$discussionController, 'sendMessageToClient']);
$router->get('/messageClient/@id', [$discussionController, 'getMessageByClientId']);

$router->post('/ticket/update', [$ticketController, 'update']);
$router->post('/realisation/ajouter_realisation', [$realisationController, 'ajouter_realisation']);

$router->post('/ticket/evaluation', [$evaluationController, 'evaluate']);

$router->get('/admin/dashboard', [$dashboardController, 'showDashboard']);



$router->get('/notification', [$notificationController, 'notification']);
$router->get('/notification/supprimer', [$notificationController, 'supprimer']);


$router->post('/admin/recherche', [$ticketController, 'findAllFiltered']);