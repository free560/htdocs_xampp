<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $entrainement_id = intval($_POST['entrainement_id']);
    $joueur_id        = intval($_POST['joueur_id']);
    $statut           = mysqli_real_escape_string($conn, $_POST['statut']);

   
    if (empty($entrainement_id)) {
        echo "Veuillez choisir un entraînement.";
        exit();
    }

    if (empty($joueur_id)) {
        echo "Veuillez choisir un joueur.";
        exit();
    }

    if (empty($statut)) {
        echo "Veuillez choisir un statut.";
        exit();
    }

    $sql = "INSERT INTO presences_entrainement(
        entrainement_id, joueur_id, statut
    ) VALUES (
        '$entrainement_id', '$joueur_id', '$statut'
    )";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: pre_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>