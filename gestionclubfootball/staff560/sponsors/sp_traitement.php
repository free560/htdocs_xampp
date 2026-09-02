<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = mysqli_real_escape_string($conn, trim($_POST['nom_sponsor']));
    $contact     = mysqli_real_escape_string($conn, trim($_POST['contact']));
    $telephone   = mysqli_real_escape_string($conn, trim($_POST['telephone']));
    $email       = mysqli_real_escape_string($conn, trim($_POST['email']));

 
    if (empty($nom)) {
        echo "Le nom du sponsor est obligatoire.";
        exit();
    }

    
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "L'adresse email est invalide.";
        exit();
    }

    $sql = "INSERT INTO sponsors(
        nom, contact, telephone, email
    ) VALUES (
        '$nom', '$contact', '$telephone', '$email'
    )";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: sp_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>