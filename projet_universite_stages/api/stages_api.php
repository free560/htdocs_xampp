<?php
/**
 * API - STAGES
 * - App2 envoie (POST) les infos de stage vers cette API -> écriture dans stages_gestion.stages
 * - App1 peut lire (GET) la liste des stages, ou les stages d'un étudiant précis (par matricule)
 *
 * Exemples :
 *   GET  /api/stages_api.php                        -> liste de tous les stages
 *   GET  /api/stages_api.php?matricule=E001          -> stages d'un étudiant précis
 *   POST /api/stages_api.php  (JSON body)           -> créer un stage
 */

require __DIR__ . '/config_db.php';

$method = $_SERVER['REQUEST_METHOD'];
$pdo = getStagesDB();

if ($method === 'GET') {

    if (isset($_GET['matricule'])) {
        $stmt = $pdo->prepare("SELECT s.*, ent.nom_entreprise
                                FROM stages s
                                JOIN entreprises ent ON ent.id_entreprise = s.id_entreprise
                                WHERE s.matricule_etudiant = ?
                                ORDER BY s.date_debut DESC");
        $stmt->execute([$_GET['matricule']]);
        jsonResponse(['success' => true, 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    }

    $sql = "SELECT s.*, ent.nom_entreprise
            FROM stages s
            JOIN entreprises ent ON ent.id_entreprise = s.id_entreprise
            ORDER BY s.id_stage DESC";
    $stmt = $pdo->query($sql);
    jsonResponse(['success' => true, 'data' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);

} elseif ($method === 'POST') {

    $body = getJsonBody();
    $required = ['matricule_etudiant', 'id_entreprise', 'date_debut', 'date_fin'];
    foreach ($required as $champ) {
        if (empty($body[$champ])) {
            jsonResponse(['success' => false, 'message' => "Champ requis manquant : $champ"], 400);
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO stages
            (matricule_etudiant, nom_etudiant_cache, id_entreprise, id_encadreur, theme_stage, date_debut, date_fin, statut)
            VALUES (?,?,?,?,?,?,?,?)");
        $stmt->execute([
            $body['matricule_etudiant'],
            $body['nom_etudiant_cache'] ?? null,
            $body['id_entreprise'],
            $body['id_encadreur'] ?? null,
            $body['theme_stage'] ?? null,
            $body['date_debut'],
            $body['date_fin'],
            $body['statut'] ?? 'planifie',
        ]);
        jsonResponse(['success' => true, 'id_stage' => $pdo->lastInsertId()], 201);
    } catch (PDOException $e) {
        jsonResponse(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()], 500);
    }

} else {
    jsonResponse(['success' => false, 'message' => 'Méthode non supportée'], 405);
}
