<?php

use app\controllers\LoginController;
use app\controllers\SignController;
use app\controllers\FormulaireController;
use app\controllers\AjouterPanierController;
use \app\controllers\TousLesProduitsController;
use \app\controllers\TousLesProduitsModel;
use app\controllers\ModifierController;
use app\controllers\DepotController;
use app\controllers\AdminController;
use flight\Engine;
use flight\net\Router;

//use Flight;
$loginController = new LoginController();
$SignController = new SignController();
$formulaireController = new FormulaireController();
$ajouterPanierController = new AjouterPanierController();
$tousLesProduitsController = new TousLesProduitsController();
$modifierController = new ModifierController();
$depotController = new DepotController();
$adminController = new AdminController();

$router->get('/', [$tousLesProduitsController, 'getProduits']);
$router->get('/login',[$loginController, 'welcome']);
$router->get('/sign', [ $SignController, 'welcome' ]);
$router->get('/LoginController', [ $loginController, 'checkLogin' ]);
$router->get('/SignController', [ $SignController, 'insertUser' ]);
$router->get('/FormulaireController', [$formulaireController, 'checkFormulaire']);
$router->get('/AjouterPanierController', [$ajouterPanierController,'check']);
$router->get('/ModifierController', [ $modifierController, 'check']);
$router->get('/formulaire', [ $formulaireController, 'afficherFormulaire' ]);
$router->get('/DepotController', [ $depotController, 'updateMoney' ]);
$router->get('/DepotController1', [ $depotController, 'insertDepot' ]);
$router->get('/admin', [ $adminController, 'listDepot' ]);
$router->get('/depot', [$ajouterPanierController,'payerParDepot']);
$router->get('/Ajouter', [$adminController,'insertCadeau']);
?>