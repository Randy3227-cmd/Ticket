<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/login.css">
    <title>Log in</title>
</head>

<body>
    <header>
        <div class="header-content">
            <h1>🎄Joyeux Noel</h1>
            <nav>
                <ul>
                    <li><a href="<?= BASE_URL ?>/">Nos Produits</a></li>
                    <li><a href="#">0342207595</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main">
        <form action="<?= BASE_URL ?>/LoginController" methode="POST">
            <h1>Se Connecter</h1>

            <p><label>Nom d'utilisateur : </label> <input type="text" name="name" id="name" value = "ranto" required></p>
            <p><label>Mots de passe : </label> <input type="password" name="pwd" id="pwd" value = "1" required></p>
            <?php if (isset($reponse)) {?>
            <p class="alert">
                <?= $reponse ?>
            </p>
            <?php }?>
            <input type="submit" value="Valider">
            <br>
            <a href="<?= BASE_URL ?>/sign">Pas encore de compte ?</a>
        </form>
    </div>
</body>

</html>