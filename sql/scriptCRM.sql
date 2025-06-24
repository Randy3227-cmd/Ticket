/* CREATE DATABASE crm;
USE crm; */

-- CREATE TABLE categorie_client(
--     id_categorie_client PRIMARY KEY AUTO_INCREMENT,
--     genre VARCHAR(50) NOT NULL
-- );


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

CREATE TABLE achat(
    id_achat INT PRIMARY KEY AUTO_INCREMENT,
    id_client INT,
    id_produit INT,
    montant_achat INT,
    date_achat DATE
);

CREATE TABLE categorie_produit(
    id_categorie_produit INT PRIMARY KEY AUTO_INCREMENT,
    nom_categorie_produit VARCHAR(50) NOT NULL
);

CREATE TABLE produit(
    id_produit INT PRIMARY KEY AUTO_INCREMENT,
    nom_produit VARCHAR(50) NOT NULL,
    prix_produit INT,
    id_categorie_produit INT
);

CREATE TABLE action(
    id_action INT PRIMARY KEY AUTO_INCREMENT,
    nom_action TEXT,
    id_produit INT
);

-- action iray , reaction iray na maromaro
CREATE TABLE reaction(
    id_reaction INT PRIMARY KEY AUTO_INCREMENT,
    nom_reaction TEXT,
    montant_reaction INT,
    date_reaction date,
    id_action INT NOT NULL
);

-- INSERT INTO categorie_client VALUES 
-- ("Homme"),
-- ("Femme");

INSERT INTO categorie_client(nom_categorie_client,age) VALUES 
("Enfants","4-12"),
("Adolescents","13-18"),
("Jeunes Adultes","19-30"),
("Adultes","31-50"),
("Seniors","50+"),
("Enfants","4-12"),
("Adolescents","13-18"),
("Jeunes Adultes","19-30"),
("Adultes","31-50"),
("Seniors","50+");

INSERT INTO categorie_produit(nom_categorie_produit) VALUES 
("Film"),
("Musique"),
("Jeu video");

INSERT INTO produit (nom_produit, prix_produit, id_categorie_produit) VALUES
('Inception', 12, 1),
('Interstellar', 15, 1),
('Thriller - Michael Jackson', 10, 2),
('Random Access Memories - Daft Punk', 11, 2),
('The Last of Us', 45, 3),
('FIFA 25', 50, 3),
('Titanic', 9, 1),
('Adele 30', 12, 2),
('GTA VI', 60, 3),
('Call of Duty', 55, 3);
