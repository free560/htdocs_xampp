<?php
include '../config/db.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: stati_j_lister.php");
    exit();
}


$check = mysqli_query($conn, "SELECT id FROM statistiques_joueurs WHERE id = $id");
if (mysqli_num_rows($check) === 0) {
    die("Erreur : statistique introuvable.");
}


$sql = "DELETE FROM statistiques_joueurs WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: stati_j_lister.php");
    exit();
} else {
    die("Erreur lors de la suppression : " . mysqli_error($conn));
}
?>