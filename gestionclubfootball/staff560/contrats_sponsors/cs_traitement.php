<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sponsor_id = intval($_POST['sponsor_id']);
    $montant    = floatval($_POST['montant']);
    $date_debut = mysqli_real_escape_string($conn, $_POST['date_debut']);
    $date_fin   = mysqli_real_escape_string($conn, $_POST['date_fin']);


    if (empty($sponsor_id)) {
        echo "Veuillez choisir un sponsor.";
        exit();
    }

   
    if ($date_fin <= $date_debut) {
        echo "La date de fin doit être après la date de début.";
        exit();
    }


    if ($montant <= 0) {
        echo "Le montant doit être supérieur à 0.";
        exit();
    }

    $sql = "INSERT INTO contrats_sponsors(
        sponsor_id, montant, date_debut, date_fin
    ) VALUES (
        '$sponsor_id', '$montant', '$date_debut', '$date_fin'
    )";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: cs_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>