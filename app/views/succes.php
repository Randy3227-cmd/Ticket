<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        font-family: 'Georgia', serif;
        background-color: #f8f9fa;
        background-image: url('https://example.com/path-to-snow-background.jpg');
        /* Ajoutez une image de fond festif */
        background-size: cover;
        background-position: center;
        margin: 0;
        padding: 0;
        text-align: center;
        color: #8b0000;
        /* Rouge profond pour Noël */
    }

    h1 {
        font-size: 4em;
        /* Grande taille de police */
        margin-top: 20%;
        background-color: rgba(255, 255, 255, 0.8);
        /* Fond blanc semi-transparent */
        padding: 20px;
        border-radius: 15px;
        display: inline-block;
        text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
        /* Ombre pour un effet 3D */
        border: 3px solid #228b22;
        /* Bordure verte festive */
        animation: glow 1.5s infinite alternate;
        /* Animation scintillante */
    }

    @keyframes glow {
        0% {
            text-shadow: 3px 3px 10px #ff0000, 0 0 20px #ff0000, 0 0 30px #ff6347;
        }

        100% {
            text-shadow: 3px 3px 10px #228b22, 0 0 20px #228b22, 0 0 30px #32cd32;
        }
    }

    /* Ajout de flocons de neige */
    body::before {
        content: "❄️ ❄️ ❄️ ❄️";
        font-size: 3em;
        position: absolute;
        top: 5%;
        left: 50%;
        transform: translateX(-50%);
        animation: snowFall 10s infinite linear;
    }

    @keyframes snowFall {
        0% {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        100% {
            transform: translateX(-50%) translateY(100vh);
            opacity: 0;
        }
    }
    </style>
    <title>Document</title>
</head>

<body>
    <h1><?= $result?></h1>
    <?php if (str_contains($result, "solde est insuffisant")) {?>
        <div class="main">
        <form action="<?= BASE_URL ?>/depot" method="get">
            <h3>Voulez-vous completer votre argent par <?= $argent?> €</h3>
            <input type="hidden" name="id" value = "<?= $id?>">
            <input type="hidden" name="prix" value = "<?= $prix?>">
            <p><input type="number" name="depot" id="" value = "<?= $argent?>"> €</p>
            <p><input type="submit" value="Faire depot"></p>
        </form>
        <p><a href="<?= BASE_URL ?>/">Retour</a></p>
        </div>
    <?php } else if (!str_contains($result, "solde est insuffisant")) {?>
        <p><a href="<?= BASE_URL ?>/">Faire une autre achat</a></p>
    <?php }?>
</body>

</html>