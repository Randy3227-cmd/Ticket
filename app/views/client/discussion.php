<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Client - Système d'Information</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #2980b9;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --success-color: #27ae60;
            --agent-color: #e3f2fd;
            --client-color: #f5f5f5;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
            color: var(--dark-color);
        }
        
        .main-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .chat-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.2rem;
            border-radius: 8px 8px 0 0;
            margin-bottom: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .back-link {
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        
        .back-link svg {
            margin-right: 0.5rem;
        }
        
        .chat-container {
            background-color: white;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .message-list {
            min-height: 400px;
            max-height: 60vh;
            overflow-y: auto;
            padding: 1.5rem;
            background-color: #fafafa;
            display: flex;
            flex-direction: column;
        }
        
        .message {
            padding: 0.8rem 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            max-width: 75%;
            position: relative;
            line-height: 1.4;
            word-wrap: break-word;
        }
        
        .message-client {
            background-color: var(--client-color);
            margin-right: auto;
            border-left: 3px solid var(--secondary-color);
            align-self: flex-start;
        }
        
        .message-agent {
            background-color: var(--agent-color);
            margin-left: auto;
            border-right: 3px solid var(--success-color);
            align-self: flex-end;
        }
        
        .message-meta {
            display: flex;
            justify-content: space-between;
            margin-top: 0.5rem;
            font-size: 0.75rem;
        }
        
        .message-sender {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .message-time {
            color: #7f8c8d;
            margin-left: 1rem;
        }
        
        .message-form-container {
            padding: 1rem;
            border-top: 1px solid #eee;
            background-color: white;
        }
        
        .message-form {
            display: flex;
            gap: 0.8rem;
        }
        
        .message-input {
            flex-grow: 1;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: all 0.3s;
            resize: none;
            min-height: 50px;
            max-height: 150px;
        }
        
        .message-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .send-button {
            padding: 0 1.8rem;
            background-color: var(--success-color);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            align-self: flex-end;
            height: 50px;
        }
        
        .send-button:hover {
            background-color: #219653;
        }
        
        .status-indicator {
            text-align: center;
            padding: 0.5rem;
            font-size: 0.8rem;
            color: #7f8c8d;
            border-bottom: 1px solid #eee;
        }
        
        .typing-indicator {
            display: none;
            font-size: 0.8rem;
            color: #7f8c8d;
            margin-bottom: 0.5rem;
        }
        
        @media (max-width: 768px) {
            .main-container {
                margin: 0;
                padding: 0;
            }
            
            .chat-container {
                border-radius: 0;
            }
            
            .message {
                max-width: 85%;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="chat-container">
            <h1 class="chat-header">
                <a href="client/tickets" class="back-link">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Retour
                </a>
                Discussion Client
                <span></span>
            </h1>
            
            <div class="status-indicator">
                <?php echo htmlspecialchars($client['nom_client'] ?? 'Client'); ?> - En ligne
            </div>
            
            <div class="message-list" id="message-list">
                <?php foreach($messages as $message): ?>
                    <div class="message <?php echo ( $message['id_agent'] == null ? 'message-agent' : 'message-client'); ?>">
                        <?php echo htmlspecialchars($message['messages']); ?>
                        <div class="message-meta">
                            <span class="message-sender">
                                <?php echo ($message['id_agent'] ? 'Agent' : htmlspecialchars($client['nom_client'] ?? 'Vous')); ?>
                            </span>
                            <span class="message-time">
                                <?php echo date('d/m/Y H:i', strtotime($message['date_creation'] ?? 'now')); ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="typing-indicator" id="typing-indicator"></div>
            </div>
            
            <div class="message-form-container">
                <form action="sendMessage" method="post" class="message-form" id="message-form">
                    <textarea name="message" id="message" class="message-input" placeholder="Écrivez votre message..." required></textarea>
                    <button type="submit" class="send-button">Envoyer</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Scroll automatique vers le bas des messages
        const messageList = document.getElementById('message-list');
        messageList.scrollTop = messageList.scrollHeight;
        
        // Gestion de l'indicateur de saisie
        const messageInput = document.getElementById('message');
        const typingIndicator = document.getElementById('typing-indicator');
        
        let typingTimer;
        
        messageInput.addEventListener('input', () => {
            typingIndicator.style.display = 'block';
            typingIndicator.textContent = 'Vous écrivez...';
            
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                typingIndicator.style.display = 'none';
            }, 2000);
        });
        
        messageInput.focus();
        
        document.getElementById('message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const message = messageInput.value.trim();
            if (message === '') return;
            
            // Créer un élément message immédiatement
            const messageDiv = document.createElement('div');
            messageDiv.className = 'message message-agent';
            messageDiv.innerHTML = `
                ${message}
                <div class="message-meta">
                    <span class="message-sender">Vous</span>
                    <span class="message-time">${new Date().toLocaleTimeString('fr-FR', {hour: '2-digit', minute:'2-digit'})}</span>
                </div>
            `;
            
            messageList.insertBefore(messageDiv, typingIndicator);
            messageInput.value = '';
            messageList.scrollTop = messageList.scrollHeight;
            
            fetch('sendMessage', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `message=${encodeURIComponent(message)}`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert("Erreur lors de l'envoi du message");
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>