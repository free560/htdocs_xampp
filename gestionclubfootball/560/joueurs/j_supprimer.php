<?php
include '../config/db.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: j_lister.php");
    exit();
}

// Vérification que le joueur existe
$check = mysqli_query($conn, "SELECT id FROM joueurs WHERE id = $id");
if (mysqli_num_rows($check) === 0) {
    die("Erreur : joueur introuvable.");
}

// Désactivation : on passe le statut à 'inactif' au lieu de supprimer
$sql = "UPDATE joueurs SET statut = 'inactif' WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: j_lister.php");
    exit();
} else {
    die("Erreur lors de la désactivation : " . mysqli_error($conn));
}
?>