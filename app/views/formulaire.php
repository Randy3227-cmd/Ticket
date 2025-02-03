<?php
session_start();
$_SESSION['id'] = $id;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/formulaire.css">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="header-content">
            <h1>🎄Joyeux Noel</h1>
            <nav>
                <ul>
                    <form action="<?= BASE_URL ?>/DepotController1" method="get">
                        <input type="hidden" name="id" value="<?= $_SESSION['id'];?>">
                        <input type="number" name="argent" id="" placeholder="Depot d'argent ici💵">
                        <input type="submit" value="Dépot">
                    </form>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main">
        <form action="<?= BASE_URL ?>/FormulaireController" method="get">
            <input type="number" name="fille" id="" placeholder="nombre de fille">
            <input type="number" name="garcon" id="" placeholder="nombre de garçon">
            <input type="number" name="neutre" id="" placeholder="cadeau neutre">
            <input type="submit" value="valider">
        </form>
    </div>
</body>

</html>