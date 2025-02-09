<?php
namespace app\controllers;

use app\models\ReinitialiserModel;
use Flight;

class ReinitialiserController {
    public function reinitialiserProjet() {
        try {
            $reinitialiserModel = new ReinitialiserModel(Flight::db());
            $reinitialiserModel->reinitialiserProjet();
            Flight::redirect(BASE_URL .'/stock?success=Projet réinitialisé avec succès');
        } catch (\Exception $e) {
            Flight::redirect(BASE_URL .'/stock?error=' . urlencode($e->getMessage()));
        }
    }
}