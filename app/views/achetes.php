<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animaux Achetés</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f5f5f5;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    .achats-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    .achat-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        width: 250px;
        text-align: center;
    }

    .achat-card img {
        width: 100%;
        height: auto;
        border-radius: 10px;
        margin-bottom: 10px;
    }
    </style>
</head>

<body>
    <h1>Animaux Achetés</h1>

    <div class="achats-container">
        <?php if (!empty($achats)) : ?>
        <?php foreach ($achats as $achat) : ?>
        <div class="achat-card">
            <?php if (!empty($achat['imageAnimaux'])) : ?>
            <img src="<?= 'public/assets/img/' . htmlspecialchars($achat['imageAnimaux']) ?>"
                alt="Image de <?= htmlspecialchars($achat['animal']) ?>">
            <?php else : ?>
            <p>Pas d'image</p>
            <?php endif; ?>

            <h3><?= htmlspecialchars($achat['animal']) ?></h3>
            <p>Acheté le : <?= htmlspecialchars($achat['dateAchat']) ?></p>

            <form action="<?= BASE_URL ?>/vendre" method="post">
                <input type="hidden" name="idAnimaux" value="<?= htmlspecialchars($achat['idAnimauxAchete']) ?>">
                <input type="hidden" name="prix" value="<?= htmlspecialchars($achat['prixVenteParKg']) ?>">
                <button type="submit" class="btn-acheter">
                    Vendre
                </button>
            </form>
        </div>
        <?php endforeach; ?>
        <?php else : ?>
        <p>Aucun animal n'a été acheté.</p>
        <?php endif; ?>
    </div>
</body>

</html>