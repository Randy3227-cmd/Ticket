<?php

namespace app\controllers;

use app\models\SignModel;
use Flight;

class SignController {

	public function __construct() {

	}

    public function welcome () {
        $data = ['welcome' => 'welcome'];
        Flight::render('sign', $data);
    }

    public function insertUser () {

        $user = Flight::request()->query['name'] ?? null;
        $password = Flight::request()->query['pwd'] ?? null;
        $money = 0;

        $signModel = new signModel(Flight::db());
        $reponse =  $signModel->insertuser($user, $password, $money);

        $data = ['welcome' => 'welcome'];
        Flight::render('login', $data);
    }

}

?>