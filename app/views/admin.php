<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/listCadeau.css">
    <title>Document</title>
</head>

<body>
<div class="pu">
    <form action="<?= BASE_URL ?>/CommissionController" method="get">
        <input type="number" name="commission" id="" placeholder="⚙️Commission">
        <input type="submit" value="Valider">
    </form>

    <form action="<?= BASE_URL ?>/Ajouter" method="get">
        <input type="text" name="cadeau" id="" placeholder="cadeau🎁">
        <select name="categorie" id="">
            <option value="1">Garçon</option>
            <option value="2">Fille</option>
            <option value="3">Neutre</option>
        </select>
        <br>
        <input type="number" name="prix" id="" placeholder="prix💵">
        <input type="submit" value="Valider">
    </form>
</div>

    <div class="main">
        <?php if (isset ($result)) {
          for ($i = 0; $i < count($result); $i++) { ?>
        <div class="product-item">
            <p>idDepot : <?= htmlspecialchars($result[$i]['idDepotUtilisateur']) ?></p>
            <p>idUtilisateur : <?= htmlspecialchars($result[$i]['idUtilisateur']) ?></p>
            <p>Une somme de : <?= htmlspecialchars($result[$i]['argent']) ?></p>
            <form action="<?= BASE_URL ?>/DepotController" method="get">
                <input type="hidden" name="idUtilisateur" value="<?= htmlspecialchars($result[$i]['idUtilisateur']) ?>">
                <input type="submit" value="Accepter">
            </form>
        </div>
        <br>
        <?php } }?>
    </div>


</body>

</html>