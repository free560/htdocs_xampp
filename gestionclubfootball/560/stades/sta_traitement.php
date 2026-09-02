<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom_stade = mysqli_real_escape_string($conn, trim($_POST['nom_stade']));
    $adresse   = mysqli_real_escape_string($conn, trim($_POST['adresse']));
    $capacite  = intval($_POST['capacite']);

    // ✅ Vérifier que le nom du stade n'est pas vide
    if (empty($nom_stade)) {
        echo "Le nom du stade est obligatoire.";
        exit();
    }

    // ✅ Vérifier que la capacité est positive
    if ($capacite <= 0) {
        echo "La capacité doit être supérieure à 0.";
        exit();
    }

    $sql = "INSERT INTO stades(
        nom_stade, adresse, capacite
    ) VALUES (
        '$nom_stade', '$adresse', '$capacite'
    )";

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