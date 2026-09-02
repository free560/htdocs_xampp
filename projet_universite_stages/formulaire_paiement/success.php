<?php
require __DIR__ . '/vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_VOTRE_CLE_SECRETE_STRIPE');

$sessionId = $_GET['session_id'] ?? null;
$session = $sessionId ? \Stripe\Checkout\Session::retrieve($sessionId) : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Paiement réussi</title><link rel="stylesheet" href="../app1_universite/style.css"></head>
<body>
<h1>✅ Paiement réussi</h1>
<?php if ($session): ?>
<p>Merci <?= htmlspecialchars($session->metadata->nom_complet ?? '') ?>, votre paiement a bien été reçu.</p>
<p>Pays : <?= htmlspecialchars($session->metadata->pays ?? '') ?></p>
<?php else: ?>
<p>Paiement confirmé.</p>
<?php endif; ?>
</body>
</html>
