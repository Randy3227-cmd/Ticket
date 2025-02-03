<?php

namespace app\controllers;

use app\models\DepotModel;
use Flight;  
    
class DepotController{

    public function __construct(){
    } 

    public function updateMoney() {
        $idUtilisateur = Flight::request()->query['idUtilisateur'] ?? null;

        $depotModel = new DepotModel(Flight::db());

        $depot = $depotModel->getDepot ($idUtilisateur);
        $userMoney = $depotModel->getUserMoney ($idUtilisateur);

        $newSold = $userMoney["argent"] + $depot["argent"];
        
        $update = $depotModel->updateUserMoney($idUtilisateur, $newSold);
        $delete = $depotModel->deleteDepot ($idUtilisateur);

        $data = ['welcome' => 'mety'];
        Flight::render('admin', $data);
    }

    public function insertDepot () {
        $idUtilisateur = Flight::request()->query['id'] ?? null;
        $argent = Flight::request()->query['argent']?? null;

        $depotModel = new DepotModel(Flight::db());
        $data;
        if ($argent < 0) {
            $data = ['reponse' => "le montant du dépôt doit être positif"];
            Flight::render('formulaire', $data);
            return;
        } else {
            $data = ['reponse' => 'En attente de validation'];
            $insert = $depotModel->insertDepot ($idUtilisateur, $argent);
        }

        Flight::render('login', $data);
    }

}