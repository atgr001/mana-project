CREATE DATABASE serre_db;
USE serre_db;

CREATE TABLE capteurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    humidite FLOAT NOT NULL,
    date_mesure DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE actionneurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    etat BOOLEAN DEFAULT 0
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);

INSERT INTO users (username, password) VALUES ('chef', 'admin123');