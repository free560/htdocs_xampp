-- ===========================================
-- Application 2 : GESTION DES STAGES
-- Base de données : stages_gestion
-- ===========================================

CREATE DATABASE IF NOT EXISTS stages_gestion CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE stages_gestion;

-- Table 1 : entreprises
CREATE TABLE entreprises (
    id_entreprise INT AUTO_INCREMENT PRIMARY KEY,
    nom_entreprise VARCHAR(150) NOT NULL,
    secteur_activite VARCHAR(100),
    adresse VARCHAR(255),
    ville VARCHAR(100),
    telephone VARCHAR(30),
    email VARCHAR(150),
    date_ajout TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 2 : encadreurs (encadreurs professionnels au sein de l'entreprise)
CREATE TABLE encadreurs (
    id_encadreur INT AUTO_INCREMENT PRIMARY KEY,
    id_entreprise INT NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    fonction VARCHAR(100),
    email VARCHAR(150),
    telephone VARCHAR(30),
    FOREIGN KEY (id_entreprise) REFERENCES entreprises(id_entreprise) ON DELETE CASCADE
);

-- Table 3 : stages
-- NOTE : id_etudiant ne référence PAS une table locale (l'étudiant vit dans l'appli 1).
-- On stocke matricule_etudiant (identifiant partagé) obtenu via l'API de l'application 1.
CREATE TABLE stages (
    id_stage INT AUTO_INCREMENT PRIMARY KEY,
    matricule_etudiant VARCHAR(30) NOT NULL,   -- vient de l'API app1 (etudiants.matricule)
    nom_etudiant_cache VARCHAR(150),           -- copie locale du nom (mise à jour via API, évite un appel à chaque affichage)
    id_entreprise INT NOT NULL,
    id_encadreur INT,
    theme_stage VARCHAR(255),
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    statut ENUM('planifie','en_cours','termine','abandonne') DEFAULT 'planifie',
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_entreprise) REFERENCES entreprises(id_entreprise) ON DELETE CASCADE,
    FOREIGN KEY (id_encadreur) REFERENCES encadreurs(id_encadreur) ON DELETE SET NULL
);

-- Table 4 : evaluations
CREATE TABLE evaluations (
    id_evaluation INT AUTO_INCREMENT PRIMARY KEY,
    id_stage INT NOT NULL,
    note_encadreur DECIMAL(4,2),      -- note donnée par l'encadreur professionnel
    note_soutenance DECIMAL(4,2),     -- note de soutenance académique
    commentaire TEXT,
    date_evaluation DATE,
    FOREIGN KEY (id_stage) REFERENCES stages(id_stage) ON DELETE CASCADE
);
