<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Animaux</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        header {
    background-color: white;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 10px 20px;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;
}

nav ul {
    list-style: none;
    display: flex;
    padding: 0;
    margin: 0;
}

nav ul li {
    margin-right: 20px;
}

nav ul li a {
    text-decoration: none;
    color: black;
    font-weight: bold;
    padding: 8px 12px;
    transition: color 0.3s ease;
}

nav ul li a:hover {
    color: #FF4500;
}

.btn-reinitialiser {
    background-color: #FF4500;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-reinitialiser:hover {
    background-color: #D14000;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

/* Ajuster le body pour ne pas être caché par le header */
body {
    padding-top: 60px;
}

        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f5f5f5; }
        h1 { text-align: center; }
        .animaux-container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .animal-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 250px;
            text-align: center;
        }
        .animal-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .animal-info { text-align: left; }
        .btn-acheter {
            background-color: green;
            color: white;
            border: none;
            padding: 8px 15px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-acheter:hover { background-color: darkgreen; }

        footer {
            background-color: #222;
            color: #fff;
            text-align: center;
            padding: 15px;
            font-family: Arial, sans-serif;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 5px 0;
        }

        footer .credits {
            font-size: 14px;
            font-style: italic;
            color: #ccc;
        }
    </style>
</head>

<header>
    <div class="header-container">
        <nav>
            <ul>
                <li><a href="<?= BASE_URL ?>/argent">Argent</a></li>
                <li><a href="<?= BASE_URL ?>/stock">Stock</a></li>
                <li><a href="<?= BASE_URL ?>/situation">Situation</a></li>
                <li><a href="<?= BASE_URL ?>/listAlimentation">Alimentation</a></li>
                <li><a href="<?= BASE_URL ?>/achetes">Acheté(es)</a></li>
                <li>
                    <select name="autovente" id="autovente">
                        <option value="">Autovente</option>
                        <option value="1">OUI</option>
                        <option value="2">NON</option>
                    </select>
                </li>
            </ul>
        </nav>

        <form action="<?= BASE_URL ?>/reinitialiser" method="post">
            <button type="submit" class="btn-reinitialiser">Reload</button>
        </form>
    </div>
</header>

    </form>

<body>


    <h1>Liste des Animaux</h1>

    <div class="animaux-container">
        <?php if (!empty($animaux)) : ?>
            <?php foreach ($animaux as $animal) : ?>
                <div class="animal-card">
                    <?php if (!empty($animal['imageAnimaux'])) : ?>
                        <img src="<?= 'public/assets/img/' . htmlspecialchars($animal['imageAnimaux']) ?>" 
                             alt="Image de <?= htmlspecialchars($animal['animal']) ?>">
                    <?php else : ?>
                        <p>Pas d'image</p>
                    <?php endif; ?>

                    <h3><?= htmlspecialchars($animal['animal']) ?></h3>

                    <div class="animal-info">
                        <p><strong>Poids Min:</strong> <?= htmlspecialchars($animal['poidsMin']) ?> kg</p>
                        <p><strong>Poids Max:</strong> <?= htmlspecialchars($animal['poidsMax']) ?> kg</p>
                        <p><strong>Prix Vente:</strong> <?= htmlspecialchars($animal['prixVenteParKg']) ?> MGA/kg</p>
                        <p><strong>Poids Initial:</strong> <?= htmlspecialchars($animal['poidsInitial']) ?> kg</p>
                    </div>


                    <form action="<?= BASE_URL ?>/acheter" method="post">
                        <input type="hidden" name="idAnimaux" value="<?= htmlspecialchars($animal['idAnimaux']) ?>">
                        <input type="hidden" name="prix" value="<?= htmlspecialchars($animal['prixVenteParKg']) ?>">
                        <button type="submit" class="btn-acheter">Acheter</button>
                    </form>
                </div>....

                <div class="reset-container" style="text-align: center; margin-top: 20px;">

</div>



            <?php endforeach; ?>
        <?php else : ?>
            <p>Aucun animal trouvé.</p>
        <?php endif; ?>
    </div>

    <footer>
    <p class="credits">Developed and designed by Randy, Mihaja, and Carole</p>
    <p>ETU003227-ETU003139-ETU003186</p>
</footer>

</body>
</html>
