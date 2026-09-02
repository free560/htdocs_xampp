-- ===========================================
-- Application 1 : GESTION UNIVERSITAIRE
-- Base de données : univ_gestion
-- ===========================================

CREATE DATABASE IF NOT EXISTS univ_gestion CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE univ_gestion;

-- Table 1 : formations (créée avant etudiants/inscriptions à cause des clés étrangères)
CREATE TABLE formations (
    id_formation INT AUTO_INCREMENT PRIMARY KEY,
    nom_formation VARCHAR(150) NOT NULL,
    niveau VARCHAR(50) NOT NULL,          -- ex: Bac1, Bac2, Bac3
    duree_annees INT DEFAULT 3,
    description TEXT,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 2 : etudiants
CREATE TABLE etudiants (
    id_etudiant INT AUTO_INCREMENT PRIMARY KEY,
    matricule VARCHAR(30) NOT NULL UNIQUE,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telephone VARCHAR(30),
    date_naissance DATE,
    sexe ENUM('M','F') NOT NULL,
    adresse VARCHAR(255),
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 3 : inscriptions (relie etudiants <-> formations)
CREATE TABLE inscriptions (
    id_inscription INT AUTO_INCREMENT PRIMARY KEY,
    id_etudiant INT NOT NULL,
    id_formation INT NOT NULL,
    annee_academique VARCHAR(20) NOT NULL,   -- ex: 2025-2026
    statut ENUM('en_cours','validee','annulee') DEFAULT 'en_cours',
    date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_etudiant) REFERENCES etudiants(id_etudiant) ON DELETE CASCADE,
    FOREIGN KEY (id_formation) REFERENCES formations(id_formation) ON DELETE CASCADE
);

-- Quelques données de test
INSERT INTO formations (nom_formation, niveau, duree_annees, description) VALUES
('Génie Logiciel', 'Bac3', 3, 'Formation en développement logiciel'),
('Réseaux et Télécoms', 'Bac3', 3, 'Formation en réseaux informatiques'),
('Technologie Multimédia', 'Bac2', 3, 'Formation en multimédia et web');
