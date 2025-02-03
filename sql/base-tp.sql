CREATE TABLE noel_utilisateur(
    idUtilisateur integer primary key auto_increment,
    nom varchar(20),
    mot_de_passe varchar(20),
    argent integer
);

INSERT INTO noel_utilisateur (nom, mot_de_passe, argent) VALUES ("ranto", "1", 0);
INSERT INTO noel_utilisateur (nom, mot_de_passe, argent) VALUES ("Randy", "3227", 0);

CREATE TABLE noel_cadeau(
    idCadeau integer primary key auto_increment,
    Cadeau varchar(30),
    imageCadeau varchar(50),
    idCategorie integer,
    prix integer
);

CREATE TABLE noel_categorie(
    idCategorie integer primary key auto_increment,
    typeCategorie varchar(10)
);

CREATE TABLE depot_utilisateur(
    idDepotUtilisateur integer primary key auto_increment,
    idUtilisateur integer,
    argent integer
);

INSERT INTO noel_categorie (typeCategorie)
VALUES 
    ('Homme'),
    ('Femme'),
    ('Neutre');

INSERT INTO noel_cadeau (Cadeau, imageCadeau, idCategorie, prix) 
VALUES 
    ('Poupée', 'poupee.jpg', 3, 25),
    ('T-shirt', 'tshirt.jpg', 2, 15),
    ('Smartphone', 'smartphone.jpg', 1, 200),
    ('Roman', 'roman.jpg', 3, 12),
    ('Guirlande', 'guirlande.jpg', 3, 10),
    ('Casque audio', 'casque_audio.jpg', 1, 50),
    ('Parfum', 'parfum.jpg', 2, 40),
    ('Montre', 'montre.jpg', 1, 150),
    ('Sac à main', 'sac_a_main.jpg', 2, 60),
    ('Jeu de société', 'jeu_societe.jpg', 3, 30),
    ('Boîte de chocolats', 'chocolats.jpg', 3, 20),
    ('Écharpe', 'echarpe.jpg', 2, 18),
    ('Lego', 'lego.jpg', 3, 45),
    ('Montre connectée', 'montre_connectee.jpg', 1, 120),
    ('Bague', 'bague.jpg', 2, 70),
    ('Drone', 'drone.jpg', 1, 300),
    ('Pull de Noël', 'pull_noel.jpg', 3, 25),
    ('Peluche', 'peluche.jpg', 3, 15),
    ('Boucles d\'oreilles', 'boucles_oreilles.jpg', 2, 50), -- Correction ici
    ('Vélo', 'velo.jpg', 3, 250),
    ('Porte-clés', 'porte_cles.jpg', 3, 5),
    ('Tablette', 'tablette.jpg', 1, 180),
    ('Vase', 'vase.jpg', 3, 20),
    ('Baskets', 'baskets.jpg', 1, 80),
    ('Parure de lit', 'parure_lit.jpg', 3, 40),
    ('Chapeau', 'chapeau.jpg', 2, 25),
    ('Tapis de yoga', 'tapis_yoga.jpg', 3, 35),
    ('Kit de peinture', 'kit_peinture.jpg', 3, 22),
    ('Appareil photo', 'appareil_photo.jpg', 1, 400),
    ('Coque de téléphone', 'coque_telephone.jpg', 3, 10),
    ('Bougie parfumée', 'bougie_parfumee.jpg', 3, 15),
    ('Robe', 'robe.jpg', 2, 50),
    ('Puzzle', 'puzzle.jpg', 3, 20),
    ('Écouteurs', 'ecouteurs.jpg', 1, 30),
    ('Bracelet', 'bracelet.jpg', 2, 35),
    ('Livre de recettes', 'livre_recettes.jpg', 3, 18),
    ('Jeux vidéo', 'jeux_video.jpg', 1, 60),
    ('Trousse de maquillage', 'trousse_maquillage.jpg', 2, 40),
    ('Boîte à bijoux', 'boite_bijoux.jpg', 3, 35),
    ('Cafetière', 'cafeiere.jpg', 3, 90),
    ('Porte-monnaie', 'porte_monnaie.jpg', 2, 25),
    ('Clavier mécanique', 'clavier_mecanique.jpg', 1, 70),
    ('Lampe décorative', 'lampe_decorative.jpg', 3, 50),
    ('Ballon de football', 'ballon_football.jpg', 3, 25),
    ('Collier', 'collier.jpg', 2, 55),
    ('Trottinette électrique', 'trottinette.jpg', 1, 300),
    ('Figurine', 'figurine.jpg', 3, 20),
    ('Livre pour enfants', 'livre_enfants.jpg', 3, 15),
    ('Planche de skateboard', 'skateboard.jpg', 3, 100);