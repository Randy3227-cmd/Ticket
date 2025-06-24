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


/*Mbola tsy ao*/
CREATE TABLE commentaires(
    id_commentaire INT PRIMARY KEY AUTO_INCREMENT,
    id_ticket INT NOT NULL,
    contenu TEXT NOT NULL,
    date_commentaire DATE NOT NULL
);

CREATE TABLE notes(
    id_note INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT NOT NULL,
    id_agent INT NOT NULL,
    note INT CHECK (note >= 1 AND note <= 5),
    date_note DATE NOT NULL,
    FOREIGN KEY (id_client) REFERENCES client(id_client),
    FOREIGN KEY (id_agent) REFERENCES agent(id_agent)
);


