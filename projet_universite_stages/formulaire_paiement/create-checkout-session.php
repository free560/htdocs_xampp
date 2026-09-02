<?php
// composer require stripe/stripe-php
require __DIR__ . '/vendor/autoload.php';
header('Content-Type: application/json; charset=utf-8');

\Stripe\Stripe::setApiKey('sk_test_VOTRE_CLE_SECRETE_STRIPE');

$body = json_decode(file_get_contents('php://input'), true);

// Mêmes noms de champs que le formulaire LumiCash : payerName, amount, reason
// + email et country, propres au paiement par carte
$payerName = trim($body['payerName'] ?? '');
$email     = trim($body['email'] ?? '');
$country   = trim($body['country'] ?? '');
$amount    = (float)($body['amount'] ?? 0);
$reason    = $body['reason'] ?? 'autre';

if (!$payerName || !$email || !$country || $amount <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Champs manquants ou montant invalide.']);
    exit;
}

$libellesMotif = [
    'cotisation'  => 'Cotisation',
    'inscription' => 'Inscription',
    'equipement'  => 'Équipement',
    'autre'       => 'Autre',
];

try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'customer_email' => $email,
        'line_items' => [[
            'price_data' => [
                // BIF est accepté par Stripe comme devise "zero-decimal" (comme le JPY) :
                // 5000 = 5 000 BIF, pas 50.00 BIF. Changez en 'usd' si votre compte Stripe
                // (rattaché à un pays supporté par Stripe) ne peut pas régler en BIF.
                'currency' => 'bif',
                'product_data' => [
                    'name' => ($libellesMotif[$reason] ?? 'Paiement') . ' - ' . $payerName,
                ],
                'unit_amount' => (int) round($amount), // BIF = devise zero-decimal, pas de x100
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'metadata' => [
            'payerName' => $payerName,
            'country'   => $country,
            'reason'    => $reason,
        ],
        'success_url' => 'http://localhost/club/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'  => 'http://localhost/club/cancel.php',
    ]);

    echo json_encode(['success' => true, 'url' => $session->url]);

} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}