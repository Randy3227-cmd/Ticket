<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Clients - Système d'Information</title>
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
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 1.5rem 2rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 1.5rem;
        }
        
        .header p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }
        
        .client-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }
        
        .client-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid #eee;
        }
        
        .client-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            border-color: var(--secondary-color);
        }
        
        .client-name {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }
        
        .client-id {
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-bottom: 1.2rem;
        }
        
        .client-status {
            display: flex;
            align-items: center;
            font-size: 0.8rem;
            margin-bottom: 1rem;
            color: #7f8c8d;
        }
        
        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #27ae60;
            margin-right: 0.5rem;
        }
        
        .message-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.6rem 1.2rem;
            background-color: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s;
            width: 80%;
        }
        
        .message-btn:hover {
            background-color: var(--accent-color);
        }
        
        .message-btn svg {
            margin-right: 0.5rem;
        }
        
        #chat-box {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 380px;
            height: 500px;
            background: white;
            border: 1px solid #ddd;
            padding: 0;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            border-radius: 12px;
            z-index: 1000;
            flex-direction: column;
        }
        
        .chat-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 1.5rem;
            margin: 0;
            font-size: 1.1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .close-chat {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 1.2rem;
        }
        
        #messages {
            flex-grow: 1;
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
            max-width: 80%;
            position: relative;
            line-height: 1.4;
            word-wrap: break-word;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .message-agent {
            background-color: var(--agent-color);
            margin-left: auto;
            border-right: 3px solid var(--secondary-color);
            align-self: flex-end;
        }
        
        .message-client {
            background-color: var(--client-color);
            margin-right: auto;
            border-left: 3px solid var(--success-color);
            align-self: flex-start;
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
        
        .chat-input-container {
            padding: 1rem;
            border-top: 1px solid #eee;
            background-color: white;
        }
        
        .message-form {
            display: flex;
            gap: 0.8rem;
        }
        
        #message-input {
            flex-grow: 1;
            padding: 0.8rem 1rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.3s;
            resize: none;
            min-height: 50px;
            max-height: 100px;
        }
        
        #message-input:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .send-btn {
            padding: 0 1.5rem;
            background-color: var(--success-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            align-self: flex-end;
            height: 50px;
        }
        
        .send-btn:hover {
            background-color: #219653;
        }
        
        .typing-indicator {
            display: none;
            font-size: 0.8rem;
            color: #7f8c8d;
            margin-bottom: 0.5rem;
            padding-left: 1rem;
        }
        
        .no-messages {
            color: #7f8c8d;
            text-align: center;
            margin: auto;
        }
        
        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }
            
            .client-list {
                grid-template-columns: 1fr;
            }
            
            #chat-box {
                width: 100%;
                height: 70vh;
                bottom: 0;
                right: 0;
                border-radius: 12px 12px 0 0;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header">
            <div>
                <h1>Gestion des Clients</h1>
                <p>Système d'Information - Plateforme de support client</p>
            </div>
            <div>
                <a href="<?= BASE_URL ?>">Accueil</a>
            </div>
        </div>

        <div class="client-list">
            <?php foreach($clients as $client): ?>
                <div class="client-card">
                    <div class="client-name"><?php echo htmlspecialchars($client['nom_client']); ?></div>
                    <div class="client-id">ID Client: <?php echo htmlspecialchars($client['id_client']); ?></div>
                    <div class="client-status">
                        <span class="status-indicator"></span>
                        En ligne
                    </div>
                    <a href="#" class="message-btn" onclick="openChat(<?php echo $client['id_client']; ?>, '<?php echo addslashes(htmlspecialchars($client['nom_client'])); ?>')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Ouvrir le chat
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="chat-box">
            <div class="chat-header">
                <span id="chat-title">Discussion</span>
                <button class="close-chat" onclick="document.getElementById('chat-box').style.display = 'none'">×</button>
            </div>
            <div id="messages"></div>
            <div class="typing-indicator" id="typing-indicator"></div>
            <div class="chat-input-container">
                <div class="message-form">
                    <input type="text" id="message-input" placeholder="Écrivez votre message..." autocomplete="off">
                    <button class="send-btn" onclick="sendMessage()">Envoyer</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentClientId = null;
        let currentClientName = null;
        let messageCheckInterval = null;

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleTimeString('fr-FR', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        function createMessageElement(message, isAgent) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${isAgent ? 'message-agent' : 'message-client'}`;
            
            const contentDiv = document.createElement('div');
            contentDiv.className = 'message-content';
            contentDiv.textContent = message.messages;
            
            const metaDiv = document.createElement('div');
            metaDiv.className = 'message-meta';
            
            const senderDiv = document.createElement('div');
            senderDiv.className = 'message-sender';
            senderDiv.textContent = isAgent ? 'Vous' : currentClientName;
            
            const timeDiv = document.createElement('div');
            timeDiv.className = 'message-time';
            timeDiv.textContent = formatDate(message.date_creation);
            
            metaDiv.appendChild(senderDiv);
            metaDiv.appendChild(timeDiv);
            
            messageDiv.appendChild(contentDiv);
            messageDiv.appendChild(metaDiv);
            
            return messageDiv;
        }

        function loadMessages(clientId) {
            fetch(`messageClient/${clientId}`)
                .then(res => res.json())
                .then(data => {
                    const messagesDiv = document.getElementById('messages');
                    messagesDiv.innerHTML = '';

                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(msg => {
                            const isAgent = msg.id_agent !== null;
                            messagesDiv.appendChild(createMessageElement(msg, isAgent));
                        });
                        messagesDiv.scrollTop = messagesDiv.scrollHeight;
                    } else {
                        const noMessages = document.createElement('div');
                        noMessages.className = 'no-messages';
                        noMessages.textContent = 'Aucun message pour le moment';
                        messagesDiv.appendChild(noMessages);
                    }
                })
                .catch(err => {
                    console.error('Erreur de chargement des messages:', err);
                });
        }

        function openChat(clientId, clientName) {
            currentClientId = clientId;
            currentClientName = clientName;
            const chatBox = document.getElementById('chat-box');
            chatBox.style.display = 'flex';
            document.getElementById('chat-title').textContent = `Discussion avec ${clientName}`;
            document.getElementById('messages').innerHTML = '<div class="no-messages">Chargement...</div>';

            // Charger les messages initiaux
            loadMessages(clientId);

            // Démarrer la vérification périodique des nouveaux messages
            if (messageCheckInterval) {
                clearInterval(messageCheckInterval);
            }
            messageCheckInterval = setInterval(() => loadMessages(clientId), 5000);
        }

        function sendMessage() {
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            const messagesDiv = document.getElementById('messages');

            if (message === '' || !currentClientId) return;

            // Créer un message temporaire
            const tempMessage = {
                messages: message,
                date_creation: new Date().toISOString(),
                id_agent: 1 // Supposons que l'agent a l'ID 1
            };
            
            const messageElement = createMessageElement(tempMessage, true);
            messagesDiv.appendChild(messageElement);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
            
            input.value = '';

            // Envoyer le message au serveur
            fetch(`sendMessageToClient/${currentClientId}`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include',
                body: JSON.stringify({ message: message })
            })
            .then(res => res.json())
            .then(response => {
                if (!response.success) {
                    alert("Erreur: " + (response.error || "Échec de l'envoi"));
                }
            })
            .catch(err => {
                console.error("Erreur de connexion:", err);
                alert("Erreur de connexion au serveur");
            });
        }

        // Permettre d'envoyer un message avec la touche Entrée
        document.getElementById('message-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });

        // Fermer le chat quand on clique en dehors
        document.addEventListener('click', function(event) {
            const chatBox = document.getElementById('chat-box');
            if (chatBox.style.display === 'flex' && 
                !chatBox.contains(event.target) && 
                !event.target.classList.contains('message-btn')) {
                chatBox.style.display = 'none';
                if (messageCheckInterval) {
                    clearInterval(messageCheckInterval);
                }
            }
        });
    </script>
</body>
</html>