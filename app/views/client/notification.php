<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Notifications</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .notification-container {
            max-width: 800px;
            margin: auto;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .notification-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .notification-item:last-child {
            border-bottom: none;
        }

        .notification-title {
            font-weight: bold;
            color: #2980b9;
        }

        .notification-message {
            margin: 5px 0;
        }

        .notification-date {
            font-size: 0.85rem;
            color: gray;
        }
    </style>
</head>
<body>
    <div class="notification-container">
        <h2>Mes Notifications</h2>
        
        <?php if (!empty($notifications) && is_array($notifications)): ?>
            <?php foreach ($notifications as $notif): ?>
                <div class="notification-item">
                    <div class="notification-message"><?= htmlspecialchars($notif['notification']) ?></div>
                    <div class="notification-date"><?= htmlspecialchars($notif['date_notification']) ?></div>
                </div>
                <div>
                    <a href="<?= BASE_URL?>/notification/supprimer?id=<?= htmlspecialchars($notif['id_notification']) ?>" class="btn btn-secondary">Supprimer</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucune notification pour le moment.</p>
        <?php endif; ?>
    </div>
</body>
</html>
