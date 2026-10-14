CREATE DATABASE IF NOT EXISTS hacking_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE hacking_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    adresse VARCHAR(255),
    date_naissance DATE,
    num_securite_sociale VARCHAR(32)
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100),
    sujet VARCHAR(150),
    message TEXT,
    date_envoi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Données 100 % fictives réservées au laboratoire.
INSERT INTO users (username, password, role, adresse, date_naissance, num_securite_sociale) VALUES
('admin', 'admin_super_secret', 'admin', '1 rue de la Paix, Paris', '1980-05-12', '1 80 05 75 000 001'),
('user', 'motdepasse', 'user', '10 avenue des Champs, Paris', '2000-01-01', '1 00 01 75 123 456'),
('pdg', 'boss2024', 'user', '15 avenue de la République, Lyon', '1975-11-22', '1 75 11 69 999 888'),
('maxence', 'User123!', 'user', '24 rue du Laboratoire, Bordeaux', '2002-03-14', '1 02 03 33 111 222');

INSERT INTO messages (nom, email, sujet, message) VALUES
('Client Test', 'test@test.local', 'Question', 'Bonjour, ceci est un message normal.'),
('Utilisateur Démo', 'demo@test.local', 'Support', 'Pouvez-vous vérifier mon compte ?');
