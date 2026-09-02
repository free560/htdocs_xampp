<?php
include '../config/db.php';

// Vérification méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: pa_lister.php');
    exit;
}

// Récupération et nettoyage des données
$id             = isset($_POST['id'])             ? intval($_POST['id'])             : 0;
$match_id       = isset($_POST['match_id'])       ? intval($_POST['match_id'])       : 0;
$joueur_id      = isset($_POST['joueur_id'])      ? intval($_POST['joueur_id'])      : 0;
$titulaire      = isset($_POST['titulaire'])      ? intval($_POST['titulaire'])      : 0;
$minutes_jouees = isset($_POST['minutes_jouees']) ? intval($_POST['minutes_jouees']) : 0;

// Validation
if ($id <= 0 || $match_id <= 0 || $joueur_id <= 0 || $minutes_jouees < 0 || $minutes_jouees > 120) {
    header('Location: pa_modifier.php?id=' . $id . '&erreur=1');
    exit;
}

// Mise à jour
$stmt = $conn->prepare(
    "UPDATE participations_match
     SET match_id = ?, joueur_id = ?, titulaire = ?, minutes_jouees = ?
     WHERE id = ?"
);
$stmt->bind_param("iiiii", $match_id, $joueur_id, $titulaire, $minutes_jouees, $id);

if ($stmt->execute()) {
    header('Location: pa_lister.php?success=1');
} else {
    header('Location: pa_modifier.php?id=' . $id . '&erreur=1');
}

$stmt->close();
$conn->close();
exit;
?>