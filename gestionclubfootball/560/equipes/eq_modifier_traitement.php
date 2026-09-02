<?php
include '../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id            = intval($_POST['id']);
    $nom_equipe    = mysqli_real_escape_string($conn, trim($_POST['nom_equipe']));
    $categorie     = mysqli_real_escape_string($conn, trim($_POST['categorie']));
    $date_creation = mysqli_real_escape_string($conn, $_POST['date_creation']);
    $description   = mysqli_real_escape_string($conn, trim($_POST['description']));

    if (empty($id)) {
        echo "Identifiant invalide.";
        exit();
    }

    if (empty($nom_equipe)) {
        echo "Le nom de l'équipe est obligatoire.";
        exit();
    }

    $sql = "UPDATE equipes SET
        nom_equipe = '$nom_equipe',
        categorie = '$categorie',
        date_creation = '$date_creation',
        description = '$description'
        WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: eq_lister.php");
        exit();
    } else {
        echo "Erreur MySQL : " . mysqli_error($conn);
    }

} else {
    echo "Accès refusé.";
}
?>