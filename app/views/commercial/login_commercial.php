<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification Agent - Système d'Information</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #2980b9;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --error-color: #e74c3c;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--dark-color);
        }
        
        .auth-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            width: 100%;
            max-width: 450px;
            border-top: 4px solid var(--primary-color);
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .auth-header h1 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
        }
        
        .auth-header p {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
        }
        
        input[type="text"] {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border 0.3s;
            box-sizing: border-box;
        }
        
        input[type="text"]:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .submit-btn {
            width: 100%;
            padding: 0.8rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .submit-btn:hover {
            background-color: var(--accent-color);
        }
        
        .form-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.9rem;
            color: #7f8c8d;
        }
    </style>
</head>
<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh; gap: 50px;">
        
        <!-- Formulaire gauche -->
        <div class="auth-container">
            <div class="auth-header">
                <h1>Agent Responsable Discussion</h1>
                <p>Système d'Information - Accès sécurisé</p>
            </div>
            
            <form action="auth_commercial" method="post">
                <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" id="nom" placeholder="Entrez votre nom" required>
                </div>
                
                <div class="form-group">
                    <label for="prenom">Mot de passe :</label>
                    <input type="password" name="prenom" id="prenom" placeholder="Entrez votre mot de passe" required>
                </div>
                
                <button type="submit" class="submit-btn">Se connecter</button>
            </form>

            <div class="form-footer">
                Accès réservé au personnel autorisé
            </div>
        </div>

        <!-- Formulaire droite -->
        <div class="auth-container">
            <div class="auth-header">
                <h1>Agent Responsable Ticket</h1>
                <p>Système d'Information - Accès sécurisé</p>
            </div>
            
            <form action="auth_ticket" method="post">
                <div class="form-group">
                    <label for="nom2">Nom :</label>
                    <input type="text" name="nom" id="nom2" placeholder="Entrez votre nom, ex: Rabe " required>
                </div>
                
                <div class="form-group">
                    <label for="prenom2">Prénom :</label>
                    <input type="text" name="prenom" id="prenom2" placeholder="Entrez votre prenom, ex: Mialy" required>
                </div>
                
                <button type="submit" class="submit-btn">Se connecter</button>
            </form>

            <div class="form-footer">
                Accès réservé au personnel autorisé
            </div>
        </div>
    </div>
</body>
</html>