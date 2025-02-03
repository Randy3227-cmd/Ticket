<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/listCadeau.css">
    <title>Accueil</title>
</head>

<body>
    <header>
        <nav class="header-nav">
            <ul>
                <li><a href="<?= BASE_URL ?>/login">🧑‍💻Login</a></li>
                <li><a href="<?= BASE_URL ?>/sign">👩‍💻S'inscrire</a></li>
                <li><a href="<?= BASE_URL ?>/admin">😶‍🌫️Administrateur</a></li>                
                <li><a href="#">👦Garçon</a></li>
                <li><a href="#">👧Fille</a></li>
                <li><a href="#">🎄Neutre</a></li>
            </ul>
        </nav>
    </header>
    <h1>ETU003113 - ETU003227</h1>
    <div class="main">
        <?php for ($i = 0; $i < count($produit); $i++) { ?>
        <div class="product-item">
            <h3><?= htmlspecialchars($produit[$i]['Cadeau']) ?></h3>
            <p>Catégorie <?= htmlspecialchars($produit[$i]['idCategorie']) ?></p>
            <img src="<?= htmlspecialchars($produit[$i]['imageCadeau']) ?>" alt="<?= htmlspecialchars($produit[$i]['Cadeau']) ?>" width="100">
            <p>Prix : <?= htmlspecialchars($produit[$i]['prix']) ?>€</p>
        </div>
        <br>
        <?php } ?>
    </div>
</body>

</html>