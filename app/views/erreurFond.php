<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/erreur.css">
    <title>Fonds Insuffisants</title>
</head>
<body>
    <h2>Achat non valide</h2>
    
    <div class="erreur-details">
        <p><?= htmlspecialchars($message) ?></p>
    </div>

        <p>Que voulez-vous faire ?</p>
    <div class="actions">
        <a href="<?= BASE_URL ?>/depotArgent">Déposer de l'argent</a>
        <a href="<?= BASE_URL ?>/listAlimentation">Retour à la liste</a>
    </div>
</body>
</html>