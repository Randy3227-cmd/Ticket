<?php

namespace app\controllers;

use app\models\TousLesProduitsModel;
use Flight;

class TousLesProduitsController{

    public function __construct(){

    }
    public function getProduits(){
        $tousLesProduitsModel = new TousLesProduitsModel(Flight::db());
        $produit = $tousLesProduitsModel->listeProduit();
        $data = ['produit' => $produit];
        Flight::render('accueil', $data);
    }
    public function getProduitsById(){
        $tousLesProduitsModel = new TousLesProduitsModel(Flight::db());
        $produitParCategorie = array();
        for ($i=0; $i < 3; $i++) { 
            array_push($produitParCategorie, $tousLesProduitsModel->produitParCategorie($i));
        }
        $data = ['produitParCategorie'=> $produitParCategorie];
        Flight::render('accueil', $data);
    }
}
?>