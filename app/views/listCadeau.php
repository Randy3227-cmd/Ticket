<?php session_start()?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/listCadeau.css">
    <title>Liste des Cadeaux</title>
</head>

<body>

    <center>
        <?php if (isset($garcon, $fille, $neutre)){?>
        <p>Pour <?= $garcon?> garçon(s), <?= $fille ?> fille(s), <?= $neutre ?> cadeau(x) neutre(s)</p>
        <?php } ?>
    </center>
    <br><br>
    <?php $total_prix = 0;?>

    <p>Cochez le box si vous voulez modifier </p>
    <form action="<?= BASE_URL ?>/ModifierController" method="get">
        <div class="main">
            <input type="hidden" name="garcon" value="<?= $garcon?>">
            <input type="hidden" name="fille" value="<?= $fille?>">
            <input type="hidden" name="neutre" value="<?= $neutre?>">

            <?php foreach($cadeau as $c) { ?>
            <input type="hidden" name="gifts[]" value="<?= htmlspecialchars(json_encode($c), ENT_QUOTES, 'UTF-8') ?>">
            <div>
                <input type="checkbox" name="cadeaux[]" value="<?= $c['idCadeau'] ?>" id="cadeau_<?= $c['idCadeau'] ?>">
                <h3><?= $c['Cadeau'] ?></h3>
                <p><u>Catégorie :</u> <?= $c['typeCategorie']?></p>
                <img src="<?= $c['imageCadeau'] ?>" alt="<?= $c['Cadeau'] ?>" width="100">
                <p>Prix : <?= $c['prix'] ?>€</p>
                <?php $total_prix += $c['prix']?>
            </div>
            <br>
            <?php ?>
            <?php } ?>
            <button type="submit">Valider la modification</button>
    </form>

    <form action="<?= BASE_URL ?>/AjouterPanierController" method="get">
        <input type="hidden" name="total_prix" value="<?= $total_prix?>">
        <input type="hidden" name="id" value="<?= $_SESSION['id']?>">
        <button type="submit">Acheter tous pour le prix de <?= $total_prix ?>€</button>
    </form>

    </div>
</body>

</html>