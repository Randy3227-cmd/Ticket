-- Création des tables
CREATE TABLE Alimentation (
    idAlimentation INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idAnimaux INT(11) NOT NULL,
    pourcentageGain DECIMAL(10,2) NOT NULL,
    aliment VARCHAR(255) NOT NULL,
    prix INT(11) NOT NULL,
    imageAlimentation varchar(200)
);

CREATE TABLE AchatAlimentation (
    idAchat INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idAlimentation INT(11) NOT NULL,
    quantite INT(11) NOT NULL,
    dateAchat date,
    FOREIGN KEY (idAlimentation) REFERENCES Alimentation(idAlimentation)
);

CREATE TABLE Animaux (
    idAnimaux INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    animal VARCHAR(255) NOT NULL,
    poidsMin DECIMAL(10,2) NOT NULL,
    poidsMax DECIMAL(10,2) NOT NULL,
    prixVenteParKg INT(11) NOT NULL,
    nbJourSansMangerAvantMourir INT(11) NOT NULL,
    pourcentagePertePoidsParJour DECIMAL(10,2) NOT NULL,
    poidsInitial DECIMAL(10,2) NOT NULL,
    imageAnimaux varchar(200)
);

CREATE TABLE animauxAchete (
    idAnimauxAchete INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idAnimaux INT(11) NOT NULL,
    dateAchat date,
    FOREIGN KEY (idAnimaux) REFERENCES Animaux(idAnimaux)
);

CREATE TABLE StockAnimaux (
    idStock INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    idAnimaux INT(11) NOT NULL,
    FOREIGN KEY (idAnimaux) REFERENCES Animaux(idAnimaux)
);

CREATE TABLE Capital (
    valeur INT(11) NOT NULL
);