CREATE DATABASE IF NOT EXISTS CapolavoroDM_Users;
USE CapolavoroDM_Users;
/*
CREATE TABLE Libreria {
    CodiceLibreria INT PRIMARY KEY AUTO_INCREMENT,
}

CREATE TABLE Libro {
    ISBN INT(13) PRIMARY KEY,
    Titolo VARCHAR(50),
    Autore VARCHAR(50),
    Descrizione VARCHAR(50),
    Genere VARCHAR(50),
    Editore VARCHAR(50)
}

CREATE TABLE LibreriaLibro {
    CodiceLibreria INT,
    ISBN INT(13),
    FOREIGN KEY (CodiceLibreria) ON Libreria(CodiceLibreria),
    FOREIGN KEY (ISBN) ON Libro(ISBN),
}
*/
CREATE TABLE Users {
    Username VARCHAR(50) PRIMARY KEY,
    Password VARCHAR(50)
}
