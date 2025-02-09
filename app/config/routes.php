<?php

use app\controllers\SituationController;
use app\controllers\ListerAnimauxController;
use app\controllers\StockAnimauxController;
use app\controllers\AnimauxAcheteController;
use app\controllers\ReinitialiserController;
use app\controllers\ArgentController;
use app\controllers\AlimentationController;
use flight\Engine;
use flight\net\Router;
$situationController = new SituationController();
$listerAnimauxController = new ListerAnimauxController();
$stock_animauxController = new StockAnimauxController();
$animaux_acheteController = new AnimauxAcheteController();
$reinitialiser_Controller = new ReinitialiserController();
$argent = new ArgentController();
$alimentation = new AlimentationController();

// Route pour afficher la page principale
$router->get('/',[$listerAnimauxController, 'getAllAnimaux']);
$router->get('situation',[$situationController, 'getAnimauxAchete']);
$router->get('/situation',[$situationController, 'getAllAnimaux']);
$router->get('/situation', function () {
    include __DIR__ . '/../views/situation.php'; // Charge la vue correctement
});

// Route pour recevoir la requête AJAX
$router->post('/situation/getPoidsActuel', [$situationController, 'getPoidsActuel']);
$router->get('/stock', [$stock_animauxController, 'getStock']);
$router->post('/acheter', [$stock_animauxController, 'acheterAnimal']);
$router->get('/achetes', [$animaux_acheteController, 'getAchats']);
$router->post('/reinitialiser', [$reinitialiser_Controller, 'reinitialiserProjet']);
$router->post('/vendre', [$stock_animauxController, 'vendreAnimal']);

$router->get('/argent',[$argent, 'showMontant']);
$router->post('/depotArgent',[$argent, 'depotArgent']);
$router->get('/depotArgent',[$argent, 'afficherFormulaire']);
$router->get('/listAlimentation',[$alimentation, 'listAlimentations']);
$router->get('/achatAlimentationFormulaire',[$alimentation, 'afficherFormulaireAchat']);
$router->get('/alimentation',[$alimentation, 'validerAchat']);
$router->get('/alimentationAcheter',[$alimentation, 'afficherAchats']);