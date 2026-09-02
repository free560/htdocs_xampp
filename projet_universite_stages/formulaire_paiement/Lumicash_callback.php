<?php
/**
 * CALLBACK / WEBHOOK LUMICASH
 * ============================
 * C'est LumiCash (le serveur de Lumitel) qui appelle CETTE URL de son propre
 * serveur vers le vôtre, pour vous prévenir qu'un paiement a bien été reçu
 * (ou a échoué). Ce n'est PAS appelé par votre formulaire JS.
 *
 * Il faudra donner cette URL à Lumitel lors de la configuration de votre
 * compte marchand, ex : https://votre-domaine.bi/club/lumicash-callback.php
 * (Lumitel ne peut pas appeler "localhost" — pour tester ce fichier en
 * conditions réelles, il faudra un nom de domaine public ou un tunnel
 * comme ngrok pendant les tests.)
 *
 * TODO : adapter la vérification de signature et les noms de champs dès
 * que vous aurez la documentation officielle Lumitel.
 */

header('Content-Type: application/json; charset=utf-8');
require __DIR__ . '/config/db.php'; // votre connexion PDO habituelle

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

error_log('Callback LumiCash reçu : ' . $raw); // utile pour voir le vrai format pendant les tests

// TODO : vérifier une signature/HMAC si Lumitel en fournit une, pour être sûr
// que l'appel vient bien d'eux et pas d'un tiers malveillant qui devinerait l'URL.

$reference = $data['reference'] ?? null;
$statut    = $data['status'] ?? null; // TODO : vraies valeurs possibles (ex: 'SUCCESS', 'FAILED')

if (!$reference || !$statut) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Payload invalide']);
    exit;
}

// Exemple de mise à jour en base — adaptez la table/les colonnes à votre schéma club
try {
    $stmt = $pdo->prepare("UPDATE paiements SET statut = ? WHERE reference = ?");
    $stmt->execute([$statut, $reference]);
} catch (PDOException $e) {
    error_log('Erreur mise à jour paiement : ' . $e->getMessage());
}

// Répondre 200 pour que Lumitel sache que le callback a bien été reçu
echo json_encode(['success' => true]);