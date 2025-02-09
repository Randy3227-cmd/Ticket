<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Alimentations</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/styles.css">
</head>
<body>
    <h2>Liste des Alimentations</h2>

    <div class="container">
        <?php foreach ($alimentations as $aliment) : ?>
            <div class="card">
                <img src="<?= BASE_URL ?>/public/assets/img/<?= htmlspecialchars($aliment['imageAlimentation']) ?>" alt="<?= htmlspecialchars($aliment['aliment']) ?>">
                <p><strong><?= htmlspecialchars($aliment['aliment']) ?></strong></p>
                <p>Prix : <?= htmlspecialchars($aliment['prix']) ?> MGA</p>
                <p>Gain : <?= htmlspecialchars($aliment['pourcentageGain']) ?>%</p>
                <form action="<?= BASE_URL ?>/achatAlimentationFormulaire" method="get">
                    <input type="hidden" name="idAlimentation" value="<?= htmlspecialchars($aliment['idAlimentation']) ?>">
                    <button type="submit">Acheter</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
    <a href="<?= BASE_URL ?>/alimentationAcheter">Mes aliments</a>
</body>
</html>
