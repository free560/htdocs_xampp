<?php
include '../config/db.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: sp_lister.php");
    exit();
}

// Vérification que le sponsor existe
$check = mysqli_query($conn, "SELECT id FROM sponsors WHERE id = $id");
if (mysqli_num_rows($check) === 0) {
    die("Erreur : sponsor introuvable.");
}

// Suppression définitive (pas de notion de compte ou de statut pour les sponsors)
$sql = "DELETE FROM sponsors WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: sp_lister.php");
    exit();
} else {
    die("Erreur lors de la suppression : " . mysqli_error($conn));
}
?>