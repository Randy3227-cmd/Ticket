<?php

namespace app\controllers;

use app\models\AdminModel;
use Flight;  
    
class AdminController{

    public function __construct(){

    } 
    public function listDepot(){
        $adminModel = new AdminModel(Flight::db());
        $result = $adminModel->listDepot();
        $data = ['result' => $result];
        Flight::render('admin',$data);
    }

    public function insertCadeau(){
        $cadeau = Flight::request()->query['cadeau'] ?? null;
        $idCategorie = Flight::request()->query['categorie'] ?? 0;
        $prix = Flight::request()->query['prix'] ?? null;

        $adminModel = new AdminModel(Flight::db());
        $result = $adminModel->insertCadeau($cadeau, $idCategorie, $prix);
        $data = ['result' => $result];
        Flight::render('login' ,$data);
    }
}
?>