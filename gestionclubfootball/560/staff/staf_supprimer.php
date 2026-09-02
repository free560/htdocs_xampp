<?php
include '../config/db.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: staf_lister.php");
    exit();
}

// Vérification que le membre du staff existe
$check = mysqli_query($conn, "SELECT id FROM staff WHERE id = $id");
if (mysqli_num_rows($check) === 0) {
    die("Erreur : membre du staff introuvable.");
}

// Suppression définitive (pas de colonne "statut" sur la table staff)
$sql = "DELETE FROM staff WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: staf_lister.php");
    exit();
} else {
    die("Erreur lors de la suppression : " . mysqli_error($conn));
}
?>