-- Création des tables

CREATE TABLE Departement(
    idDepartement INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    departement VARCHAR(255)
);

CREATE TABLE Categorie (
    idCategorie INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    categorieName VARCHAR(255) NOT NULL
);

CREATE TABLE Type (
    idType INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    typeName VARCHAR(255) NOT NULL,
    idCategorie INT(11) REFERENCES Categorie(idCategorie)
);

CREATE TABLE SoldeDebut (
    idSolde INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    dateSolde date, 
    valeur INT,
    idDepartement INT REFERENCES Departement(idDepartement)
);

CREATE TABLE Rubrique (
    idRubrique INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    rubrique VARCHAR(255)
);

CREATE TABLE Prevision (
    idPrevision INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    datePrevision date,
    montant INT,
    idType INT REFERENCES Type(idType),
    idRubrique INT REFERENCES Rubrique(idRubrique),
    idDepartement INT REFERENCES Departement(idDepartement)
);

CREATE TABLE Realisation(
    idRealisation INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    dateRealisation date,
    montant INT,
    idType INT REFERENCES Type(idType),
    idRubrique INT REFERENCES Rubrique(idRubrique),
    idDepartement INT REFERENCES Departement(idDepartement)
);

CREATE TABLE demandeFinance(
    idDemandeFinance INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    dateDemande date,
    dateAcceptation date,
    argentManque INT
);