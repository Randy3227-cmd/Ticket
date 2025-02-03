<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/listCadeau.css">
    <style>
        .carousel {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            gap: 20px;
            padding: 20px;
            background-color: #f7f7f7;
        }

        .carousel-item {
            flex: 0 0 auto;
            scroll-snap-align: start;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .carousel-item img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }

        .carousel-title {
            text-align: center;
            font-weight: bold;
            margin: 10px 0;
        }

        .carousel p {
            font-size: 14px;
            color: #555;
        }
    </style>
    <title>Accueil</title>
</head>

<body>
    <header>
        <nav class="header-nav">
            <ul>
                <li><a href="<?= BASE_URL ?>/login">🧑‍💻Login</a></li>
                <li><a href="<?= BASE_URL ?>/sign">👩‍💻S'inscrire</a></li>
                <li><a href="#">👦Garçon</a></li>
                <li><a href="#">👧Fille</a></li>
                <li><a href="#">🎄Neutre</a></li>
            </ul>
        </nav>
    </header>é

    <div class="main">
        <h2 class="carousel-title">Garçons</h2>
        <div class="carousel">
            <?php foreach ($produit as $item) { if ($item['gender'] === 'garcon') { ?>
            <div class="carousel-item">
                <img src="<?= htmlspecialchars($item['imageCadeau']) ?>" alt="<?= htmlspecialchars($item['Cadeau']) ?>">
                <p><?= htmlspecialchars($item['Cadeau']) ?></p>
                <p>Prix : <?= htmlspecialchars($item['prix']) ?>€</p>
            </div>
            <?php } } ?>
        </div>

        <h2 class="carousel-title">Filles</h2>
        <div class="carousel">
            <?php foreach ($produit as $item) { if ($item['gender'] === 'fille') { ?>
            <div class="carousel-item">
                <img src="<?= htmlspecialchars($item['imageCadeau']) ?>" alt="<?= htmlspecialchars($item['Cadeau']) ?>">
                <p><?= htmlspecialchars($item['Cadeau']) ?></p>
                <p>Prix : <?= htmlspecialchars($item['prix']) ?>€</p>
            </div>
            <?php } } ?>
        </div>

        <h2 class="carousel-title">Neutres</h2>
        <div class="carousel">
            <?php foreach ($produit as $item) { if ($item['gender'] === 'neutre') { ?>
            <div class="carousel-item">
                <img src="<?= htmlspecialchars($item['imageCadeau']) ?>" alt="<?= htmlspecialchars($item['Cadeau']) ?>">
                <p><?= htmlspecialchars($item['Cadeau']) ?></p>
                <p>Prix : <?= htmlspecialchars($item['prix']) ?>€</p>
            </div>
            <?php } } ?>
        </div>
    </div>
</body>

</html>
