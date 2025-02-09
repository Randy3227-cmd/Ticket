
-- Insertion de données de test

INSERT INTO Alimentation (idAlimentation, idAnimaux, pourcentageGain, aliment, prix, imageAlimentation) VALUES
(1, 1, 10.50, 'ble', 500, 'ble.jpg'),
(2, 2, 8.75, 'carotte', 300, 'carotte.jpg'),
(3, 3, 12.30, 'feuille', 200, 'feuille.jpg'),
(4, 4, 15.00, 'herbe', 150, 'herbe.jpg'),
(5, 5, 20.25, 'insecte', 1000, 'insecte.jpg'),
(6, 6, 9.80, 'legume', 350, 'legume.jpg'),
(7, 7, 11.40, 'mais', 400, 'mais.jpg'),
(8, 8, 7.60, 'manioc', 250, 'manioc.jpg'),
(9, 9, 18.90, 'pollen', 600, 'pollen.jpg'),
(10, 10, 13.55, 'riz', 450, 'riz.jpg');

INSERT INTO AchatAlimentation (idAchat, idAlimentation, quantite) VALUES
(1, 1, 50),
(2, 2, 30),
(3, 3, 20);

INSERT INTO Animaux (animal, poidsMin, poidsMax, prixVenteParKg, nbJourSansMangerAvantMourir, 
                     pourcentagePertePoidsParJour, poidsInitial, imageAnimaux)
VALUES 
('Abeille', 0.01, 0.02, 500, 2, 10.00, 0.015, 'abeille.jpeg'),
('Chevre', 15.00, 40.00, 10, 5, 3.50, 25.00, 'chevre.jpg'),
('Cochon', 20.00, 150.00, 8, 7, 4.00, 50.00, 'cochon.jpg'),
('Dinde', 3.00, 15.00, 12, 4, 2.00, 8.00, 'dinde.jpg'),
('Lapin', 1.50, 5.00, 15, 3, 2.50, 2.00, 'lapin.jpg'),
('Poule', 1.20, 2.50, 20, 2, 3.00, 1.80, 'poule.webp'),
('Zebu', 200.00, 400.00, 5, 10, 2.00, 250.00, 'zebu-123rf.jpg'),
('Tilapia', 0.50, 3.00, 25, 3, 1.50, 1.00, 'tilapia.jfif'),
('Canard', 0.30, 2.00, 30, 3, 2.00, 0.75, 'images.jfif');

INSERT INTO StockAnimaux (idStock, idAnimaux) VALUES
(1, 1),
(2, 2),
(3, 3);

INSERT INTO Capital (valeur) VALUES
(100000000);
