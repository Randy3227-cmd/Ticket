<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aliments Achetes</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/achat.css">
</head>
<body>
    <h2>Liste des Aliments Achetes</h2>

    <div class="aliments-container">
        <?php if (!empty($achats)): ?>
            <?php foreach ($achats as $achat): ?>
                <div class="aliment-card">
                    <img src="<?= BASE_URL ?>/public/assets/img/<?= htmlspecialchars($achat['imageAlimentation']) ?>" alt="<?= htmlspecialchars($achat['aliment']) ?>">
                    <p><strong><?= htmlspecialchars($achat['aliment']) ?></strong></p>
                    <p>Quantité : <?= htmlspecialchars($achat['quantite']) ?></p>
                    <p>Prix Unitaire : <?= htmlspecialchars($achat['prix']) ?> MGA</p>
                    <p><strong>Total : <?= htmlspecialchars($achat['totalPrix']) ?> MGA</strong></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun achat effectué.</p>
        <?php endif; ?>
    </div>

    <a href="<?= BASE_URL ?>/listAlimentation">Retour</a>
</body>
</html>
