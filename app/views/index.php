<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Système d'Information</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #2c3e50;
        }

        .container {
            background-color: #fff;
            padding: 40px 60px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
        }

        h1 {
            color: #2980b9;
            margin-bottom: 20px;
        }

        p {
            color: #7f8c8d;
            font-size: 1rem;
            margin-bottom: 30px;
        }

        a {
            display: block;
            margin: 10px 0;
            text-decoration: none;
            background-color: #3498db;
            color: white;
            padding: 12px;
            border-radius: 6px;
            font-weight: 500;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Système d'Information</h1>
        <p>Bienvenue sur la plateforme de gestion des tickets.</p>

        <a href="<?= BASE_URL ?>/login_commercial">Agent Commercial</a>
        <a href="<?= BASE_URL ?>/login">Client</a>
        <a href="<?= BASE_URL ?>/admin/login">Administrateur</a>
    </div>
</body>

</html>
