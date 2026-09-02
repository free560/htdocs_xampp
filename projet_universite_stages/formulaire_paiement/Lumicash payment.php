<?php
/**
 * BACKEND LUMICASH — SQUELETTE À COMPLÉTER
 * ==========================================
 * Ce fichier reproduit le flux standard des API mobile money :
 *   1) Le client (formulaire) envoie payerName, phoneNumber, amount, reason
 *   2) On demande à LumiCash de déclencher un push USSD / OTP vers ce numéro
 *   3) Le client saisit le code OTP reçu par SMS et le renvoie
 *   4) On confirme la transaction auprès de LumiCash avec cet OTP
 *   5) LumiCash appelle ensuite votre callback (lumicash-callback.php) pour
 *      confirmer que l'argent est bien arrivé
 *
 * TOUT CE QUI EST MARQUÉ "TODO" doit être remplacé par les vraies valeurs
 * fournies par Lumitel une fois votre compte marchand LumiCash activé.
 * Sans ces valeurs, ce fichier ne peut pas fonctionner — c'est normal.
 */

header('Content-Type: application/json; charset=utf-8');

// ==========================================
// CONFIGURATION — à remplacer par les vraies valeurs Lumitel
// ==========================================
define('LUMICASH_BASE_URL', 'https://TODO-url-fournie-par-lumitel.bi/api'); // TODO
define('LUMICASH_MERCHANT_ID', 'TODO_MERCHANT_ID');                        // TODO
define('LUMICASH_API_KEY', 'TODO_CLE_API');                                // TODO
define('LUMICASH_SECRET', 'TODO_SECRET');                                  // TODO
// Certaines API mobile money signent chaque requête (HMAC). Si Lumitel l'exige,
// on ajoutera une fonction signerRequete() ici une fois le format connu.

// ==========================================
// Fonctions d'appel HTTP génériques
// ==========================================
function lumicashRequest($endpoint, array $data) {
    $ch = curl_init(LUMICASH_BASE_URL . $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . LUMICASH_API_KEY, // TODO : format exact à confirmer avec Lumitel
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);

    $raw = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($raw === false) {
        return ['ok' => false, 'message' => 'Erreur réseau : ' . $curlError];
    }

    $json = json_decode($raw, true);
    if ($json === null) {
        // La réponse n'est pas du JSON valide : très utile à logger pendant les tests
        error_log('Réponse LumiCash non-JSON (' . $httpCode . ') : ' . $raw);
        return ['ok' => false, 'message' => 'Réponse LumiCash invalide (voir logs PHP)'];
    }

    return ['ok' => $httpCode >= 200 && $httpCode < 300, 'code' => $httpCode, 'data' => $json];
}

// ==========================================
// ÉTAPE 1 : demander le push / OTP
// ==========================================
function demanderPaiement($payerName, $phoneNumber, $amount, $reason) {
    // TODO : adapter les noms de champs exacts attendus par LumiCash
    // (merchantId, msisdn, amount... les vrais noms viendront de leur doc)
    $payload = [
        'merchantId'  => LUMICASH_MERCHANT_ID,
        'msisdn'      => $phoneNumber,     // numéro du payeur, format à confirmer (avec/sans indicatif 257)
        'amount'      => $amount,
        'currency'    => 'BIF',
        'reference'   => 'CLUB-' . time(), // référence unique pour retrouver la transaction
        'description' => $reason . ' - ' . $payerName,
    ];

    return lumicashRequest('/payment/request', $payload); // TODO : vrai endpoint
}

// ==========================================
// ÉTAPE 2 : confirmer avec l'OTP reçu par SMS
// ==========================================
function confirmerAvecOtp($reference, $otp) {
    $payload = [
        'merchantId' => LUMICASH_MERCHANT_ID,
        'reference'  => $reference,
        'otp'        => $otp,
    ];

    return lumicashRequest('/payment/confirm', $payload); // TODO : vrai endpoint
}

// ==========================================
// ROUTAGE DE LA REQUÊTE ENTRANTE (venant du formulaire JS)
// ==========================================
$body = json_decode(file_get_contents('php://input'), true) ?: [];
$etape = $body['etape'] ?? 'demande'; // 'demande' ou 'confirmation'

if ($etape === 'demande') {

    $payerName   = trim($body['payerName'] ?? '');
    $phoneNumber = trim($body['phoneNumber'] ?? '');
    $amount      = (float)($body['amount'] ?? 0);
    $reason      = $body['reason'] ?? 'autre';

    if (!$payerName || !$phoneNumber || $amount <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Champs manquants ou montant invalide.']);
        exit;
    }

    $resultat = demanderPaiement($payerName, $phoneNumber, $amount, $reason);

    if ($resultat['ok']) {
        echo json_encode([
            'success'   => true,
            'message'   => 'Code envoyé par SMS. Veuillez le saisir pour confirmer.',
            'reference' => $resultat['data']['reference'] ?? null, // TODO : vrai nom de champ retourné
            'etape_suivante' => 'confirmation',
        ]);
    } else {
        http_response_code(502);
        echo json_encode(['success' => false, 'message' => $resultat['message'] ?? 'Échec de la demande LumiCash.']);
    }

} elseif ($etape === 'confirmation') {

    $reference = $body['reference'] ?? '';
    $otp       = $body['otp'] ?? '';

    if (!$reference || !$otp) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Référence ou code OTP manquant.']);
        exit;
    }

    $resultat = confirmerAvecOtp($reference, $otp);

    if ($resultat['ok']) {
        echo json_encode(['success' => true, 'message' => 'Paiement confirmé avec succès.']);
    } else {
        http_response_code(502);
        echo json_encode(['success' => false, 'message' => $resultat['message'] ?? 'Échec de la confirmation.']);
    }

} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Étape inconnue.']);
}