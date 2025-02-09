<?php

namespace app\controllers;

use app\models\ListerAnimauxModel;
use Flight;

class ListerAnimauxController {

    public function __construct() {

    }

    public function getAllAnimaux() {
        $model = new ListerAnimauxModel(Flight::db());
        try {
            $animaux = $model->getAllAnimaux();
            Flight::render('listerAnimaux', ['animaux' => $animaux]);
        } catch (\Exception $e) {
            Flight::json(['error' => $e->getMessage()], 500);
        }
    }
}