<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $equipe_id         = (int) $_POST['equipe_id'];
    $date_entrainement = mysqli_real_escape_string($conn, $_POST['date_entrainement']);
    $lieu              = mysqli_real_escape_string($conn, $_POST['lieu']);
    $description       = mysqli_real_escape_string($conn, $_POST['description']);


    if ($equipe_id <= 0) {
        die("Erreur : veuillez choisir une équipe.");
    }


    if (empty($date_entrainement)) {
        die("Erreur : veuillez indiquer une date d'entraînement.");
    }

    
    if (empty($lieu)) {
        die("Erreur : veuillez indiquer le lieu de l'entraînement.");
    }


    $sql = "INSERT INTO entrainements (equipe_id, date_entrainement, lieu, description) 
            VALUES ($equipe_id, '$date_entrainement', '$lieu', '$description')";

    if (mysqli_query($conn, $sql)) {
        header("Location: e_lister.php");
        exit();
    } else {
        die("Erreur lors de l'enregistrement : " . mysqli_error($conn));
    }

} else {
    header("Location: e_ajouter.php");
    exit();
}
?>