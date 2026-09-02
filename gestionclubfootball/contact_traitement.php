<?php
session_start();
require_once 'config/db.php';


if (!empty($_POST['website'])) {
    header("Location: contact_nous.php?status=erreur");
    exit;
}

$champs = ['nom', 'email', 'sujet', 'priorite', 'message'];
foreach ($champs as $champ) {
    if (empty(trim($_POST[$champ]))) {
        header("Location: contact_nous.php?status=erreur");
        exit;
    }
}

$nom      = trim($_POST['nom']);
$email    = trim($_POST['email']);
$sujet    = trim($_POST['sujet']);
$priorite = $_POST['priorite'];
$message  = trim($_POST['message']);


if (!in_array($priorite, ['legere', 'moyenne', 'grave'])) {
    header("Location: contact_nous.php?status=erreur");
    exit;
}

$stmt = $conn->prepare(
    "INSERT INTO contact_messages (nom, email, sujet, priorite, message, statut, created_at)
     VALUES (?, ?, ?, ?, ?, 'non_lu', NOW())"
);
$stmt->bind_param("sssss", $nom, $email, $sujet, $priorite, $message);
$ok = $stmt->execute();
$stmt->close();

header($ok
    ? "Location: contact_nous.php?status=ok"
    : "Location: contact_nous.php?status=erreur"
);
exit;