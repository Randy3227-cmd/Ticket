<?php

namespace app\controllers;

use app\models\LoginModel;
use Flight;

class LoginController {

	public function __construct() {

	}

    public function checkLogin() {

        $nom = Flight::request()->query['name'] ?? null;
        $pwd = Flight::request()->query['pwd'] ?? null;

        $loginModel = new LoginModel(Flight::db());

        $reponse =  $loginModel->checkLogin ($nom, $pwd);

        if ($reponse != "login successful") {
            $data = ['reponse' => $reponse];
            Flight::render('login', $data);
            return;            
        }
        $id = $loginModel->getIdByNom($nom, $pwd);
        $data = ['id' => $id];
        Flight::render('formulaire', $data);
    } 

    public function welcome () {
        $data = ['welcome' => 'welcome'];
        Flight::render('login', $data);
    }

}

?>