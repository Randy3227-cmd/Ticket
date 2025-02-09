<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validation d'Achat</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/aliment.css">
</head>
<body>

    <div class="container">
        <h2>Confirmer l'Achat</h2>

        <p>
            <img src="public/assets/img/<?= htmlspecialchars($aliment['imageAlimentation']) ?>" 
                 alt="<?= htmlspecialchars($aliment['aliment']) ?>" 
                 width="100">
        </p>
        <p><strong>Aliment :</strong> <?= htmlspecialchars($aliment['aliment']) ?></p>
        <p><strong>Prix :</strong> <?= htmlspecialchars($aliment['prix']) ?> MGA</p>
        <p><strong>Pourcentage de Gain :</strong> <?= htmlspecialchars($aliment['pourcentageGain']) ?>%</p>
        
       

        <form action="<?= BASE_URL ?>/alimentation" method="get">
            <input type="hidden" name="idAlimentation" value="<?= htmlspecialchars($aliment['idAlimentation']) ?>">

            <label for="quantite">Quantité :</label>
            <input type="number" id="quantite" name="quantite" value="1" min="1" required>

            <button type="submit">Valider l'achat</button>
        </form> 

        <a href="<?= BASE_URL ?>/listAlimentation">Annuler</a>
    </div>

</body>
</html>
