<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock des Animaux</title>
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
        .stock-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }
        .stock-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 250px;
            text-align: center;
            position: relative;
        }
        .stock-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .stock-info {
            text-align: left;
        }
        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .stock-badge-high { 
            background-color: #4CAF50; 
            color: white; 
        }
        .stock-badge-low { 
            background-color: #FF9800; 
            color: white; 
        }
        .stock-badge-empty { 
            background-color: #F44336; 
            color: white; 
        }
        .btn-acheter {
            background-color: green;
            color: white;
            border: none;
            padding: 8px 15px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
        }
        .btn-acheter:hover { 
            background-color: darkgreen; 
        }
        .btn-acheter:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .success { 
            background-color: #DFF0D8; 
            color: #3C763D; 
        }
        .error { 
            background-color: #F2DEDE; 
            color: #A94442; 
        }
    </style>
</head>
<body>
    <h1>Stock des Animaux</h1>

    <?php if (isset($_GET['success'])): ?>
        <div class="message success">Achat effectué avec succès !</div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="message error">
            Erreur : <?= htmlspecialchars(urldecode($_GET['error'])) ?>
        </div>
    <?php endif; ?>

    <div class="stock-container">
        <?php if (!empty($stockAnimaux)) : ?>
            <?php foreach ($stockAnimaux as $animal) : ?>
                <div class="stock-card">
                    <?php 
                    // Déterminer la classe du badge de stock
                    $stockClass = $animal['stock'] > 3 ? 'stock-badge-high' : 
                                 ($animal['stock'] > 0 ? 'stock-badge-low' : 'stock-badge-empty');
                    ?>
                    <span class="stock-badge <?= $stockClass ?>">
                        Stock : <?= $animal['stock'] ?>
                    </span>

                    <?php if (!empty($animal['imageAnimaux'])) : ?>
                        <img src="<?= 'public/assets/img/' . htmlspecialchars($animal['imageAnimaux']) ?>"
                             alt="Image de <?= htmlspecialchars($animal['animal']) ?>">
                    <?php else : ?>
                        <img src="public/assets/img/placeholder.jpg" alt="Pas d'image">
                    <?php endif; ?>

                    <h3><?= htmlspecialchars($animal['animal']) ?></h3>

                    <div class="stock-info">
                        <p><strong>Poids Min:</strong> <?= htmlspecialchars($animal['poidsMin']) ?> kg</p>
                        <p><strong>Poids Max:</strong> <?= htmlspecialchars($animal['poidsMax']) ?> kg</p>
                        <p><strong>Prix Vente:</strong> <?= htmlspecialchars($animal['prixVenteParKg']) ?> MGA/kg</p>
                    </div>

                    <form action="<?= BASE_URL ?>/acheter" method="post">
                        <input type="hidden" name="idAnimaux" value="<?= htmlspecialchars($animal['idAnimaux']) ?>">
                        <input type="hidden" name="prix" value="<?= htmlspecialchars($animal['prixVenteParKg']) ?>">
                        <button type="submit" class="btn-acheter" 
                                <?= $animal['stock'] <= 0 ? 'disabled' : '' ?>>
                            <?= $animal['stock'] <= 0 ? 'Stock épuisé' : 'Acheter' ?>
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Aucun animal en stock.</p>
        <?php endif; ?>
    </div>
</body>
</html>