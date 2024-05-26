DROP DATABASE IF EXISTS capolavoro;

CREATE DATABASE capolavoro;

use capolavoro;

CREATE TABLE utenti(
    nome VARCHAR(50),
    cognome VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(600),

    PRIMARY KEY (email)
);	

CREATE TABLE libreria(
    isbn VARCHAR(13),
    email VARCHAR(50),

    PRIMARY KEY (isbn,email),
    FOREIGN KEY (email) REFERENCES utenti(email)
)