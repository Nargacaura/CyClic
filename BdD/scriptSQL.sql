

CREATE DATABASE IF NOT EXISTS Cyclic;

USE Cyclic;

CREATE TABLE IF NOT EXISTS Categorie(
idCategorie INT AUTO_INCREMENT,
nom VARCHAR(50),
PRIMARY KEY(idCategorie)
);
  

CREATE TABLE IF NOT EXISTS Etat(
idEtat INT AUTO_INCREMENT,
nom VARCHAR(50),
PRIMARY KEY(idEtat)
);
  

CREATE TABLE IF NOT EXISTS StatutEchange(
idStatut INT AUTO_INCREMENT,
nom VARCHAR(50),
PRIMARY KEY(idStatut)
);
  

CREATE TABLE IF NOT EXISTS Utilisateur(
idUtilisateur INT AUTO_INCREMENT,
pseudo VARCHAR(50),
motDePasse VARCHAR(255),
email VARCHAR(100),
nom VARCHAR(50),
prenom VARCHAR(50),
dateNaissance DATE,
checkMail BOOLEAN,
moderateur BOOLEAN,
PRIMARY KEY(idUtilisateur)
);
  

CREATE TABLE IF NOT EXISTS Localisation(
idLocalisation INT AUTO_INCREMENT,
ville VARCHAR(100),
codePostal VARCHAR(5),
rue VARCHAR(100),
idUtilisateur INT NOT NULL,
PRIMARY KEY(idLocalisation),
FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
);
  

CREATE TABLE IF NOT EXISTS Annonce(
idAnnonce INT AUTO_INCREMENT,
titre VARCHAR(50),
dateAnnonce DATETIME,
contenu TEXT,
idStatut INT NOT NULL,
idCategorie INT NOT NULL,
idEtat INT NOT NULL,
idLocalisation INT NOT NULL,
idUtilisateur INT NOT NULL,
PRIMARY KEY(idAnnonce),
FOREIGN KEY(idStatut) REFERENCES StatutEchange(idStatut),
FOREIGN KEY(idCategorie) REFERENCES Categorie(idCategorie),
FOREIGN KEY(idEtat) REFERENCES Etat(idEtat),
FOREIGN KEY(idLocalisation) REFERENCES Localisation(idLocalisation),
FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
);
  

CREATE TABLE IF NOT EXISTS Photo(
idPhoto INT AUTO_INCREMENT,
path VARCHAR(255),
idAnnonce INT NOT NULL,
PRIMARY KEY(idPhoto),
FOREIGN KEY(idAnnonce) REFERENCES Annonce(idAnnonce)
);
  

CREATE TABLE IF NOT EXISTS Message(
idMessage INT AUTO_INCREMENT,
dateMessage DATETIME NOT NULL,
contenu TEXT,
idUtilisateur INT NOT NULL,
idAnnonce INT NOT NULL,
idUtilisateur_1 INT NOT NULL,
PRIMARY KEY(idMessage),
FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur),
FOREIGN KEY(idAnnonce) REFERENCES Annonce(idAnnonce),
FOREIGN KEY(idUtilisateur_1) REFERENCES Utilisateur(idUtilisateur)
);
  

CREATE TABLE IF NOT EXISTS noteUtilisateur(
idUtilisateur INT,
idUtilisateur_1 INT,
note INT,
PRIMARY KEY(idUtilisateur, idUtilisateur_1),
FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur),
FOREIGN KEY(idUtilisateur_1) REFERENCES Utilisateur(idUtilisateur)
);
  

