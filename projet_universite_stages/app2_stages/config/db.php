<?php
// Connexion à la base de données de l'application 2 (Gestion des stages)

$host = 'localhost';
$dbname = 'stages_gestion';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Adresse de base de l'API (voir dossier /api)
// define('API_BASE_URL', 'http://localhost/api');
