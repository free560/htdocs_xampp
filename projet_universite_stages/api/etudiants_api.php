<?php
/**
 * API - ETUDIANTS
 * - App1 envoie (POST) les infos étudiant vers cette API -> écriture dans univ_gestion.etudiants
 * - App2 (ou App1) peut lire (GET) la liste des étudiants ou un étudiant précis via matricule
 *
 * Exemples :
 *   GET  /api/etudiants_api.php                -> liste de tous les étudiants
 *   GET  /api/etudiants_api.php?matricule=E001 -> un étudiant précis
 *   POST /api/etudiants_api.php  (JSON body)   -> créer un étudiant
 */

require __DIR__ . '/config_db.php';

$method = $_SERVER['REQUEST_METHOD'];
$pdo = getUnivDB();

if ($method === 'GET') {

    if (isset($_GET['matricule'])) {
        $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE matricule = ?");
        $stmt->execute([$_GET['matricule']]);
        $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$etudiant) {
            jsonResponse(['success' => false, 'message' => 'Étudiant introuvable'], 404);
        }
        jsonResponse(['success' => true, 'data' => $etudiant]);
    }

    // Liste complète (avec la formation si inscrit)
    $sql = "SELECT e.*, f.nom_formation
            FROM etudiants e
            LEFT JOIN inscriptions i ON i.id_etudiant = e.id_etudiant
            LEFT JOIN formations f ON f.id_formation = i.id_formation
            ORDER BY e.id_etudiant DESC";
    $stmt = $pdo->query($sql);
    jsonResponse(['success' => true, 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);

} elseif ($method === 'POST') {

    $body = getJsonBody();
    $required = ['matricule', 'nom', 'prenom', 'email', 'sexe'];
    foreach ($required as $champ) {
        if (empty($body[$champ])) {
            jsonResponse(['success' => false, 'message' => "Champ requis manquant : $champ"], 400);
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO etudiants
            (matricule, nom, prenom, email, telephone, date_naissance, sexe, adresse)
            VALUES (?,?,?,?,?,?,?,?)");
        $stmt->execute([
            $body['matricule'],
            $body['nom'],
            $body['prenom'],
            $body['email'],
            $body['telephone'] ?? null,
            $body['date_naissance'] ?? null,
            $body['sexe'],
            $body['adresse'] ?? null,
        ]);
        jsonResponse(['success' => true, 'id_etudiant' => $pdo->lastInsertId()], 201);
    } catch (PDOException $e) {
        jsonResponse(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
    }

} else {
    jsonResponse(['success' => false, 'message' => 'Méthode non supportée'], 405);
}
