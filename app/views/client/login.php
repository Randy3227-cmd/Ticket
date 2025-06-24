<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion Client - Système d'Information</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      color: #2c3e50;
    }

    .login-container {
      background-color: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    h1 {
      color: #2980b9;
      margin-bottom: 25px;
    }

    label {
      display: block;
      margin-bottom: 10px;
      font-weight: 500;
    }

    select {
      width: 100%;
      padding: 10px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 20px;
      background-color: #fafafa;
    }

    input[type="submit"] {
      background-color: #3498db;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 1rem;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
      width: 100%;
    }

    input[type="submit"]:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Connexion Client</h1>
    <form action="login" method="post">
      <label for="username">Choisissez votre nom :</label>
      <select name="username" id="username" required>
        <?php foreach ($clients as $client) { ?>
          <option value="<?= $client['id_client'] ?>">
            <?= htmlspecialchars($client['nom_client']) ?>
          </option>
        <?php } ?>
      </select>
      <input type="submit" value="Se connecter">
    </form>
  </div>
</body>
</html>
