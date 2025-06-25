CREATE TABLE categorie_client(
    id_categorie_client INT PRIMARY KEY AUTO_INCREMENT,
    nom_categorie_client VARCHAR(50),
    age VARCHAR(50) NOT NULL
    -- FOREIGN KEY (id_categorie_client) REFERENCES categorie_client(id_categorie_client)
);

CREATE TABLE client(
    id_client INT PRIMARY KEY AUTO_INCREMENT,
    nom_client VARCHAR(50) NOT NULL,
    genre VARCHAR(50) NOT NULL,
    id_categorie_client INT NOT NULL
    -- FOREIGN KEY (id_categorie_client) REFERENCES categorie_client(id_categorie_client)
);

CREATE TABLE agent(
    id_agent INT PRIMARY KEY AUTO_INCREMENT,
    nom_agent VARCHAR(50) NOT NULL,
    prenom_agent VARCHAR(50) NOT NULL,
    tarif INT NOT NULL
);

CREATE TABLE demande_ticket(
    id_demande INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT NOT NULL,
    sujet VARCHAR(50) NOT NULL,
    message TEXT,
    status INT NOT NULL DEFAULT 0,
    fichier VARCHAR(255),
    FOREIGN KEY (id_client) REFERENCES client(id_client)
);

CREATE TABLE Discussion(
    id_discussion INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT NOT NULL,
    id_agent INT,
    date_creation DATETIME NOT NULL,
    messages TEXT NOT NULL,
    FOREIGN KEY (id_client) REFERENCES client(id_client)
);

CREATE TABLE notes(
    id_note INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT NOT NULL,
    id_agent INT NOT NULL,
    note INT CHECK (note >= 1 AND note <= 5),
    date_note DATETIME NOT NULL,
    commentaires TEXT,
    id_ticket INT,
    FOREIGN KEY (id_client) REFERENCES client(id_client),
    FOREIGN KEY (id_agent) REFERENCES agent(id_agent)
);

CREATE TABLE HISTORIQUE_STATUT(
    id_historique INT PRIMARY KEY AUTO_INCREMENT,
    id_ticket INT NOT NULL,
    status INT NOT NULL,
    date_changement DATETIME NOT NULL,
);

CREATE TABLE notification(
    id_notification INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT REFERENCES client(id_client),
    notification TEXT,
    date_notification DATETIME
);


/*Mbola tsy ao*/
-- CREATE TABLE commentaires(
--     id_commentaire INT PRIMARY KEY AUTO_INCREMENT,
--     id_ticket INT NOT NULL,
--     contenu TEXT NOT NULL,
--     date_commentaire DATE NOT NULL
-- );



INSERT INTO demande_ticket (id_client, sujet, message, status) VALUES
(1, 'Problème de connexion', 'Je narrive pas à me connecter à mon compte.', 0),
(2, 'Facturation', 'Je pense avoir été facturé deux fois.', 1),
(3, 'Demande dinformation', 'Je souhaite connaître les horaires.', 0);

INSERT INTO Discussion (id_client, id_agent, date_creation, messages) VALUES
(1, 1, '2025-06-24 10:00:00', 'Bonjour, j ai un problème de mot de passe.'),
(2, 2, '2025-06-24 10:15:00', 'Merci pour votre réponse rapide !'),
(3, NULL, '2025-06-24 11:00:00', 'J attends qu un agent prenne en charge ma demande.');
