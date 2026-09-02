<?php
// L'API a besoin d'accéder aux DEUX bases pour faire le pont entre les deux applications.
header('Content-Type: application/json; charset=utf-8');
// Autoriser les appels cross-origin depuis les deux applications (à restreindre en prod)
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

function getUnivDB() {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO("mysql:host=localhost;dbname=univ_gestion;charset=utf8mb4", 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $pdo;
}

function getStagesDB() {
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO("mysql:host=localhost;dbname=stages_gestion;charset=utf8mb4", 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return $pdo;
}

function jsonResponse($data, $code = 200) {
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function getJsonBody() {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    return $data ?: [];
}
