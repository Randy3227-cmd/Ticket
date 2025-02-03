<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/assets/css/login.css">
    <title>Sign In</title>
</head>

<body>
    <header>
        <div class="header-content">
            <h1>🎄Joyeux Noel</h1>
            <nav>
                <ul>
                    <li><a href="<?= BASE_URL ?>/">Nos Produits</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="main">
        <form action="<?= BASE_URL ?>/SignController" methode="GET">
            <h1>S'inscrire</h1>
            <p><label>Nom d'utilisateur : </label> <input type="text" name="name" id="name"></p>
            <p><label>Mots de passe : </label><input type="password" name="pwd" id="pwd"></p>
            <input type="submit" value="Valider">
            <br>
            <a href="<?= BASE_URL ?>/">Retour</a>
        </form>
    </div>
</body>

</html>