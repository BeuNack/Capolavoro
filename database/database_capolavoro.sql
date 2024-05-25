DROP DATABASE IF EXISTS Capolavoro_DM;
CREATE DATABASE IF NOT EXISTS CapolavoroDM;
USE CapolavoroDM;

CREATE TABLE Utenti (
    Username VARCHAR(50) PRIMARY KEY,
    Password VARCHAR(50),
    Nome VARCHAR(50),
    Cognome VARCHAR(50) 
);

CREATE TABLE Libro (
    ISBN INT(13),
	Username VARCHAR(50),
    StatoLettura VARCHAR(50),
    PRIMARY KEY (ISBN,Username),
	FOREIGN KEY (Username) REFERENCES Utenti(Username)
);

