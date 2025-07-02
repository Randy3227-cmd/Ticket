<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Administrateur - Système d'Information</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            color: #2c3e50;
        }

        header {
            background-color: #2980b9;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #ecf0f1;
            padding: 15px 20px;
            border-bottom: 1px solid #ccc;
        }

        nav ul {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        nav a {
            text-decoration: none;
            color: #2980b9;
            font-weight: bold;
            padding: 10px 15px;
            background-color: #ffffff;
            border: 1px solid #3498db;
            border-radius: 6px;
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

        .welcome-msg {
            text-align: center;
            padding: 30px 0;
        }

        .welcome-msg h1 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .welcome-msg p {
            font-size: 1rem;
            color: #7f8c8d;
        }

        .search-form {
    background-color: #ffffff;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 20px;
    margin: 20px auto;
    max-width: 1000px;
}

.search-form .form-row {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 15px;
}

.search-form label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

.search-form input,
.search-form select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 0.95rem;
}

.form-submit {
    text-align: center;
    margin-top: 20px;
}

.form-submit button {
    padding: 10px 20px;
    font-size: 1rem;
    background-color: #2980b9;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.form-submit button:hover {
    background-color: #1f6391;
}

    </style>
</head>

<body>
    <header>
        <h1>Espace Administrateur</h1>
    </header>

    <div class="welcome-msg">
        <h1>Bienvenue</h1>
        <p>Veuillez choisir une section dans le menu ci-dessous.</p>
    </div>

    <nav>
        <ul>
            <li><a href="<?= BASE_URL ?>">🏠 Accueil</a></li>
            <li><a href="<?= BASE_URL ?>/admin/demandes">📄 Demandes</a></li>
            <li><a href="<?= BASE_URL ?>/admin/tickets">🎫 Tickets</a></li>
            <li><a href="<?= BASE_URL ?>/admin/dashboard">🗃️ Dashboard</a></li>
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