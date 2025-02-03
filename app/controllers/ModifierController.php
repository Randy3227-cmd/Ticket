<?php

namespace app\controllers;

use app\models\ModifierModel;
use Flight;  
    
class ModifierController{

    public function __construct(){

    } 
    public function check(){
        $idCadeau = Flight::request()->query['cadeaux'] ?? [];
        $jsonString = Flight::request()->query['gifts'] ?? [];
        $nombreGarcon = Flight::request()->query['garcon'] ?? null;
        $nombreFille = Flight::request()->query['fille'] ?? null;
        $neutre = Flight::request()->query['neutre'] ?? null;

        $gifts = array();

        for ($i = 0; $i < count($jsonString); $i++) { 
            $gift = json_decode($jsonString[$i], true);
            array_push($gifts, $gift);
        }

        $modifierModel = new ModifierModel(Flight::db());
        $newGift = $modifierModel->modifierProduit ($idCadeau);
        
        for ($i = 0; $i < count($gifts); $i++) { 
            for ($j = 0; $j < count($newGift); $j++) {

                if ($gifts[$i]['idCadeau'] == (int)$idCadeau[$j]) {    
                    $gifts[$i] = $newGift[$j];
                }
            }
        }
        
        $data = ['cadeau' => $gifts, 'garcon' => $nombreGarcon , 'fille' => $nombreFille , 'neutre' => $neutre];
        Flight::render('listCadeau', $data);
        return;
    }
}
?>