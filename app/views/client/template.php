<?php
    if (!isset($_SESSION['id_client'])) {
        header('Location: ' . BASE_URL);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - Système d'Information</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #2c3e50;
        }

        header {
            background-color: #2980b9;
            padding: 20px;
            color: white;
            text-align: center;
        }

        nav {
            background-color: #ecf0f1;
            padding: 20px;
            border-bottom: 1px solid #ccc;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        nav li {
            margin: 0;
        }

        nav a {
            text-decoration: none;
            color: #2980b9;
            font-weight: bold;
            padding: 10px 15px;
            background-color: white;
            border: 1px solid #3498db;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #3498db;
            color: white;
        }

        main {
            padding: 30px;
            max-width: 1000px;
            margin: auto;
        }
    </style>
</head>
<body>
    <header>
        <h1>Espace Client</h1>
        <p>Bienvenue dans votre espace personnel</p>
    </header>

    <nav>
        <ul>
            <li><a href="<?= BASE_URL ?>">🏠 Accueil</a></li>
            <li><a href="<?= BASE_URL ?>/client/demandes/create">➕ Demander un Ticket</a></li>
            <li><a href="<?= BASE_URL ?>/client/tickets">🎫 Mes Tickets</a></li>
            <li><a href="<?= BASE_URL ?>/client/demandes">📄 Mes Demandes</a></li>
            <li><a href="<?= BASE_URL ?>/discussionClient">💬 Discussion</a></li>
        </ul>
    </nav>

    <main>
        <?php 
            if (isset($page) && !empty($page)) {
                $page = htmlspecialchars($page, ENT_QUOTES, 'UTF-8');
                include($page . '.php'); 
            }
        ?>
    </main>
</body>
</html>
