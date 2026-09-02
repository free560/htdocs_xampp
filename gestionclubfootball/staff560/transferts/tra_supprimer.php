<?php
include '../config/db.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: tra_lister.php");
    exit();
}

// Vérification que le transfert existe
$check = mysqli_query($conn, "SELECT id FROM transferts WHERE id = $id");
if (mysqli_num_rows($check) === 0) {
    die("Erreur : transfert introuvable.");
}

// Suppression définitive (pas de notion de statut pour les transferts)
$sql = "DELETE FROM transferts WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: tra_lister.php");
    exit();
} else {
    die("Erreur lors de la suppression : " . mysqli_error($conn));
}
?>