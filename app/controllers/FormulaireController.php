<?php

namespace app\controllers;

use app\models\FormulaireModel;
use Flight;  
    
class FormulaireController{

    public function __construct(){
    } 

    public function checkFormulaire(){
        $gift = array();
        $nombreGarcon = Flight::request()->query['garcon'] ?? null;
        $nombreFille = Flight::request()->query['fille'] ?? null;
        $neutre = Flight::request()->query['neutre'] ?? null;

        $formulaireModel = new FormulaireModel(Flight::db());

        $formulaire = $formulaireModel->cadeauRandom($nombreFille, $nombreGarcon, $neutre);

        for ($i=0; $i < count($formulaire); $i++) { 
            foreach($formulaire[$i] as $c) { 
                array_push($gift, $c);
            }
        }
        
        $data = ['cadeau' => $gift , 'garcon' => $nombreGarcon , 'fille' => $nombreFille , 'neutre' => $neutre];
        Flight::render('listCadeau',$data);
    }

    public function afficherFormulaire() {
        Flight::render('formulaire');
    }
}
?>