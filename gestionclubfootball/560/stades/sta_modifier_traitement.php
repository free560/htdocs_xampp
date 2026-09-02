<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id        = intval($_POST['id']);
    $nom_stade = mysqli_real_escape_string($conn, trim($_POST['nom_stade']));
    $adresse   = mysqli_real_escape_string($conn, trim($_POST['adresse']));
    $capacite  = intval($_POST['capacite']);

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($nom_stade)) {
        echo "Le nom du stade est obligatoire.";
        exit();
    }

    $sql = "UPDATE stades SET
        nom_stade = '$nom_stade',
        adresse = '$adresse',
        capacite = '$capacite'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: sta_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>