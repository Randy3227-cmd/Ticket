<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/assets/css/depot.css">
    <title>Ajouter du Capital</title>
</head>
<body>
    <h2>Ajouter du Capital</h2>
    <form action="<?= BASE_URL ?>/depotArgent" method="post">
        <label for="valeur">Montant :</label>
        <input type="number" name="valeur" id="valeur" required>
        <button type="submit">Ajouter</button>
    </form>
</body>
</html>
