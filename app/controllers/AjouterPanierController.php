<?php

namespace app\controllers;

use app\models\AjouterPanierModel;
use aPP\models\DepotModel;
use Flight;  
    
class AjouterPanierController{

    public function __construct(){

    } 
    public function check(){
        $id = Flight::request()->query['id'] ?? null;
        $prix = Flight::request()->query['total_prix'] ?? null;

        $ajouterPanierModel = new AjouterPanierModel(Flight::db());

        $result = $ajouterPanierModel->checkAchat($prix, $id);
        $data = ['result' => $result[0] , 'id' => $id, 'argent' => $result[1], 'prix' => $prix];
        Flight::render('succes',$data);
    }


    public function payerParDepot(){
        $id = Flight::request()->query['id'] ?? null;
        $prix = Flight::request()->query['prix'] ?? null;
        $depot = Flight::request()->query['depot'] ?? null;

        $depotModel = new DepotModel(Flight::db());
        $ajouterPanierModel = new AjouterPanierModel(Flight::db());

        $argentActuelle = $depotModel->getUserMoney ($id);

        $newSold = $argentActuelle['argent'] + $depot;
        $updateMoney = $depotModel->updateUserMoney($id, $newSold);

        $result = $ajouterPanierModel->checkAchat($prix, $id);
        $data = ['result' => $result[0] , 'id' => $id, 'argent' => $result[1], 'prix' => $prix];
        Flight::render('succes',$data);
    }
}
?>